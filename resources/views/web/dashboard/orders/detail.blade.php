@extends('web.dashboard.layouts.dashboard')

@section('content-dashboard')
    <div class="tab-content profile-tabs-content">
        <div class="tab-pane-wrap">
            <div class="profile-order-wrap-main">
                <div class="user-profile profile-order-detail-wrap">
                    <div class="profile-order-detail-inner">
                        <div class="order-detail-box border-bottom">
                            <div class="order-top d-flex">
                                <h5 class="tittle-order">Order # {{$order->order_number}}</h5>
                                <h5 class="total-amount-list ml-auto"><span class="primary-color">{{currencyFormatter($order->total)}}</span></h5>
                            </div>
                            <div class="order-info-left w-100">
                                <div class="order-info-left w-100">
                                    <ul class="order-combination">
                                        <li class="list">Order Placement Time:&nbsp;<span class="order-date primary-color">
                                            {{\Carbon\Carbon::parse($order->created_at)->format('M Y, d H:i')}}
                                            </span></li>
                                    </ul>
                                    <ul class="order-combination">
                                        <li class="list">Scheduled Time:&nbsp;<span class="order-date primary-color"> {{\Carbon\Carbon::parse($order->visit_time)->format('M Y, d H:i')}}</span></li>
                                    </ul>

                                    <ul class="order-combination">
                                        <li class="list">Total Services:&nbsp;<span class="primary-color">{{$order->services_count}}</span></li>
                                    </ul>
                                    <ul class="order-combination">
                                        <li class="list">Status:&nbsp;<span>{{$order->order_status}}</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="order-list-wrap border-bottom">
                            <h4 class="order-main-title">Supplier</h4>
                            <div class="row supplier-row">
                                <div class="col-lg-3 col-md-3 col-sm-12">
                                    <figure class="mt-thumb">
                                        <img src="{{imageUrl($order->store->image, 178,92,95,2)}}" alt="">
                                    </figure>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-12">
                                    <div class="text-wrap">
                                        <div class="d-flex w-100 supplier-details">
                                            <div class="supplier-content">
                                                <h4 class="title">{{$order->store->store_name[app()->getLocale()]}}</h4>
                                                <span class="phone-info">
                                      <img src="{{asset('assets/web/img/Icon-feather-phone-outgoing.svg')}}" alt="">
                                      <a href="tel:{{$order->store->phone}}">{{$order->store->phone}}</a>
                                    </span>
                                            </div>
                                            <h5 class="ml-auto payment-title">Payment Method <span>{{$order->payment_method}}</span></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
{{--                        @php dd($order->address->city->title) @endphp--}}
                        <div class="order-list-wrap border-bottom">
                            <h5 class="order-main-title">Address</h5>
                            <ul class="user-profile-detail-mt">
                                <li>
                                    <h5 class="profile-title d-flex">
                                        <span class="span-col">Name: </span>
                                        <span class="text">{{$order->address->name}}</span>
                                    </h5>
                                </li>
                                <li>
                                    <h5 class="profile-title d-flex">
                                        <span class="span-col">Phone No:</span>
                                        <span class="text">
                                  <a href="tel:{{$order->address->phone}}">{{$order->address->phone}}</a>
                                </span>
                                    </h5>
                                </li>
                                <li>
                                    <h5 class="profile-title d-flex">
                                        <span class="span-col">Address: </span>
                                        <span class="text"> {{$order->address->address}} </span>
                                    </h5>
                                </li>
                                <li>
                                    <h5 class="profile-title d-flex">
                                        <span class="span-col">City: </span>
                                        <span class="text"> {{$order->address->city->title->{app()->getLocale()} }}, {{$order->address->area->title->{app()->getLocale()} }}  </span>
                                    </h5>
                                </li>
                                <li>
                                    <h5 class="profile-title d-flex">
                                        <span class="span-col">Detail: </span>
                                        <span class="text"> {{$order->address->detail}} </span>
                                    </h5>
                                </li>
                            </ul>
                        </div>

                        <div class="order-list-wrap border-bottom">
                            <h5 class="order-main-title">Selected Services</h5>
                            <div class="row">
                                @forelse($order->orderDetails as $orderDetail)
                                <div class="col-12">
                                    <div class="order-list-box d-flex">
                                        <div class="order-detail d-flex justify-content-between w-100">
                                            <div class="order-img d-flex justify-content-center align-items-center mr-2">
                                                <img src="{{imageUrl($orderDetail->image, 205,136,95,2)}}" alt="" class="img-fluid">
                                            </div>
                                            <div class="order-info-left w-100">
                                                <h5 class="order-sub-title">
                                                    {{$orderDetail->service->title[app()->getLocale()]}}
                                                </h5>
                                                <div class="d-flex order-sub-det">
                                                    <p>{{$order->store->store_name[app()->getLocale()]}}</p>
                                                    <h5 class="price-wrap ml-auto"> {{currencyFormatter($orderDetail->price)}}</h5>
                                                </div>
                                                @include('web.common.rating', ['rating' => $orderDetail->service->average_rating])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                @endforelse
                            </div>
                        </div>

                        <div class="order-list-wrap border-bottom order-summary-wrap">
                            <h5 class="order-main-title">Order Summary</h5>
                            <ul class="order-summary-listed">
                                <li class="d-flex">
                                    Price
                                    <strong class="order-price ml-auto">{{currencyFormatter($order->subtotal)}}</strong>
                                </li>
                                <li class="d-flex">
                                    VAT
                                    <strong class="order-price ml-auto">{{currencyFormatter($order->vat)}}</strong>
                                </li>
                                <li class="d-flex">
                                    Service Fee
                                    <strong class="order-price ml-auto">{{currencyFormatter($order->service_fees)}}</strong>
                                </li>

                                @if(!is_null($order->coupon))
                                <li class="d-flex">
                                    Coupon Code
                                    <strong class="order-price ml-auto"> <span class="primary-color coupon">#{{$order->coupon->coupon_code}} ({{$order->coupon->discount}}%)</span>
                                        -{{currencyFormatter($order->coupon_discount)}}</strong>
                                </li>
                                @endif
                            </ul>

                        </div>

                        <div class="d-flex order-total-wrap">
                            <h5 class="d-flex">Grand Total</h5>

                            <strong class="order-price primary-color ml-auto">{{currencyFormatter($order->total)}}</strong>
                        </div>
                        @if($user->isStore())
                        <div class="order-list-wrap order-btn-wrap">
                            <div class="row">
                                <!-- <div class="col-12 mb-2">
                                    <a class="btn-style w-100 btn-accept" href="#">Accept Order</a>
                                  </div> -->
                                <div class="col-12">
                                    @if($order->isConfirmed())
                                    <a class="btn-style w-100 btn-cancel action-confirm" href="{{route('web.dashboard.order.in-progress', ['order' => $order->id])}}" data-message="This order will be marked as in progress and cannot be cancelled">Mark as In-progress</a>
                                        <a class="btn-style w-100 btn-cancel action-confirm" href="{{route('web.dashboard.order.cancel', ['order' => $order->id])}}" data-message="Once cancelled this action cannot be reverted">Cancel Order</a>
                                    @elseif($order->isInprogress())
                                        <a class="btn-style w-100 btn-cancel action-confirm" href="{{route('web.dashboard.order.complete', ['order' => $order->id])}}" data-message="Once completed this action cannot be reverted">Mark as Completed</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('script-end')
    <script>
       $(document).ready(function (){
           $('.action-confirm').on('click', function (event) {
                console.log(1111)
               event.preventDefault();
               const url = $(this).attr('href');
               console.log(url)
               const message = $(this).attr('data-message');
               Swal.fire({
                   title: 'Are you sure?',
                   text: message,
                   icon: 'warning',
                   showCancelButton: true,
                   confirmButtonText: 'Continue',
               }).then(function(value) {
                   if (value.isConfirmed) {
                       window.location.href = url;
                   }
               });
           });
       })
    </script>
@endpush
