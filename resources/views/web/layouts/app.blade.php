<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title.' | Click & Shine' : 'Click & Shine' }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('assets/web/css/custom.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/app.css')}}" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    {{ Breadcrumbs::view('breadcrumbs::json-ld') }}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" id="theme-styles">
    @stack('style-end')
    <script>
        window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
                "locale" => app()->getLocale(),
                'apiUrl' => url('/').'/'.app()->getLocale()."/api/",
                'base' => env('APP_URL'),
                'baseUrl' => url('/').'/'.app()->getLocale()."/",
                'websocketKey' => env('PUSHER_APP_KEY'),
                'websocketCluster' => env('PUSHER_APP_CLUSTER'),
                'websocketPort' => env('PUSHER_APP_PORT'),
                'websocketPath' => env('PUSHER_APP_PATH'),
                'loggedInUserId' => (isset($user) && !is_null($user) ? $user->id: 0),
            ]) !!};
    </script>
</head>

<body class="" >
    <div class="wrapper" id="main-app">
        @include('web.common.header')
        @if(Route::currentRouteName() != 'web.front.index')
            {{ Breadcrumbs::render() }}
        @endif

        @yield('content')

        @include('web.common.footer')
    </div>

    <script src="{{asset('assets/web/js/jquery.min.js')}}"></script>
    <script src="https://getbootstrap.com/docs/4.1/assets/js/vendor/popper.min.js"></script>
    <script src="{{asset('assets/web/js/bootstrap.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#header-categories-select').select2({
                minimumResultsForSearch: -1
            });
        });
        function formatState (state) {
            if (!state.id) {
                return state.text;
            }
            return state.title;
        };
        $(document).ready(function() {
            $('#header-categories-select-2').select2({
                minimumResultsForSearch: -1,
                templateSelection: formatState
            });
        });
    </script>
    @stack('script-end')
    <script src="{{asset('js/app.js')}}"></script>

    @include('web.common.toastr')
    @stack('script-end1')
</body>
</html>
