<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Braintree\Gateway;
use App\Models\Product;
use App\Models\GuestUser;
use App\Models\OrderAddress;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\CartController;

class BrainTreeController extends Controller
{
    public function token(Request $request){
        $gateway = new \Braintree\Gateway([
            'environment' => config('braintree.environment'),
            'merchantId' => config('braintree.merchant_id'),
            'publicKey' => config('braintree.public_key'),
            'privateKey' => config('braintree.private_key')
        ]);

        $clientToken = $gateway->clientToken()->generate();
        $data = $request->all();
        $amount = $data['data']['amount'];
        return view('BraintreePaymentView', ['token' => $clientToken, 'data' => $data]);
    }

    public function processData(Request $request){
        $gateway = new \Braintree\Gateway([
            'environment' => config('braintree.environment'),
            'merchantId' => config('braintree.merchant_id'),
            'publicKey' => config('braintree.public_key'),
            'privateKey' => config('braintree.private_key')
        ]);

        DB::beginTransaction();
        $nonce = $request->input('nonce');
        $data = $request->input('data.data');
        
        //check if customer already exists
        if(!Auth::check()){
            $addGuest=null;
            $guestUser = GuestUser::where('email',$data['data']['email'])->first();
            if(!$guestUser) {
                $addGuest = GuestUser::create([
                    'name' => $data['data']['fname'] . " " . $data['data']['lname'],
                    'email' =>$data['data']['email']
                ]);
            if(!$request->hasCookie('guest_id')) {
                Cookie::queue('guest_id', $addGuest->id, 60 * 24 * 30); //30 days
            } else {
                $addGuest = $guestUser;
                Cookie::queue('guest_id', $addGuest->id, 60 * 24 * 30); //30 days
            }
            } else {
                $addGuest = GuestUser::find($request->cookie('guest_id'));
                Cookie::queue('guest_id', $addGuest->id, 60 * 24 * 30); //30 days
            }
        }

        $cartproduct = new CartController;
        $product = $cartproduct->fetchCartProducts($request);
        $amount = 0;
        foreach ($product as $item) {
            $price = $item['price'] * $item['quantity'];
            $amount+=$price;
        }

        $createOrder = Order::create([
            'user_id' => Auth::check() ? Auth::user()->id : null,
            'guest_id' => $addGuest ? $addGuest->id : null,
            'payment_method' => 'braintree',
            'order_status' => 'ordered',
            'amount' => $amount,
            'transaction_id' => null,
        ]);
       
        if($createOrder) {

            $orderAddress = OrderAddress::create([
                'order_id' => $createOrder->id,
                'shipping_address' => $data['address'],
                'shipping_city' => $data['city'],
                'shipping_state' => $data['state'],
                'shipping_zipcode' => $data['zipcode'],
                'shipping_country' => $data['country'],
                'shipping_phone' => $data['phone'],
                'billing_person_name' => $data['data']['billing_first_name'] . " " . ($data['data']['billing_last_name']) ?? null,
                'billing_address' => $data['billing_address'] ?? null,
                'billing_city' => $data['billing_city'] ?? null,
                'billing_state' => $data['billing_state'] ?? null,
                'billing_zipcode' => $data['billing_zipcode'] ?? null,
                'billing_country' => $data['billing_country'] ?? null,
                'billing_phone' => $data['billing_phone'] ?? null,
            ]);

            foreach($product as $productItem) {
                foreach($productItem['product'] as $product){
                    $orderProduct = OrderProduct::create([
                        'product_id' => $product->id,
                        'order_id' => $createOrder->id,
                        'option' => $productItem['option'],
                        'quantity' => $productItem['quantity'],
                        'sample_image' => $productItem['sample_image'],
                    ]);
                    $productQuanity = Product::where('id',$product->id)->select('quantity')->first();
                    $decreaseQuantity = Product::where('id' ,$product->id)->update(['quantity' => ($productQuanity->quantity - $productItem['quantity'])  ]);
                }
            }

            $result = $gateway->transaction()->sale([
                'amount' => $amount,
                'paymentMethodNonce' => $nonce,
            ]);

            if ($result->success) {
                if(isset($result->transaction->id) && $result->transaction->id != '') {
                    $redirectUrl = route('dashboard');
                    $updateOrder = Order::where('id',$createOrder->id)->update(['transaction_id' => $result->transaction->id]);
                    if($updateOrder) {
                        $deleteCart = new CartController;
                        $deleteCart->deleteCart($request);
                        DB::commit();
                        return response()->json(['status' => 200 , 'redirectUrl' => $redirectUrl],200); 
                    }
                }
            } else {
                DB::rollBack();
                return response()->json(['status' => 500],500);
            }
        }
    }
}
