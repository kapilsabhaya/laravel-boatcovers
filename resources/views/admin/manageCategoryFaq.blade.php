<x-admin-layout>
    @push('title')
    <title>Manage Category Faq</title>
    @endpush

    @push('heading')
    Manage Category Faq
    @endpush
    <br>
    <section class="section">
        <div class="card">

            <div style="display: flex; align-items: center;">
                <div class="card-header">
                    <h5 class="card-title">
                        All Category Faq
                    </h5>
                </div>
                <div class="ms-auto pe-5">
                    <a href="#" class="buttons btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addCategoryFaq">Add
                        new</a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive datatable-minimal">
                    <table class="table" id="table2">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Faq Queston</th>
                                <th>Faq Answer</th>
                                <th>Sort Order</th>
                                <th>Slug</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Graiden</td>
                                <td>Q</td>
                                <td>A</td>
                                <td>0</td>
                                <td>Slug</td>
                                <td style="display:flex;">

                                    {{-- Update --}}
                                    <button type="button" data-bs-toggle="tooltip" data-bs-placement="left"
                                        title="Edit">
                                        <a class="btn icon btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editCategoryFaq"><i class="bi bi-pencil"></i></a>
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
        {{-- ADD Category Faq MODAL --}}
        <div class="modal fade text-left" id="addCategoryFaq" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel160" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-l" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title white" id="myModalLabel160">Add Category FaQ
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <label for="">Category</label>
                        <select data-placeholder="Select Models" multiple class="chosen-select" name="">
                            <option>Asiatic Black Bear</option>
                            <option>Brown Bear</option>
                        </select> <br><br>
                        <label for="">Faq Question</label>
                        <input type="text" id="" class="form-control round" placeholder="Faq Question">
                        <br>

                        <label for="exampleFormControlTextarea1" class="form-label">FaQ Answer</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                        <br>

                        <label for="">Sort Order</label>
                        <input type="number" id="" class="form-control round" placeholder="Sort Order" min="0">
                        <br>

                        <label for="">Slug</label>
                        <input type="text" id="" class="form-control round" placeholder="Slug">
                        <br>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="button" class="btn btn-primary ms-1" data-bs-dismiss="modal">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Add</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {{-- END ADD Category Faq MODAL --}}

        {{-- UPDATE Category Faq MODAL --}}
        <div class="modal fade text-left" id="editCategoryFaq" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel160" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-l" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title white" id="myModalLabel160">Update Category Faq
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <label for="">Category</label>
                        <select data-placeholder="Select Models" multiple class="chosen-select" name="">
                            <option>Asiatic Black Bear</option>
                            <option>Brown Bear</option>
                        </select>
                        <br><br>
                        <label for="">Faq Question</label>
                        <input type="text" id="" class="form-control round" placeholder="Faq Question">
                        <br>

                        <label for="exampleFormControlTextarea1" class="form-label">FaQ Answer</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                        <br>

                        <label for="">Sort Order</label>
                        <input type="number" id="" class="form-control round" placeholder="Sort Order" min="0">
                        <br>

                        <label for="">Slug</label>
                        <input type="text" id="" class="form-control round" placeholder="Slug">
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
        {{-- END UPDATE Category Faq MODAL --}}
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

    @endpush


</x-admin-layout>