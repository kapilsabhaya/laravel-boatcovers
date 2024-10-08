<x-admin-layout>

    @php
    $admin = Auth::guard('admin')->user();
    $adminRole = Spatie\Permission\Models\Role::find($admin->id);
    @endphp

    @push('title')
    <title>Manage Option Value </title>
    @endpush

    @if($adminRole->hasPermissionTo('view-option-value'))
    @push('heading')
    Manage Option Value
    @endpush

    <section class="section">
        <div class="card">
            <div style="display: flex; align-items: center;">
                <div class="card-header">
                    <h5 class="card-title">
                        Option Values of <i> {{ $optName[0]->option_name }} </i>
                    </h5>
                </div>
                <div class="ms-auto pe-5">
                    <a class="buttons btn btn-primary" data-bs-toggle="modal" @if($adminRole->hasPermissionTo('create-option-value')) data-bs-target="#addOptionValue" @else onclick="alert('Permission Denied'); return false;" @endif>Add
                        new</a>
                    <a href="{{ route('option.index') }}" class="buttons btn btn-secondary">Back</a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive datatable-minimal">
                    <table class="table" id="table2">
                        <thead>
                            <tr>
                                <th>Value</th>
                                <th>Is Default?</th>
                                <th>Sort Order</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($optVal as $item)
                            <tr>
                                <td>{{ $item->option_value }} </td>
                                @if ($item->is_default == '1')
                                <td>Yes</td>
                                @else
                                <td>No</td>
                                @endif
                                <td>{{ $item->sort_order}} </td>

                                <td style="display:flex;">

                                    <button type="button" data-bs-toggle="tooltip" data-bs-placement="left"
                                        title="Edit">
                                        <a class="btn icon btn-primary" data-bs-toggle="modal"
                                           @if($adminRole->hasPermissionTo('update-option-value')) data-bs-target="#editOptionValue-{{ $item->id }}" @else onclick="alert('Permission Denied'); return false;" @endif><i
                                                class="bi bi-pencil"></i></a>
                                    </button>

                                    <button style="padding-left:2%" data-bs-toggle="tooltip" data-bs-placement="right"
                                        title="Delete" class="deleteOptVal" value="{{ $item->id }}">
                                        <a href="#" class="btn icon btn-danger"><i class="bi bi-x"></i></a>
                                    </button>
                                </td>
                            </tr>
                            @push('modal')
                            {{-- UPDATE OPTION VALUE MODAL --}}
                            <div class="modal fade text-left" id="editOptionValue-{{ $item->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-l" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary">
                                            <h5 class="modal-title white" id="myModalLabel160">Update Option Value </h5>
                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                <i data-feather="x"></i>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" id="updateValForm">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="option_id" value="{{ $optId }}">
                                                <input type="hidden" value="{{ $item->id }}" id="optValId">
                                                <label for="">Option Value Name</label>
                                                <input type="text" required autocomplete="off"
                                                    value="{{ $item->option_value }}" name="name"
                                                    class="uname form-control round" placeholder="Name">
                                                <p id="name_error"></p>
                                                <br>

                                                <label for="">Is Default?</label>
                                                <input type="radio" name="is_default" id="" value="1" 
                                                @if ($item->is_default == 1) checked @endif
                                                class="form-check-input">&nbsp;Yes
                                                <input type="radio" name="is_default" id="" value="0" 
                                                @if ($item->is_default == 0) checked @endif class="form-check-input"
                                                >&nbsp;No
                                                <br>
                                                <br>

                                                <label for="">Sort Order</label>
                                                <input type="number" required autocomplete="off" name="sort_order"
                                                    class="usort form-control round" value="{{ $item->sort_order }}"
                                                    placeholder="Sort Order" min="0">
                                                <p id="sort_order_error"></p>
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
                            {{-- END UPDATE OPTION VALUE MODAL --}}
                            @endpush
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @push('modal')
        {{-- ADD OPTION VALUE MODAL --}}
        <div class="modal fade text-left" id="addOptionValue" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel160" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-l" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title white" id="myModalLabel160">Add Option Value
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="addOptionValForm" method="post">
                            @csrf
                            <input type="hidden" name="option_id" value="{{ $optId }}">
                            <label for="">Option Value Name</label>
                            <input type="text" name="name" required autocomplete="off" class="name form-control round"
                                placeholder="Name">
                            <p id="nameError"></p>

                            <label for="">Is Default?</label>
                            <input type="radio" name="is_default" value="1" class="form-check-input">&nbsp;Yes
                            <input type="radio" name="is_default" value="0" class="form-check-input" checked>&nbsp;No
                            <br>
                            <br>



                            <label for="">Sort Order</label>
                            <input type="number" required autocomplete="off" name="sort_order"
                                class="sort_order form-control round" placeholder="Sort Order" min="0">
                            <p id="sortOrderError"></p>
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
        {{-- END OPTION VALUE USER MODAL --}}


        @endpush

    </section>
    @else
    <div class="alert alert-danger"> {{ "Permission Denied !" }} </div>
    @endif
    @push('script')

    <script>
        $(document).on('submit', '.addOptionValForm', function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "post"
                , url: "{{ route('optionValue.store') }}"
                , data: new FormData(this)
                , dataType: "json"
                , cache: false
                , processData: false
                , contentType: false
                , success: function(response) {
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
                        if (errors['name']) {
                            $('.name').addClass('is-invalid').next('#nameError').addClass('invalid-feedback').html(errors.name).show();
                        }
                        
                        if (errors['sort_order']) {
                            $('.sort_order').addClass('is-invalid').next('#sortOrderError').addClass('invalid-feedback').html(errors.sort_order).show();
                        }
                        if(!is_array(errors)) {
                            alert(errors);
                        }
                    }
                }
            });
        });

        $(document).on('submit', '#updateValForm', function(e) {
            e.preventDefault();
            var id = $(this).find("#optValId").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST"
                , url: "{{ route('optionValue.update', ':id') }}".replace(':id', id)
                , data: new FormData(this)
                , dataType: "json"
                , cache: false
                , contentType: false
                , processData: false
                , success: function(response) {
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
                        if (errors['name']) {
                            $('.uname').addClass('is-invalid').next('#name_error').addClass('invalid-feedback').html(errors.name).show();
                        }
                        if (errors['sort_order']) {
                            $('.usort').addClass('is-invalid').next('#sort_order_error').addClass('invalid-feedback').html(errors.sort_order).show();
                        }
                        if(!is_array(errors)) {
                            alert(errors);
                        }
                    }
                }
            });
        });

        $(".deleteOptVal").click(function(e) {
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
                        url: "{{ route('optionValue.destroy',':id') }}".replace(':id',id),
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