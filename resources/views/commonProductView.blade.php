<x-app-layout>

	@if($errors->any())
	<center><div class="alert alert-danger ms-5 w-50 mt-5" > 
			{{ $errors->first() }} 
	</div></center>
	@endif

	{{-- @if(session('errors'))
    <div class="alert alert-danger"> {{session('errors')}} </div>
    @endif --}}

	@if(isset($products) && $products->isNotEmpty())
    <div class="container" style="width:82%;margin-top:20px;">
        <img src="{{ asset('uploads/Category/50.jpg') }}" alt="50%off" />
        <br>
        <div id="itemCount">We have {{ $products->count() }} Items That Fits Your <br>
			<h5> {{ $make . " " . $model . " ". $year . " " . "All Models" }} </h5>
		</div>
        <br>
        @foreach ($products as $product)
        <div class="product">
            <div class="column img">
                <div class="warranty">  
                    @if ($product->warranty == 'Lifetime')
                       <img src="{{ asset('uploads/Product/lifetimewarranty.webp') }}" alt="Lifetime"> 
                    @elseif($product->warranty == '+10')
                        <img src="{{ asset('uploads/Product/10_Year_Warranty.webp') }}" alt="10+ years">
                    @elseif($product->warranty == '+5')
                        <img src="{{ asset('uploads/Product/5_Year_Warranty.webp') }}" alt="10+ years">
                    @elseif($product->warranty == '+2')
                        <img src="{{ asset('uploads/Product/2_Year_Warranty.webp') }}" alt="10+ years">
                    @endif
                </div>
                <div class="proImg">
                    @foreach ($product->media as $item)
					<a class="proDetails" href=" {{route('singleProduct',$product->slug)}} "><img src="{{ asset('uploads/Product/' . $item->media ) }}" alt="{{ $product->name }}"></a>
                    @endforeach
                </div>
            </div>
            <div class="column description">
                <h4>{{ $product->name }}</h4>
				<div class="star">
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
				<small>{{ $make . " " . $model . " ". $year . " " . "All Models" }} </small>
               <p> {!! $product->description !!} </p>
			    @if ($product->warranty == 'Lifetime')
					<img src="{{ asset('uploads/Product/lifetime_rate.png') }}" alt="Lifetime">
				@elseif($product->warranty == '+10')
					<img src="{{ asset('uploads/Product/10_rate.png') }}" alt="10 Year">
				@elseif($product->warranty == '+5')
					<img src="{{ asset('uploads/Product/5_rate.png') }}" alt="5 Year">
			   @else
				   <img src="{{ asset('uploads/Product/2_rate.png') }}" alt="2 year">
			   @endif	
            </div>
            <div class="column price">
               <h3> ${{ $product->price }} </h3>
               <p>Free Shipping</p>

			   <form id="addToCart" action="{{route('addToCart')}}" method="get">

			   <div class="color-option">
				@foreach ($product->productOption as $key => $product_option)
					@if($product_option && $product_option->optionValue !=null)
					<input type="radio" id="color-{{$product->id}}[{{$key}}]" name="color[{{$product->id}}]" value="{{$product_option->optionValue->id}}"  {{ $key == 0 ? 'checked' : '' }}>
					<label for="color-{{$product->id}}[{{$key}}]" style="background-color:{{ $product_option->optionValue->option_value }}"></label>
					@endif
				@endforeach
				</div>

               	<div class="qty-input">
                    <button class="qty-count qty-count--minus" data-action="minus" type="button">-</button>
                    <input class="product-qty" type="number" name="product-qty" min="0" max="10" value="1">
                    <button class="qty-count qty-count--add" data-action="add" type="button">+</button>
                </div>
				
                <button type="submit" class="btn cartBtn">Add to cart<i class="bi bi-cart"></i></button><br>
			</form>

                <a class="proDetails" href=" {{route('singleProduct',$product->slug)}} ">Product Details ></a>
            </div>	
        </div>
        @endforeach
    </div>
	@endif


    @push('script')
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
@include('footer')
