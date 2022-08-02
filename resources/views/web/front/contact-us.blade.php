@extends('web.layouts.app')

@push('style-end')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')

    <section class="login-section contact-us-section pd-tb100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
                    <div class="authentication-wrap contact-content-wrap">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="contact-map" >
                                    <div id="map" ></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="contact-inner-content">
                                    <div class="sec-heading mb-2">
                                        <h4 class="title"> Contact Us </h4>
                                    </div>
                                    @include('web.common.alerts')
                                    <form class="row" method="POST" action="{{route('web.contact.submit')}}" id="contact-form">
                                        {{csrf_field()}}
                                        <div class="col-12 mb-2">
                                            <div class="input-style">
                                                <label class="d-block">What can we help you with? <span class="text-danger">*</span></label>
                                                <div class="type-pass">
                                                    <select name="subject" required class="form-control" id="contact-subject">
                                                        @forelse($subjects as $key => $subject)
                                                            @if(old('subject') == $subject)
                                                                <option value="{{$subject}}" selected>{{$subject}}</option>
                                                            @else
                                                                <option value="{{$subject}}" {{$key == 1 ?? 'selected'}}>{{$subject}}</option>
                                                            @endif

                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-2">
                                            <div class="input-style">
                                                <label class="d-block">Full Name <span class="text-danger">*</span></label>
                                                <div class="type-pass">
                                                    <input type="text" class="ctm-input" name="name" placeholder="John Doe" required value="{{old('name', '')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 col-sm-12 mb-2">
                                            <div class="input-style">
                                                <label class="d-block">Email <span class="text-danger">*</span></label>
                                                <input type="email" class="ctm-input" name="email" placeholder="Email" required value="{{old('email', '')}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                            <div class="input-style">
                                                <label class="d-block">Comment <span class="text-danger">*</span>
                                                </label>
                                                <textarea class="ctm-textarea" name="content" placeholder="Write Here..." required>{{old('content', '')}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-0">
                                            <input type="hidden" value="POST" name="_method">
                                            <button class="btn-style btn-auth" type="submit">Submit</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('script-end')
    <script src="{{asset('assets/web/js/parsley.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNcTmnS323hh7tSQzFdwlnB4EozA3lwcA&libraries=places"></script>
    <script>
        $(document).ready(function() {
            $('#contact-subject').select2({
                minimumResultsForSearch: -1
            });
            $('#contact-form').parsley();
        });

    </script>
    <script>

        var lat = {{config('project_settings.latitude')}};
        var lng = {{config('project_settings.longitude')}};
        $(document).ready(function () {
            initMap();
        });
        function initMap() {
            console.log("contact map initmap should work");

            // The location of Uluru
            var uluru = {lat: lat, lng: lng};
            var map = new google.maps.Map(
                document.getElementById('map'), {
                    zoom: 15, center: uluru, styles: [
                        {
                            "elementType": "geometry",
                            "stylers": [
                                {
                                    "color": "#f5f5f5"
                                }
                            ]
                        },
                        {
                            "elementType": "labels.icon",
                            "stylers": [
                                {
                                    "visibility": "off"
                                }
                            ]
                        },
                        {
                            "elementType": "labels.text.fill",
                            "stylers": [
                                {
                                    "color": "#616161"
                                }
                            ]
                        },
                        {
                            "elementType": "labels.text.stroke",
                            "stylers": [
                                {
                                    "color": "#f5f5f5"
                                }
                            ]
                        },
                        {
                            "featureType": "administrative.land_parcel",
                            "elementType": "labels.text.fill",
                            "stylers": [
                                {
                                    "color": "#bdbdbd"
                                }
                            ]
                        },
                        {
                            "featureType": "poi",
                            "elementType": "geometry",
                            "stylers": [
                                {
                                    "color": "#eeeeee"
                                }
                            ]
                        },
                        {
                            "featureType": "poi",
                            "elementType": "labels.text.fill",
                            "stylers": [
                                {
                                    "color": "#757575"
                                }
                            ]
                        },
                        {
                            "featureType": "poi.park",
                            "elementType": "geometry",
                            "stylers": [
                                {
                                    "color": "#e5e5e5"
                                }
                            ]
                        },
                        {
                            "featureType": "poi.park",
                            "elementType": "labels.text.fill",
                            "stylers": [
                                {
                                    "color": "#9e9e9e"
                                }
                            ]
                        },
                        {
                            "featureType": "road",
                            "elementType": "geometry",
                            "stylers": [
                                {
                                    "color": "#ffffff"
                                }
                            ]
                        },
                        {
                            "featureType": "road.arterial",
                            "elementType": "labels.text.fill",
                            "stylers": [
                                {
                                    "color": "#757575"
                                }
                            ]
                        },
                        {
                            "featureType": "road.highway",
                            "elementType": "geometry",
                            "stylers": [
                                {
                                    "color": "#dadada"
                                }
                            ]
                        },
                        {
                            "featureType": "road.highway",
                            "elementType": "labels.text.fill",
                            "stylers": [
                                {
                                    "color": "#616161"
                                }
                            ]
                        },
                        {
                            "featureType": "road.local",
                            "elementType": "labels.text.fill",
                            "stylers": [
                                {
                                    "color": "#9e9e9e"
                                }
                            ]
                        },
                        {
                            "featureType": "transit.line",
                            "elementType": "geometry",
                            "stylers": [
                                {
                                    "color": "#e5e5e5"
                                }
                            ]
                        },
                        {
                            "featureType": "transit.station",
                            "elementType": "geometry",
                            "stylers": [
                                {
                                    "color": "#eeeeee"
                                }
                            ]
                        },
                        {
                            "featureType": "water",
                            "elementType": "geometry",
                            "stylers": [
                                {
                                    "color": "#c9c9c9"
                                }
                            ]
                        },
                        {
                            "featureType": "water",
                            "elementType": "labels.text.fill",
                            "stylers": [
                                {
                                    "color": "#9e9e9e"
                                }
                            ]
                        }
                    ]
                });

            var image = "{{asset("assets/web/img/target.svg")}}"
            var marker = new google.maps.Marker({map: map, position: uluru, icon: image});
            marker.info = new google.maps.InfoWindow({
                content: '<p>{!! config('project_settings.address') !!}</p> '
            });
            marker.info.open(map, marker);
        }

    </script>


@endpush
