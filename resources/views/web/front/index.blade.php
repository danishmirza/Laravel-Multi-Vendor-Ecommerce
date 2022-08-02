@extends('web.layouts.app')

@push('style-end')
    <link rel="stylesheet" href="{{asset('assets/web/css/slick.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/web/css/owl.carousel.css')}}" type="text/css">
@endpush

@section('content')
    @if(count($categories) > 0)
    <!--Banner Section Start-->
    <section class="banner-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5 col-lg-3" id="banner-text-main">
                    <div class="banner-content">
                        <h1 class="banner-title">
                            {{$categories[0]->title[app()->getLocale()]}}
                        </h1>
                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam non iieirmod tempor invidunt ut
                            labore elit dolore magna aliquyam erat.</p>
                        <a href="{{route('web.front.services', ['subcategories' => $categories[0]->subcategories->pluck('id')->toArray()])}}" class="btn-style btn-book btn-effect1">
                            Book Now
                        </a>
                    </div>
                </div>
                <div class="col-md-7 col-lg-9">
                    <!--Banner Slider Start-->
                    <div class="banner-slider">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="banner-slider">
                                    <div id="banner-slider" class="owl-carousel owl-theme slider-nav-wrap slider-navCenter-wrap">
                                        @forelse($categories as $category)
                                        <div class="slider-item" data-category="{{json_encode($category)}}" data-link="{{route('web.front.services', ['subcategories' => $category->subcategories->pluck('id')->toArray()])}}">
                                            <figure class="slider-thumb">
                                                <img src="{{imageUrl($category->image, 468, 613, 95, 2)}}" alt="">
                                                <figcaption class="caption">
                                                    <h2 class="slider-title">{{$category->title[app()->getLocale()]}}</h2>
                                                    <p>{{$category->content[app()->getLocale()]}}</p>
                                                </figcaption>
                                            </figure>
                                        </div>
                                        @empty
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!--Banner Slider End-->
                </div>
            </div>
        </div>

    </section>
    <!--Banner Section End-->
    @endif

    @if(count($featuredServices) > 0)
    <!--Services Latest Start-->
    <section class="services-section services-latest-section pd-tb100">
        <div class="container">
            <!--Heading Layout Start-->
            <div class="heading-outer text-center">
                <h2 class="heading-title">Latest Services</h2>
                <p>Search through the latest services posted by the registered suppliers</p>
            </div>
            <!--Heading Layout End-->

            <!--Service Slider Start-->
            <div id="service-slider" class="owl-carousel owl-theme slider-nav-wrap slider-navCenter-wrap">
                @foreach($featuredServices->chunk(6) as $services)
                <div class="slider-item">
                    <div class="row">
                        @foreach($services as $service)
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                @include('web.common.service', ['service' => $service])
                            </div>
                        @endforeach

                    </div>
                </div>
                @endforeach
            </div>
            <!--Service Slider End-->
        </div>
    </section>
    @endif
    <!--Services Latest End-->

    <!--Map Section Start-->
    <store-locator site-latitude="{{config('project_settings.latitude')}}" site-longitude="{{config('project_settings.longitude')}}"></store-locator>
    <!--Map Section End-->

    @if(count($offeredServices) > 0)
    <!--Services Latest Start-->
    <section class="services-section services-latest-section pd-tb100">
        <div class="container">
            <!--Heading Layout Start-->
            <div class="heading-outer text-center">
                <h2 class="heading-title">Offered Services</h2>
                <p>Services to get your home maintenance done in minutes on discounted rates</p>
            </div>
            <!--Heading Layout End-->

            <!--Service Slider Start-->
            <div id="service-slider_v2" class="owl-carousel owl-theme slider-nav-wrap slider-navCenter-wrap">
                @foreach($offeredServices->chunk(6) as $services)
                <div class="slider-item">
                    <div class="row">
                        @foreach($services as $service)
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            @include('web.common.service', ['service' => $service])
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
            <!--Service Slider End-->

        </div>
    </section>
    <!--Services Latest End-->

    @endif

    <!--Discount Section Start-->
    @if(count($ads) > 0)
        <section class="discount-section">
            <div id="offer-slider" class="owl-carousel">
                @foreach($ads as $ad)
                <div class="offer-slide">
                    <img src="{{imageUrl($ad->image, 1150, 350, 95, 1)}}" alt="">
                    <div class="discount-content-wrap text-center">
                        <h4>{{$ad->sub_title[app()->getLocale()]}}</h4>
                        <h2 class="discount-title">{{$ad->title[app()->getLocale()]}}</h2>
                        <p>{{$ad->content[app()->getLocale()]}}</p>
                        <a href="{{route('web.front.store.detail', ['user' => $ad->store_id])}}" class="btn-style btn-available btn-effect1">
                            Avail Now
                        </a>
                    </div>
                </div>
                    @endforeach
            </div>

        </section>
    @endif
    <!--Discount Section End-->

    @if(count($faqs) > 0)
    <!--Faq Section Start-->
    <section class="faq-section pd-tb100">
        <div class="container">
            <!--Heading Layout Start-->
            <div class="heading-outer text-center">
                <h2 class="heading-title">Frequently Asked Questions</h2>
                <p>Answers to the frequently asked questions about the service or platform</p>
            </div>
            <!--Heading Layout End-->

            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="faq-accordion-content-main">
                        <div id="accordion">
                            @foreach($faqs as $faq)
                            @include('web.common.faq', ['faq' => $faq])
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <figure class="mt-thumb">
                        <img src="{{asset('assets/web/img/faq-thumb.jpg')}}" alt="">
                    </figure>
                </div>
            </div>
        </div>
    </section>
    <!--Faq Section End-->
    @endif
