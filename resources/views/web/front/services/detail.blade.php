@extends('web.layouts.app')

@section('content')

    <section class="services-section services-detail-section pd-tb100">
        <div class="container">
            <div class="provider-wrappper service-detail-wrap">
                <div class="row providers-row">
                    <div class="col-lg-5 service-thumb-col">
                        <div class="service-providers-img">
                            <img src="{{imageUrl($service->image, 488, 285, 95,2)}}" alt="service-provider">
                        </div>
                    </div>
                    <div class="col-lg-7 service-content-col">
                        <div class="service-providers-details">
                            <div class="provider-title align-items-center">
                                <h4>
                                    {{$service->title[app()->getLocale()]}}
                                    <span>
                                        {{$service->category->title[app()->getLocale()]}},
                                        {{$service->subcategory->title[app()->getLocale()]}}
                                    </span>
                                </h4>
                            </div>

                            @include('web.common.rating', ['rating' => $service->average_rating, 'noExtraClasses' => true])
                            <h4 class="price-wrap">
                                {{currencyFormatter($service->price, $service->actual_price, $service->has_offer)}}
                            </h4>

                            <div class="service-list-wrap">
                                <h5 class="title">Supplier</h5>
                                <div class="order-list-box d-flex">
                                    <div class="order-detail d-flex justify-content-between w-100">
                                        <div class="order-img d-flex justify-content-center align-items-center mr-2">
                                            <img src="{{imageUrl($service->store->image, 134,70,95,2)}}" alt="" class="img-fluid">
                                        </div>
                                        <div class="order-info-left d-flex align-items-center w-100">
                                            <div class="left-content">
                                                <h5 class="order-sub-title">
                                                    <a href="{{route('web.front.store.detail', ['user' => $service->store->id])}}">
                                                        {{$service->store->store_name[app()->getLocale()]}}
                                                    </a>

                                                </h5>
                                                <ul class="service-listed">
                                                    <li>
                                                        <i class="fas fa-map-marker-alt"></i> {{$service->store->address}}
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="right-content ml-auto">
                                                @include('web.common.rating', ['rating' => $service->store->average_rating])
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="service-form">
                                @if(\Illuminate\Support\Facades\Session::has('client_area'))
                                <a href="{{route('web.dashboard.cart.add-to-cart', ['service' => $service->id, 'area' => \Illuminate\Support\Facades\Session::get('client_area')])}}" class="btn-style btn-cart w-100" >Add to Cart</a>
                                @else
                                    <a href="{{route('web.dashboard.cart.add-to-cart', ['service' => $service->id])}}" class="btn-style btn-cart w-100" id="select-area">Add to Cart</a>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
                <div class="about-content">
                    <h5 class="sub-title">About</h5>
                    <p>{{$service->content[app()->getLocale()]}}
                    </p>
                </div>
            </div>
            <div class="service-tabs-wrap w-100">
                <!--Profile Sub Tab Start-->
                <div class="profile-sub-tab">
                    <div class="tab-content profile-tabs-content">
                        <div class="tab-panel">
                            <div class="rating-box-wrap">
                                <div class="services-ratings d-flex">
                                    <h4 class="title-review">Rating And Reviews</h4>
                                    @if(auth()->check() && $service->serviceReview)
                                    <a  class="rate-link" data-toggle="modal" data-target="#add-review">
                                        Rate Service
                                    </a>
                                    @endif
                                </div>
                                @if(count($reviews) > 0)
                                <ul class="rating-listed">
                                    @foreach($reviews as $review)
                                    @include('web.common.review', ['review' => $review])
                                    @endforeach
                                </ul>
                                @else
                                    <div class="row">
                                        <div class="col-12">
                                            @include('web.common.not-found', ['message' => 'This service have no reviews'])
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="row">
                                {!! $reviews->onEachSide(0)->links() !!}

                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </section>

    @if(auth()->check() && $service->serviceReview)
        @include('web.common.give-rating-modal', [
        'title' => $service->title[app()->getLocale()],
        'reviewId' => $service->serviceReview->id,
        'route' => 'web.dashboard.service-reviews.add'
        ])
    @endif
@endsection

@push('script-end')
<script>
    let storeAreas = JSON.parse('@json($storeAreas)');
    let areas =  new Map();

    storeAreas.forEach(object => {
        areas.set(object.area_id, object.area.title.en);
    });


    console.log(areas);
    $(document).ready(function (){
        $('#select-area').on('click', (event) =>{
            event.preventDefault()
            let addToCartHref = $('#select-area').attr('href');
            console.log(addToCartHref)
            Swal.fire({
                title: 'Please select area.',
                input: 'select',
                inputOptions: areas,
                inputPlaceholder: 'Select an area',
                showCancelButton: true,
                inputValidator: (value) => {
                    return new Promise((resolve) => {
                        if (value) {
                            resolve()
                        } else {
                            resolve('Please select area.')
                        }
                    })
                }
            }).then((response) => {
                if(response.value){
                    // console.log(addToCartHref+'/'+response.value);
                    window.location.href = addToCartHref+'/'+response.value;
                }

            })
        });
    })


</script>
@endpush
