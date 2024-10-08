<x-admin-layout>
    @php
        $admin = Auth::guard('admin')->user();
        $adminRole = Spatie\Permission\Models\Role::find($admin->id);
    @endphp

    @push('title')
    <title>Admin Roles</title>
    @endpush

    @if($adminRole->hasPermissionTo('view-role'))
    @push('heading')
    Admin Roles
    @endpush

    <section class="section">
        <div class="card">

            <div style="display: flex; align-items: center;">
                <div class="card-header">
                    <h5 class="card-title">
                        All Roles
                    </h5>
                </div>
                <div class="ms-auto pe-5">
                    <a href="#" id="addRoleBtn" class="buttons btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRole">Add
                        new</a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive datatable-minimal">
                    <table class="table" id="table2">
                        <thead>

                            <tr>
                                <th>Name</th>
                                <th>Guard</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($role as $key => $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td> {{ $item->guard_name }} </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @push('modal')
        @if($adminRole->hasPermissionTo('create-role'))
        <div class="modal fade text-left" id="addRole" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-l" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title white" id="myModalLabel160">Add Role
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form class="addRole" method="post">
                        @csrf
                        <div class="modal-body">
                            <label for="">Role Name</label>
                            <input type="text" name="role" autocomplete="off"
                                class="role form-control round"  placeholder="Role name">
                            <p></p>
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
        @else
        <script>
            $("#addRoleBtn").on('click', function () {
                alert("You Don't have permission to create role");
            });
        </script>
        @endif
        @endpush

        @push('script')
            <script>
                $(document).ready(function() { 
                    $(document).on('submit',".addRole",function(e) {
                        e.preventDefault();
                        var role = $(".role").val();
                        if(role == ""){
                            $(".role").addClass("is-invalid").next('p').text('Role Field Is Required').addClass('invalid-feedback');
                            return;
                        } 
                        $.ajaxSetup({
                            headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                        });
                        $.ajax({
                            type: "post",
                            url: "{{ route('roles.store') }}",
                            data: new FormData(this),
                            dataType: "json",
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (response) {
                                if(response.error){
                                    alert(response.error)
                                } else {
                                    alert('Role added Successfully');
                                }
                            }
                        });
                    })
                });
            </script>
        @endpush
    </section>
    @else
    <div class="alert alert-danger"> {{$error}} </div>
    @endif

</x-admin-layout>
