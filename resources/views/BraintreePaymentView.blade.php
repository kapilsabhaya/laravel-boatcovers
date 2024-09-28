<x-app-layout>
    @push('script')
    <script src="https://js.braintreegateway.com/web/dropin/1.24.0/js/dropin.min.js"></script>
    @endpush

    <div class="py-12">
        <div id="error-message" style="display: none"></div>
        @csrf
        <div id="dropin-container" style="display: flex;justify-content: center;align-items: center;"></div>
        <div style="display: flex;justify-content: center;align-items: center; color: white">
            <a id="submit-button" class="btn btn-sm btn-success">Submit payment</a>
        </div>
        @push('script')

    <script>
            var button = document.querySelector('#submit-button');
            braintree.dropin.create({
                authorization: '{{$token}}',
                container: '#dropin-container'
            },
            function (createErr, instance) {
                button.addEventListener('click', function () {
                    instance.requestPaymentMethod(function (err, payload) {
                        button.addEventListener('click', function () {
                            instance.requestPaymentMethod(function (err, payload) {
                                (function($) {
                                $(function() {
                                    var data = @json($data);
                                    console.log(data);
                                    // alert("jk");
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });
                                    $.ajax({
                                        type: "POST",
                                        url: "{{route('processData')}}",
                                        data: {nonce : payload.nonce, data : data},
                                        success: function (response) {
                                            if(response.status === 200){
                                            alert("Payment Successful");
                                            location.href = response.redirectUrl;
                                            }
                                        },
                                        error: function (response) {
                                            if (response.status === 500) {
                                                $('#error-message').text('An internal server error occurred. Please try again later.').show();
                                            }
                                        }
                                    });
                                });
                                })(jQuery);
                            });
                        });
                    });
                });
            });
    </script>
        @endpush
    </div>
</x-app-layout>