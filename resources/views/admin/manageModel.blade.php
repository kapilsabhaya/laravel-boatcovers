<x-admin-layout>
    @php
    $admin = Auth::guard('admin')->user();
    $adminRole = Spatie\Permission\Models\Role::find($admin->id);
    @endphp
    @push('title')
    <title>Manage Model</title>
    @endpush

    @push('heading')
    Manage Model
    @endpush
    @if($adminRole->hasPermissionTo('view-model'))
        <section class="section">
            <div class="card">

                <div style="display: flex; align-items: center;">
                    <div class="card-header">
                        <h5 class="card-title">
                            All Model
                        </h5>
                    </div>
                    <div class="ms-auto pe-5">
                        <a @if($adminRole->hasPermissionTo('create-model')) data-bs-target="#addModel" @else onclick="alert('Permission Denied'); return false;" @endif href="#" class="buttons btn btn-primary" data-bs-toggle="modal" >Add
                            new</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive datatable-minimal">
                        <table class="table" id="table2">
                            <thead>
                                <tr>
                                    <th>Model Name</th>
                                    <th>Category</th>
                                    <th>Make</th>
                                    <th>Slug</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($model as $item)

                                <tr>
                                    <td>{{ $item->model_name }} </td>
                                    <td> {{ $item->category->category_name }} </td>
                                    <td> {{ $item->make->name }} </td>
                                    <td> {{ $item->slug }} </td>

                                    <td style="display:flex;gap:5px;">

                                        {{-- Update --}}
                                        <button type="button" data-bs-toggle="tooltip" data-bs-placement="left"
                                            title="Edit">
                                            <a class="btn icon btn-primary" @if($adminRole->hasPermissionTo('update-model')) data-bs-target="#editModel-{{ $item->id }}" @else onclick="alert('Permission Denied'); return false;" @endif  data-bs-toggle="modal">
                                                <i class="bi bi-pencil"></i></a>
                                        </button>

                                        {{-- DELETE --}}
                                        <button style="padding-left:2%" data-bs-toggle="tooltip" data-bs-placement="right"
                                            value="{{ $item->id }}" title="Delete" class="deleteModel">
                                            <a class="btn icon btn-danger"><i class="bi bi-x"></i></a>
                                        </button>
                                    </td>
                                </tr>
                                @push('modal')
                                {{-- UPDATE Model MODAL --}}
                                <div class="modal fade text-left" id="editModel-{{ $item->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel160" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-l" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h5 class="modal-title white" id="myModalLabel160">Update Model
                                                </h5>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <i data-feather="x"></i>
                                                </button>
                                            </div>
                                            <form id="updateModel" method="post">
                                                @method('PATCH')
                                                @csrf
                                                <div class="modal-body">
                                                    <input type="hidden" id="modelId" value="{{ $item->id }}">
                                                    <label for="">Model Name</label>
                                                    <input type="text" value="{{ $item->model_name }}" name="model"
                                                        class="umodel form-control round" placeholder="Model Name">
                                                    <p class="model_error"></p>
                                                    <br>

                                                    <label for="">Slug</label>
                                                    <input type="text" value="{{ $item->slug }}" name="slug"
                                                        class="uslug form-control round" placeholder="Slug">
                                                    <p class="slug_error"></p>
                                                    <br>

                                                    <label for="">Category</label>

                                                    @php
                                                    $modelCategoryId = $item->category->id;
                                                    @endphp

                                                    <select required name="category" class="form-control">
                                                        @if ($category && $category->isNotEmpty())
                                                        @foreach ($category as $cat)
                                                        <option {{ $cat->id == $modelCategoryId ? 'selected' : '' }}
                                                            value="{{$cat->id}}">{{ $cat->category_name }}</option>
                                                        @endforeach
                                                        @else
                                                        <option selected disabled value="">No Category Available</option>
                                                        @endif
                                                    </select>
                                                    <br>
                                                    <label for="">Model</label>
                                                    <select required name="make" class="form-control">
                                                        @if ($make && $make->isNotEmpty())
                                                        @foreach ($make as $key => $mk)
                                                        <option @if($mk->id == $item->make->id) selected @endif value="{{ $mk->id }}">{{ $mk->name }}</option>
                                                        @endforeach
                                                        @else
                                                        <option selected disabled value="">No Make Available</option>
                                                        @endif
                                                    </select>

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
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                {{-- END UPDATE MODEL MODAL --}}
                                @endpush
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @push('modal')

            {{-- ADD Model MODAL --}}
            <div class="modal fade text-left" id="addModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-l" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title white" id="myModalLabel160">Add Model
                            </h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <form id="addModelForm" method="post">
                            @csrf
                            <div class="modal-body">
                                <label for="">Model Name</label>
                                <input type="text" required autocomplete="off" name="model"
                                    class="amodel form-control round" placeholder="Model Name">
                                <p class="modelError"></p>
                                <br>

                                <label for="">Slug</label>
                                <input type="text" readonly required autocomplete="off" name="slug"
                                    class="aslug form-control round" placeholder="Slug">
                                <p class="slugError"></p>
                                <br>

                                <label for="">Category</label>
                                <select required name="category" id="category" class="form-control">
                                    @if ($category && $category->isNotEmpty())
                                    @foreach ($category as $key => $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                    @endforeach
                                    @else
                                    <option selected disabled value="">No Category Available</option>
                                    @endif
                                </select>
                                <br>
                                <label for="">Make</label>
                                <select required name="make" id="make" class="form-control">
                                    @if ($make && $make->isNotEmpty())
                                    @foreach ($make as $key => $mk)
                                    <option value="{{ $mk->id }}">{{ $mk->name }}</option>
                                    @endforeach
                                    @else
                                    <option selected disabled value="">No Make Available</option>
                                    @endif
                                </select>
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
            {{-- END ADD MODEL MODAL --}}

            @endpush

        </section>
    @else
        <div class="alert alert-danger"> {{$error}} </div>
    @endif
    @push('script')
    <script>
        $('.amodel').change(function (e){
            e.preventDefault();
            value = $(this).val();
            $.ajax({
                type: "GET",
                url: "{{ route('getSlug') }}",
                data: { title : value },
                dataType: "json",
                success: function (response) {
                    if(response["status"] === true) {
                        $(".aslug").val(response["slug"]);
                    }
                }
            });
        });

        $('.umodel').change(function (e){
            e.preventDefault();
            value = $(this).val();
            $.ajax({
                type: "GET",
                url: "{{ route('getSlug') }}",
                data: { title : value },
                dataType: "json",
                success: function (response) {
                    if(response["status"] === true) {
                        $(".uslug").val(response["slug"]);
                    }
                }
            });
        });

        $(document).on('submit', '#addModelForm', function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "post",
                url: "{{ route('model.store') }}",
                data: new FormData(this),
                dataType: "json",
                cache: false,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 200) {
                        const showToast = (options) => {
                            Toastify(options).showToast();
                        };
                        showToast({
                            text: response.message
                            , duration: 3000
                            , close: true
                            , gravity: "top"
                            , position: "right"
                            , backgroundColor: "green"
                        , });
                    } else if (response.errors) {
                        var errors = response.errors;
                        if (errors['model']) {
                            $('.amodel').addClass('is-invalid').next('.modelError').addClass('invalid-feedback').html(errors.model).show();
                        }
                        if (errors['slug']) {
                            $('.aslug').addClass('is-invalid').next('.slugError').addClass('invalid-feedback').html(errors.slug).show();
                        }
                        if(!is_array(errors)) {
                            alert(errors);
                        }
                    }
                }
            });
        });

        $(document).on('submit' ,'#updateModel',function(e){
            e.preventDefault();
            var id = $(this).find('#modelId').val();
            $.ajax({
                type: "POST",
                url: "{{ route('model.update',':id') }}".replace(':id' , id),
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
                            if (errors['model']) {
                                $('.umodel').addClass('is-invalid').next('.model_error').addClass('invalid-feedback').html(errors.model).show();
                            }
                            if (errors['slug']) {
                                $('.uslug').addClass('is-invalid').next('.slug_error').addClass('invalid-feedback').html(errors.slug).show();
                            }
                            if(!is_array(errors)) {
                                alert(errors);
                            }
                        }
                }
            });
        });

        $(".deleteModel").click(function(e) {
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
                        url: "{{ route('model.destroy',':id') }}".replace(':id',id),
                        dataType: "json",
                        success: function (response) {
                            if(response.status === 200) {
                                Swal2.fire({
                                title: "Deleted!",
                                text: response.message,
                                icon: "success"
                                });
                            } else if(response.status === 500) {
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
    </script>
    @endpush


</x-admin-layout>