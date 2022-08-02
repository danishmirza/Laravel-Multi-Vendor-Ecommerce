@extends('web.dashboard.layouts.dashboard')

@section('content-dashboard')
    @include('web.common.alerts')
    <div class="tab-content profile-tabs-content">
        <div class="tab-pane-wrap">
            <div class="user-profile portfolio-wrap-outer profile-manage-address-outer">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <a href="{{route('web.dashboard.store-ads.create')}}" class="btn-style btn-auth w-100">Add new Ad</a>
                    </div>
                    <div class="col-md-6">
                        <div class="dropdown mt-dropdown mt-dropdown-custom mt-dropdown-status d-flex">
                            <button class="btn btn-status dropdown-toggle ml-auto" type="button" id="status-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span>Status</span>

                            </button>
                            <div class="dropdown-menu" aria-labelledby="status-dropdown" >
                                <ul class="dropdown-listed">
                                    <li class="{{($status == 'pending') ? 'active' : ''}}">
                                        <a class="dropdown-item" href="{{route('web.dashboard.store-ads.index', ['status' => 'pending'])}}">
                                            Pending
                                            <span class="icon"></span>
                                        </a>
                                    </li>
                                    <li class="{{($status == 'approved') ? 'active' : ''}}">
                                        <a class="dropdown-item" href="{{route('web.dashboard.store-ads.index', ['status' => 'approved'])}}">
                                            Accepted
                                            <span class="icon"></span>
                                        </a>
                                    </li>
                                    <li class="{{($status == 'completed') ? 'active' : ''}}">
                                        <a class="dropdown-item" href="{{route('web.dashboard.store-ads.index', ['status' => 'completed'])}}">
                                            Completed
                                            <span class="icon"></span>
                                        </a>
                                    </li>
                                    <li class="{{($status == 'rejected') ? 'active' : ''}}">
                                        <a class="dropdown-item" href="{{route('web.dashboard.store-ads.index', ['status' => 'rejected'])}}">
                                            Rejected
                                            <span class="icon"></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row">
                    @forelse($ads as $ad)
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="portfolio-item manage-portfolio">
                            <figure class="thumb">
                                <a href="#">
                                    <img class="img-fluid" src="{{imageUrl($ad->image, 416,244,95,1)}}" alt="">
                                </a>
                                <figcaption class="caption">
                                    <div class="btns-wrap">
                                        <a href="{{route('web.dashboard.store-ads.edit', ['ad' => $ad->id])}}" class="btn btn-edit">
                                            <img src="{{asset('assets/web/img/edit-icon.svg')}}" alt="">
                                        </a>
                                        <a href="{{route('web.dashboard.store-ads.delete', ['ad' => $ad->id])}}" class="btn btn-trash delete-confirm" data-message="Do you want to delete this ad?">
                                            <img src="{{asset('assets/web/img/trash-icon.svg')}}" alt="">
                                        </a>
                                    </div>
                                </figcaption>
                            </figure>
                            <div class="text-holder">
                                <div class="d-flex mb-1">
                                    <h5 class="title">
                                        <a href="#">
                                            {{$ad->title[app()->getLocale()]}}
                                        </a>
                                    </h5>
                                    <div class="status-content ml-auto">
                                        Status:
                                        <span>{{ucfirst($ad->ad_status)}}</span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <h5 class="sub-title">
                                        <a href="#">{{$ad->sub_title[app()->getLocale()]}}</a>
                                    </h5>

                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                        <div class="col-12">
                            @include('web.common.not-found', ['message' => 'No ads available.'])
                        </div>
                    @endforelse
                    {!! $ads->render() !!}

                </div>

            </div>
            <!--Profile Address Outer End-->
        </div>
    </div>
@endsection

@push('script-end')
    <script src="{{asset('assets/web/js/website.js')}}" ></script>
@endpush
