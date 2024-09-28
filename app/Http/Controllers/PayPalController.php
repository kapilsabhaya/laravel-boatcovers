<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\GuestUser;
use App\Models\OrderAddress;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\CartController;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    public function validateData(Request $request) {
        $request->validate([
            'email' => 'required',
            'fname' => 'required',
            'lname' => 'required',
            'address' => 'required',
            'country' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zipcode' => 'required|regex:/^[0-9]{6}$/',
            'phone' => 'required|regex:/^[0-9]{10}$/',
            'billing_zipcode' => 'nullable|regex:/^[0-9]{6}$/',
            'billing_phone' => 'nullable|regex:/^[0-9]{10}$/'
        ],[
            'email.required' => 'Email is required',
            'fname.required' => 'First name is required',
            'lname.required' => 'Last name is required',
            'address.required' => 'Address is required',
            'country.required' => 'Country is required',
            'city.required' => 'City is required',
            'state.required' => 'State is required',
            'zipcode.required' => 'Zipcode is required',
            'zipcode.regex' => 'Zipcode must be a 6-digit number.',
            'phone.required' => 'Phone number is required',
            'phone.regex' => 'Phone number must be a 10-digit number.',
            'billing_zipcode.regex' => 'Zipcode must be a 6-digit number.',
            'billing_phone.regex' => 'Phone number must be a 10-digit number.',
        ]);
        if($request['payment_method'] == 'paypal') {
            return redirect()->route('paypal' , ['data' => $request->all()]);
        } elseif($request['payment_method'] == 'braintree') {
            return redirect()->route('token',['data' => $request->all()]);
        } else if($request['payment_method'] == 'stripe') {
            return redirect()->route('stripe' , ['data' => $request->all()]);
        }
        
    }

    public function paypal(Request $request) {
        DB::beginTransaction();

        $data = $request->all();
        $amount = $data['data']['amount'];
        $cartproduct = new CartController;
        $product = $cartproduct->fetchCartProducts($request);
        $total = 0;
        foreach ($product as $item) {
            $price = $item['price'] * $item['quantity'];
            $total+=$price;
        }

        //check amount
        if(abs(floatval($total)) - floatval($amount) > 0.01){
            return back()->with(['error' => 'Amount Mismatch !']);
        }

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

        $createOrder = Order::create([
            'user_id' => Auth::check() ? Auth::user()->id : null,
            'guest_id' => $addGuest ? $addGuest->id : null,
            'payment_method' => 'paypal',
            'order_status' => 'ordered',
            'amount' => $amount,
            'transaction_id' => null,
        ]);


        if($createOrder){
            $orderAddress = OrderAddress::create([
            'order_id' => $createOrder->id,
            'shipping_address' => $data['data']['address'],
            'shipping_city' => $data['data']['city'],
            'shipping_state' => $data['data']['state'],
            'shipping_zipcode' => $data['data']['zipcode'],
            'shipping_country' => $data['data']['country'],
            'shipping_phone' => $data['data']['phone'],
            'billing_person_name' => $data['data']['billing_first_name'] . " " . ($data['data']['billing_last_name']) ?? null,
            'billing_address' => $data['data']['billing_address'] ?? null,
            'billing_city' => $data['data']['billing_city'] ?? null,
            'billing_state' => $data['data']['billing_state'] ?? null,
            'billing_zipcode' => $data['data']['billing_zipcode'] ?? null,
            'billing_country' => $data['data']['billing_country'] ?? null,
            'billing_phone' => $data['data']['billing_phone'] ?? null,
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
            
            DB::commit();
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalAccessToken = $provider->getAccessToken();

            $response = $provider->createOrder([
                'intent' => 'CAPTURE',
                'application_context'=>[
                    'return_url' => route('success',['order_id' => $createOrder->id]),
                    'cancel_url' => route('cancel'),
                ],
                'purchase_units' => [
                    [
                        'amount' => [
                        'currency_code' => 'USD',
                        'value' => $amount
                        ]
                    ]
                ]
            ]);

            if(isset($response['id']) && $response['id'] != null) {
                foreach ($response['links'] as $link) {
                    if(($link['rel'] === 'approve') && isset($link['href']))  {
                        $redirectUrl = $link['href'];
                        return redirect()->to($redirectUrl);
                    }
                }
            } else {
                DB::rollback();
                return redirect()->route('cancel');
            }
        } 
    }
    public function success(Request $request) {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalAccessToken = $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);
        if(isset($response['status']) && $response['status'] == 'COMPLETED') {
            DB::beginTransaction();
            $updateOrder = Order::where('id',$request['order_id'])->update(['transaction_id' => $response['id']]);

            if($updateOrder) {
                $deleteCart = new CartController;
                $deleteCart->deleteCart($request);
                DB::commit();
                return redirect()->route('dashboard');
            } 
            else {
                DB::rollback();
                return back()->with(['error' => "Something Went Wrong"]);
            }
        }
    }
    public function cancel() {
        return back()->with(['error' => "Something went wrong ,Please Try Again!"]);
    }
}
