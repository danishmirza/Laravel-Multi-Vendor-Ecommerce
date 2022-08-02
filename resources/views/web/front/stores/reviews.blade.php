@extends('web.layouts.app')

@section('content')
    @include('web.common.alerts')
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
                                <a class="nav-link" href="{{route('web.front.store.detail.portfolio', ['user' => $store->id])}}">Portfolio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" >Reviews</a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content authentication-tabs-content">
                        <div class="tab-panel">
                            <!--Profile Sub Tab Start-->
                            <div class="profile-sub-tab">

                                <div class="tab-content profile-tabs-content">
                                    <div class="tab-panel">

                                        <div class="rating-box-wrap">
                                            <div class="services-ratings d-flex">
                                                <h4 class="title">Ratings & Reviews</h4>
                                                @if(auth()->check() && $store->storeReview)
                                                <a  class="rate-link" data-toggle="modal" data-target="#add-review">
                                                    Rate Service Provider
                                                </a>
                                                    @endif
                                            </div>
                                            @if(count($reviews) > 0)
                                            <ul class="rating-listed">
                                                @foreach($reviews as $review)
                                                @include('web.common.review', ['review' => $review])
                                                @endforeach
                                            </ul>
                                            @else
                                                <div class="row">
                                                    <div class="col-12">
                                                        @include('web.common.not-found', ['message' => 'This service provider has no reviews'])
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        {!! $reviews->onEachSide(0)->links() !!}

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
    @if(auth()->check() && $store->storeReview)
    @include('web.common.give-rating-modal', [
    'title' => $store->store_name[app()->getLocale()],
    'reviewId' => $store->storeReview->id,
    'route' => 'web.dashboard.store-reviews.add'
    ])
    @endif
@endsection

