<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\GuestUser;
use App\Models\OrderAddress;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\CartController;

class StripeController extends Controller
{
    public function stripe(Request $request) {
        $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));

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
            'payment_method' => 'stripe',
            'order_status' => 'ordered',
            'amount' => $amount,
            'transaction_id' => null,
        ]);
        

        if($createOrder) {

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

            $response = $stripe->checkout->sessions->create([
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'usd',
                            'unit_amount' => $data['data']['amount'] * 100, 
                            'product_data' => [
                                'name' => 'Your product name',
                            ],
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => route('stripe.success', ['order_id' => $createOrder->id]) . '&session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('stripe.cancel'),
            ]);
            if(isset($response->id) && $response->id !=''){
                DB::commit();   
                return redirect($response->url);
            }else{
                DB::rollBack();
                return redirect()->route('stripe.cancel');   
            }
        }
    }
    
    public function success(Request $request) {
        DB::beginTransaction();

        if($request->query('session_id') != null){
            $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
            $response = $stripe->checkout->sessions->retrieve($request->query('session_id'));
            if($response->id){
                $updateOrder = Order::where('id',$request->query('order_id'))->update(['transaction_id' => $response->payment_intent]);
                if($updateOrder) {
                    $deleteCart = new CartController;
                    $deleteCart->deleteCart($request);
                    DB::commit();
                    return redirect()->route('dashboard'); 
                } else {
                    DB::rollback();
                    return back()->with(['error' => "Something Went Wrong"]);
                }
            }
        }
    }
    
    public function cancel() {
        return back()->with(['error' => "Something went wrong ,Please Try Again!"]);
    }
}
