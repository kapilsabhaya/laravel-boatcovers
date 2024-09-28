<x-admin-layout>
    @push('heading')
    Assign Vehicle Variant
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
                    <label for="">Select Years</label><br>
                    <select data-placeholder="Select Years" multiple id="year" class="chosen-select" name="year[]"
                        style="width: 70%;min-height:200vh">
                        @if ($year->isNotEmpty())
                        @foreach ($year as $item)
                        <option value="{{ $item->id }}">{{ $item->year }}</option>
                        @endforeach
                        @else
                        <option selected disabled>No Years Found</option>
                        @endif
                    </select>
                    <p class="yearError"></p>
                    <br><br>

                    <label for="">Select Models</label><br>
                    <select data-placeholder="Select Models" id="model" multiple class="chosen-select" name="model[]"
                        style="width: 70%;min-height:200vh">
                        @if ($model->isNotEmpty())
                        @foreach ($model as $mdl)
                        <option value="{{ $mdl->id }}">{{ $mdl->model_name }}</option>
                        @endforeach
                        @else
                        <option selected disabled>No Model Found</option>
                        @endif
                    </select>
                    <p class="modelError"></p>
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
                url: "{{ route('assignMakeModel.store') }}",
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
                            $('#year_chosen').addClass('is-invalid').next('.yearError').addClass('invalid-feedback').html(errors.year).show();
                        }
                        if (errors['model']) {
                            $('#model_chosen').addClass('is-invalid').next('.modelError').addClass('invalid-feedback').html(errors.model).show();
                        }
                    }   
                }
            });
        });
    </script>
    @endpush
</x-admin-layout>