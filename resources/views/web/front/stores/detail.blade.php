@extends('web.layouts.app')

@section('content')

    <section class="services-section pd-tb100">
        <div class="container">
            <div class="row">
               @include('web.front.stores.store-card')
                <div class="service-tabs-wrap w-100">
                    <div class="authentication-tabs-wrap">
                        <ul class="nav nav-pills mb-3 register-tabs">
                            <li class="nav-item">
                                <a class="nav-link active">Services</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('web.front.store.detail.portfolio', ['user' => $store->id])}}">Portfolio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('web.front.store.detail.reviews', ['user' => $store->id])}}">Reviews</a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content authentication-tabs-content">
                        <div class="tab-panel">
                            <!--Profile Sub Tab Start-->
                            <div class="profile-sub-tab">

                                <div class="tab-content profile-tabs-content">
                                    <div class="tab-panel">
                                        <div class="row">
                                            @forelse($services as $service)
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <!--Service Item Start-->
                                                @include('web.common.service', ['service' => $service])
                                                <!--Service Item End-->
                                            </div>
                                            @empty
                                                @include('web.common.not-found', ['message' => 'No services added'])
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Profile Sub Tab End-->
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
