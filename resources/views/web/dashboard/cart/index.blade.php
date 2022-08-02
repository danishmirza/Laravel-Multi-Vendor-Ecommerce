@extends('web.layouts.app')

@push('style-end')
    <link href= "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<style>
    .bootstrap-datetimepicker-widget.dropdown-menu{
        display: block;
    }
</style>

@endpush

@section('content')
    @if(count($cartItems) > 0)

        <section class="section cart-section pd-tb100">
            <div class="container">
                <!--Cart Inner Start-->
                <div class="cart-inner-wrap">
                    <div class="user-profile profile-order-detail-wrap">
                        <div class="profile-order-detail-inner">
                            <form class="row"  method="get" action="{{route('web.dashboard.checkout')}}" id="continue-to-checkout">
                                <div class="col-lg-8 col-md-8">
                                    <div class="order-list-wrap">
                                        <!-- <h5 class="order-main-title mb-2">Selected Services</h5> -->
                                        <div class="row">
                                            @php $total = 0 @endphp
                                            @foreach($cartItems as $item)
                                            <div class="col-12">
                                                @include('web.dashboard.common.cart-item', ['showDeleteButton' => true, 'item' => $item])
                                            </div>
                                                @php $total = $total + $item->service->actual_price; @endphp
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="order-list-wrap order-date-wrap" >
                                        <h4 class="order-main-title">Choose Date & Time</h4>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 mb-2">
                                                <div class="input-style">
                                                    <label class="d-block">Select Date <span class="text-danger">*</span></label>
                                                    <div class="type-pass">
                                                        <input type="text" class="ctm-input datepicker" placeholder="Date" id="date" name="cart_date" required
                                                               >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 mb-2">
                                                <div class="input-style">
                                                    <label class="d-block">Select Time <span class="text-danger">*</span></label>
                                                    <div class="type-pass">
                                                        <input type="text" class="ctm-input timepicker" placeholder="Time" id="time" name="cart_time" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="widget widget-cart">
                                        <div class="d-flex order-total-wrap">
                                            <h5 class="total-title d-flex">Grand Total</h5>
                                            <strong class="order-price primary-color ml-auto">{!! currencyFormatter($total) !!}</strong>
                                        </div>
                                        @if($isServiceAreaCorrect)
                                        <div class="order-list-wrap order-btn-wrap">
                                            <div class="row">
                                                <div class="col-12">
                                                    <button type="submit"  class="btn-style btn-checkout w-100" >Continue to checkout</button>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                            <div class="order-list-wrap order-btn-wrap">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <a  id="select-area" class="btn-style btn-checkout w-100" href="{{route('web.front.select-area-get')}}">Change Service Area</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div><!--Cart Inner End-->
            </div>

        </section>

    @else
        @include('web.common.not-found', ['message' => 'Your cart is empty.'])
    @endif
@endsection


@push('script-end')
    <script type="text/javascript" src=
    "https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js">
    </script>
    <script src=
            "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js">
    </script>
    <script src="{{asset('assets/web/js/parsley.min.js')}}"></script>
    <script>
        window.ParsleyValidator
            .addValidator('mindate', function (value, requirement) {
                // is valid date?
                if(!$("[name=discount_expiry_date]").prop("required")){
                    return true;
                };
                var timestamp = Date.parse(value),
                    minTs = Date.parse(requirement);

                let test = isNaN(timestamp) ? false : timestamp > minTs;
                console.log(test)
                return test
            }, 32)
            .addMessage('en', 'mindate', 'This date should be greater than %s');

        $(document).ready(function() {
            $('#continue-to-checkout').parsley();
            $('#date').datetimepicker({
                format: 'DD-MM-YYYY',
                minDate: Date.now(),
                // debug:true
            }).on('changeDate', function(e) {
                $(this).parsley().validate();
            });
            $('#time').datetimepicker({
                format: 'HH:mm',
                // debug:true
            }).on('changeTime', function(e) {
                $(this).parsley().validate();
            });
        });
    </script>
    <script>

        let storeAreas = JSON.parse('@json($storeAreas)');
        let areas =  new Map();

        storeAreas.forEach(object => {
            areas.set(object.area_id, object.area.title.en);
        });




        console.log(areas);
        $(document).ready(function (){
            let isServiceAreaCorrect = '{{($isServiceAreaCorrect) ? 'true' : 'false'}}'
            console.log(isServiceAreaCorrect)
            if(isServiceAreaCorrect == 'false'){
                Swal.fire('Service provider does not provide services in this area.', '', 'error')
                // Swal.error('Service provider does not provide services in this area.')
            }
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
                        window.location.href = addToCartHref+'?header_area='+response.value;
                    }

                })
            });
        })


    </script>
@endpush
