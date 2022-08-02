@extends('web.dashboard.layouts.dashboard')

@section('content-dashboard')
    @include('web.common.alerts')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
            <a class="btn-style btn-new-service w-100" href="{{route('web.dashboard.store-services.create')}}">Add New Service</a>
        </div>
    </div>
    <div class="tab-content profile-tabs-content">
        <div class="tab-pane-wrap services-section services-tabs-wrap">
            <div class="order-dropdown-row order-dropdown-row_v2 mb-3 d-flex">
                <div class="dropdown mt-dropdown mt-dropdown-custom {{($showTab == 'all') ? 'active': ''}}">
                    <a class="btn dropdown-toggle d-flex" href="{{route('web.dashboard.store-services.index')}}">
                        <span>All</span>
                    </a>
                </div>
                <div class="dropdown mt-dropdown mt-dropdown-custom ml-auto {{($showTab == 'offered') ? 'active': ''}}">
                    <a class="btn dropdown-toggle d-flex" href="{{route('web.dashboard.store-services.index', ['offered'=> true])}}">
                        <span>Offered</span>
                    </a>
                </div>
                <div class="dropdown mt-dropdown mt-dropdown-custom ml-auto {{($showTab == 'featured') ? 'active': ''}}">
                    <a class="btn dropdown-toggle d-flex" href="{{route('web.dashboard.store-services.index', ['featured'=> true])}}">
                        <span>Featured</span>
                    </a>
                </div>
            </div>
            <div class="user-profile">
                <div class="row">
                    @forelse($services as $service)
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <!--Service Item Start-->
                        <div class="service-item service-item_v2">
                            <figure class="thumb">
                                <img src="{{imageUrl($service->image, 250,200,95,2)}}" alt="">
                            </figure>
                            <div class="text-wrap">
                                <ul class="btn-listed d-flex">
                                    <li>
                                        <a href="{{route('web.dashboard.store-service.delete', ['service' => $service->id])}}" class="btn-delete-service delete-confirm" data-message="Do you want to delete this service?">
                                            <i class="fas fa-trash-alt"></i>
                                            Delete
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('web.dashboard.store-services.edit', ['service' => $service->id])}}" class="btn-edit-service">
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </a>
                                    </li>
                                </ul>
                                <h4 class="title">
                                    <a href="#">{{$service->title[app()->getLocale()]}}</a>
                                </h4>
                                @include('web.common.rating', ['rating' => $service->average_rating])
                                <h5 class="price-wrap">
                                    {!! currencyFormatter($service->price) !!}
                                </h5>
                            </div>
                        </div>
                        <!--Service Item End-->
                    </div>
                    @empty
                        @include('web.common.not-found', ['message' => 'No Services found'])
                    @endforelse
                </div>
                {!! $services->render() !!}
            </div>

        </div>
    </div>

@endsection
@push('script-end')
    <script src="{{asset('assets/web/js/website.js')}}" ></script>
@endpush
