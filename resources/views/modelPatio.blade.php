<x-app-layout>
    <div class="container" style="width:82%;margin-top:20px;">
        <img src="{{ asset('uploads/Category/50.jpg') }}" alt="50%off">
        @if ($product->isNotEmpty())
            <div class="chooseSelection">
                <h2> Choose Your {{ $product->first()->getCategory->sub_category_name }} </h2>
                <span></span>
            </div>
            <div class="row">
                @foreach ($product as $item)
                    <div class="col-3 previewDiv">
                        @foreach ($item->media as $img)
                            <a href="{{route('singleProduct',$item->slug)}}"><img src="{{ asset('uploads/Product/'.$img->media) }}" alt="{{ $item->name }}"></a>
                        @endforeach
                        <p> {{ $item->name}} </p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>