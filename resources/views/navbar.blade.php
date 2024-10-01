<?php
$master = App\Models\MasterCategory::where('status',true)->get();
?>

<!-- header start -->
<div class="header">
    <div class="container">
        <!-- navigation bar start -->
        <div class="container-navbar p-3 d-flex flex-wrap">
            <!-- nav-left -->
            <div class="navbar-left col-md-2">
                <a href="{{ route('dashboard') }}"><img  src="{{ asset('resource/logo.png') }}" class="brand-logo" /></a>
            </div>
            <!-- nav-middle -->
            <div class="navbar-mid col-md-6 text-start">
                <div class="nav-menus">
                    <ul class="d-flex flex-wrap">
                        {{-- @foreach ($master as $key => $item)
                        @php
                            $category = DB::table('category')->where('master_category_id', $item->id)->where(function($query) {
                                    $query->whereNull('sub_category_name')
                                        ->whereNull('image');
                                    })->get();
                        @endphp
                        
                        @if ($category->isEmpty())
                            <li class="master-category" data-mas-id="{{ $item->id }}" style="padding:13px">
                                <a> {{ $item->master_category_name }}</a>
                            </li>
                        @else
                            <li style="padding:13px"><a href="{{ route('handleSlug',$item->slug) }}">{{ $item->master_category_name }}</a></li>
                        @endif
                        @endforeach --}}
                        {{-- ================================== --}}
                         {{-- @foreach ($master->slice(3,) as $key=>$mat)
                            <li style="padding:13px"><a href="{{ route('handleSlug',$mat->slug) }}">{{ $mat->master_category_name }}</a></li>
                        @endforeach 
                        @foreach ($master as $key => $item)
                            @php
                                $category = Db::table('category')->where('master_category_id',$item->id)->where('sub_category_name',!null)->where('image',!null)->get();
                            @endphp 
                            @if ($category)
                                <li class="master-category" data-mas-id="{{ $item->id }}" style="padding:13px">
                                    <a> {{ $item->master_category_name }}</a>
                                </li>
                            @else
                            <li style="padding:13px"><a href="{{ route('handleSlug',$item->slug) }}">{{ $item->master_category_name }}</a></li>
                                
                            @endif
                        @endforeach  --}}

                        {{-- ================================== --}}

                        @foreach ($master->slice(0,3) as $key => $item)
                        <li class="master-category" data-mas-id="{{ $item->id }}" style="padding:13px">
                            <a> {{ $item->master_category_name }}</a>
                        </li>
                        @endforeach

                        @foreach ($master->slice(3,) as $mat)
                            <li style="padding:13px"><a href="{{ route('handleSlug',$mat->slug) }}">{{ $mat->master_category_name }}</a></li>
                        @endforeach 
                        
                        <li style="padding:13px"><a href="#">Help</a></li>
                    </ul>
                </div>

            </div>
            <!-- nav-right -->
            <div class="navbar-right col-md-4 text-center">
                <div class="right-menus">
                    <div class="left p-2">
                        <i class="bi bi-telephone-x bold p-1"></i>
                        <span>800-915-0038</span>
                    </div>
                    <div class="right  p-2">
                        <a href="{{ route('cartView') }}">
                            <i class="bi bi-cart3 bold p-1"></i>
                            <span>Cart</span>
                        </a>
                    </div>
                </div>
                <div class="myOrders"><a href="{{route('myOrder')}}"><i class="bi bi-basket-fill" title="My Orders"></i></a></div>
            </div>

        </div>
        <div id="subcategory-navbar" class="d-none">
            <div class="subnav-content">
                <ul id="subcategory-list"></ul>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.master-category').mouseenter(function(){

            var masId = $(this).data('mas-id');
            $myData = null;
            $.ajax({
                type: "get",
                url: "{{ route('getSubCategory',':id') }}".replace(':id', masId),
                dataType: "json",
                cache: false,
                contentType : false,
                processData: false,
                
                success: function (response) {
                    if(response.subcategories.length > 0) {
                        $('#subcategory-list').empty();
                            $.each(response.subcategories, function(index, subcategory) {
                                var imageUrl = "{{ asset('uploads/Category/') }}/" + subcategory.image;
                                var url = "{{ route('handleSlug',':slug') }}".replace(':slug',subcategory.slug);
                                
                                $('#subcategory-list').append('<li id="subcat-' + subcategory.id + '">' +
                                    '<a href="' + url +'">' +
                                        '<img src="' + imageUrl + '" alt="' + subcategory.category_name + ' image" >' +
                                        '<div  class="cat_name text-white">' + subcategory.category_name + '</div>' + '</a>' +
                                        '</li>');
                                    });
                        $('#subcategory-navbar').removeClass('d-none');
                    } 
                }
            });
        });

        $('.master-category').mouseleave(function() {
            // do nothing, let the subcategory navbar stay visible
        });

        $('#subcategory-navbar').on('mouseleave', function() {
            setTimeout(function() {
                $('#subcategory-navbar').addClass('d-none');
            }, 500); 
        });

        $('#subcategory-navbar li').on('mouseleave', function() {
            setTimeout(function() {
                $('#subcategory-navbar').addClass('d-none');
            }, 500); 
        });
    });
</script>
<!-- header end -->