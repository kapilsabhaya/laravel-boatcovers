<x-app-layout>
    @push('title')
    <title>My Orders</title>
    @endpush


    {{-- @dd($myOrder) --}}
    <div class="container" style="width:82%;margin-top:20px;">
        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        @if($myOrder->isNotEmpty())

        <div style="display: flex" class="ms-5 mb-3">
            <h4>My Orders</h4>
        </div>

        <div class="ms-5">
            @foreach ($myOrder as $orders)
            @foreach ($orders as $order)
            @php
            $orderId = base64_encode($order->order_id);
            $productId =base64_encode($order->product_id);
            @endphp
            <a href="{{ route('orderReceipt', ['orderId' => $orderId, 'productId' => $productId]) }}">
            <div class="product-container">
                    <div class="product-card">
                        @foreach ($order->product->media as $media)
                        <div class="product-image">
                            <img src="{{asset('uploads/Product/'. $media->media)}}" alt="Product Image">
                        </div>
                        @endforeach
                        <div class="product-description">
                            <p>{{ $order->product->name }}</p>
                            @if($order->option)
                                @foreach ($order->option as $key => $item)
                                    @if(!is_array($item))
                                        <small>{{ ucfirst($key)." " . ":" . " " . $item }}</small>&nbsp;
                                    @elseif(is_array($item))
                                    @foreach ($item as $key => $item)
                                        <small> {{ $key . " " . $item }}</small>&nbsp;
                                    @endforeach
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        <div class="product-price">
                            <p>Amount: {{ $order->order->amount }}</p>
                            <p>Quantity: {{ $order->quantity }}</p>
                        </div>
                    </div>
                    @endforeach
                    @endforeach
                </div>
            </a>
        </div>
        @else
        <center>
            <h4 class="mt-5">You Haven't Shopped Anything Yet...!</h4><br>
            <a class="btn" href="{{route('dashboard')}}"><button>Continue Shopping <i
                        class="bi bi-arrow-right"></i></button></a>
        </center>
        @endif
    </div>
</x-app-layout>