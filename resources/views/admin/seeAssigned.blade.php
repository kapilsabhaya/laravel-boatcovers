<x-admin-layout>
    @push('title')
    <title>Manage Assign Model-Year</title>
    @endpush

    @push('heading')
    Manage Assign Model-Year
    @endpush

    <section class="section">
        <div class="card">

            <div style="display: flex; align-items: center;">
                <div class="card-header">
                    <h5 class="card-title">
                        All Assigned
                    </h5>
                </div>
                <div class="ms-auto pe-5">
                    <a href="{{ route('assignMakeModel.create') }}" class="buttons btn btn-primary">Add new</a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive datatable-minimal">
                    <table class="table" id="table2">
                        <thead>
                            <tr>
                                <th>Make</th>
                                <th>Model</th>
                                <th>Year</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assign as $item)

                            <tr>
                                <td>{{$item->model->make->name}}</td>
                                <td> {{ $item->model->model_name }} </td>
                                <td>{{ $item->year->year }}</td>
                                <td style="display:flex;">
                                    <button style="padding-left:2%" data-bs-toggle="tooltip" data-bs-placement="right"
                                        title="Delete" class="deleteAssign" value="{{ $item->id }}">
                                        <a href="#" class="btn icon btn-danger"><i class="bi bi-x"></i></a>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>

    @push('script')
    <script>
        $(".deleteAssign").click(function(e) {
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
                    url: "{{ route('assignMakeModel.destroy',':id') }}".replace(':id',id),
                    dataType: "json",
                    success: function (response) {
                        if(response.status === 200) {
                            Swal2.fire({
                            title: "Deleted!",
                            text: response.message,
                            icon: "success"
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