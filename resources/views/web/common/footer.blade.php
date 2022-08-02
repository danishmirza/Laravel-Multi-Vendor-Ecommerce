<footer class="footer">
    <div class="container">
        <div class="ft-middle-row">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="widget widget-about">
                        <h4 class="widget-title">About</h4>
                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing <br>
                            elitr, sed diam nonumy hjsd eirmod tempor invidunt gghgnnmm. </p>
                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam non</p>

                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6">
                    <div class="widget widget-link">
                        <h4 class="widget-title">Links</h4>
                        <ul class="listed">
                            <li>
                                <a href="{{route('web.front.about-us')}}">About Us</a>
                            </li>
                            <li>
                                <a href="{{route('web.front.page', ['page' => config('project_settings.terms_and_condition')])}}">Term & Condition</a>
                            </li>
                            <li>
                                <a href="{{route('web.front.page', ['page' => config('project_settings.privacy_policy')])}}">Privacy Policy</a>
                            </li>
                            <li>
                                <a href="{{route('web.front.articles')}}">Blog</a>
                            </li>
                            <li>
                                <a href="{{route('web.front.faqs')}}">Faqs</a>
                            </li>
                        </ul>

                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6">
                    <div class="widget widget-services">
                        <h4 class="widget-title">Categories</h4>
                        <ul class="listed">
                            @forelse($headerCategories->take(5) as $category)
                            <li>
                                <a href="{{route('web.front.services', ['subcategories' => $category->subcategories->pluck('id')->toArray()])}}">{{$category->title[app()->getLocale()]}}</a>
                            </li>
                            @empty
                            @endforelse
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6">
                    <div class="widget widget-contact">
                        <h4 class="widget-title">Contact Us</h4>
                        <ul class="listed">
                            <li>
                                <a href="tel:{{config('project_settings.contact_phone')}}">{{config('project_settings.contact_phone')}}</a>
                            </li>
                            <li>
                                <a href="mailto:{{config('project_settings.contact_email')}}">{{config('project_settings.contact_email')}}</a>
                            </li>

                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6">
                    <div class="widget widget-app">
                        <h4 class="widget-title">Download App</h4>
                        <ul class="listed">
                            <li>
                                <a href="{{config('project_settings.ios_app')}}">
                                    <img class="store-img" src="{{asset('assets/web/img/app-store-img.png')}}" alt="">
                                </a>
                            </li>
                            <li>
                                <a href="{{config('project_settings.android_app')}}">
                                    <img class="store-img" src="{{asset('assets/web/img/google-store-img.png')}}" alt="">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="copyright-row">

            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <strong class="ft-logo">
                        <a href="#">
                            <img src="{{asset('assets/web/img/logo-ft.png')}}" alt="">
                        </a>
                    </strong>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="copy-content">
                    <p><a href="#">Click & Shine</a> <i class="far fa-copyright"></i> Copyrighted 2022 - All Rights Reserved</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <ul class="social-links justify-content-end">
                        <li>
                            <a href="{{config('project_settings.facebook_url')}}">
                                <img class="fb-img" src="{{asset('assets/web/img/social-icon-fb.svg')}}" alt="">
                            </a>
                        </li>
                        <li>
                            <a href="{{config('project_settings.twitter_url')}}">
                                <img class="twitter-img" src="{{asset('assets/web/img/social-icon-twitter.svg')}}" alt="">
                            </a>
                        </li>
                        <li>
                            <a href="{{config('project_settings.instagram_url')}}">
                                <img class="insta-img" src="{{asset('assets/web/img/social-icon-insta.svg')}}" alt="">
                            </a>
                        </li>
                        <li>
                            <a href="{{config('project_settings.google_url')}}">
                                <img class="google-img" src="{{asset('assets/web/img/social-icon-google.svg')}}" alt="">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