@endsection

@push('script-end')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNcTmnS323hh7tSQzFdwlnB4EozA3lwcA&libraries=places&language=en"></script>
    <script src="{{asset('assets/web/js/slick.min.js')}}"></script>
    <script src="{{asset('assets/web/js/owl.carousel.min.js')}}"></script>
   <script>
       $(document).ready(function($) {
           "use strict";
           /* Owl Slider For Banner
          ================================================*/
           if ($('#banner-slider').length) {
               $('#banner-slider').owlCarousel({
                   loop: true,
                   dots: false,
                   nav: true,
                   navText: '',
                   items: 3,
                   smartSpeed: 1500,
                   padding: 0,
                   margin: 30,
                   autoplay: false,
                   responsiveClass: true,
                   // autoWidth:true,
                   autoplayHoverPause: true,
                   responsive: {
                       0: {
                           items: 1,
                       },
                       768: {
                           items: 1,
                       },
                       850: {
                           items: 2,
                       },
                       1440: {
                           items: 3,
                       },
                       1441: {
                           items: 3,
                       }
                   }
               });

           }

           var bannerSlider = $("#banner-slider");

           function bannerSliderClasses(){
               bannerSlider.each(function(){
                   var totalItem = $(this).find("owl-item.active").length;
                   $(this).find(".owl-item").removeClass("current-item");
                   $(this).find(".owl-item.active").each(function(index){
                       if(index === 0){
                           $(this).addClass("current-item")
                       }
                   })
               });
           }
           bannerSliderClasses();
           bannerSlider.on("translated.owl.carousel", function(event){
               console.log(event.item.index)
               let jsonCat = $(event.target).find(".owl-item").eq(event.item.index).find(".slider-item").attr('data-category');
               let link = $(event.target).find(".owl-item").eq(event.item.index).find(".slider-item").attr('data-link');
              let cat = JSON.parse(jsonCat)
               let html = `<div class="banner-content">
                        <h1 class="banner-title">
                            ${cat.title.en}
                        </h1>
                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam non iieirmod tempor invidunt ut
                            labore elit dolore magna aliquyam erat.</p>
                        <a href="${link}" class="btn-style btn-book btn-effect1">
                            Book Now
                        </a>
                    </div>`
               $('#banner-text-main').html(html)
               bannerSliderClasses()
           });

           bannerSlider.on('changed.owl.carousel initialized.owl.carousel', function (event) {
               bannerSliderClasses();
           });
           bannerSlider.on('changed.owl.carousel',function(property){
               var current = property.item.index;
               var src = $(property.target).find(".owl-item").eq(current).find(".item").attr('category');
               console.log(src);
           });

           /* Owl Slider For Services
           ================================================*/
           if ($('#service-slider').length) {
               $('#service-slider').owlCarousel({
                   loop: true,
                   dots: false,
                   nav: true,
                   navText: '',
                   items: 1,
                   smartSpeed: 1500,
                   padding: 0,
                   margin: 0,
                   autoplay: false,
                   // animateOut: 'slideOutDown',
                   // animateIn: 'flipInX',
                   responsiveClass: true,
               });
           }


           /* Owl Slider For Services
           ================================================*/
           if ($('#service-slider_v2').length) {
               $('#service-slider_v2').owlCarousel({
                   loop: true,
                   dots: false,
                   nav: true,
                   navText: '',
                   items: 1,
                   smartSpeed: 1500,
                   padding: 0,
                   margin: 0,
                   autoplay: false,
                   // animateOut: 'slideOutDown',
                   // animateIn: 'flipInX',
                   responsiveClass: true,
               });
           }

           /* Owl Slider For Map
           ================================================*/
        //    if ($('#map-slider').length) {
        //        $('#map-slider').owlCarousel({
        //            loop: false,
        //            dots: false,
        //            nav: true,
        //            navText: '',
        //            items: 1,
        //            smartSpeed: 1500,
        //            padding: 0,
        //            margin: 0,
        //            autoplay: true,
        //            responsiveClass: true,
        //            animation: true,
        //            mouseDrag: false,
        //            animateOut: 'animate__slideOutUp',
        //            animateIn: 'animate__slideInUp',
        //        });
        //    }




           if ($('#offer-slider').length) {
               $('#offer-slider').owlCarousel({
                   loop: true,
                   dots: false,
                   nav: true,
                   navText: '',
                   items: 1,
                   smartSpeed: 1500,
                   padding: 0,
                   margin: 0,
                   autoplay: true,
                   responsiveClass: true,
                   mouseDrag: true,
                   // animation: true,
                   // animateOut: 'animate__slideOutUp',
                   // animateIn: 'animate__slideInUp',
               });
           }


       });
   </script>
@endpush

