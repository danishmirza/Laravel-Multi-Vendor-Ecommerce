@extends('web.layouts.app')

@section('content')
    @if($user->isStore())
        @if(!$user->isTradeLicenseVerified())
            <div class="alert alert-danger" role="alert">
                Until your trade license is approved, your account will not appear in website search.
            </div>

        @endif
        @if($user->isNotSubscribed())
            <div class="alert alert-warning" role="alert">
                Please subscribe to a package to open full account functionalities.
                <a href="{{route('web.dashboard.subscription')}}">Subscribe Now</a>
            </div>
        @endif
        @if($user->isSubscribed() && $user->isSubscriptionExpired())
            <div class="alert alert-warning" role="alert">
                Your subscription expired. Please subscribe to a package to continue enjoy full expirence of the account.
                <a href="{{route('web.dashboard.subscription')}}">Subscribe Now</a>
            </div>
        @endif
    @endif
    <section class="profile-section pd-tb100">
        <div class="container">
            <div class="profile-tabs-wrap">
                <div class="row custom-row">
                    <div class="col-lg-3 col-md-4 col-sm-4">
                        @if($user->isUser())
                            @include('web.dashboard.common.user-menu')
                        @else
                            @include('web.dashboard.common.store-menu')
                        @endif
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-4">
                        @yield('content-dashboard')
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
