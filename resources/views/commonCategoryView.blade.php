<x-app-layout>
    <div class="container" style="width:82%;margin-top:20px;">
        
        <img src="{{ asset('uploads/Category/50.jpg') }}" alt="50%off">
 
        <div id="errorDiv" style="display: none" class="alert alert-danger mt-4"></div>
        <div class="find">
            <img id="bannerImg" src="{{ asset('uploads/Category/find.webp') }}" alt="img">
            <h2>Find Your
                {{ $category->category_name }}
            </h2>
            <form method="get">
                <input type="hidden" name="categoryId" id="categoryId" value="{{ $category->id }}">
                <div class="make">
                    <select name="make" id="make">
                        <option selected disabled>1 | Select Make</option>
                        @foreach ($make as $item)
                            <option value="{{$item->id}}"> {{ $item->name }} </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('make')" class="mt-2" />
                </div>
                <div class="year">
                    <select name="year" id="year">
                        <option selected disabled>2 | Select Year</option>
                    </select>
                    <x-input-error :messages="$errors->get('year')" class="mt-2" />
                </div>
                <div class="model">
                    <select name="model" id="model">
                        <option selected disabled>3 | Select Model</option>
                    </select>
                    <x-input-error :messages="$errors->get('model')" class="mt-2" />
                </div>
                <div class="option">
                    <select name="option" id="option">
                        <option selected disabled value="">4 | Select Option</option>
                        <option value="All Models">All Models</option>
                    </select>
                </div>
                <div class="goBtn">
                    <button type="submit" class="btn">Go</button>
                </div>
            </form>
        </div> 
        {{-- <div id="errorDiv" style="display: none" class="alert alert-danger mt-4"></div>
        <div class="find container position-relative">
            <img src="{{ asset('uploads/Category/find.webp') }}" alt="img" class="img-fluid">
            
            <!-- H2 Positioned Over the Image -->
            <h2 class="text-center">Find Your {{ $category->category_name }}</h2>
            
            <!-- Form Positioned Over the Image -->
            <form method="get" class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                <input type="hidden" name="categoryId" id="categoryId" value="{{ $category->id }}">
        
                <!-- Make Selection -->
                <div class="make">
                    <select name="make" id="make" class="form-control">
                        <option selected disabled>1 | Select Make</option>
                        @foreach ($make as $item)
                            <option value="{{$item->id}}"> {{ $item->name }} </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('make')" class="mt-2" />
                </div>
        
                <!-- Year Selection -->
                <div class="year">
                    <select name="year" id="year" class="form-control">
                        <option selected disabled>2 | Select Year</option>
                    </select>
                    <x-input-error :messages="$errors->get('year')" class="mt-2" />
                </div>
        
                <!-- Model Selection -->
                <div class="model">
                    <select name="model" id="model" class="form-control">
                        <option selected disabled>3 | Select Model</option>
                    </select>
                    <x-input-error :messages="$errors->get('model')" class="mt-2" />
                </div>
        
                <!-- Option Selection -->
                <div class="option">
                    <select name="option" id="option" class="form-control">
                        <option selected disabled value="">4 | Select Option</option>
                        <option value="All Models">All Models</option>
                    </select>
                </div>
        
                <!-- Submit Button -->
                <div class="goBtn">
                    <button type="submit" class="btn btn-primary">Go</button>
                </div>
            </form>
        </div> --}}
        

 

          <div class="head-section-bottom d-flex flex-wrap banner">
            <div class="col-md-3 d-flex">
                <div class="benifits-logo text-center col-4 m-2">
                    <img src="{{ asset('uploads/Category/saving.png') }}" alt="Savings">
                </div>
                <div class="col-8 m-2">
                    <h6>Snug Fit. Great Price!</h6>
                    <small>Savings! Up to 60% Off!</small>
                </div>
            </div>
            <div class="col-md-3 d-flex">
                <div class="benifits-logo text-center col-4 m-2">
                    <img src="{{ asset('uploads/Category/exchange.png') }}" alt="">
                </div>
                <div class="col-8 m-2">
                    <h6>Buy with Confidence</h6>
                    <small>Hassle Free Exchanges</small>
                </div>
            </div>
            <div class="col-md-3 d-flex">
                <div class="benifits-logo text-center col-4 m-2">
                    <img src="{{ asset('uploads/Category/protection.png') }}" alt="">
                </div>
                <div class="col-8 m-2">
                    <h6>Seal Protection</h6>
                    <small>Warranties Directly Guaranteed</small>
                </div>
            </div>
            <div class="col-md-3 d-flex">
                <div class="benifits-logo text-center col-4 m-2">
                    <img src="{{ asset('uploads/Category/lock.png') }}" alt="">
                </div>
                <div class="col-8 m-2">
                    <h6>Quick & Easy</h6>
                    <small>Safe Secure Checkout</small>
                </div>
            </div>

        </div>
        
    </div>
    


    @push('script')
    <script>
        $(document).ready(function () {
            $("#make").change(function (e) { 
                e.preventDefault();
                var makeId = $(this).val();

                $.ajax({
                    type: "get",
                    url:"{{ route('getYear',':id') }}".replace(':id',makeId),
                    dataType: "json",
                    success: function (response) {
                        if(response.years) {
                            $("#year").empty();
                            $("#year").append(`<option selected disabled>2 | Select Year</option>`); // Re-add the default option
                            $.each(response.years, function(index, item) {
                               $("#year").append(
                                `<option value="${item.id}">${item.year}</option>`
                               );
                            });
                        } else {
                            $("#errorDiv").text(response.error).show();
                        }
                    }
                });
            });

            $("#year").change(function (e) {
                e.preventDefault();
                var makeId = $("#make").val();
                var catId = $("#categoryId").val();
                $.ajax({
                    type: "get",
                    url:"{{ route('getModel', ['makeId' => ':makeId', 'catId' => ':catId']) }}"
                            .replace(':makeId', makeId)
                            .replace(':catId', catId),
                    dataType: "json",
                    success: function (response) {
                        if(response.models) {
                            $("#model").empty();
                            $("#model").append(`<option selected disabled>3 | Select Model</option>`); // Re-add the default option
                            $.each(response.models, function(index, item) {
                               $("#model").append(
                                `<option value="${item.id}">${item.model_name}</option>`
                               );
                            }); 
                        } else {
                            $("#errorDiv").text(response.error).show();
                        }
                    }
                });
            });
            
            $("#option").change(function (e) {
                var makeText = $("#make option:selected").text();
                var yearText = $("#year option:selected").text();
                var modelText = $("#model option:selected").text();
                var optionText = $("#option option:selected").text();      
                var combinedText = `${makeText}/${modelText} ${optionText} ${yearText}`;
                var make = makeText.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ').toLowerCase().replace(/^\s+|\s+$/gm,'').replace(/\s+/g, '-');
                var model = modelText.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ').toLowerCase().replace(/^\s+|\s+$/gm,'').replace(/\s+/g, '-');
                var year = yearText.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ').toLowerCase().replace(/^\s+|\s+$/gm,'').replace(/\s+/g, '-');
                window.location.href = "{{ route('getProduct',[':make' ,':model' ,':year']) }}".replace(':make' , make).replace(':model' , model).replace(':year' , year);
            });
            
        }); 
    </script>
    @endpush
</x-app-layout>
@include('footer')