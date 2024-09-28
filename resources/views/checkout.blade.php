<x-app-layout>
    @push('title')
    <title>Checkout</title>
    @endpush
    <div class="container" style="width:82%;margin-top:20px;">
        @if(session()->has('error'))
        <div class="alert alert-danger"> {{session('error')}} </div>
        @endif
        <form method="post" action="{{ route('validateData') }}">
            @csrf
            <div class="row checkout">
                <div class="col-6 contact">
                    <div>
                        <div class="form-group">
                            <h4>Contact</h4>
                            <input type="email" class="form-control" id="" name="email" placeholder="Enter email">
                            <x-input-error :messages="$errors->get('email')" class="mt-2 error" />
                        </div>
                        <br>
    
                        <div class="form-group delivery">
                            <h4>Delivery</h4>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <input type="text" name="fname" class="form-control" id="" placeholder="First Name">
                                    <x-input-error :messages="$errors->get('fname')" class="mt-2 error" />
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" name="lname" class="form-control" id="" placeholder="Last Name">
                                    <x-input-error :messages="$errors->get('lname')" class="mt-2 error" />
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <textarea name="address" id="" class="form-control" cols="30" rows="3" placeholder="Address"></textarea>
                                <x-input-error :messages="$errors->get('address')" class="mt-2 error" />
                            </div>
                            <br>
                            <div class="form-group">
                                <input type="text" name="country" placeholder="Country" class="form-control" id="">
                                <x-input-error :messages="$errors->get('country')" class="mt-2 error" />
                            </div>
                            <br>
    
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <input type="text" name="city" placeholder="City" class="form-control" id="">
                                    <x-input-error :messages="$errors->get('city')" class="mt-2 error" />
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="text" name="state" placeholder="State" class="form-control" id="">
                                    <x-input-error :messages="$errors->get('state')" class="mt-2 error" />
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="text" name="zipcode" class="form-control" placeholder="Zipcode" id="inputZip">
                                    <x-input-error :messages="$errors->get('zipcode')" class="mt-2 error" />
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <input type="text" pattern="[0-9]{10}" class="form-control" id="" name="phone" placeholder="Phone Number">
                                <x-input-error :messages="$errors->get('phone')" class="mt-2 error" />
                            </div>
                        </div>
                        <br><br>
    
                        <div class="form-group address_selector">
                            <h4>Billing Address</h4>
                            <div class="form-check shipping">
                                <input class="form-check-input" type="radio" name="address_selector" id="address_selector" value="shipping" checked>
                                <label class="form-check-label" for="">
                                  Same as shipping address
                                </label>
                              </div>
                              <div class="form-check billing">
                                <input class="form-check-input" type="radio" name="address_selector" id="address_selector" value="billing">
                                <label class="form-check-label" for="">
                                  Use a different billing address
                                </label>
                              </div>
                        </div><br>
    
                        <div class="form-group payment">
                            <h4>Payment</h4>
                            <input type="hidden" name="payment_method" id="payment_method">
                            <button class="paypal" title="Pay with paypal" onclick="document.getElementById('payment_method').value='paypal'"><img src="{{asset('uploads/Product/paypal.webp')}}" alt="paypal"></button>
                            <button class="braintree" title="Pay with braintree" onclick="document.getElementById('payment_method').value='braintree'"><img src="{{asset('uploads/Product/braintree.png')}}" alt="braintree"></button>
                            <button class="stripe" title="Pay with Stripe" onclick="document.getElementById('payment_method').value='stripe'"><img src="{{asset('uploads/Product/stripe.png')}}" alt="stripe"></button>
                        </div>
    
                    </div>
                </div>
    
                <div class="col-6 order table-responsive">
                    <table class="table table-active">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col"> </th>
                                {{-- <th style="padding-left:115px;" scope="col">Quantity</th> --}}
                                <th scope="col" style="padding-left:10%;">Price</th>
                            </tr>
                        </thead>
    
                        <tbody>
                            @php
                            $totalQuantity = 0;
                            $totalPrice = 0;
                            @endphp
                            @foreach ($products as $productCollection)
                            @foreach ($productCollection['product'] as $product)
                            <tr>
                                <td>
                                    @foreach ($product->media as $media)
                                    <div class="qty">{{ $productCollection['quantity'] }}</div>
                                    <img src="{{asset('uploads/Product/'. $media->media)}}" alt="" srcset=""
                                        style="width:70px;height:70px">
                                    @endforeach
                                </td>
    
    
                                <td>
                                    {{ $product->name }}
                                    <br>
                                    @foreach ($product->productOption as $key => $product_option)
                                    @if ($product_option->optionValue && $product_option->optionValue->option)
                                    @php
                                    $optionName = (strtolower($product_option->optionValue->option->option_name));
                                    @endphp
    
                                    @if ($optionName == 'color')
                                    <small>Color : {{ $product_option->optionValue->option_value }}</small>
                                    @elseif ($optionName == 'size')
                                    <br>
                                    <small>Size : {{ $product_option->optionValue->option_value }}</small>
                                    @endif
                                    @endif
                                    @endforeach
                                </td>
    
                                <td>
                                    @php
                                    $price = $productCollection['price'] * $productCollection['quantity'];
                                    $totalPrice += $price;
                                    $totalQuantity += $productCollection['quantity'];
                                    @endphp
    
                                </td>
    
                                <td>
                                    <p class="price">{{ "$". $price }}</p>
                                </td>
    
                            </tr>
                            @endforeach
                            @endforeach
    
                            <tr>
                                <td>Subtotal ({{ $totalQuantity }} items)</td>
                                <td></td>
                                <td style="padding-left:10%">${{ $totalPrice }}</td>
                            </tr>
                            <tr>
                                <td><b>
                                        <h5>Total</h5>
                                    </b></td>
                                <td></td>
                                <td style="padding-left:10%"><b>
                                        <h5>${{ $totalPrice }}</h5>
                                    </b></td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="amount" value="{{$totalPrice}}">
                </div>
            </div>
        </form>
    </div>
    @push('script')
    <script>
        $(document).ready(function() {
            // Show billing address form when "Use a different billing address" is selected
            $('input[name="address_selector"]').on('change', function() {
                if ($(this).val() == 'billing') {
                    var billingFields = `
                        <div class="billing-info">
                            <br>
                            <h4>Billing Information</h4>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" name="billing_first_name" placeholder="Billing First Name">
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" name="billing_last_name" placeholder="Billing Last Name">
                                </div>
                            </div><br>
                            <div class="form-group">
                                <textarea name="billing_address" id="" class="form-control" cols="30" rows="3" placeholder="Billing Address"></textarea>
                            </div><br>
                            <div class="form-group">
                                <input type="text" name="billing_country" placeholder="Billing Country" class="form-control" id="">
                            </div><br>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <input type="text" class="form-control" name="billing_city" placeholder="Billing City">
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="text" class="form-control" name="billing_state" placeholder="Billing State">
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="text" class="form-control" name="billing_zipcode" placeholder="Billing Zipcode">
                                    <x-input-error :messages="$errors->get('billing_zipcode')" class="mt-2 error" />
                                </div>
                            </div><br>
                            <div class="form-group">
                                <input type="text" name="billing_phone" placeholder="Billing Phone Number" class="form-control" id="">
                                <x-input-error :messages="$errors->get('billing_phone')" class="mt-2 error" />
                            </div><br>
                        </div>`;
                    $('.billing').after(billingFields);
                } else {
                    $('.billing-info').remove();
                }
            });
        });
    </script>
    
    @endpush
</x-app-layout>