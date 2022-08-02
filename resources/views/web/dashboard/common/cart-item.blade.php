<div class="order-list-box cart-list-item d-flex">
    <div class="order-detail d-flex justify-content-between w-100">
        <div class="order-img d-flex justify-content-center align-items-center mr-2">
            <a href="#">
                <img src="{{imageUrl($item->image, 205,136,95,2)}}" alt="" class="img-fluid">
            </a>

        </div>
        <div class="order-info-left w-100">
            <h5 class="order-sub-title">
                {{$item->service->title[app()->getLocale()]}}
            </h5>
            @include('web.common.rating', ['rating' => $item->service->average_rating])
            <div class="d-flex">
                <h5 class="price-wrap">{!! currencyFormatter($item->service->price, $item->service->actual_price, $item->service->has_offer) !!}</h5>
            </div>
            @if($showDeleteButton)
            <a href="{{route('web.dashboard.cart.delete', ['cart' => $item->id])}}" class="btn-cart-close">
                <img src="{{asset('assets/web/img/close-icon.svg')}}" alt="">
            </a>
            @endif
        </div>
    </div>
</div>