<x-app-layout>
    @push('title')
    <title>Cart</title>
    @endpush
    {{-- {{ session()->forget('cart') }} --}}
    {{-- {{ print_r(session()->get('cart'))}} --}}
    <div class="container cart" style="width:82%;margin-top:20px;">
        @if($products->isNotEmpty())
        <div class="row">
            <div style="display: flex">
                <h4>Shopping Cart</h4>
                <a class="keepShopping" href="{{route('dashboard')}}"><button>Keep Shopping</button></a>
            </div>
            <div class="col-md-8" style="margin-top:24px">
                <div class="table-responsive">
                    <table class="table table-light">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col"> </th>
                                <th style="padding-left:115px;" scope="col">Quantity</th>
                                <th scope="col">Price</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($products as $productCollection)
                            @foreach ($productCollection['product'] as $product)
                            <tr>
                                <td>
                                    @foreach ($product->media as $media)
                                    <img src="{{asset('uploads/Product/'. $media->media)}}" alt="" srcset=""
                                        style="width:70px;height:70px">
                                    @endforeach
                                </td>


                                <td>
                                    <a href="{{route('singleProduct',$product->slug) }}"><b>{{ $product->name }}</b></a>
                                    <br>
                                    @foreach ($product->productOption as $key => $product_option)
                                    @if ($product_option->optionValue && $product_option->optionValue->option)
                                    @php
                                    $optionName = (strtolower($product_option->optionValue->option->option_name));
                                    @endphp

                                    @if ($optionName == 'color')
                                    <small><b> Color : </b> {{ $product_option->optionValue->option_value }}</small>
                                    @elseif ($optionName == 'size')
                                    <br>
                                    <small><b>Size : </b>{{ $product_option->optionValue->option_value }}</small>
                                    @endif
                                    @endif
                                    @endforeach

                                    @if($product->setting->isNotEmpty())
                                    <div class="cartSetting">
                                        @foreach ($product->setting as $setting)
                                        @if ($setting)
                                        <div class="settingName">{{ $setting->setting_name }}</div>
                                        <div class="settingValue">{{ $setting->value }}</div>
                                        <br>
                                        @endif
                                        @endforeach
                                    </div>
                                    @endif
                                </td>


                                <td>
                                    @php
                                    $price = $productCollection['price'];
                                    @endphp

                                    <div class="qty-input">
                                        <button class="qty-count qty-count--minus" data-original_price="{{$price}}"
                                            data-product_id="{{$product->id}}" data-action="minus"
                                            type="button">-</button>
                                        <input class="product-qty" readonly type="number" name="product-qty" min="0"
                                            max="10" value="{{ $productCollection['quantity'] ?? 0 }}">
                                        <button class="qty-count qty-count--add" data-original_price="{{$price}}"
                                            data-product_id="{{$product->id}}" data-action="add"
                                            type="button">+</button>
                                    </div>
                                </td>

                                <td>
                                    <b>
                                        <p class="price">{{ "$". $price * $productCollection['quantity'] }}</p>
                                    </b>
                                </td>
                            </tr>
                            @endforeach
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
            <div class="col-md-4 subtotal">
                <div class="total">
                    <h6>Subtotal</h6>
                    <p id="total-price"></p>
                </div>
                <div class="place_order">
                    <p>Taxes and shipping calculated at checkout</p>
                    <form action="{{route('checkout')}}" method="get">
                        <button type="submit"><i class="bi bi-shield-lock-fill"></i>&nbsp;&nbsp;Place Secure
                            Order</button>
                    </form>
                </div>
            </div>
        </div>
        @else
        <center>
            <h4>Cart is empty !</h4><br>
            <a class="btn" href="{{route('dashboard')}}"><button>Continue Shopping <i
                        class="bi bi-arrow-right"></i></button></a>
        </center>
        @endif
    </div>
    @push('script')
    <script>
        $(document).ready(function () {
        subtotal();
        function subtotal() {
            var totalPrice = 0;
            $('.price').each(function () {
                var priceText = $(this).text();
                var priceValue = parseFloat(priceText.replace('$', ''));
                totalPrice += priceValue;
            });
            $('#total-price').text('$' + totalPrice.toFixed(2));
        }
    
        var QtyInput = (function () {
            var $qtyInputs = $(".qty-input");
        
            if (!$qtyInputs.length) {
                return;
            }
        
            var $inputs = $qtyInputs.find(".product-qty");
            var $countBtn = $qtyInputs.find(".qty-count");
            var qtyMin = parseInt($inputs.attr("min"));
            var qtyMax = parseInt($inputs.attr("max"));

            $inputs.change(function () {
                var $this = $(this);
                var $minusBtn = $this.siblings(".qty-count--minus");
                var $addBtn = $this.siblings(".qty-count--add");
                var qty = parseInt($this.val());
                if (isNaN(qty) || qty <= qtyMin) {
                    $this.val(qtyMin);
                    $minusBtn.attr("disabled", true);
                } else {
                    $minusBtn.attr("disabled", false);
                    
                    if(qty >= qtyMax){
                        $this.val(qtyMax);
                        $addBtn.attr('disabled', true);
                    } else {
                        $this.val(qty);
                        $addBtn.attr('disabled', false);
                    }
                }
                
                
            });
        
            $countBtn.click(function () {
                var operator = this.dataset.action;
                var $this = $(this);
                var $input = $this.siblings(".product-qty");
                var qty = parseInt($input.val());
                var product_id = $(this).siblings(".qty-count").data('product_id');
                var originalPrice = $(this).siblings(".qty-count").data('original_price');
                var $priceElement = $this.closest('tr').find('.price'); // Store the reference to the .price element

                if (operator == "add") {
                    qty += 1;   
                    if (qty >= qtyMin + 1) {
                        $this.siblings(".qty-count--minus").attr("disabled", false);
                    }
        
                    if (qty >= qtyMax) {
                        $this.attr("disabled", true);
                    }
                } else {
                    qty = qty <= qtyMin ? qtyMin : (qty -= 1);
                    
                        if (qty == qtyMin) {
                            $this.attr("disabled", true);
                        }
        
                        if (qty < qtyMax) {
                            $this.siblings(".qty-count--add").attr("disabled", false);
                        }
                }
                $input.val(qty);
                
                // Update cart session
                $.ajax({
                    type: 'get',
                    url: "{{ route('updateCart') }}",
                    data: {
                        'product_id': product_id,
                        'quantity': qty
                    },
                    success: function(response) {
                        if(response.status == false){
                            alert("Something Went Wrong !Please Try Again.")
                        } else {
                            var totalPrice = originalPrice * qty;
                            $priceElement.text("$" + totalPrice.toFixed(2))
                            subtotal();
                        }
                    }
                });
            });
        })();
    });

    </script>
    @endpush
</x-app-layout>