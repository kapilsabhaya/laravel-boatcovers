<x-admin-layout>
    @push('title')
    <title>Manage Product </title>
    @endpush
    <link rel="stylesheet" href="{{ asset('assets/extensions/quill/quill.snow.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/quill/quill.bubble.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/filepond/filepond.css') }}">

    <style>
        .updateProduct .updateProductImg button{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            opacity:0.6;
            background-color: grey;
            height:40%;
            width:40%;
            border-radius:2px;
        }
        .updateProduct .updateProductImg button:hover{
            color:white;
        }
    </style>
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
                <form class="updateProduct" id='updateProductForm' method="post">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" class="productId" value="{{ $item->id }}">
                    
                    <div class="updateProductImg">
                        @foreach ($item->media as $media)
                            <div style="position: relative; display: inline-block;">
                                <img src="{{ asset('uploads/Product/'.$media->media) }}" alt="{{$item->name}}" style="margin:1px; height:90px; width:90px;">
                                <button class="deleteImg" type="button" data-img-id="{{$media->id}}" ><i class="bi bi-trash3-fill"></i></button>
                            </div>
                        @endforeach
                    </div>
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
                                <option @if($cat->id == $item->category_id) selected @endif value="{{ $cat->id }}">
                                    {{ $cat->category_name }} @if($cat->sub_category_name != null) {{"(" . $cat->sub_category_name . ")" }} @endif</option>
                                @endforeach
                                @else
                                <option selected disabled value="">No Master Category Available</option>
                                @endif
                            </select>
                        </div>
                    </div>


                    <label for="" class="form-label">Description</label>
                    <div id="full"> {!! $item->description !!}</div>
                    <input type="hidden" name="desc" id="hiddenDesc">
                    <p id="descError"></p>
                    <br>

                    <div class="row">
                        <div class="col-4">
                            <label for="">Price($)</label>
                            <input value="{{ $item->price }}" autocomplete="off" type="number" id="" name="price"
                                class="prc form-control round" step="0.01" placeholder="Price" >
                            <p id="priceError"></p>
                        </div>
                        <div class="col-4">
                            <label for="">Quantity</label>
                            <input value="{{ $item->quantity }}" autocomplete="off" type="number" name="qty"
                                class="qty form-control round" placeholder="Quantity" >
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

                    <div class="card-header">
                        <h5 class="card-title">
                            Options
                        </h5>
                    </div>
                    {{-- OPTIONS --}}
                    @foreach($item->productOption as $options)
                    <div class="optionValue">
                        <br>
                        <div class="row">
                            <div class="col-3">
                                <label for="">Option Name</label>
                                <select name="option[]" class="option form-control">
                                    @if ($option->isNotEmpty())
                                        <option selected disabled>Select Option</option>
                                        @foreach ($option as $opt)
                                            <option @if($options->optionValue->option_id == $opt->id) selected @endif value="{{$opt->id}}">{{ $opt->option_name }}</option>
                                        @endforeach
                                    @else
                                        <option selected disabled>No Option Available</option>
                                    @endif
                                </select>
                                <p id="optionError"></p>
                            </div>
                            <div class="col-3">
                                <label for="">Option Value</label>
                                <select name="optVal[]" class="optionValDropDown form-control">
                                    <option selected value="{{$options->optionValue->id}}">{{ $options->optionValue->option_value}}</option>
                                </select>
                                <p id="optValError"></p>
                            </div>
                            <div class="col-6">
                                <label for="">Base Price</label>
                                <input type="number" id="bprice" autocomplete="off" name="base_price[]"
                                step="0.01" value="{{ $options->base_price }}" class="form-control round" placeholder="Base Price">
                                <p id="bpriceError"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="">Price Increment</label>&nbsp;&nbsp;<small><i>can skip</i></small>
                                <input type="number" autocomplete="off" id="pinc" name="price_increment[]"
                                    class="form-control round" value="{{ $options->price_increment }}" placeholder="In (%)" min="0">
                                <p id="priceIncrementError"></p>
                            </div>
                            <div class="col-6">
                                <label for="">Option Sort Order</label>
                                <input autocomplete="off" type="number" name="option_sort_order[]" id="option_sort_ord"
                                    class="form-control round" value="{{ $options->sort_order }}" placeholder="Sort Order" min="0">
                                <p id="osort_orderError"></p>
                            </div>
                        </div>
                    </div>
                    <button class="removeOption btn btn-danger float-right">Remove</button>
                    @endforeach
                    <button type="button" class="btn btn-primary add-option-btn">Add Option</button>
                    <div class="optionContainer"></div> 
                    {{-- OPTIONS --}}

                    {{-- SETTINGS --}}
                    <hr>
                    <br>
                    <div class="card-header">
                        <h5 class="card-title">
                             Settings
                        </h5>
                    </div>
                        @foreach ($item->setting as $setting)
                        <div class="setting">
                            <br>
                            <div class="row">
                                <div class="col-6">
                                    <label for="">Setting Name</label>
                                    <input type="text" class="form-control" id="sname" placeholder="Ex. Shipping"
                                        value="{{ $setting->setting_name }}" autocomplete="off" name="setting_name[]" id="setting_name">
                                    <p id="setNameError"></p>
                                </div>
                                <div class="col-6">
                                    <label for="">Value</label>
                                    <input type="text" id="svalue" class="form-control" placeholder="Free/12.7"
                                    value="{{ $setting->value }}"  autocomplete="off" name="setting_value[]">
                                    <p id="setValError"></p>
                                </div>
                                <input type="hidden" name="setting_id[]" value="{{$setting->id}}">
                            </div>
                        </div>
                    <button class="removeSetting btn btn-danger float-right">Remove</button>
                        @endforeach
                    <button type="button" class="btn btn-primary add-setting-btn">Add Setting</button>
                    <div class="settingContainer"></div>
                    {{-- SETTINGS --}}

                    <button type="submit" class="btn btn-primary" style="margin-left:80%">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Update Product</span>
                    </button>
                </form>
                <input type="hidden" form="updateProductForm" name="product_id" value="{{$item->id}}">
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

        //===========clone option script
        const optionContainer = document.querySelector('.optionContainer');
        const originalOption = document.querySelector('.optionValue');
        const addOptionButton = document.querySelector('.add-option-btn');

        //create a template foe option div
        // const optionTemplate = `
        //     <div class="optionValue">
        //         <br>
        //         <div class="row">
        //             <div class="col-3">
        //                 <label for="">Option Name</label>
        //                 <select name="option[]" class="option form-control">
        //                     @if ($option->isNotEmpty())
        //                         <option selected disabled>Select Option</option>
        //                         @foreach ($option as $item)
        //                             <option value="{{$item->id}}">{{ $item->option_name }}</option>
        //                         @endforeach
        //                     @else
        //                         <option selected disabled>No Option Value Available</option>
        //                     @endif
        //                 </select>
        //                 <p id="optionError"></p>
        //             </div>
        //             <div class="col-3">
        //                 <label for="">Option Value</label>
        //                 <select name="optVal[]" class="optionValDropDown form-control"></select>
        //                 <p id="optValError"></p>
        //             </div>
        //             <div class="col-6">
        //                 <label for="">Base Price</label>
        //                 <input type="number" id="bprice" autocomplete="off" name="base_price[]"
        //                 step="0.01" class="form-control round" placeholder="Base Price">
        //                 <p id="bpriceError"></p>
        //             </div>
        //         </div>
        //         <div class="row">
        //             <div class="col-6">
        //                 <label for="">Price Increment</label>&nbsp;&nbsp;<small><i>can skip</i></small>
        //                 <input type="number" autocomplete="off" id="pinc" name="price_increment[]"
        //                     class="form-control round" placeholder="In (%)" min="0">
        //                 <p id="priceIncrementError"></p>
        //             </div>
        //             <div class="col-6">
        //                 <label for="">Option Sort Order</label>
        //                 <input autocomplete="off" type="number" name="option_sort_order[]" id="option_sort_ord"
        //                     class=" form-control round" placeholder="Sort Order" min="0">
        //                 <p id="osort_orderError"></p>
        //             </div>
        //         </div>
        //     </div>
        // `;
        const optionTemplate = `
            <div class="optionValue">
                <br>
                <div class="row">
                    <div class="col-3">
                        <label for="">Option Name</label>
                        <select name="option[]" class="option form-control">
                            <option selected disabled>Select Option</option>
                        </select>
                        <p id="optionError"></p>
                    </div>
                    <div class="col-3">
                        <label for="">Option Value</label>
                        <select name="optVal[]" class="optionValDropDown form-control">
                        </select>
                        <p id="optValError"></p>
                    </div>
                    <div class="col-6">
                        <label for="">Base Price</label>
                        <input type="number" id="bprice" autocomplete="off" name="base_price[]"
                        step="0.01" class="form-control round" placeholder="Base Price">
                        <p id="bpriceError"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="">Price Increment</label>&nbsp;&nbsp;<small><i>can skip</i></small>
                        <input type="number" autocomplete="off" id="pinc" name="price_increment[]"
                            class="form-control round" placeholder="In (%)" min="0">
                        <p id="priceIncrementError"></p>
                    </div>
                    <div class="col-6">
                        <label for="">Option Sort Order</label>
                        <input autocomplete="off" type="number" name="option_sort_order[]" id="option_sort_ord"
                            class=" form-control round" placeholder="Sort Order" min="0">
                        <p id="osort_orderError"></p>
                    </div>
                </div>
            </div>
        `;

        function createNewOption() {
            let newOptionRow;
            if(originalOption) {
                newOptionRow = originalOption.cloneNode(true);
            } else {
                newOptionRow = document.createElement('div');
                newOptionRow.innerHTML = optionTemplate;
            }

            const optionSelect = newOptionRow.querySelector('.option');
            const options = {!! $option !!}; 
            options.forEach(option => {
                const optionElement = document.createElement('option');
                optionElement.value = option.id;
                optionElement.textContent = option.option_name;
                optionSelect.appendChild(optionElement);
            });
            var dropdown = $(optionSelect).closest('.optionValue').find('.optionValDropDown');
            dropdown.empty();

            newOptionRow.querySelectorAll('input').forEach((element) => {
                element.value = '';
            });

            newOptionRow.querySelectorAll('p[id$="Error"]').forEach((element) => {
                element.remove();
            });
            const removeOption = document.createElement('button');
            removeOption.textContent = 'Remove';
            removeOption.classList.add('btn', 'btn-danger','float-right');
            newOptionRow.appendChild(removeOption);

            removeOption.addEventListener('click', () => {
                newOptionRow.remove();
            });
            optionContainer.appendChild(newOptionRow);
        }
        addOptionButton.addEventListener('click', createNewOption);
        
        //=================clone setting script
        const settingContainer = document.querySelector('.settingContainer');
        const originalSetting = document.querySelector('.setting');
        const addSettingButton = document.querySelector('.add-setting-btn');

        // Create a template for the setting div
        const settingTemplate = `
            <div class="setting">
                <br>
                <div class="row">
                    <div class="col-6">
                        <label for="">Setting Name</label>
                        <input type="text" class="form-control" id="sname" placeholder="Ex. Shipping" name="setting_name[]" autocomplete="off">
                        <p id="setNameError"></p>
                    </div>
                    <div class="col-6">
                        <label for="">Value</label>
                        <input type="text" id="svalue" class="form-control" placeholder="Free/12.7" name="setting_value[]" autocomplete="off">
                        <p id="setValError"></p>
                    </div>
                </div>
            </div>
        `;

        function createNewSetting() {
            let newSettingRow;
            if (originalSetting) {
                newSettingRow = originalSetting.cloneNode(true);
            } else {
                newSettingRow = document.createElement('div');
                newSettingRow.innerHTML = settingTemplate;
            }

            newSettingRow.querySelectorAll('input').forEach((element) => {
                element.value = '';
            });

            newSettingRow.querySelectorAll('p[id$="Error"]').forEach((element) => {
                element.remove();
            });
            const removeSetting = document.createElement('button');
            removeSetting.textContent = 'Remove';
            removeSetting.classList.add('btn', 'btn-danger','float-right');
            newSettingRow.appendChild(removeSetting);

            removeSetting.addEventListener('click', () => {
                newSettingRow.remove();
            });
            settingContainer.appendChild(newSettingRow);
        }
        addSettingButton.addEventListener('click', createNewSetting);
        
        $('.removeOption').click(function (e) { 
            e.preventDefault();
            const removeBtn = $(this);
            const optionContainer = removeBtn.prev('.optionValue');
            optionContainer.remove();
            removeBtn.remove();
        });

        $('.removeSetting').click(function (e) { 
            e.preventDefault();
            const removeBtn = $(this);
            const settingContainer = removeBtn.prev('.setting');
            settingContainer.remove();
            removeBtn.remove();
        });

        //get option values
        $(document).on('click', '.option', function() {
            var option = $(this).val();
            var optContainer = $(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ route('getOptionValue',':id') }}".replace(':id',option),
                dataType: "json",
                success: function (response) {
                    var dropdown = optContainer.closest('.optionValue').find('.optionValDropDown');
                    var selectedOption = dropdown.find('option:selected').val();
                    dropdown.empty();
                    if(response.optVal.length === 0) {
                        dropdown.append('<option selected  disabled>No Option Value</option>');
                    } else {
                        response.optVal.forEach(function(item) {
                        var option="<option value=' " + item.option_val_id +"'>  " + item.option_value +" </option>";
                        if(item.option_val_id == selectedOption) {
                            option = "<option value='" + item.option_val_id + "' selected>" + item.option_value + "</option>";
                        }
                        dropdown.append(option);
                        });
                    }
                }
            });
        });
       
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
                        if(!is_array(errors)) {
                            alert(errors);
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

        //delete Image
        $(".deleteImg").click(function() {
           var imgId = $(this).data('img-id');
           var productId = $(".productId").val();
           var imgElement = $(this).parent();

           $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            });
            $.ajax({
                type: "post",
                url: "{{route('deleteImg')}}",
                data: { imgId : imgId, productId:productId },
                dataType: "json",
                success: function (response) {
                    if(response.status === 500) {
                        alert(response.error);
                    } else {
                     imgElement.remove();
                    }
                }
            });
        });
    </script>
    @endpush
</x-admin-layout>