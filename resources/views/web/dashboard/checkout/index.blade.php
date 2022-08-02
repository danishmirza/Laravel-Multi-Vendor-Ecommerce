@extends('web.layouts.app')

@section('content')
    <section class="section cart-section pd-tb100">
        <div class="container">
            @include('web.common.alerts')
            <!--Cart Inner Start-->
            <div class="cart-inner-wrap">
                <div class="user-profile profile-order-detail-wrap">
                    <div class="profile-order-detail-inner checkout-form">
                        <div class="row">
                            <div class="col-lg-8 col-md-8">
                                <div class="checkout-inner-content">
                                    @if(is_null($defaultAddress))
                                        <checkout-address :cities="{{json_encode($cities)}}" :default-address-prop="null" :area="{{\Illuminate\Support\Facades\Session::get('client_area')}}"></checkout-address>
                                    @else
                                        <checkout-address :cities="{{json_encode($cities)}}" :default-address-prop="{{json_encode($defaultAddress)}}" :area="{{\Illuminate\Support\Facades\Session::get('client_area')}}"></checkout-address>
                                    @endif
                                        <div id="address-errors"></div>
                                    <div class="order-list-wrap order-checkout-wrap checkout-payment-wrap mb-3 border-bottom">
                                        <h4 class="order-main-title">Payment Method</h4>
                                        <div class="checkout-payment-listed">
{{--                                            <div class="payment-checkList">--}}
{{--                                                <label class="custom-radio home-cr">Apple Pay <br>--}}
{{--                                                    <input type="radio" name="radio-address">--}}
{{--                                                    <span class="checkmark home-checkmark"></span>--}}
{{--                                                </label>--}}
{{--                                            </div>--}}
{{--                                            <div class="payment-checkList">--}}
{{--                                                <label class="custom-radio home-cr">Samsung Pay <br>--}}
{{--                                                    <input type="radio" name="radio-address">--}}
{{--                                                    <span class="checkmark home-checkmark"></span>--}}
{{--                                                </label>--}}
{{--                                            </div>--}}
{{--                                            <div class="payment-checkList">--}}
{{--                                                <label class="custom-radio home-cr">Paypal<br>--}}
{{--                                                    <input type="radio" name="radio-address">--}}
{{--                                                    <span class="checkmark home-checkmark"></span>--}}
{{--                                                </label>--}}
{{--                                            </div>--}}
{{--                                            <div class="payment-checkList">--}}
{{--                                                <label class="custom-radio home-cr">Credit Card<br>--}}
{{--                                                    <input type="radio" name="radio-address">--}}
{{--                                                    <span class="checkmark home-checkmark"></span>--}}
{{--                                                </label>--}}
{{--                                            </div>--}}
                                            <div class="payment-checkList">
                                                <label class="custom-radio home-cr">Cash on Arrival<br>
                                                    <input type="radio" name="radio-address" checked>
                                                    <span class="checkmark home-checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order-list-wrap mb-3 border-bottom">
                                        <h4 class="order-main-title mb-2">Selected Services</h4>
                                        <div class="row">
                                            @php $total = 0 @endphp
                                            @foreach($cartItems as $item)
                                                <div class="col-12">
                                                    @include('web.dashboard.common.cart-item', ['showDeleteButton' => false, 'item' => $item])
                                                </div>
                                                @php $total = $total + $item->service->actual_price; @endphp
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="order-list-wrap order-date-wrap">
                                        <h4 class="order-main-title mb-1">Selected Date & Time</h4>
                                        <p>Scheduled Time: <span class="primary-color">{{$dateTime->format('M Y, d')}} at {{$dateTime->format('H:i')}}</span> </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="widget widget-cart">
                                    <div class="order-list-wrap order-summary-wrap">
                                        <h4 class="order-main-title">Order Summary</h4>
                                        <ul class="order-summary-listed">
                                            <li class="d-flex">
                                                Price
                                                <strong class="order-price ml-auto">{{currencyFormatter($total)}}</strong>
                                            </li>
                                            @if(!is_null($appliedCoupon))
                                                @php $discount = ($appliedCoupon->discount/100) * $total;
                                                    $total = $total - $discount
                                                @endphp
                                            <li class="d-flex">
                                                Discount
                                                <strong class="order-price ml-auto">{{currencyFormatter($discount)}}</strong>
                                            </li>
                                            @endif
                                            @php $vat = ($vat/100) * $total @endphp
                                            <li class="d-flex">
                                                VAT
                                                <strong class="order-price ml-auto">{{currencyFormatter($vat)}}</strong>
                                            </li>
                                            @if($defaultAddress)
                                            <li class="d-flex">
                                                Service Fee
                                                <strong class="order-price ml-auto">{{currencyFormatter($serviceFees)}}</strong>
                                            </li>
                                            @endif
                                            @if(is_null($appliedCoupon))
                                                <coupon-checkout-template :implemented-coupon="null"></coupon-checkout-template>
                                            @else
                                                <coupon-checkout-template :implemented-coupon="{{json_encode($appliedCoupon) }}"></coupon-checkout-template>
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="d-flex order-total-wrap">
                                        <h5 class="d-flex">Grand Total</h5>

                                        <strong class="order-price primary-color ml-auto">{!! currencyFormatter(($total + $vat + $serviceFees)) !!}</strong>
                                    </div>
                                    <form class="order-list-wrap order-btn-wrap" method="post" action="{{route('web.dashboard.checkout.submit', ['area' => \Illuminate\Support\Facades\Session::get('client_area')])}}" id="checkout">
                                        <div class="row" >
                                            @csrf
                                            <div class="col-12">
                                                <input type="text" class="d-none" name="address_id" value="{{($defaultAddress) ? $defaultAddress->id: ''}}" required  data-parsley-errors-container="#address-errors">
                                                <input type="hidden" name="visit_time" value="{{$dateTime->timestamp}}">
                                                <input type="hidden" name="payment_method" value="{{$paymentMethod}}">
                                                <button type="submit" class="btn-style btn-checkout w-100" >Place Order</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!--Cart Inner End-->
        </div>

    </section>
@endsection

@push('script-end')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNcTmnS323hh7tSQzFdwlnB4EozA3lwcA&libraries=places&language=en"></script>
    <script src="{{asset('assets/web/js/parsley.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#checkout').parsley();

        });
    </script>

@endpush
