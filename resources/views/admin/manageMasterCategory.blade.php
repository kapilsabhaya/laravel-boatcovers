<x-admin-layout>
    @php
    $admin = Auth::guard('admin')->user();
    $adminRole = Spatie\Permission\Models\Role::find($admin->id);
    @endphp

    @push('title')
    <title>Master Category</title>
    @endpush

    @if($adminRole->hasPermissionTo('view-master-category'))
    @push('heading')
    Master Category
    @endpush

    <section class="section">
        <div class="card">

            <div style="display: flex; align-items: center;">
                <div class="card-header">
                    <h5 class="card-title">
                        All Master Category
                    </h5>
                </div>
                <div class="ms-auto pe-5">
                    <a href="#" id="addMasterBtn" class="buttons btn btn-primary" @if($adminRole->hasPermissionTo('create-master-category'))  data-bs-target="#addMaster" @else onclick="alert('Permission Denied'); return false;" @endif  data-bs-toggle="modal">Add
                     new</a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive datatable-minimal">
                    <table class="table" id="table2">
                        <thead>

                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                            <tr>
                                <td>{{ $item->master_category_name }}</td>
                                <td> {{ $item->slug }} </td>
                                <td>
                                    @if ($item->status == '1')
                                    <span class="badge bg-success">Active</span>
                                    @else
                                    <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td style="display:flex;gap :10px">
                                    <button class="editMasterBtn" type="button" data-bs-toggle="tooltip" data-bs-placement="left"
                                        title="Edit" >
                                        <a class="btn icon btn-primary" data-bs-toggle="modal"
                                        @if($adminRole->hasPermissionTo('update-master-category')) data-bs-target="#editMaster-{{ $item->id }}" @else onclick="alert('Permission Denied'); return false;" @endif><i
                                                class="bi bi-pencil"></i></a>
                                    </button>

                                    <button style="padding-left:2%" data-bs-toggle="tooltip" data-bs-placement="right"
                                        title="Delete" value="{{ $item->id }}" class="deleteMaster btn icon btn-danger">
                                        <i class="bi bi-x"></i>
                                    </button>

                            {{-- UPDATE MASTER CATEGORY MODAL --}}
                            @push('modal')
                                <div class="modal fade text-left" id="editMaster-{{ $item->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-l" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h5 class="modal-title white" id="myModalLabel160">Update Master
                                                    Category
                                                </h5>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <i data-feather="x"></i>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="updateMaster" method="post">
                                                    @method('PATCH')
                                                    @csrf
                                                    <input type="hidden" id="id" value="{{ $item->id }}">
                                                    <label for="">Master Category</label>
                                                    <input type="text" value="{{ $item->master_category_name }}"
                                                        id="" required class="update_master_name form-control round"
                                                        name="master_name" autocomplete="off"
                                                        placeholder="Master Category">
                                                    <p></p>
                                                    <br>
                                                    <label for="">Slug</label>
                                                    <input type="text" value="{{ $item->slug }}"
                                                        id="" required class="uslug form-control round"
                                                        name="slug" autocomplete="off"
                                                        placeholder="Slug">
                                                    <p></p>
                                                    <br>
                                                    <label for="">Status</label>
                                                    <select name="status" id="" class="form-control">
                                                        <option value="1" @if( $item->status == '1' ) selected
                                                            @endif>Active
                                                        </option>
                                                        <option value="0" @if( $item->status == '0' ) selected
                                                            @endif>Inactive</option>
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
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endpush
                            {{-- END UPDATE MASTER CATEGORY MODAL --}}

                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @push('modal')
        {{-- ADD MASTER CATEGORY MODAL --}}
        <div class="modal fade text-left" id="addMaster" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-l" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title white" id="myModalLabel160">Add Master Category
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form class="addMasterCategory" method="post">
                        @csrf
                        <div class="modal-body">
                            <label for="">Master Category</label>
                            <input type="text" name="master_name" autocomplete="off"
                                class="add_master_name form-control round" required placeholder="Master Category">
                            <p></p>
                            <label for="">Slug</label>
                            <input readonly type="text" name="slug" autocomplete="off"
                                class="aslug form-control round" required placeholder="Slug">
                            <p></p>
                            <br>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="submit" class="btn btn-primary ms-1">
                                <i class=" bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Add</span>
                            </button>
                    </form>
                </div>
            </div>
        </div>
        </div>
        {{-- END ADD MASTER CATEGORY MODAL --}}

        @endpush

    </section>
    @else
    <div class="alert alert-danger"> {{$error}} </div>
    @endif
    @push('script')

    <script>
    $(".add_master_name").change(function() {
        var value = $(this).val();
        $.ajax({
            type: "get",
            url: "{{ route('getSlug') }}",
            data: {title : value},
            dataType: "json",
            success: function (response) {
                if(response["status"] === true) {
                    $(".aslug").val(response["slug"]);
                }
            }
        });
    });

    $(".update_master_name").change(function() {
        var value = $(this).val();
        $.ajax({
            type: "get",
            url: "{{ route('getSlug') }}",
            data: {title : value},
            dataType: "json",
            success: function (response) {
                if(response["status"] === true) {
                    $(".uslug").val(response["slug"]);
                }
            }
        });
    });

    $(document).on('submit' , '.addMasterCategory' , function (event) {
        event.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('masterCategory.store') }}",
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
                    if(errors['master_name']){
                        $('.add_master_name').addClass('is-invalid').next('p').addClass('invalid-feedback').html(errors.master_name).show();
                    } else {
                        $('.add_master_name').removeClass('is-invalid').next('p').removeClass('invalid-feedback').html('').hide();
                    }
                    if(errors['slug']){
                        $('.aslug').addClass('is-invalid').next('p').addClass('invalid-feedback').html(errors.slug).show();
                    } else {
                        $('.aslug').removeClass('is-invalid').next('p').removeClass('invalid-feedback').html('').hide();
                    }
                }
            }
        }); 
    });

    $(document).on('submit' , '#updateMaster' , function(e) {
        e.preventDefault();
        var id = $(this).find('#id').val();
        $.ajax({
            type: "POST",
            url: "{{ route('masterCategory.update', ':id') }}".replace(':id' , id),
            data: new FormData(this),
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
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
                    if(errors['master_name']){
                        $('.update_master_name').addClass('is-invalid').next('p').addClass('invalid-feedback').html(errors.master_name).show();
                    } else {
                        $('.update_master_name').removeClass('is-invalid').next('p').removeClass('invalid-feedback').html('').hide();
                    }
                    if(errors['slug']){
                        $('.uslug').addClass('is-invalid').next('p').addClass('invalid-feedback').html(errors.slug).show();
                    } else {
                        $('.uslug').removeClass('is-invalid').next('p').removeClass('invalid-feedback').html('').hide();
                    }
                }
            }
        });
    });

    $(".deleteMaster").click(function (e) { 
        e.preventDefault();
        var id=$(this).val();
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
                    url: "{{ route('masterCategory.destroy',':id' ) }}".replace(':id',id),
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