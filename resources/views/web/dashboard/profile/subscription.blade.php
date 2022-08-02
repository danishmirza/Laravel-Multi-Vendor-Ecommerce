@extends('web.layouts.app')

@section('content')
    <section class="subcription-section login-sec pd-tb100">
        <div class="container">
            <div class="row">
               <div class="col-12">
                   @include('web.common.alerts')
               </div>
                @forelse($packages as $package)
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <!--Subcription Item Start-->
                    <div class="main-service text-center">
                        <div class="service-price">
                            <h5 class="sub-title">{{$package->title[app()->getLocale()]}}</h5>
                        </div>
                        <div class="service-detail d-flex align-items-center justify-content-center flex-column">
                            <div class="packg-time">
                                <p>{{$package->duration}} {{ucfirst($package->duration_type)}} Package</p>
                            </div>
                            @if($package->is_free)
                            <strong class="sub-price text-uppercase">Free</strong>
                            @else
                                <strong class="sub-price text-uppercase">{{currencyFormatter($package->price)}}</strong>
                            @endif
                            {!! $package->description[app()->getLocale()] !!}
                            <a class="btn-style btn-style-tp subcription-btn" href="{{route('web.dashboard.subscribe-to-package.submit', ['package' => $package->id])}}">Subscribe</a>

                        </div>
                    </div>
                    <!--Subcription Item End-->
                </div>

                @empty
                    <div class="col-12">
                        @include('web.common.not-found', 'No subscription packages found.')
                    </div>
                @endforelse
                <div class="col-12">
                    {!! $packages->render() !!}
                </div>
            </div>
        </div>
    </section>

@endsection
