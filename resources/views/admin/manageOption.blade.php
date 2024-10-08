<x-admin-layout>
    @php
    $admin = Auth::guard('admin')->user();
    $adminRole = Spatie\Permission\Models\Role::find($admin->id);
    @endphp

    @push('title')
    <title>Manage Option</title>
    @endpush

    @if($option != null)
    @push('heading')
    Manage Option
    @endpush

    <section class="section">
        <div class="card">

            <div style="display: flex; align-items: center;">
                <div class="card-header">
                    <h5 class="card-title">
                        All Options
                    </h5>
                </div>
                <div class="ms-auto pe-5">
                    <a href="#" class="buttons btn btn-primary" data-bs-toggle="modal" @if($adminRole->hasPermissionTo('create-option')) data-bs-target="#addOption" @else onclick="alert('Permission Denied'); return false;" @endif>Add
                        new</a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive datatable-minimal">
                    <table class="table" id="table2">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($option as $item)

                            <tr>
                                <td> {{ $item->option_name }} </td>
                                <td>
                                    @if ($item->status == '1')
                                    <span class="badge bg-success">Active</span>
                                    @else
                                    <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td style="display:flex;">

                                    <button type="button" data-bs-toggle="tooltip" data-bs-placement="left"
                                        title="Edit">
                                        <a class="btn icon btn-primary" data-bs-toggle="modal"
                                            @if($adminRole->hasPermissionTo('update-option')) data-bs-target="#editOption-{{ $item->id }}" @else onclick="alert('Permission Denied'); return false;" @endif><i
                                                class="bi bi-pencil"></i></a>
                                    </button>

                                    <button style="padding-left:2%" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="See Values" value="1">
                                        <a @if($adminRole->hasPermissionTo('view-option-value')) href="{{ route('option.show', $item->id )}}" @else onclick="alert('Permission Denied'); return false;" @endif class="btn icon btn-success"><i
                                                class="bi bi-info-circle"></i></a>
                                    </button>

                                    <button style="padding-left:2%" data-bs-toggle="tooltip" data-bs-placement="right"
                                        title="Delete" class="deleteOption" value="{{ $item->id }}">
                                        <a class="btn icon btn-danger"><i class="bi bi-x"></i></a>
                                    </button>
                                </td>
                            </tr>
                            @push('modal')
                            {{-- UPDATE Option MODAL --}}
                            <div class="modal fade text-left" id="editOption-{{ $item->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-l" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary">
                                            <h5 class="modal-title white" id="myModalLabel160">Update Option
                                            </h5>
                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                <i data-feather="x"></i>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="updateOptionForm" method="post">
                                                @method('PATCH')
                                                @csrf
                                                <input type="hidden" id="optionId" value="{{ $item->id }}">
                                                <label for="">Option Name</label>
                                                <input autocomplete="off" type="text" value="{{ $item->option_name }}" name="option"
                                                    class="uoption form-control round" placeholder="Option name">
                                                <p id="option_error"></p>
                                                <br>
                                                <select name="status" class="form-control" id="">
                                                    <option value="1" @if( $item->status == '1' ) selected @endif>Active
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
                            {{-- END UPDATE Option MODAL --}}
                            @endpush
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @push('modal')
        {{-- ADD OPTION MODAL --}}
        <div class="modal fade text-left" id="addOption" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-l" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title white" id="myModalLabel160">Add Option
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="addOption" method="post">
                            @csrf
                            <label for="">Option Name</label>
                            <input autocomplete="off" type="text" name="option" class="option form-control round"
                                placeholder="Option name">
                            <p id="optionError"></p>
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
        {{-- END ADD Option MODAL --}}
        @endpush

    </section>
    @else
    <div class="alert alert-danger"> {{$error}} </div>
    @endif
    @push('script')
    <script>
        $(document).on('submit' , '.addOption' , function (event) {
            event.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('option.store') }}",
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
                        if(errors['option']){
                            $('.option').addClass('is-invalid').next('#optionError').addClass('invalid-feedback').html(errors.option).show();
                        }
                        if(!is_array(errors)) {
                            alert(errors);
                        }
                    } 
                }
            }); 
        });

        $(document).on('submit' , '.updateOptionForm' , function(e) {
            e.preventDefault();
            var id = $(this).find('#optionId').val();
            $.ajax({
                type: "POST",
                url: "{{ route('option.update', ':id') }}".replace(':id' , id),
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
                        if(errors['option']){
                            $('.uoption').addClass('is-invalid').next('#option_error').addClass('invalid-feedback').html(errors.option).show();
                        } if(!is_array(errors)) {
                            alert(errors);
                        }
                    }
                }
            });
        });

        $(".deleteOption").click(function (e) { 
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
                    url: "{{ route('option.destroy',':id' ) }}".replace(':id',id),
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