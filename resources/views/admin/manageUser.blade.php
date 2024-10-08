<x-admin-layout>

    @php
    $admin = Auth::guard('admin')->user();
    $adminRole = Spatie\Permission\Models\Role::find($admin->id);
    @endphp

    @push('title')
    <title>Manage User</title>
    @endpush

    @if($adminRole->hasPermissionTo('view-user'))
        @push('heading')
        Manage User
        @endpush
        <section class="section">
            <div class="card">

                <div style="display: flex; align-items: center;">
                    <div class="card-header">
                        <h5 class="card-title">
                            All User
                        </h5>
                    </div>
                    {{-- <div class="ms-auto pe-5">
                        <a href="#" class="buttons btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUser">Add
                            new</a>
                    </div> --}}
                </div>

                <div class="card-body">
                    <div class="table-responsive datatable-minimal">
                        <table class="table" id="table2">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user as $key => $userVal)


                                <tr>
                                    <td> {{ $userVal->name }} </td>
                                    <td>{{ $userVal->email }}</td>
                                    <td>
                                        @if ($userVal->status == 1)
                                        <span class="badge bg-success">Active</span>
                                        @else
                                        <span class="badge bg-danger">Inactive</span>

                                        @endif
                                    </td>
                                    <td style="display:flex;gap:10px;">

                                        <button class="editBtn" type="button" data-bs-toggle="tooltip" data-bs-placement="left"
                                            title="Edit">
                                            <a class="btn icon btn-primary" @if($adminRole->hasPermissionTo('update-user')) data-bs-target="#editUser-{{$userVal->id}}" @else onclick="alert('Permission Denied'); return false;" @endif data-bs-toggle="modal"><i class="bi bi-pencil"></i></a>
                                        </button>
                                        <button style="padding-left:3%;" class="deleteUser btn icon btn-danger"
                                            data-bs-toggle="tooltip" data-bs-placement="right" type="button"
                                            id="deleteUser-{{$userVal->id}}" title="Delete" value="{{ $userVal->id }}">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </td>
                                </tr>


                                @push('modal')
                                    <div class="modal fade text-left" id="editUser-{{ $userVal->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-l" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary">
                                                    <h5 class="modal-title white" id="myModalLabel160">Update User
                                                    </h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="updateUser" method="post">
                                                        @method('PATCH')
                                                        @csrf
                                                        <input type="hidden" class="userId" value="{{ $userVal->id }}">
                                                        <label for="">Name</label>
                                                        <input type="text" id="name" name="name" class="form-control round"
                                                            required value="{{ $userVal->name }}" placeholder="Rounded Input">
                                                        <p id="name_error"></p>
                                                        <br>

                                                        <label for="">Email</label>
                                                        <input type="text" id="user-email" name="email"
                                                            class="form-control round" required value="{{ $userVal->email }}"
                                                            placeholder="Rounded Input">
                                                        <p id="email_error"></p>
                                                        <br>

                                                        <label for="">Status</label>
                                                        <select name="status" id="" class="form-control">
                                                            <option value="1" @if( $userVal->status == '1' ) selected
                                                                @endif>Active
                                                            </option>
                                                            <option value="0" @if( $userVal->status == '0' ) selected
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

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </section>
    @else
        <div class="alert alert-danger">{{ $error }}</div>
    @endif

    @push('script')

    <script>
    $(document).on('submit','.modal-body form', function (event) {
        event.preventDefault();
        var id = $(this).find('.userId').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('user.update', ':id') }}".replace(':id', id),
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
                        text: "Data Updated Successfully",
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "green",
                    });
                } else if (response.errors) {
                    console.log(response.errors)
                    var errors = response.errors;
                    if(errors['name']){
                        $('#name').addClass('is-invalid').next('#name_error').addClass('invalid-feedback').html(errors.name).show();
                    }
                    if(errors['email']) {
                    $('#user-email').addClass('is-invalid').next('#email_error').addClass('invalid-feedback').html(errors.email).show();
                    }
                    if(!is_array(errors)){
                        alert(errors);
                    }
                }
            }
        });
    });


    $(document).on('click','.deleteUser', function () {
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
                    url: "{{ route('user.destroy',':id' ) }}".replace(':id',id),
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