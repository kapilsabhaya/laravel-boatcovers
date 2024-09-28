<x-admin-layout>
    @push('title')
    <title>Manage Product </title>
    @endpush
    <link rel="stylesheet" href="{{ asset('assets/extensions/quill/quill.snow.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/quill/quill.bubble.css') }}">

    @push('heading')
    Manage Product
    @endpush
    <section class="section">
        <div class="card">

            <div style="display: flex; align-items: center;">
                <div class="card-header">
                    <h5 class="card-title">
                        All Product
                    </h5>
                </div>
                <div class="ms-auto pe-5">
                    <a href="{{ route('product.create') }}" class="buttons btn btn-primary">Add new</a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive datatable-minimal">
                    <table class="table" id="table2">
                        <thead>
                            <tr>
                                {{-- <th>Image</th> --}}
                                <th>Product Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Warranty</th>
                                <th>Is_active</th>
                                <th>Is_customizable</th>
                                <th>Slug</th>
                                <th>Sort Order</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product as $item)

                            <tr>
                                {{-- <td>img</td> --}}
                                <td> {{ $item->name }}</td>
                                <td> {{ strip_tags($item->description) }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{$item->quantity }}</td>
                                <td>{{$item->warranty }}</td>
                                @if ($item->is_active == 1 )
                                <td>Yes</td>
                                @else
                                <td>No</td>
                                @endif
                                @if ($item->is_customizable == 1 )
                                <td>Yes</td>
                                @else
                                <td>No</td>
                                @endif
                                <td> {{ $item->slug }} </td>
                                <td> {{ $item->sort_order }} </td>
                                <td style="display:flex;gap:10px">

                                    <button type="button" data-bs-toggle="tooltip" data-bs-placement="left"
                                        title="Edit">
                                        <a href="{{ route('product.edit',$item->id) }}" class="btn icon btn-primary"><i
                                                class="bi bi-pencil"></i></a>
                                    </button>

                                    <button value="{{ $item->id }}" style="padding-left:2%" data-bs-toggle="tooltip"
                                        data-bs-placement="right" title="Delete" class="deleteProduct">
                                        <a class="btn icon btn-danger"><i class="bi bi-x"></i></a>
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

    <script>
        $(".deleteProduct").click(function(e) {
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
                        url: "{{ route('product.destroy',':id') }}".replace(':id',id),
                        dataType: "json",
                        success: function (response) {
                            if(response.status === 200) {
                                Swal2.fire({
                                title: "Deleted!",
                                text: response.message,
                                icon: "success"
                                });
                            } else if (response.status === 500) {
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
</x-admin-layout>