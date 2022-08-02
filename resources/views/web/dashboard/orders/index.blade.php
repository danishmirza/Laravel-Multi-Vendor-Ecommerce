@extends('web.dashboard.layouts.dashboard')

@section('content-dashboard')
    <div class="tab-content profile-tabs-content">
        <div class="tab-pane-wrap">
            <div class="profile-order-wrap-main">
                <div class="order-dropdown-row">
                    <div class="dropdown mt-dropdown mt-dropdown-custom ml-auto mb-2">
                        <button class="btn dropdown-toggle d-flex" type="button" id="order-dropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span>{{ucfirst(request('order_status', 'all'))}}</span>
                            <span class="dropdown-icon ml-auto">
                            <i class="fas fa-angle-down"></i>
                          </span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="order-dropdown">
                            <ul class="dropdown-listed">
                                <li>
                                    <a class="dropdown-item" href="{{route('web.dashboard.orders.index', ['order_status' => 'all'])}}">All</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{route('web.dashboard.orders.index', ['order_status' => 'confirmed'])}}">Confirmed</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{route('web.dashboard.orders.index', ['order_status' => 'in-progress'])}}">In-Progress</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{route('web.dashboard.orders.index', ['order_status' => 'completed'])}}">Completed</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{route('web.dashboard.orders.index', ['order_status' => 'cancelled'])}}">Cancelled</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!--Order Progress Start-->
                <div class="user-profile profile-order-wrap">
                    <div class="my-ordemt-a">
                        <div class="row">
                            @forelse($orders as $order)
                          <a href="{{route('web.dashboard.orders.detail', ['order' => $order->id])}}">
                          <div class="col-12">
                                <div class="order-list-box d-flex">
                                    <div class="order-top d-flex">
                                        <h5 class="tittle-order">Order # {{$order->order_number}}</h5>
                                        <h5 class="total-amount-list ml-auto"><span>{{currencyFormatter($order->total)}}</span></h5>
                                    </div>
                                    <div class="order-detail d-flex justify-content-between w-100">
                                        <div class="order-img d-flex justify-content-center align-items-center mr-2">
                                            <img src="{{imageUrl($order->image, 300,200,95,2)}}" alt="" class="img-fluid">
                                        </div>
                                        <div class="order-info-left w-100">
                                            <ul class="order-combination">
                                                <li class="list">Scheduled Time:&nbsp;<span class="order-date primary-color">
                                                        {{Carbon\Carbon::parse($order->visit_time)->format('d-m-Y H:i')}}
                                                    </span></li>
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
                            </div>

                          </a>
                            @empty
                                @include('web.common.not-found', ['message'=> 'No orders found.'])
                            @endforelse
                        </div>
                    </div>
                </div>
                <!--Order Progress End-->

            </div>
        </div>
    </div>
@endsection