<style>
    #pre-loader {
        background-color: #fff;
        height: 100%;
        width: 100%;
        position: fixed;
        z-index: 1;
        margin-top: 0px;
        top: 0px;
        left: 0px;
        bottom: 0px;
        overflow: hidden !important;
        right: 0px;
        z-index: 999999;
    }

    #pre-loader img {
        text-align: center;
        left: 0;
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        -webkit-transform: translateY(-50%);
        -o-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        -moz-transform: translateY(-50%);
        z-index: 99;
        margin: 0 auto;
    }
</style>
<div id="pre-loader">
    <img src="{{ asset('uploads/loader.gif') }}" alt="Loading..." />
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
          setTimeout(function() {
            window.location.href="{{ route('dashboard') }} ";
          }, 1000);
        });     
</script>