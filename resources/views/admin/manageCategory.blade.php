<x-admin-layout>
    @php
    $admin = Auth::guard('admin')->user();
    $adminRole = Spatie\Permission\Models\Role::find($admin->id);
    @endphp
    @push('title')
    <title>Category</title>
    @endpush

    <link rel="stylesheet"
        href="{{ asset('assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/filepond/filepond.css') }}">

    @if($adminRole->hasPermissionTo('view-category'))
    @push('heading')
    Category
    @endpush

    <section class="section">
        <div class="card">

            <div style="display: flex; align-items: center;">
                <div class="card-header">
                    <h5 class="card-title">
                        All Category
                    </h5>
                </div>
                <div class="ms-auto pe-5">
                    <a href="#" class="buttons btn btn-primary" data-bs-toggle="modal" @if($adminRole->hasPermissionTo('create-category')) data-bs-target="#addCategory" @else onclick="alert('Permission Denied'); return false;" @endif>Add
                        new</a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive datatable-minimal">
                    <table class="table" id="table2">
                        <thead>
                            <tr>
                                <th>Master Category</th>
                                <th>Category Name</th>
                                <th>Sub Category Name</th>
                                <th>Slug</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($category as $category)
                            <tr>
                                <td>{{ $category->category->master_category_name }}</td>

                                <td> {{ $category->category_name }} </td>
                                @if ($category->sub_category_name)

                                <td> {{ $category->sub_category_name }} </td>
                                @else
                                <td>null</td>
                                @endif
                                <td> {{ $category->slug }} </td>
                                <td>
                                    @if ($category->image)
                                    <img src="{{ asset('uploads/Category/'. $category->image) }}" alt="img" height="15%" width="15%">
                                </td>
                                @else
                                <img src="{{ asset('uploads/Category/no-image.jpg') }}" alt="no-image" width="15%"
                                    height="15%">
                                @endif
                                <td style="display:flex;gap:7px;">

                                    <button class="editCatBtn" type="button" data-bs-toggle="tooltip" data-bs-placement="left"
                                        title="Edit">
                                        <a class="btn icon btn-primary" data-bs-toggle="modal"  @if($adminRole->hasPermissionTo('update-category')) data-bs-target="#editCategory-{{ $category->id }}"  @else onclick="alert('Permission Denied'); return false;" @endif><i
                                                class="bi bi-pencil"></i></a>
                                    </button>

                                    <button style="padding-left:2%" data-bs-toggle="tooltip" data-bs-placement="right"
                                        title="Delete" class="deleteCat" value="{{ $category->id }}">
                                        <a href="#" class="btn icon btn-danger"><i class="bi bi-x"></i></a>
                                    </button>
                                </td>
                            </tr>
                            {{-- UPDATE CATEGORY MODAL --}}
                            @push('modal')
                            <div class="modal fade text-left" id="editCategory-{{ $category->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-l" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary">
                                            <h5 class="modal-title white" id="myModalLabel160">Update Category
                                            </h5>
                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                <i data-feather="x"></i>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="updateCat" method="post">
                                                @csrf
                                                @method('PATCH')

                                                <input type="hidden" class="catId" value="{{ $category->id }}">
                                                {{-- MASTER CATEGORY --}}
                                                <label for="">Status</label>
                                                <select name="master_category" id="" class="form-control">
                                                    @foreach ($masterCategory as $key => $msc)
                                                    <option value="{{ $msc->id }}" @if($msc->id ==
                                                        $category->master_category_id) selected @endif>{{
                                                        $msc->master_category_name }}</option>
                                                    @endforeach
                                                </select>

                                                <br>

                                                {{-- CATEGORY --}}
                                                <label for="">Category Name</label>
                                                <input name="category_name" type="text" id="edit_cname" class="edit_cname form-control round" autocomplete="off" required
                                                    value="{{ $category->category_name }}"
                                                    placeholder="Enter Category Name">
                                                <p id="cnameError"></p>
                                                <br>

                                                {{-- SUB CATEGORY --}}
                                                <label for="">Sub Category Name</label>
                                                <input name="sub_category_name" type="text" id="sub_category_name"
                                                    class="form-control round" value="{{$category->sub_category_name}}"
                                                    placeholder="Enter Sub Category Name">
                                                <br>

                                               {{-- SLUG --}}
                                                <label for=""> Slug</label>
                                                <input type="text" value="{{$category->slug}}" readonly required name="slug" class="edit_slug form-control round">
                                                <p id="slug_error"></p>
                                                <br>


                                                {{-- Image --}}
                                                <label for="">Image</label>
                                                <input type="file" name="image" class="basic-filepond"
                                                    id="filepond-{{ $category->id }}">
                                                <br>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light-secondary"
                                                data-bs-dismiss="modal">
                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Close</span>
                                            </button>
                                            <button type="submit" class="btn btn-primary ms-1">
                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Update</span>
                                            </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endpush 
                            {{-- END OF UPDATE MODAL --}}
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @push('modal')

        {{-- ADD CATEGORY MODAL --}}
        <div class="modal fade text-left" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-l" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title white" id="myModalLabel160">Add Category
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="addCat" method="post" enctype="multipart/form-data">
                            @csrf
                            {{-- MASTER CATEGORY --}}
                            <label for="">Master Category</label>
                            <select required name="master_category" class="form-control">
                                @if ($masterCategory && $masterCategory->isNotEmpty())
                                @foreach ($masterCategory as $key => $msc)
                                <option value="{{ $msc->id }}">{{ $msc->master_category_name }}</option>
                                @endforeach
                                @else
                                <option selected disabled value="">No Master Category Available</option>
                                @endif
                            </select>
                            <br>

                            {{-- CATEGORY --}}
                            <label for="">Category Name</label>
                            <input type="text" id="" autocomplete="off" required name="category_name"
                                class="add_cname form-control round" placeholder="Enter Value">
                            <p id="cname_error"></p>
                            <br>

                            {{-- SUB CATEGORY --}}
                            <label for="">Sub Category Name</label>&nbsp;&nbsp;<small class="text-muted"><i>can
                                    skip</i></small>
                            <input type="text" id="add_sub_category_name" autocomplete="off" name="sub_category_name"
                                class="add_sub_cat form-control round" placeholder="">
                            <br>

                            {{--  SLUG --}}
                            <label for="">Slug</label>
                            <input type="text" readonly required name="slug" class="add_slug form-control round">
                            <p id="add_slug_error"></p>
                            <br>

                            {{-- Image --}}
                            <label for="">Image</label>
                            <input type="file" name="image" class="image-preview-filepond">
                            <br>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" class="btn btn-primary ms-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Add</span>
                        </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- END OF ADD CATEGORY MODAL --}}


        @endpush

    </section>
    @else
    <div class="alert alert-danger"> {{$error}} </div>
    @endif
    @push('script')

    <script>
       
        $(".edit_cname,#sub_category_name").change(function() {
            var value = $(this).val();
            // var value = ($("#sub_category_name").length > 0 ) ? $("#sub_category_name").val() : $(".edit_cname").val();
            console.log(value);
            $.ajax({
                type: "get",
                url: "{{ route('getSlug') }}",
                data: {title : value},
                dataType: "json",
                success: function (response) {
                    if(response["status"] === true) {
                        $(".edit_slug").val(response["slug"]);
                    }
                }
            });
        });

        
        $(".add_cname,#add_sub_category_name").change(function() {
            var value = $(this).val();
            // var value = $("#sub_category_name").length > 0 ? $("#sub_category_name").val() : $(".edit_cname").val();
            $.ajax({
                type: "get",
                url: "{{ route('getSlug') }}",
                data: {title : value},
                dataType: "json",
                success: function (response) {
                    if(response["status"] === true) {
                        $(".add_slug").val(response["slug"]);
                    }
                }
            });
        });

        $(document).on('submit','#addCat',function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                
                $.ajax({
                    type: "POST",
                    url: "{{ route('category.store') }}",
                    data: new FormData(this),
                    dataType: "json",
                    cache:false,
                    contentType:false,
                    processData : false,
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
                            if(errors['category_name']) {
                            $('.acname').addClass('is-invalid').next('#cname_error').addClass('invalid-feedback').html(errors.category_name).show();
                            }
                            if(errors['slug']) {
                            $('.add_slug').addClass('is-invalid').next('#add_slug_error').addClass('invalid-feedback').html(errors.slug).show();
                            }  
                            if(!is_array(errors)) {
                                alert(errors);
                            }
                            
                        } 
                    }
                });
        });

        $(".deleteCat").click(function(e) {
            e.preventDefault();
            var id = $(this).val();
            const Swal2 = Swal.mixin({
            customClass: {
            input: 'form-control'
            }
            })

                Swal.fire({
                    icon: "warning",
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                if (result.isConfirmed) {

                    $.ajaxSetup({
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    });
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('category.destroy',':id') }}".replace(':id',id),
                        dataType: "json",
                        success: function (response) {
                            if(response.status === 200) {
                                Swal2.fire({
                                title: "Deleted!",
                                text: response.message,
                                icon: "success"
                                });
                            } else if (response.status === 500) {
                                Swal2.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: response.message,
                                }); 
                            }
                        }
                    });
                }
            }); 
        });

        $(document).on('submit' ,'#updateCat',function(e){
            e.preventDefault();
            var id = $(this).find('.catId').val();
            $.ajax({
                type: "POST",
                url: "{{ route('category.update',':id') }}".replace(':id' , id),
                data: new FormData(this),
                dataType: "json",
                contentType:false,
                cache:false,
                processData:false,
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
                            if(errors['category_name']) {
                            $('.cname').addClass('is-invalid').next('#cnameError').addClass('invalid-feedback').html(errors.category_name).show();
                            }
                            if(errors['slug']) {
                            $('.edit_slug').addClass('is-invalid').next('#slug_error').addClass('invalid-feedback').html(errors.slug).show();
                            }
                            if(!is_array(errors)) {
                                alert(errors);
                            }
                        }
                }
            });
        });
    </script>

    {{-- FILE UPLOAD JS --}}
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

    @endpush


</x-admin-layout>