<x-app-layout>
    <div class="container" style="width:82%;margin-top:20px;">
        <img src="{{ asset('uploads/Category/50.jpg') }}" alt="50%off">
        @if ($sub_category->isNotEmpty())
            <div class="chooseSelection">
                <h2> Choose Your {{ $sub_category->first()->category_name }} </h2>
                <span></span>
            </div>
            <div class="row">
                @foreach ($sub_category as $item)
                    <div class="col-3 previewDiv">
                        <a href="{{ route('subCatPatio',$item->slug) }}">
                            <img src="{{ asset('uploads/Category/'.$item->image) }}" alt="{{ $item->sub_category_name }}"></a>
                        <p> {{ $item->sub_category_name}} </p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>