<x-app-layout>
    {{-- @dd($order) --}}
    @if($order)
    @php
        $address = $order->order->order_address;
    @endphp

    <div class="container" style="width:82%;margin-top:20px;">
        <div class="address-container">
            @if($address->shipping_address)
                <div class="shipping-address">
                    <h5 class="mb-4">Shipping Address</h5>
                    @if(Auth::check())
                    <b><h6> {{ Auth::user()->name }}</b></h6>
                    @else
                    <b><h6>{{ $guest->name }}</b></h6>
                    @endif

                    {{ $address->shipping_address }}

                    <br><br>
                    <b><h6>Phone number</h6></b> {{ $address->shipping_phone }} 
                </div>
            @endif
            @if($address->billing_address)
                <div class="billing-address ps-5">
                    <h5 class="mb-4">Billing Address</h5>
                    <b><h6> {{ $address->billing_person_name }} </h6></b>
                    {{ $address->billing_address }}
                    <br><br>
                    <b><h6>Phone number</h6></b> {{ $address->billing_phone }} 
                </div>
            @endif
        </div>

        
        {{-- <div style="border: 1px solid #ddd; padding: 20px; background: #fff; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); border-radius: 8px; max-width: 400px; margin: 20px auto;">
            <div style="text-align: center; margin-bottom: 15px;">
                <img src="{{ asset('uploads/Product/'. $order->order->order_product[0]->product->media[0]->media) }}" alt="" style="max-width: 100%; border-radius: 5px;">
            </div>
            <div style="padding: 0 10px; margin-bottom: 10px;">
                <p style="font-weight: bold; font-size: 1.2rem; margin-bottom: 5px;">{{ $order->order->order_product[0]->product->name }}</p>
                
                <!-- Product Options -->
                @if($order->option)
                    @foreach ($order->option as $key => $item)
                        @if(!is_array($item))
                            <small style="display: inline-block; background: #f0f0f0; padding: 5px 10px; border-radius: 4px; margin: 2px;">{{ ucfirst($key)." : ". $item }}</small>
                        @elseif(is_array($item))
                            @foreach ($item as $key => $item)
                                <small style="display: inline-block; background: #f0f0f0; padding: 5px 10px; border-radius: 4px; margin: 2px;">{{ $key . " " . $item }}</small>
                            @endforeach
                        @endif
                    @endforeach
                @endif
            </div>
        </div> --}}

        <div style="display: flex; border: 1px solid #ddd; padding: 20px; background: #fff; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); border-radius: 8px; max-width: 600px; margin: 20px;">
            <div style="flex: 1; margin-right: 20px;">
                <img src="{{ asset('uploads/Product/'. $order->order->order_product[0]->product->media[0]->media) }}" alt="" style="width: 100%; height: auto; border-radius: 5px;">
            </div>
            
            <div style="flex: 2;">
                <p style="font-weight: bold; font-size: 1.2rem; margin-bottom: 10px;">{{ $order->order->order_product[0]->product->name }}</p>
                
                @if($order->option)
                    @foreach ($order->option as $key => $item)
                        @if(!is_array($item))
                            <small style="display: inline-block; background: #f0f0f0; padding: 5px 10px; border-radius: 4px; margin: 2px;">{{ ucfirst($key)." : ". $item }}</small>
                        @elseif(is_array($item))
                            @foreach ($item as $key => $item)
                                <small style="display: inline-block; background: #f0f0f0; padding: 5px 10px; border-radius: 4px; margin: 2px;">{{ $key . " : " . $item }}</small>
                            @endforeach
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
        
        
        

    </div>

    @endif
</x-app-layout>
