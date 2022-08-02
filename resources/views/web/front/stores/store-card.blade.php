<div class="provider-wrappper">
    <div class="row providers-row">
        <div class="col-lg-6">
            <div class="service-providers-img">
                <img src="{{imageUrl($store->image, 633, 404, 95,2)}}" alt="service-provider">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="service-providers-details">
                <div class="provider-title">
                    <h4>
                        {{$store->store_name[app()->getLocale()]}}
                    </h4>
                    <a href="{{route('web.dashboard.start-conversation', ['user' => $store->id])}}" class="btn-style">
                        <img src="{{asset('assets/web/img/comment-icon.svg')}}" alt="comment-icon">
                    </a>
                </div>
                @include('web.common.rating', ['rating' => $store->average_rating])
                <div class="mail-phone">
                                        <span class="phone-info">
                                            <img src="{{asset('assets/web/img/icon-phone.svg')}}" alt="">
                                            <a  href="tel:{{$store->phone}}">{{$store->phone}}</a>
                                        </span>
                    <span class="mail-info">
                                            <img src="{{asset('assets/web/img/email.svg')}}" alt="">
                                            <a href="mailto:{{$store->email}}">{{$store->email}}</a>
                                        </span>
                </div>
                <span class="location-info">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <a href="#">{{$store->address}}</a>
                                    </span>
                <p class="provider-txt">
                    {!! $store->detail[app()->getLocale()] !!}
                </p>
            </div>
        </div>
    </div>
</div>
