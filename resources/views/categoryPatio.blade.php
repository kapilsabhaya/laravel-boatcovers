<x-app-layout>
    <div class="container" style="width:82%;margin-top:20px;">
        <img src="{{ asset('uploads/Category/50.jpg') }}" alt="50%off">

    <div class="chooseSelection">
        <h2> Choose Your Category </h2>
        <span></span>
    </div>

    <div class="row">
        @foreach ($category as $item)
        <div class="col-3 previewDiv">
            @php
            //convert into slug
                $cname = $item->category_name;
                $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($cname));
            @endphp

        <a href="{{route('subCatPatio',$slug)}}"><div>{{ $item->category_name}}</div> </a>
        {{-- <a href="{{route('subCatPatio',$item->category_slug)}}"><div>{{ $item->category_name}}</div> </a> --}}
        </div>
        @endforeach
    </div>  
</div>
</x-app-layout>