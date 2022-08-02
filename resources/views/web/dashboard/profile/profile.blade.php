@extends('web.dashboard.layouts.dashboard')

@push('style-end')
    <link href="{{asset('lightbox/css/lightbox.min.css')}}" rel="stylesheet" />
@endpush

@section('content-dashboard')
    @include('web.common.alerts')
    @if($user->isStore() && $user->isSubscribed() && !$user->isSubscriptionExpired())
    <div class="alert alert-info" role="alert">
        Your subscription will expire on {{\Carbon\Carbon::parse($user->subscription_ends_date)->format('d-m-Y')}}.
    </div>
    @endif
    <div class="tab-content profile-tabs-content">
        <div class="tab-pane-wrap">
            <div class="user-profile {{($user->isUser()) ? '' : 'supplier-profile'}}">
                <div class="d-flex flex-column flex-md-row">
                    <div class="profile-img-mt d-flex align-items-center justify-content-center">
                        <img src="{!! imageUrl($user->image, 250,250,95,1) !!}" class="img-fluid" alt="">
                    </div>
                    <ul class="user-profile-detail-mt mb-2">
                        @if(!$user->isUser())
                        <li>
                            <h5 class="profile-title d-flex">
                                <span class="span-col">Company Name: </span>
                                <span class="text">{{$user->store_name[app()->getLocale()]}}</span>
                            </h5>
                        </li>
                        @else
                        <li>
                            <h5 class="profile-title d-flex">
                                <span class="span-col">Name: </span>
                                <span class="text">{{$user->name}}</span>
                            </h5>
                        </li>
                        @endif
                        <li>
                            <h5 class="profile-title d-flex">
                                <span class="span-col">Email: </span>
                                <span class="text">
                              <a href="mailto:{{$user->email}}">{{$user->email}}</a>
                            </span>
                            </h5>
                        </li>
                        <li>
                            <h5 class="profile-title d-flex">
                                <span class="span-col">Phone No:</span>
                                <span class="text">
                              <a href="tel:{{$user->phone}}">{{$user->phone}}</a>
                            </span>
                            </h5>
                        </li>
                        <li>
                            <h5 class="profile-title d-flex">
                                <span class="span-col">Address: </span>
                                <span class="text">
                              {{$user->address}}
                            </span>
                            </h5>
                        </li>
                            @if(!$user->isUser())
                        <li>
                            <h5 class="profile-title d-flex">
                                <span class="span-col">City: </span>
                                <span class="text">
                                  {{$user->city->title[app()->getLocale()]}}
                                </span>
                            </h5>
                        </li>
                            @endif
                    </ul>
                </div>
                @if(!$user->isUser())
                <div class="d-flex flex-column profile-row">
                    <div class="content">
                        <h5 class="sub-title">About</h5>
                        <p>{{$user->detail[app()->getLocale()]}} </p>
                    </div>
                    <div class="content">
                        <h5 class="sub-title">Attach Your Trade License</h5>
                        <a href="{{asset($user->trade_license)}}" data-lightbox="image-1" data-title="Trade License">
                        <figure class="thumb">
                            <img src="{!! imageUrl($user->trade_license, 250,250,95,2) !!}" alt="">
                        </figure>
                        </a>
                    </div>
                </div>
                @endif
                <div class="d-flex">
                    @if($user->isUser())
                    <a href="{{route('web.dashboard.edit-user-profile')}}" class="btn-style profile-btn"> Edit Profile</a>
                    @else
                        <a href="{{route('web.dashboard.edit-store-profile')}}" class="btn-style profile-btn"> Edit Profile</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script-end')
    <script src="{{asset('lightbox/js/lightbox.min.js')}}" ></script>
@endpush
