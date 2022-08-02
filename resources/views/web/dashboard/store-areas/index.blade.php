@extends('web.dashboard.layouts.dashboard')

@section('content-dashboard')
    @include('web.common.alerts')
    <div class="tab-content profile-tabs-content">
        <div class="tab-pane-wrap">
            <div class="user-profile profile-manage-address-outer">
                <div class="row">
                    <div class="col-12 mb-2">
                        <a href="{{route('web.dashboard.store-areas.create')}}"
                           class="btn-style btn-area w-100 btn-style-light">
                            Add New Area
                        </a>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        @forelse($storeAreas as $storeArea)
                        <div class="manage-address-item manage-address-item_v2 d-flex mb-2">
                            <div class="manage-content left">
                                <h4 class="sub-title">{{$storeArea->area->title[app()->getLocale()]}}</h4>
                                <strong class="price primary-color">{{currencyFormatter($storeArea->price)}}</strong>
                            </div>
                            <ul class="manage-btns-wrap justify-content-end ml-auto">
                                <li>
                                    <a href="{{route('web.dashboard.store-areas.edit', ['store_area' => $storeArea->id])}}" class="address-edit-btn btn-new-address">
                                        <i class="far fa-edit"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('web.dashboard.store-area.delete', ['store_area' => $storeArea->id])}}" class="address-delete-btn delete-confirm" data-message="Do you want to delete this service area?">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        @empty
                            @include('web.common.not-found', ['message' => 'No delivery areas added.'])
                        @endforelse
                        {!! $storeAreas->render() !!}
                    </div>

                </div>
            </div>
            <!--Profile Address Outer Start-->
        </div>
    </div>

@endsection
@push('script-end')
    <script src="{{asset('assets/web/js/website.js')}}" ></script>
@endpush
