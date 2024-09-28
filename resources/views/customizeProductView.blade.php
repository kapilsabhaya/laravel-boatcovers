    
    @push('style')
        <link rel="stylesheet"
        href="{{ asset('assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/extensions/filepond/filepond.css') }}">
    @endpush

    <div class="container" style="width:82%;margin-top:20px;">
        <img src="{{ asset('uploads/Category/50.jpg') }}" alt="50%off" />
        <br>
        <div class="row">
            
            <div class="col-md-6">
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
            <div style="height:auto;padding-bottom:25px;background-color: white;padding:15px 25px 0px 25px " class="col-md-6">
                <div class="title">
                    <h4>{{ $product->name }}</h4>
                </div>
                <div style="text-align: justify" class="desc">
                    {!! $product->description !!}
                </div>

                <!-- Display All Product Options -->
                @php
                    $measurements = [];
                @endphp
                @foreach ($product->productOption as $product_option)
                    @if ($product_option->optionValue && $product_option->optionValue->option)
                        @php
                        $optionName = strtolower($product_option->optionValue->option->option_name);
                        @endphp

                        @if ($optionName == 'measurement')
                            @php
                                $measurements[] = [
                                'title' => $product_option->optionValue->option_value,
                                'id' => $product_option->optionValue->id
                                ];
                            @endphp
                        @elseif($optionName == 'fabric')
                            @php
                                $fabrics[] = [
                                    'title' => $product_option->optionValue->option_value,
                                    'id' => $product_option->optionValue->id,
                                    'base_price' => $product_option->base_price
                                ];
                            @endphp
                        @elseif($optionName == 'color')
                            @php
                                $colors[] = $product_option;
                            @endphp
                        @elseif($optionName == 'tie downs')
                            @php
                                $tiedowns[] = [
                                    'title' => $product_option->optionValue->option_value,
                                    'price' => $product_option->base_price,
                                    'id' => $product_option->optionValue->id
                                 ];
                            @endphp
                        @elseif($optionName == 'grommets')
                            @php
                                $grommets[] = [
                                    'title' => $product_option->optionValue->option_value,
                                    'price' => $product_option->base_price,
                                    'id' => $product_option->optionValue->id
                                ];
                            @endphp
                        @endif
                    @endif
                @endforeach

                <form action="{{route('addToCart')}}" method="get">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                <!-- Display Measurements Grouped Together -->
                @if (count($measurements) > 0)
                    <div class="configuration row mt-3 p-3">
                        <div class="col-12">
                            <label class="configuration-title" for="Measurements">Measurement</label>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                @foreach ($measurements as $index => $measurement)
                                    <div class="col-4">
                                        <label for="">{{ $measurement['title'] }}</label>
                                        <input value="1" required type="number" data-measurement="{{ $measurement['id'] }}" name="measurement[{{ $measurement['title'] }}][{{ $measurement['id'] }}]" min="1" max="10000" placeholder="Inches" class="form-control mb-2">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                {{-- @dd($colors); --}}
                <!-- Display Color Grouped Together -->
                @if (count($colors) > 0)
                    <div class="configuration row mt-3 p-3">
                        <div class="col-12">
                            <label class="configuration-title" for="Measurements">Color</label>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="price">
                                    <div class="color-option">
                                        @foreach ($colors as $key => $option_value)
                                        <input type="radio" data-color="{{$option_value->optionValue->option_value}}" id="color-{{$key}}" name="color[{{$option_value->product_id}}]" value="{{$option_value->option_value_id}}" {{ $key == 0 ? 'checked' : '' }}>
                                        <label for="color-{{$key}}" style="background-color: {{ $option_value->optionValue->option_value }}"></label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Display Fabric Grouped Together -->
                @if (count($fabrics) > 0)
                    <div class="configuration row mt-3 p-3">
                        <div class="col-12">
                            <label style="display: inline-block" class="configuration-title" for="Fabric">Fabrics</label>
                            <div class="priceText" style="display: inline-block;margin-left:55%;"><h3 style="font-size: 1.5rem">Total ${{ $product->price }}</h3></div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                @foreach ($fabrics as $index => $fabric)
                                    <div class="radio-toolbar col-4">
                                        <input type="radio" data-price="{{ $fabric['base_price'] }}" class="configuration-radio fabric" id="fabric-{{ $index }}" name="fabric" value="{{ $fabric['id'] }}" {{ $index == 0 ? 'checked' : ''}}>
                                        <label for="fabric-{{ $index }}" class="configuration-button">{{ $fabric['title'] }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Display Tie Down Grouped Together -->
                @if (count($tiedowns) > 0)
                    <div class="configuration row mt-3 p-3">
                        <div class="col-12">
                            <label class="configuration-title" for="tieDown">Tie Downs</label>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                @foreach ($tiedowns as $i => $tiedown)
                                    <div class="radio-toolbar col-4">
                                        <input type="radio" class="configuration-radio" id="tiedown-{{ $i }}" name="tiedown" value="{{ $tiedown['id'] }}" {{ $i == 0 ? 'checked' : '' }}>
                                        <label for="tiedown-{{ $i }}" class="configuration-button">{{ $tiedown['title'] }}</label>
                                        <h6> ${{ $tiedown['price'] }} </h6>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Display Grommets  Grouped Together -->
                @if (count($grommets) > 0)
                    <div class="configuration row mt-3 p-3">
                        <div class="col-12">
                            <label class="configuration-title" for="grommets">Grommets</label>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                @foreach ($grommets as $key =>$grommet)
                                    <div class="radio-toolbar col-4">
                                        <input type="radio"  class="configuration-radio" id="grommet-{{ $key }}" name="grommet" value="{{ $grommet['id'] }}" {{ $key == 0 ? 'checked' : '' }}>
                                        <label for="grommet-{{ $key }}" class="configuration-button">{{ $grommet['title'] }}</label>
                                        <h6> ${{ $grommet['price'] }} </h6>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Reference Image --}}
                <div class="configuration row mt-3 p-3">
                    <div class="col-12">
                        <label class="configuration-title" for="grommets">Upload Reference Image</label>
                    </div>
                    <input type="file" name="image" class="image-preview-filepond">
                </div>
                <hr>
            </div>
            <div>
                <div class="priceText" style="display: inline-block" id="price"><h3>Total ${{ $product->price }}</h3></div>

                <div style="width:12%;height:39px;display:inline-block;margin-bottom:-7px;" class="qty-input">
                    <button class="qty-count qty-count--minus" data-action="minus" type="button">-</button>
                    <input readonly class="product-qty" type="number" name="product-qty" min="0" max="10" value="1">
                    <button id="addButton" class="qty-count qty-count--add" data-action="add" type="button">+</button>
                </div>
                <div class="addToCart" style="display:inline-block;"><button type="submit">Add To Cart</button></div>
                </form>
            </div>
        </div>
    </div>
    @push('script')

    <script>
    
    $(document).ready(function () {
        document.querySelectorAll('.thumbnail img').forEach(function(thumbnail) {
            thumbnail.addEventListener('click', function() {
            // Get the large image URL from the data attribute
            var largeImageUrl = this.getAttribute('data-large');
            // Set it as the src of the main image
            document.getElementById('mainImage').setAttribute('src', largeImageUrl);
            });
        });

        function updatePrice() {
            var qty = parseInt($('.product-qty').val());
            if (isNaN(qty) || qty < 1) {
                qty = 1; 
            }
            
            var fabric = $('input[type=radio][name="fabric"]:checked').val();
            var tiedown = $('input[type=radio][name="tiedown"]:checked').val(); 
            var grommet = $('input[type=radio][name="grommet"]:checked').val();
            var height = $('input[type=number][name^="measurement[Height]"]').val();
            var heightId = $('input[type=number][name^="measurement[Height]"]').data('measurement');
            var width = $('input[type=number][name^="measurement[Width]"]').val();
            var widthId = $('input[type=number][name^="measurement[Width]"]').data('measurement');
            var depth = $('input[type=number][name^="measurement[Depth]"]').val();
            var depthId = $('input[type=number][name^="measurement[Depth]"]').data('measurement');
            var productId = "{{$product->id}}";
            
            if(height < 1){
                $('input[type=number][name="measurement[Height]"]').addClass('is-invalid').after('<small class="text-danger">Value must be at least 1</small>');
            } else {
                $('input[type=number][name="measurement[Height]"]').removeClass('is-invalid').next('small.text-danger').remove();
            }

            if(width < 1) {
                $('input[type=number][name="measurement[Width]"]').addClass('is-invalid').after('<small class="text-danger">Value must be at least 1</small>');
            } else {
                $('input[type=number][name="measurement[Width]"]').removeClass('is-invalid').next('small.text-danger').remove();
            }

            if(depth < 1) {
                $('input[type=number][name="measurement[Depth]"]').addClass('is-invalid').after('<small class="text-danger">Value must be at least 1</small>');
            } else {
                $('input[type=number][name="measurement[Depth]"]').removeClass('is-invalid').next('small.text-danger').remove();
            }
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "post",
                url: "{{ route('price_increment') }}",
                data: { 
                    product_id: productId,
                    fabric: fabric, 
                    tiedown: tiedown, 
                    grommet: grommet, 
                    height: [{ heightId: heightId, height: height }], 
                    width: [{ widthId: widthId, width: width }], 
                    depth: [{ depthId: depthId, depth: depth }]
                },
                dataType: "json",
                success: function (response) {
                    originalPrice = response.price_increment;
                    var finalPrice = originalPrice * qty;
                    $(".priceText h3").text("$" + finalPrice);
                }
            });
        }

        // while option changes call updatePrice function
        $('input[type=radio][name="fabric"], input[type=radio][name="tiedown"], input[type=radio][name="grommet"], input[type=number][name^="measurement"]').on('change', updatePrice);

        // Listen for quantity changes
        $('.qty-count').on('click', function() {
            var operator = this.dataset.action;
            var $input = $(this).siblings('.product-qty');
            var qty = parseInt($input.val());

            if (operator === "add") {
                // qty += 1;
            } else {
                qty = qty > 1 ? qty - 1 : 1;
            }

            $input.val(qty);
            updatePrice(); // Recalculate price when quantity changes
        });

        // Initialize price on page load
        updatePrice();
});
    </script>

    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    <script
        src="{{ asset('assets/extensions/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js') }}">
    </script>
    <script src="{{ asset('assets/extensions/filepond-plugin-image-crop/filepond-plugin-image-crop.min.js') }}">
    </script>
    <script
        src="{{ asset('assets/extensions/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}">
    </script>
    <script
        src="{{ asset('assets/extensions/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}">
    </script>
    <script src="{{ asset('assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}">
    </script>
    <script src="{{ asset('assets/extensions/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js') }}">
    </script>
    <script src="{{ asset('assets/extensions/filepond-plugin-image-filter/filepond-plugin-image-filter.min.js') }}">
    </script>
    <script src="{{ asset('assets/static/js/pages/filepond.js') }}"></script>
    <script src="{{ asset('assets/extensions/filepond/filepond.js') }}"></script>

   
    @endpush
    {{--  0.51 = totle 3
 height = 0.13
 width = 0.1
 depth = 0.1
 difference = 0.18
 
 front-height = 0.0
 PROGURD = 0.18
 ELITE : 0.12
 SUPREME : 0.17   --}}

