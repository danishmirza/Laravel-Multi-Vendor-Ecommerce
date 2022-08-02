<div class="service-item">
    <figure class="thumb">
        <img src="{{imageUrl($service->image, 412,241,95,2)}}" alt="">
        @if($service->featured())
        <figcaption class="caption">
            <a class="btn-feature btn-effect1">Featured</a>
        </figcaption>
        @endif
    </figure>
    <div class="text-wrap">
        <span class="item-name">{{$service->store->store_name[app()->getLocale()]}}</span>
        <h4 class="title">
            <a href="{{route('web.front.service.detail', ['service' => $service->id])}}">{{$service->title[app()->getLocale()]}}</a>
        </h4>
        @include('web.common.rating', ['rating' => $service->average_rating])
        <h5 class="price-wrap">
            {!! currencyFormatter($service->price, $service->actual_price, $service->has_offer) !!}
        </h5>
    </div>
</div>
