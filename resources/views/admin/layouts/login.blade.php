<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="utf-8" />
    <title>
        {!! config('settings.company_name') !!}
    </title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <link rel='icon' href='{!! asset('images/Favicon.png') !!}' type='image/x-icon'/>

    <script>
        WebFont.load({
            active: function() {
                sessionStorage.fonts = true;
            },
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]}
        });
    </script>
    <link href="{{asset('assets/admin/css/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/admin/css/style1.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/admin/css/my-technology.css')}}" rel="stylesheet" type="text/css" />
    @stack('stylesheet-page-level')
</head>

<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--singin m-login--2 m-login-2--skin-1" id="m_login" style="background-image: url('{!! asset('assets/admin/img/bg-1.jpg') !!}');">

        <div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
            @include('admin.common.alerts')
            <div class="m-login__container">
                <div class="m-login__logo">
                    <a href="#">
                        <img src="{{asset('assets/admin/img/logo.png')}}">
                    </a>

                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>


<script src="{{asset('assets/admin/js/vendors.bundle.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/scripts.bundle.js')}}" type="text/javascript"></script>
</body>
</html>
