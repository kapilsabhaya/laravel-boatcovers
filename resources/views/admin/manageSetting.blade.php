<x-admin-layout>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css" rel="stylesheet">

    @push('title')
    <title>Manage Setting</title>
    @endpush

    @push('heading')
    Manage Setting
    @endpush

    <section class="section">
        <div class="card">

            <div style="display: flex; align-items: center;">
                <div class="card-header">
                    <h5 class="card-title">
                        All Settings
                    </h5>
                </div>
                <div class="ms-auto pe-5">
                    <a href="#" class="buttons btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSetting">Add
                        new</a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive datatable-minimal">
                    <table class="table" id="table2">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Setting Name</th>
                                <th>Value</th>
                                <th>Price Increment</th>
                                <th>Sort Order</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>ABC PRODUCT</td>
                                <td>Delievery Charge</td>
                                <td>Free</td>
                                <td>0.0</td>
                                <td>1</td>
                                <td style="display:flex;">

                                    <button type="button" data-bs-toggle="tooltip" data-bs-placement="left"
                                        title="Edit">
                                        <a class="btn icon btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editSetting"><i class="bi bi-pencil"></i></a>
                                    </button>

                                    <button style="padding-left:2%" data-bs-toggle="tooltip" data-bs-placement="right"
                                        title="Delete" id="warning">
                                        <a href="#" class="btn icon btn-danger"><i class="bi bi-x"></i></a>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @push('modal')
        {{-- ADD Setting MODAL --}}
        <div class="modal fade text-left" id="addSetting" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-l" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title white" id="myModalLabel160">Add Setting
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="addSettingForm" method="post">
                            @csrf
                            <label for="">Product</label><br>
                            <select required data-placeholder="Select Product" multiple id="product"
                                class="chosen-select" name="product[]">
                                @if ($model->isNotEmpty())
                                @foreach ($model as $mdl)
                                <option value="{{ $mdl->id }}">{{ $mdl->model_name }}</option>
                                @endforeach
                                @else
                                <option value="" selected disabled>No Product Available</option>
                                @endif
                            </select>
                            <p id="productError"></p>
                            <br>

                            <label for="">Setting Name</label>
                            <input required autocomplete="off" type="text" id="" class="asname form-control round"
                                name="setting_name" placeholder="Setting name">
                            <p id="snameError"></p>
                            <br>

                            <label for="">Value</label>
                            <input required autocomplete="off" type="text" id="" class="aval form-control round"
                                name="value" placeholder="Free / $ 34.04">
                            <p id="valueError"></p>
                            <br>

                            <label for="">Price Increment</label>&nbsp;&nbsp; <small><i>can skip</i></small>
                            <input autocomplete="off" type="text" name="price_inc" class="aprice_inc form-control round"
                                placeholder="In(%)" min="0">
                            <p id="price_incError"></p>
                            <br>

                            <label for="">Sort Order</label>
                            <input required autocomplete="off" type="number" name="sort_order"
                                class="asord form-control round" placeholder="Sort Order" min="0">
                            <p id="sortOrderError"></p>
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
        {{-- END ADD Setting MODAL --}}

        {{-- UPDATE Setting MODAL --}}
        <div class="modal fade text-left" id="editSetting" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-l" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title white" id="myModalLabel160">Update Setting
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="">Product</label><br>
                        <select data-placeholder="Select Models" multiple class="chosen-select" name="">
                            <option>Asiatic Black Bear</option>
                            <option>Brown Bear</option>
                        </select>
                        <br><br>
                        <label for="">Setting Name</label>
                        <input type="text" id="" class="form-control round" placeholder="Setting name">
                        <br>

                        <label for="">Value</label>
                        <input type="text" id="" class="form-control round" placeholder="Free / 34.04$">
                        <br>

                        <label for="">Price Increment</label>
                        <input type="text" id="" class="form-control round" placeholder="In(%)" min="0">
                        <br>

                        <label for="">Sort Order</label>
                        <input type="number" id="" class="form-control round" placeholder="Sort Order" min="0">
                        <br>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="button" class="btn btn-primary ms-1" data-bs-dismiss="modal">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Update</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {{-- END UPDATE SETTING MODAL --}}
        @endpush

    </section>

    @push('script')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js" defer></script>
    <script>
        $(document).ready(function(){
              $('.modal').on('shown.bs.modal', function () {
                if (typeof $.fn.chosen === 'function') {
                  $('.chosen-select').chosen({
                      no_results_text: "Oops, nothing found!",
                      width : "100%" ,
                  });
                } else {
                  console.error('Chosen library has not been loaded yet');
                }
              });
            });
      
    </script>
    <script>
        $(document).on('submit', '.addSettingForm', function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "post"
                , url: "{{ route('setting.store') }}"
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
                        if (errors['product']) {
                            $('#product_chosen').addClass('is-invalid').next('#productError').addClass('invalid-feedback').html(errors.product).show();
                        }
                        if (errors['setting_name']) {
                            $('.asname').addClass('is-invalid').next('#snameError').addClass('invalid-feedback').html(errors.setting_name).show();
                        }
                        if (errors['sort_order']) {
                            $('.asord').addClass('is-invalid').next('#sortOrderError').addClass('invalid-feedback').html(errors.sort_order).show();
                        }
                        if (errors['value']) {
                            $('.aval').addClass('is-invalid').next('#valueError').addClass('invalid-feedback').html(errors.value).show();
                        }
                        if (errors['price_inc']) {
                            $('.aprice_inc').addClass('is-invalid').next('#price_incError').addClass('invalid-feedback').html(errors.price_inc).show();
                        }
                    }
                }
            });
        });
    </script>

    @endpush

</x-admin-layout>