<x-app-layout>
    {{-- @dd($product) --}}
    @if(session('errors'))
    <div class="alert alert-danger"> {{session('errors')}} </div>
    @endif

    @if($product->is_customizable == false)
        <div class="container" style="width:82%;margin-top:20px;">
            <img src="{{ asset('uploads/Category/50.jpg') }}" alt="50%off" />
            <br>
            <div class="row">
                <div class="col-6">
                    <div class="product-gallery">
                        <!-- Large Image Display -->
                        <div class="large-image-container">
                            <img id="mainImage" src="{{ asset('uploads/Product/' . $product->media->first()->media) }}"
                                alt="{{ $product->name }}">
                        </div>

                        <!-- Thumbnails -->
                        <div class="thumbnail-container">
                            @foreach ($product->media as $media)
                            <div class="thumbnail">
                                <img src="{{ asset('uploads/Product/' . $media->media) }}" alt="{{ $product->name }}"
                                    data-large="{{ asset('uploads/Product/' . $media->media) }}">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                    <div class="col-6">
                        <div class="title">
                            <h4> {{ $product->name }} </h4>
                            <div>
                                <div style="display:inline" class="star">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    @if ($product->warranty == 'Lifetime')
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    @elseif ($product->warranty == '+10')
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star"></i>
                                    @elseif ($product->warranty == '+5' || $product->warranty == '+2')
                                    <i class="bi bi-star"></i>
                                    <i class="bi bi-star"></i>
                                    @endif
                                </div>
                                <div style="display:inline;margin-left:70%;" class="stock">
                                    @if ($product->quantity > 0)
                                    <small style="background-color:rgb(83 212 93)" class="dot"></small>
                                    <small>In Stock</small>
                                    @else
                                    <small style="background-color: red" class="dot"></small>
                                    <small>Out Of Stock</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="details">
                            <form action="{{route('addToCart')}}" method="get">
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                            <div name="price" class="priceText"> <h3> ${{ $product->price }} </h3> </div>
                            <div class="hexagon">On Sale</div>
                            
                            
                            <br>

                            @php
                            $sizeOptions = [];
                            @endphp
                            @foreach ($product->productOption as $key => $product_option)
                                @if ($product_option->optionValue && $product_option->optionValue->option)
                                    @php
                                    $optionName = (strtolower($product_option->optionValue->option->option_name));
                                    @endphp
                                    
                                    @if ($optionName == 'color')
                                    @php
                                        $colorOptions[] = $product_option;
                                    @endphp
                                    @elseif ($optionName == 'size')
                                        @php
                                        $sizeOptions[] = $product_option;
                                        @endphp
                                    @endif
                                @endif
                            @endforeach
                            @if (!empty($colorOptions))
                            <h6 style="margin-top: 4px">Color :&nbsp;<label id="colorName"></label></h6>
                            <div class="price">
                                    <div class="color-option">
                                        @foreach ($colorOptions as $key => $option_value)
                                        <input type="radio" data-color="{{$option_value->optionValue->option_value}}" id="color-{{$key}}" name="color[{{$option_value->product_id}}]" value="{{$option_value->option_value_id}}" {{ $key == 0 ? 'checked' : '' }}>
                                        <label for="color-{{$key}}" style="background-color: {{ $option_value->optionValue->option_value }}"></label>
                                        @endforeach
                                    </div>
                                    {{-- <div class="color-option">
                                        @foreach ($colorOptions as $key => $option_value)
                                        <input type="radio" data-color="{{$option_value->option_value}}" id="color-{{$key}}" name="color" value="{{$option_value->id}}" {{ $key == 0 ? 'checked' : '' }}>
                                        <label for="color-{{$key}}" style="background-color: {{ $option_value->option_value }}"></label>
                                        @endforeach
                                    </div> --}}
                                </div>
                            @endif
                            @if (!empty($sizeOptions))
                                <h6  style="margin-top:9px">Size</h6>
                                <select class="form-control optionSize" name="size" >
                                    @foreach ($sizeOptions as $option_value)
                                    <option value="{{ $option_value->option_value_id }}" data-price="{{ $option_value->base_price }}">{{ $option_value->optionValue->option_value }}</option>
                                    @endforeach
                                </select>
                            @endif
                            {{-- @if (!empty($sizeOptions))
                                <h6  style="margin-top:9px">Size</h6>
                                <select class="form-control optionSize" >
                                    @foreach ($sizeOptions as $option_value)
                                    <option value="{{ $option_value->id }}" data-price="{{ $product_option->base_price }}">{{ $option_value->option_value }}</option>
                                    @endforeach
                                </select>
                            @endif --}}


                            <div class="setting">
                                @foreach ($product->setting as $setting)
                                <img src="{{ asset('uploads/Product/ttrue.webp') }}" alt="" srcset="">
                                    <div class="setting_name"> {{ $setting->setting_name }}  </div>
                                    <div class="value"> {{ $setting->value }} </div><br>
                                @endforeach
                            </div>
                            <hr>

                            <div>
                                <div style="width:25%;margin-top:25px;margin-left:-2px;height:39px;display:inline-block;" class="qty-input">
                                    <button class="qty-count qty-count--minus" data-action="minus" type="button">-</button>
                                    <input class="product-qty" type="number" name="product-qty" min="0" max="10" value="1">
                                    <button class="qty-count qty-count--add" data-action="add" type="button">+</button>
                                </div>
                                <div style="display: inline-block;">
                                    <button type="submit" style="margin-top:-23%;border-radius:10px;width:300%;padding-top:9px;padding-bottom:9px;font-weight:500" class="btn cartBtn">Add to cart<i style="padding-left:8px;" class="bi bi-cart"></i></button><br>
                                </div>
                            </div>

                        </div>
                    </form>
                    </div>
            </div>

            <hr>
            <div class="desc">
                {!! $product->description !!}
            </div>
        </div>
    @else
        @include('customizeProductView');
    @endif
    @push('script')
    <script>
        
        $(document).ready(function () {
            var selectedSize = $('.optionSize').find(":selected").data('price');
            if(selectedSize){
                $(".priceText h3").text("$"+ selectedSize);
            }

            $(".optionSize").change(function(e){
                e.preventDefault();
                var price = $(this).find("option:selected").attr('data-price');
                $(".priceText h3").text("$" + price);
                // var productId = "{{$product->id}}";
                // var size = $(this).val();
                // $.ajaxSetup({
                //     headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                // });
                // $.ajax({
                //     type: "post",
                //     url: "{{ route('price_increment') }}",
                //     data: { size : size, product_id :productId },
                //     dataType: "json",
                //     success: function (response) {
                //         if(response.price_increment) {
                //             $(".priceText h3").text("$" + response.price_increment);
                //         }
                //     }
                // });
            });

            var selectedColor = $('input[type=radio][name="color"]:checked').data('color');
            $("#colorName").text(selectedColor);

            $("input[type=radio][name='color']").change(function(){
                var color = $(this).data('color');
                $("#colorName").text(color);
            });
    
            document.querySelectorAll('.thumbnail img').forEach(function(thumbnail) {
                thumbnail.addEventListener('click', function() {
                // Get the large image URL from the data attribute
                var largeImageUrl = this.getAttribute('data-large');
                // Set it as the src of the main image
                document.getElementById('mainImage').setAttribute('src', largeImageUrl);
                });
            });
        });
    </script>
    
    <script>
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
            });
        })();
    
    </script>
    @endpush
</x-app-layout>