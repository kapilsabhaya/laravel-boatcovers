<x-admin-layout>
    @push('title')
    <title>Manage Make</title>
    @endpush

    @push('heading')
    Manage Make
    @endpush
    {{-- MAKE --}}
    <section class="section">
        <div class="card">

            <div style="display: flex; align-items: center;">
                <div class="card-header">
                    <h5 class="card-title">
                        All Make
                    </h5>
                </div>
                <div class="ms-auto pe-5">
                    <a href="#" class="buttons btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMake">Add
                        new</a>
                </div>

            </div>

            <div class="card-body">
                <div class="table-responsive datatable-minimal">
                    <table class="table" id="table2">
                        <thead>
                            <tr>
                                <th>Make Name</th>
                                <th>Slug</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($make as $item )

                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->slug }}</td>
                                <td style="display:flex;">

                                    {{-- Update --}}
                                    <button type="button" data-bs-toggle="tooltip" data-bs-placement="left"
                                        title="Edit">
                                        <a class="btn icon btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editMake-{{ $item->id }}"><i class="bi bi-pencil"></i></a>
                                    </button>

                                    {{-- DELETE --}}
                                    <button class="deleteMake" style="padding-left:2%" data-bs-toggle="tooltip"
                                        data-bs-placement="right" title="Delete" value="{{ $item->id }}">
                                        <a href="#" class="btn icon btn-danger"><i class="bi bi-x"></i></a>
                                    </button>
                                </td>
                            </tr>

                            @push('modal')
                            {{-- UPDATE MAKE MODAL --}}
                            <div class="modal fade text-left" id="editMake-{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel160" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-l" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary">
                                            <h5 class="modal-title white" id="myModalLabel160">Update Make
                                            </h5>
                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                <i data-feather="x"></i>
                                            </button>
                                        </div>
                                        <form id="editMakeForm" method="post">
                                            @csrf
                                            @method('PATCH')
                                            <div class="modal-body">
                                                <input type="hidden" id="makeId" value="{{ $item->id }}">
                                                <label for="">Make Name</label>
                                                <input required type="text" name="make" autocomplete="off"
                                                    value="{{ $item->name }}" class="umake form-control round"
                                                    placeholder="Make Name">
                                                <p id="make_error"></p>
                                                <br>

                                                <label for="">Slug</label>
                                                <input readonly required type="text" name="slug" autocomplete="off"
                                                    value="{{ $item->slug }}" class="uslug form-control round"
                                                    placeholder="Slug">
                                                <p id="slug_error"></p>
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
                {{-- END UPDATE MAKE MODAL --}}
                @endpush
                @endforeach

                </tbody>
                </table>
            </div>
        </div>
        </div>

        @push('modal')

        {{-- ADD MAKE MODAL --}}
        <div class="modal fade text-left" id="addMake" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-l" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title white" id="myModalLabel160">Add Make
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form class="addMakeForm" method="post">
                        @csrf
                        <div class="modal-body">
                            <label for="">Make Name</label>
                            <input type="text" autocomplete="off" name="make" required class="amake form-control round"
                                placeholder="Make Name">
                            <p id="makeError"></p>
                            <br>

                            <label for="">Slug</label>
                            <input type="text" name="slug" autocomplete="off" required readonly
                                class="aslug form-control round" placeholder="Slug">
                            <p id="slugError"></p>
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
        {{-- END ADD MAKE MODAL --}}


        @endpush

    </section>
    {{-- MAKE --}}
    @push('script')

    <script>
        $(".amake").change(function() {
            $.ajax({
                type: "GET"
                , url: "{{ route('getSlug') }}"
                , data: {
                    title: $(this).val()
                }
                , dataType: "json"
                , success: function(response) {
                    if (response["status"] === true) {
                        $(".aslug").val(response["slug"]);
                    }
                }
            });
        });
        $(".umake").change(function() {
            $.ajax({
                type: "GET"
                , url: "{{ route('getSlug') }}"
                , data: {
                    title: $(this).val()
                }
                , dataType: "json"
                , success: function(response) {
                    if (response["status"] === true) {
                        $(".uslug").val(response["slug"]);
                    }
                }
            });
        });

        $(document).on('submit', '.addMakeForm', function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "post"
                , url: "{{ route('make.store') }}"
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
                        if (errors['make']) {
                            $('.amake').addClass('is-invalid').next('#makeError').addClass('invalid-feedback').html(errors.make).show();
                        }
                        if (errors['slug']) {
                            $('.aslug').addClass('is-invalid').next('#slugError').addClass('invalid-feedback').html(errors.slug).show();
                        }
                    }
                }
            });
        });

        $(document).on('submit', '#editMakeForm', function(e) {
            e.preventDefault();
            var id = $(this).find("#makeId").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST"
                , url: "{{ route('make.update', ':id') }}".replace(':id', id)
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
                        if (errors['make']) {
                            $('.umake').addClass('is-invalid').next('#make_error').addClass('invalid-feedback').html(errors.make).show();
                        }
                        if (errors['slug']) {
                            $('.uslug').addClass('is-invalid').next('#slug_error').addClass('invalid-feedback').html(errors.slug).show();
                        }
                    }
                }
            });
        });

        $(".deleteMake").click(function(e) {
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
                        url: "{{ route('make.destroy',':id') }}".replace(':id',id),
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