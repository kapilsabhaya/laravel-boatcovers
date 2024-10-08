<x-admin-layout>
    @push('heading')
    Assign Roles
    @endpush

    <section class="section">
        <div class="card">

            <div style="display: flex; align-items: center;">
                <div class="card-header">
                    <h5 class="card-title">
                        Create new or Update
                    </h5>
                </div>
            </div>

            <div class="card-body">
                <form id="assignForm" method="post" class="form">
                    @csrf
                    <label for="">Select Admins</label><br>
                    <select data-placeholder="Select Admins" multiple id="admin" class="chosen-select" name="admin[]"
                        style="width: 70%;min-height:200vh">
                        @if ($admins->isNotEmpty())
                        @foreach ($admins as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                        @else
                        <option selected disabled>No Admins Found</option>
                        @endif
                    </select>
                    <p class="adminError"></p>
                    <br><br>

                    <label for="">Select Roles</label><br>
                    <select data-placeholder="Select Roles" id="role" multiple class="chosen-select" name="role[]"
                        style="width: 70%;min-height:200vh">
                        @if ($roles->isNotEmpty())
                        @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                        @else
                        <option selected disabled>No Roles Found</option>
                        @endif
                    </select>
                    <p class="roleError"></p>
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-1 mb-1">Assign</button>
                    </div>
                </form>

            </div>
        </div>

    </section>


    @push('script')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
    <script>
        $(".chosen-select").chosen({
        no_results_text: "Oops, nothing found!",
        })

        $(document).on('submit', '#assignForm', function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "post",
                url: "{{ route('assignRole.store') }}",
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
                        if (errors['admin']) {
                            $('#admin_chosen').addClass('is-invalid').next('.adminError').addClass('invalid-feedback').html(errors.admin).show();
                        }
                        if (errors['role']) {
                            $('#role_chosen').addClass('is-invalid').next('.roleError').addClass('invalid-feedback').html(errors.role).show();
                        } if(!is_array(errors)) {
                            alert(errors);
                        }
                    }   
                }
            });
        });
    </script>
    @endpush
</x-admin-layout>