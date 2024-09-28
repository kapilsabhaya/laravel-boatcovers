<x-admin-layout>
    @push('title')
    <title>Manage Product </title>
    @endpush
    <link rel="stylesheet" href="{{ asset('assets/extensions/quill/quill.snow.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/quill/quill.bubble.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/filepond/filepond.css') }}">

    <section class="section">
        <div class="card">

            <div style="display: flex; align-items: center;">
                <div class="card-header">
                    <h5 class="card-title">
                        Product Details
                    </h5>
                </div>
                <div class="ms-auto pe-5">
                    <a href="{{ route('product.index') }}" class="buttons btn btn-primary">Back</a>
                </div>
            </div>

            <div class="card-body">
                @foreach ($product as $item)

                <form class="updateProduct" id='addPro' method="post">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" class="productId" value="{{ $item->id }}">
                    <label for="">Image</label>
                    <input type="file" name="image[]" multiple class="image-preview-filepond">
                    <br>
                    <div class="row">
                        <div class="col-6">
                            <label for="">Product Name</label>
                            <input type="text" value="{{ $item->name }}" autocomplete="off"
                                class="pname form-control round" name="pname" placeholder="Product Name">
                            <p id="pnameError"></p>
                        </div>
                        <div class="col-6">
                            <label for="">Category</label>
                            <select required name="category" class="form-control">
                                @if ($category && $category->isNotEmpty())
                                @foreach ($category as $key => $cat)
                                <option @if($cat->id == $item->category_id) selected @endif value="{{ $cat->id }}">{{
                                    $cat->category_name }}</option>
                                @endforeach
                                @else
                                <option selected disabled value="">No Master Category Available</option>
                                @endif
                            </select>
                        </div>
                    </div>


                    <label for="" class="form-label">Description</label>
                    <div id="full">
                        {!! $item->description!!}   
                    </div>
                    <input type="hidden" name="desc" id="hiddenDesc">
                    <p id="descError"></p>
                    <br>
                    <div class="row">
                        <div class="col-4">
                            <label for="">Price($)</label>
                            <input value="{{ $item->price }}" autocomplete="off" type="number" id="" name="price"
                                class="prc form-control round" step="0.01" placeholder="Price" min="100">
                            <p id="priceError"></p>
                        </div>
                        <div class="col-4">
                            <label for="">Quantity</label>
                            <input value="{{ $item->quantity }}" autocomplete="off" type="number" name="qty"
                                class="qty form-control round" placeholder="Quantity" min="1">
                            <p id="qtyError"></p>
                        </div>
                        <div class="col-4">
                            <label for="">Warranty</label>
                                <select name="warranty" class="war form-control round">
                                    <option @if($item->warranty === "Lifetime") selected @endif value="Lifetime">Lifetime</option>
                                    <option @if($item->warranty === "+10") selected @endif value="+10">10+ years</option>
                                    <option @if($item->warranty === "+5") selected @endif value="+5">5+ years</option>
                                    <option @if($item->warranty === "+2") selected @endif value="+2">2+ years</option>
                                </select>
                            <p id="warrantyError"></p>
                        </div>
                    </div>

                    <br>
                    <div class="row">
                        <div class="col-4">
                            <label for="">Is Active?</label>
                            <input type="radio" name="is_active" value="1" class="form-check-input" @if($item->is_active
                            == 1) checked @endif>&nbsp;&nbsp;Yes
                            <input type="radio" name="is_active" value="0" class="form-check-input" @if($item->is_active
                            == 0) checked @endif>&nbsp;No
                            <p id="isactiveError"></p>
                        </div>
                        <div class="col-4">
                            <label for="">Is Customizable?</label>
                            <input type="radio" name="is_customizable" @if($item->is_customizable == 1) checked @endif
                            value="1" class="form-check-input">&nbsp;&nbsp;Yes
                            <input type="radio" name="is_customizable" @if($item->is_customizable ==0 ) checked @endif
                            value="0" class="form-check-input">&nbsp;No
                            <p id="iscustomizableError"></p>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-6">
                            <label for="">Product Sort Order</label>
                            <input autocomplete="off" type="number" name="product_sort_order"
                                value="{{ $item->sort_order }}" class="product_sort_ord form-control round"
                                placeholder="Sort Order" min="0">
                            <p id="psort_orderError"></p>
                        </div>
                        <div class="col-6">
                            <label for="">Slug</label>
                            <input value="{{ $item->slug }}" autocomplete="off" readonly type="text" name="slug"
                                class="slug form-control round" placeholder="Slug">
                            <p id="slugError"></p>
                        </div>
                    </div>


                    <button type="submit" class="btn btn-primary" style="margin-left:80%">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Update Product</span>
                    </button>
                </form>
                @endforeach
            </div>
        </div>
    </section>

    @push('script')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js" defer></script>
    <script src="{{ asset('assets/static/js/pages/quill.js') }} "></script>
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
    <script>
        // slug script
        $(".pname").change(function() {
            value = $(this).val();
            $.ajax({
                type: "get",
                url: "{{ route('getSlug') }}",
                data: {title : value},
                dataType: "json",
                success: function (response) {
                    if(response["status"] === true) {
                        $(".slug").val(response["slug"]);
                    }
                }
            });
        });

        //option option val script
        // $(".option").change(function() {
        //     var option = $(this).val();
        //     $.ajaxSetup({
        //             headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //                 }
        //     });
        //     $.ajax({
        //     type: "POST",
        //     url: "{{ route('getOptionValue',':id') }}".replace(':id',option),
        //     dataType: "json",
        //     success: function (response) {
        //         var dropdown = $('#optionValDropDown');
        //         dropdown.empty();
        //         if(response.optVal.length === 0) {
        //             dropdown.append('<option selected  disabled>No Option Value</option>');
        //         } else {
        //             response.optVal.forEach(function(item) {
        //             var option = $('<option></option>').attr('value', item.option_val_id).text(item.option_value);
        //             dropdown.append(option);
        //             });
        //         }
        //     }
        //     });
        // });

       
        //update product script
        $(document).on('submit' , '.updateProduct' , function (event) {
            event.preventDefault();
            var id = $(this).find('.productId').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('product.update',':id') }}".replace(':id',id),
                data: new FormData(this),
                dataType: "json",
                cache : false,
                processData: false,
                contentType : false,
                success: function (response) {
                    if(response.status === 200) {
                        const showToast = (options) => {
                            Toastify(options).showToast();
                        };
                        showToast({
                            text: response.message,
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "green",
                        });
                    } else if (response.errors) {
                        var errors = response.errors;
                        if(errors['pname']){
                            $('.pname').addClass('is-invalid').next('#pnameError').addClass('invalid-feedback').html(errors.pname).show();
                        } else {
                            $('.pname').removeClass('is-invalid').next('#pnameError').removeClass('invalid-feedback').html(errors.pname).hide();
                        }

                        if(errors['desc']){
                            $('.desc').addClass('is-invalid').next('#descError').addClass('invalid-feedback').html(errors.desc).show();
                        } else {
                            $('.desc').removeClass('is-invalid').next('#descError').removeClass('invalid-feedback').html(errors.desc).hide();
                        }

                        if(errors['price']){
                            $('.prc').addClass('is-invalid').next('#priceError').addClass('invalid-feedback').html(errors.price).show();
                        } else {
                            $('.prc').removeClass('is-invalid').next('#priceError').removeClass('invalid-feedback').html(errors.price).hide();
                        }

                        if(errors['qty']){
                            $('.qty').addClass('is-invalid').next('#qtyError').addClass('invalid-feedback').html(errors.qty).show();
                        } else {
                            $('.qty').removeClass('is-invalid').next('#qtyError').removeClass('invalid-feedback').html(errors.qty).hide();
                        }

                        if(errors['warranty']){
                            $('.war').addClass('is-invalid').next('#warrantyError').addClass('invalid-feedback').html(errors.warranty).show();
                        } else {
                            $('.war').removeClass('is-invalid').next('#warrantyError').removeClass('invalid-feedback').html(errors.warranty).hide();
                        }

                        if(errors['is_active']){
                            $('#isactiveError').addClass('invalid-feedback').html(errors.is_active).show();
                        } else {
                            $('#isactiveError').removeClass('invalid-feedback').html(errors.is_active).hide();
                        }
                        
                        if(errors['is_customizable']){
                            $('#iscustomizableError').addClass('invalid-feedback').html(errors.is_customizable).show();
                        } else {
                            $('#iscustomizableError').removeClass('invalid-feedback').html(errors.is_customizable).hide();
                        }

                        if(errors['product_sort_order']){
                            $('.product_sort_ord').addClass('is-invalid').next('#psort_orderError').addClass('invalid-feedback').html(errors.product_sort_order).show();
                        } else {
                            $('.product_sort_ord').removeClass('is-invalid').next('#psort_orderError').removeClass('invalid-feedback').html(errors.product_sort_order).hide();
                        }

                        if(errors['slug']){
                            $('.slug').addClass('is-invalid').next('#slugError').addClass('invalid-feedback').html(errors.slug).show();
                        } else {
                            $('.slug').removeClass('is-invalid').next('#slugError').removeClass('invalid-feedback').html(errors.slug).hide();
                        }

                        if(errors['option']){
                            $('#optionError').addClass('invalid-feedback').html(errors.option).show();
                        } else {
                            $('#optionError').removeClass('invalid-feedback').html(errors.option).hide();
                        }

                        if(errors['optVal']){
                            $('#optValError').addClass('invalid-feedback').html(errors.optVal).show();
                        } else {
                            $('#optValError').removeClass('invalid-feedback').html(errors.optVal).hide();
                        }

                        if (errors['base_price']) {
                                $('#bprice').addClass('is-invalid').next('#bpriceError').addClass('invalid-feedback').html(errors.base_price).show();
                        } else {
                            $('#bprice').removeClass('is-invalid').next('#bpriceError').removeClass('invalid-feedback').html(errors.base_price).hide();
                        }

                        if (errors['price_increment']) {
                            $('#pinc').addClass('is-invalid').next('#priceIncrementError').addClass('invalid-feedback').html(errors.price_increment).show();
                        } else {
                            $('#pinc').removeClass('is-invalid').next('#priceIncrementError').removeClass('invalid-feedback').html(errors.price_increment).hide();
                        }

                        if(errors['option_sort_order']){
                            $('#option_sort_ord').addClass('is-invalid').next('#osort_orderError').addClass('invalid-feedback').html(errors.option_sort_order).show();
                        } else {
                            $('#option_sort_ord').removeClass('is-invalid').next('#osort_orderError').removeClass('invalid-feedback').html(errors.option_sort_order).hide();
                        }
                        if(errors['setting_name']){
                            $('#sname').addClass('is-invalid').next('#setNameError').addClass('invalid-feedback').html(errors.setting_name).show();
                        } else {
                            $('#sname').removeClass('is-invalid').next('#setNameError').removeClass('invalid-feedback').html(errors.setting_name).hide();
                        }
                        if(errors['setting_value']){
                            $('#svalue').addClass('is-invalid').next('#setValError').addClass('invalid-feedback').html(errors.setting_value).show();
                        } else {
                            $('#svalue').removeClass('is-invalid').next('#setValError').removeClass('invalid-feedback').html(errors.setting_value).hide();
                        }
                        if(errors['set_price_increment']){
                            $('#set_pinc').addClass('is-invalid').next('#set_priceIncrementError').addClass('invalid-feedback').html(errors.set_price_increment).show();
                        } else {
                            $('#set_pinc').removeClass('is-invalid').next('#set_priceIncrementError').removeClass('invalid-feedback').html(errors.set_price_increment).hide();
                        }
                    } else if(response.status == 500) {
                        const showToast = (options) => {
                            Toastify(options).showToast();
                        };
                        showToast({
                            text: response.message,
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "red",
                        });
                    }
                }
            }); 
        });
    </script>
    @endpush
</x-admin-layout>