<x-admin-layout>
    @push('title')
    <title>Manage Year</title>
    @endpush

    @push('heading')
    Manage Year
    @endpush
    <section class="section">
        <div class="card">
            <div style="display: flex; align-items: center;">
                <div class="card-header">
                    <h5 class="card-title">
                        All Year
                    </h5>
                </div>
                <div class="ms-auto pe-5">
                    <a href="#" class="buttons btn btn-primary" data-bs-toggle="modal" data-bs-target="#addYear">Add
                        new</a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive datatable-minimal">
                    <table class="table" id="table2">
                        <thead>
                            <tr>
                                <th>Year</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($year as $item)

                            <tr>
                                <td>{{ $item->year }}</td>
                                <td style="display:flex;">

                                    {{-- Update --}}
                                    <button type="button" data-bs-toggle="tooltip" data-bs-placement="left"
                                        title="Edit">
                                        <a class="btn icon btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editYear-{{ $item->id }}"><i class="bi bi-pencil"></i></a>
                                    </button>

                                    {{-- DELETE --}}
                                    <button style="padding-left:2%" data-bs-toggle="tooltip" data-bs-placement="right"
                                        title="Delete" class="deleteYear" value="{{ $item->id }}">
                                        <a class="btn icon btn-danger"><i class="bi bi-x"></i></a>
                                    </button>
                                </td>
                            </tr>
                            @push('modal')

                            {{-- UPDATE YEAR MODAL --}}
                            <div class="modal fade text-left" id="editYear-{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel160" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-l" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary">
                                            <h5 class="modal-title white" id="myModalLabel160">Update Year
                                            </h5>
                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                <i data-feather="x"></i>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="updateYear" method="post">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" id="yearId" class="form-control round"
                                                    value="{{ $item->id }}">
                                                <label for="">Year</label>
                                                <input type="text" required autocomplete="off" name="year"
                                                    value="{{ $item->year }}" class="year form-control round"
                                                    placeholder="Year">
                                                <p class="yearError"></p>
                                                <br>

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
                            </div>
                            {{-- END UPDATE YEAR MODAL --}}
                            @endpush

                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @push('modal')

        {{-- ADD YEAR MODAL --}}
        <div class="modal fade text-left" id="addYear" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-l" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title white" id="myModalLabel160">Add Year
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="addYear" method="post">
                            @csrf
                            <label for="">Year</label>
                            <input type="text" required autocomplete="off" name="year" class="year form-control round"
                                placeholder="Year">
                            <p class="yearError"></p>
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
        {{-- END ADD YEAR MODAL --}}

        @endpush

    </section>
    {{-- YEAR --}}


    @push('script')
    <script>
        $(document).on('submit', '#addYear', function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "post",
                url: "{{ route('year.store') }}",
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
                        if (errors['year']) {
                            $('.year').addClass('is-invalid').next('.yearError').addClass('invalid-feedback').html(errors.year).show();
                        }
                    }
                }
            });
        });

        $(document).on('submit', '#updateYear', function(e) {
            e.preventDefault();
            var id = $(this).find("#yearId").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ route('year.update', ':id') }}".replace(':id', id),
                data: new FormData(this),
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === 200) {
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
                        if (errors['year']) {
                            $('.year').addClass('is-invalid').next('.yearError').addClass('invalid-feedback').html(errors.year).show();
                        }
                    }
                }
            });
        });

        $(".deleteYear").click(function(e) {
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
                        url: "{{ route('year.destroy',':id') }}".replace(':id',id),
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