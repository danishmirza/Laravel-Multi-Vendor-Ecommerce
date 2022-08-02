<div class="main-service text-center">
    <div class="service-price">
        <h5 class="sub-title">{{$package->title[app()->getLocale()]}}
            @if(isset($package->purchased_packages_count) && $package->purchased_packages_count > 1)
            <small>({{$package->purchased_packages_count}})</small>
            @endif
        </h5>
    </div>
    <div
            class="service-detail d-flex align-items-center justify-content-center flex-column">
        <div class="packg-time">
            <p>{{$package->duration}} {{ucfirst($package->duration_type)}} Package</p>
        </div>
        @if($package->is_free)
            <strong class="sub-price text-uppercase">Free</strong>
        @else
            <strong class="sub-price text-uppercase">{{currencyFormatter($package->price)}}</strong>
        @endif
        {!! $package->description[app()->getLocale()] !!}
        @if(!$package->trashed())
        <a class="btn-style btn-style-tp subcription-btn" href="{{route('web.dashboard.purchase-package.submit', ['package' => $package->id])}}">Buy Now</a>
        @endif
    </div>
</div>