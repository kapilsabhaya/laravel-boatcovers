<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\CartModel;
use App\Models\GuestUser;
use App\Models\OptionValue;
use Illuminate\Http\Request;
use App\Models\ProductOptionValue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    
    public function addToCart(Request $request) {
        if (isset($request['color']) && is_array($request['color'])) {
            $product_id = array_key_first($request['color']);
        } else {
            $product_id = $request['product_id'];
        }

        //check if product exists
        $checkProduct = Product::where('id',$product_id)->first();
        if(!$checkProduct) {
            return back()->with(['errors' => 'Product Not Found']); 
        }

        $measurement = array_map(function($value) {
            return $value ?? null;
        }, $request['measurement'] ?? []);
        $hasOption = false;
        if(isset($request['color']) || isset($request['size']) || isset($request['fabric']) || isset($request['tiedown']) || isset($request['grommet']) || isset($request['measurement'])) {
            $hasOption = true;
        }

        if($hasOption) {
            $checkOptionValue = OptionValue::where('id',$request['color'])
            ->orWhere('id' ,$request['size'])
            ->orWhere('id' ,$request['fabric'])
            ->orWhere('id' ,$request['tiedown'])
            ->orWhere('id' ,$request['grommet'])
            ->orWhere('id' ,array_key_first($request['measurement']['Height']))
            ->orWhere('id' ,array_key_first($request['measurement']['Width']))
            ->orWhere('id' ,array_key_first($request['measurement']['Depth']))
            ->orWhere('id' ,array_key_first($request['measurement']['Front Height']))
            ->get();

            if(!$checkOptionValue->isNotEmpty()){
                return back()->with(['errors' => 'Option Value Mismatch']); 
            } 
        }

        if($hasOption) {
            $checkProductOptionValue = ProductOptionValue::where('product_id',$product_id)
            ->where('option_value_id',$request['color'])
            ->orWhere('option_value_id',$request['size'])
            ->orWhere('option_value_id',$request['fabric'])
            ->orWhere('option_value_id',$request['tiedown'])
            ->orWhere('option_value_id',$request['grommet'])
            ->get();

            if(!$checkProductOptionValue->isNotEmpty()){
                return back()->with(['errors' => 'Product Option Value Mismatch']);
            }
        }

       

        DB::beginTransaction();
        $session_id = session()->getId();

         // product options
        if($hasOption) {
            $json_option = json_encode([
                $product_id => [
                    'color' => $request['color'][$product_id],
                    'size' => $request['size'],
                    'measurement' => $request['measurement'],
                    'fabric' => $request['fabric'],
                    'tiedown' => $request['tiedown'],
                    'grommet' => $request['grommet']
                ]
            ]);
        }

        //add cart product into session
        $cart = session()->get('cart',[]);
        $cart[$product_id] = [
            'product_id' => $product_id,
            'option' => $json_option??null,
            'quantity' => $request['product-qty'],
            'sample_image' => $request['image']??null
        ];
        session()->put('cart',$cart);

        Auth::check() ? $user_id = Auth::user()->id : $user_id = null;
        $cartTable = CartModel::create([
            'user_id' => $user_id,
            'product_id' => $product_id,
            'session_id' => $session_id,
            'option' => $json_option??null,
            'quantity' => $request['product-qty'],
            'sample_image' => $request['image']
        ]);

        if($cartTable) {
            DB::commit();
            Cookie::queue('session_id', $session_id, 60 * 24 * 30); // 30 days
        return redirect()->route('cartView');
        } else {
            DB::rollback();
            return back()->with(['error' => "Something Went Wrong ! Please Try Again"]);
        }
    }  
    
    public function fetchCartProducts(Request $request) {
        $session_id = $request->cookie('session_id');

        $cart = collect(session()->get('cart'));
        if($cart->isEmpty() && $session_id) {
            $cart = CartModel::where('session_id', $session_id)->get();
        }
        $products = [];
        $options = null;
        $sample_image = null;
        foreach($cart as $cartProduct) {
            $color = $size = $fabric = $tiedown = $grommet = null;
            $heightId = $heightInch = $widthId = $widthInch = $depthId = $depthInch = $frontHeightId = $frontInch = null;
            $options = $cartProduct['option'];
            $sample_image = $cartProduct['sample_image'];
            $option = json_decode($cartProduct['option'],true);
            if($option) {
            $color = $option[$cartProduct['product_id']]['color'] ?? null;
            $size = $option[$cartProduct['product_id']]['size'] ?? null;
            $fabric = $option[$cartProduct['product_id']]['fabric'] ?? null;
            $tiedown = $option[$cartProduct['product_id']]['tiedown'] ?? null;
            $grommet = $option[$cartProduct['product_id']]['grommet'] ?? null;
            $heightId = $option[$cartProduct['product_id']]['measurement'] ? array_key_first($option[$cartProduct['product_id']]['measurement']['Height']) : null;
            $heightInch = $heightId ? $option[$cartProduct['product_id']]['measurement']['Height'][$heightId] : null;
            $widthId = $option[$cartProduct['product_id']]['measurement'] ? array_key_first($option[$cartProduct['product_id']]['measurement']['Width']) : null;
            $widthInch = $widthId ? $option[$cartProduct['product_id']]['measurement']['Width'][$widthId] : null;
            $depthId = $option[$cartProduct['product_id']]['measurement'] ? array_key_first($option[$cartProduct['product_id']]['measurement']['Depth']) : null;
            $depthInch = $depthId ? $option[$cartProduct['product_id']]['measurement']['Depth'][$depthId] : null;
            $frontHeightId = $option[$cartProduct['product_id']]['measurement'] ? array_key_first($option[$cartProduct['product_id']]['measurement']['Front Height']) : null;
            $frontInch = $frontHeightId ? $option[$cartProduct['product_id']]['measurement']['Front Height'][$frontHeightId] : null;
            }
            $product = Product::with([
                'getCategory',
                'productOption' => function($query) use ($cartProduct ,$color ,$size ,$fabric ,$tiedown ,$grommet, $heightId,$widthId,$depthId,$frontHeightId) {
                    $query->where('option_value_id',$color )
                 ->orWhere('option_value_id',$size )
                 ->orWhere('option_value_id',$fabric )
                 ->orWhere('option_value_id', $tiedown)
                 ->orWhere('option_value_id', $grommet)
                 ->orWhere('option_value_id', $heightId)
                 ->orWhere('option_value_id', $widthId)
                 ->orWhere('option_value_id', $depthId)
                 ->orWhere('option_value_id', $frontHeightId);
                },
                'productOption.optionValue.option',
                'setting',
                'media' => function($query) {
                    $query->orderBy('sort_order')->limit(1);
                }
            ])->where('id', $cartProduct['product_id'])->where('product.is_active', true)->orderBy('sort_order')->get();
            $price = $this->price_calculation($cartProduct['product_id'],$color ,$size ,$fabric ,$tiedown ,$grommet,$heightId , $widthId, $depthId,$frontHeightId ,$heightInch ,$widthInch,$depthInch,$frontInch);
            $products[] = [
                'product' => $product,
                'price' => $price,
                'option' => $options,
                'sample_image' => $sample_image,
                'quantity' => $cartProduct['quantity']
            ]; 
        }
        return collect($products);
    }

    public function cartView(Request $request) {
        $products = $this->fetchCartProducts($request);
        return view('cart',['products' => $products]);
    }

    public function updateCart(Request $request) {
        if($request->product_id && $request->product_id != null) {
            $product_id = $request->input('product_id');
            $quantity = $request->input('quantity');
            $session_id = $request->cookie('session_id');
            
            $cart = session()->get('cart', []);
            if(empty($cart) && $session_id) {
                $cart = CartModel::where('session_id', $session_id)->where('product_id',$product_id)->select('product_id','option','quantity','sample_image')->get()->keyBy('product_id')->toArray();
            }

            if (isset($cart[$product_id])) {
                DB::beginTransaction();
                if ($quantity <= 0) {
                    $deleteProduct = CartModel::where('session_id',$session_id)->where('product_id',$product_id)->delete();
                    unset($cart[$product_id]);
                } else {
                    $cart[$product_id]['quantity'] = $quantity;
                    $updateCart = CartModel::where('session_id',$session_id)->where('product_id',$product_id)->update(['quantity' => $quantity]);
                }
                DB::commit();
                $cart = CartModel::where('session_id', $session_id)->select('product_id', 'option', 'quantity', 'sample_image')->get()->keyBy('product_id')->toArray();
                session()->put('cart', $cart);
            }
            return response()->json(['success' => true]);
        } else {
            DB::rollback();
            return response()->json(['status' => false]);
        }
    }

    public function price_calculation($product_id,$color ,$size ,$fabric ,$tiedown ,$grommet,$heightId , $widthId , $depthId ,$frontHeightId,$heightInch ,$widthInch,$depthInch,$frontInch) {
            $productOption = ProductOptionValue::with('product')
                ->where('product_id', $product_id)
                ->where(function($query) use ($color ,$size ,$fabric ,$tiedown ,$grommet,$heightId , $widthId , $depthId ,$frontHeightId,$heightInch ,$widthInch,$depthInch,$frontInch) {
                    $query->where('option_value_id', $fabric)
                        ->orWhere('option_value_id', $tiedown)
                        ->orWhere('option_value_id', $grommet)
                        ->orWhere('option_value_id', $heightId)
                        ->orWhere('option_value_id', $widthId)
                        ->orWhere('option_value_id', $depthId)
                        ->orWhere('option_value_id', $frontHeightId)
                        ->orWhere('option_value_id', $size)
                        ->orWhere('option_value_id', $color);
                })
                ->get();
            $total_price_increment = 0;
            $measurePrice = 0;

            // if in case there r no options for product like extra category 
            if ($productOption->isEmpty()) {
                $product = Product::find($product_id);
                $total_price_increment = $product->price;
            } else {
            foreach($productOption as $proOpt) {
                if($proOpt->option_value_id == $heightId && $heightInch) {
                    $heightPrice = $proOpt->base_price * $heightInch;
                    $price_inc = number_format(($heightPrice + ($heightPrice * $proOpt->price_increment)/ 100),2);
                    $measurePrice += $price_inc;
                }
                else if($proOpt->option_value_id == $widthId && $widthInch) {
                    $widthPrice = $proOpt->base_price * $widthInch;
                    $price_inc = number_format(($widthPrice + ($widthPrice * $proOpt->price_increment)/ 100),2);
                    $measurePrice += $price_inc;
                }
                else if($proOpt->option_value_id == $depthId && $depthInch) {
                    $depthPrice = $proOpt->base_price * $depthInch;
                    $price_inc = number_format(($depthPrice + ($depthPrice * $proOpt->price_increment)/ 100),2);
                    $measurePrice += $price_inc;
                }
                else if($proOpt->option_value_id == null || $proOpt->option_value_id == $color || $proOpt->option_value_id == $size || $proOpt->option_value_id == $fabric || $proOpt->option_value_id == $tiedown || $proOpt->option_value_id == $grommet ) {
                $price = $proOpt->product->price;
                $increment_rate = $proOpt->price_increment;
                $base_price = $proOpt->base_price;
                $price_increment = number_format($price + ($base_price + ($base_price * $increment_rate / 100)) ,2);
                $total_price_increment += $price_increment;
                }
            }
        }
        return (number_format($total_price_increment + $measurePrice,2));
    }

    public function checkout(Request $request){
        $cartProducts = $this->fetchCartProducts($request);
        return view('checkout',['products' => $cartProducts]);
    }

    public function deleteCart(Request $request) {
        $session_id = $request->cookie('session_id');
        
        $cart = collect(session()->get('cart'));
        session()->forget('cart');
        $deleteCart = CartModel::where('session_id', $session_id)->delete();
    }
}
