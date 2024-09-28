<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Option;
use App\Models\Product;
use App\Models\GuestUser;
use App\Models\OptionValue;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Models\ProductOptionValue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class MyOrderController extends Controller
{
    public function myOrder(Request $request) {
        Auth::check() ? $user = Auth::user()->id : $user = $request->cookie('guest_id');
        Auth::check() ? $column = 'user_id' : $column = 'guest_id';
        
        $orders = Order::where($column,$user)->get();
        $myOrders = [];
        foreach($orders as $order) {
            $myOrder = OrderProduct::with(['product.media' => function($query){ $query->orderBy('sort_order')->limit(1); },'order'])->where('order_id',$order->id)->get();
            $myOrders[] = $myOrder;

            $myOrder->each(function ($orderProduct) {
                $options = json_decode($orderProduct->option, true);
                if ($options) {
                    foreach ($options as $productId => $optionDetails) {
                        $orderProduct->option = $this->getOptionDetails($productId, $optionDetails);
                    }
                }
            });
        }
        
        return view('myOrder',['myOrder' => collect($myOrders)]);
    }

    protected function getOptionDetails($productId, $optionDetails)
    {
        $optionData = [];

        $product = Product::find($productId);
        if ($product) {
            foreach ($optionDetails as $key => $value) {
                if ($key == "measurement") {
                    $measurementData = [];
                    if($value != null) {

                        foreach ($value as $measurementKey => $measurementValue) {
                            foreach ($measurementValue as $id => $measurement) {
                                $measurementData[$measurementKey] = $measurement;
                            }
                        }
                        $optionData[$key] = $measurementData;
                    }
                } elseif ($value) {
                    $optionValue = ProductOptionValue::with(['optionValue'])->where('option_value_id', $value)->where('product_id', $productId)->get();
                    foreach ($optionValue as $optionValue) {
                        $optionData[$key] = $optionValue ? $optionValue->optionValue->option_value : null;
                    }
                }
            }
        }
        return $optionData;
    }

    public function orderReceipt($orderId ,$productId) {
        $orderId = base64_decode($orderId);
        $productId = base64_decode($productId);

        $checkOrder = OrderProduct::where('order_id',$orderId)->where('product_id',$productId)->get();
        if($checkOrder->isEmpty()){
            return redirect()->route('myOrder')->with('error','Order not found');
        }
        $guest = GuestUser::where('id',Cookie::get('guest_id'))->first();
        $order = OrderProduct::with(['order.order_address','order.order_product' => function($query) use($productId) { $query->where('product_id',$productId); } , 'order.order_product.product.media' => function($query) { $query->orderBy('sort_order')->limit(1); }])->where('order_id',$orderId)->where('product_id',$productId)->first();
        $options = json_decode($order->option, true);
        if ($options) {
            foreach ($options as $productId => $optionDetails) {
                $order->option = $this->getOptionDetails($productId, $optionDetails);
            }
        }
        return view('orderReceipt', ['order' => $order , 'guest' => $guest]);
    }
}
