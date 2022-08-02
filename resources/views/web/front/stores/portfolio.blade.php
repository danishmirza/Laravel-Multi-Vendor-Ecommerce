@extends('web.layouts.app')

@push('style-end')
    <link href="{{asset('lightbox/css/lightbox.min.css')}}" rel="stylesheet" />
@endpush

@section('content')

    <section class="services-section pd-tb100">
        <div class="container">
            <div class="row">
                @include('web.front.stores.store-card')
                <div class="service-tabs-wrap w-100">
                    <div class="authentication-tabs-wrap">
                        <ul class="nav nav-pills mb-3 register-tabs">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('web.front.store.detail', ['user' => $store->id])}}">Services</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active">Portfolio</a>
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
                                        <section class="section gallery-section">
                                            <div class="row">
                                                @forelse($images as $image)
                                                <div class="col-md-3 col-sm-4 col-xs-12">
                                                    <div class="gallery-item">
                                                        <figure class="thumb">
                                                            <a href="{{asset($image->image)}}" data-lightbox="portfolio-image" data-title="Portfolio Image">
                                                                <img class="mklbItem"
                                                                     src="{{imageUrl($image->image, 302,302,95,2)}}" alt="">
                                                            </a>
                                                        </figure>
                                                    </div>
                                                </div>
                                                @empty
                                                    @include('web.common.not-found', ['message' => 'No portfolio images added.'])
                                                @endforelse
                                            </div>
                                        </section>
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

@push('script-end')
    <script src="{{asset('lightbox/js/lightbox.min.js')}}" ></script>
@endpush