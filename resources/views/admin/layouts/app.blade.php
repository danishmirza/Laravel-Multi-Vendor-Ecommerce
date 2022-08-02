<!DOCTYPE html>
<html lang="en" >
<!-- begin::Head -->
<head>
    <meta charset="utf-8" />
    <title>
        {!! __(config('settings.company_name')) !!}
    </title>
    <meta name="description" content="Bootstrap alert examples">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css" integrity="sha512-4uGZHpbDliNxiAv/QzZNo/yb2FtAX+qiDb7ypBWiEdJQX8Pugp8M6il5SRkN8jQrDLWsh3rrPDSXRf3DwFYM6g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel='icon' href="{!! asset('assets/front/images/fav.png') !!}" type='image/x-icon'/>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <script type="text/javascript">
        window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
                'baseUrl' => url('/').'/'.config('app.locale')."/admin/"/*url(config('app.locale')).'/'*/,
                'apiUrl' => url('/').'/'.config('app.locale')."/api/"/*url(config('app.locale')).'/'*/,
                'base' => env('APP_URL'),
                'locale' => config('app.locale')
            ]) !!};
    </script>
    <style>
        .overlap .bef{
            max-height: 420px !important;
            height: auto !important;
        }
    </style>
    <link href="{{asset('assets/admin/css/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/admin/css/style1.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <link href="{{asset('assets/admin/css/my-technology.css')}}" rel="stylesheet" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    {{--        <link rel="shortcut icon" href="{{asset('dist/assets/img/rent-car-favicon.png')}}" />--}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link src="https://preview.keenthemes.com/metronic-v5/preview/assets/vendors/custom/datatables/datatables.bundle.css"/>


    @stack('stylesheet-page-level')
    @stack('stylesheet-end')
</head>
<body class="rtl m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
<div class="m-grid m-grid--hor m-grid--root m-page">
    @include('admin.common.header')
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        @include('admin.common.left-sidebar')
        <div class="m-grid__item m-grid__item--fluid m-wrapper">
            @yield('breadcrumb')
            <div class="m-content">
                @include('admin.common.alerts')
                @yield('content')
            </div>
        </div>
    </div>
    @include('admin.common.footer')
</div>
<div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
    <i class="la la-arrow-up"></i>
</div>
<script src="{{asset('assets/admin/js/vendors.bundle.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/scripts.bundle.js')}}" type="text/javascript"></script>
<script src="{!! asset('assets/admin/js/functions.js') !!}" type="text/javascript"></script>
<script src="{!! asset('assets/admin/js/select2.js') !!}" type="text/javascript"></script>
<script src="https://preview.keenthemes.com/metronic-v5/preview/assets/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
<!-- end of global js -->
@stack('script-page-level')
<!-- custom scripts -->
@stack('script-end')

<script type="text/javascript">
    $.fn.serializeObject = function () {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function () {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };
    $(document).ready(function(){

        // if( $('.m-menu__item ul.m-menu__subnav li.nav-active').length !== 0) {
        $('.m-menu__item').addClass('m-menu__item--open');
        // }
        if ($('.mt-select2').length > 0) {
            $(".mt-select2").select2({
                // theme: "bootstrap"
            });
        }
        if ($('.mt-datetime-picker').length > 0) {
            $('.mt-datetime-picker').datepicker({minDate: new Date(new Date().getTime()+(24 * 60 * 60 * 1000)),todayHighlight:true,}); // min date = tomorrw
        }

        if ($('.order-mt-datetime-picker').length > 0) {

            $('.order-mt-datetime-picker').datepicker({endDate: new Date(), autoclose: true,
                todayHighlight:true, minDate: new Date(new Date().getTime()+(24 * 60 * 60 * 1000)),}); // min date = tomorrw
        }
    });
</script>

@yield('custom_js')
</body>
</html>
