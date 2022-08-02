
<header class="header">
    <!-- Topbar Start-->
    <div class="topbar-row">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 col-6">
                    <div class="top-nav-left d-flex">
                        <!-- Language Dropdown -->
                        <div class="dropdown mt-dropdown lang-dd">
                            <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                <span>EN</span>
                                <span class="dropdown-icon">
                      <img src="{{asset('assets/web/img/icon-down.svg')}}" alt="">
                    </span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <ul class="dropdown-listed">
                                    <li>
                                        <a class="dropdown-item" href="#">English</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">Arabic</a>
                                    </li>
                                </ul>
                            </div>
                        </div> <!-- Language Dropdown End-->

                        <div class="dropdown mt-dropdown mt-dropdown-price">
                            <button class="btn dropdown-toggle" type="button" id="dropdownprice" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                <span>USD</span>
                                <span class="dropdown-icon">
                      <img src="{{asset('assets/web/img/icon-down.svg')}}" alt="">
                    </span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownprice">
                                <ul class="dropdown-listed">
                                    <li>
                                        <a class="dropdown-item" href="#">USD</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">OMR</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- locaton city select 2 -->

                        <div class="input-style loction-custom-us-head">
                                        <form class="custom-selct-icons-arow position-relative" method="post" action="{{route('web.front.select-area')}}">
                                            @csrf
                                            <div class="loctaion-svg-city">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10.385" height="15" viewBox="0 0 10.385 15">
                                                <path id="Icon_ionic-ios-pin" data-name="Icon ionic-ios-pin" d="M13.067,3.375A5.019,5.019,0,0,0,7.875,8.2c0,3.75,5.192,10.179,5.192,10.179S18.26,11.946,18.26,8.2A5.019,5.019,0,0,0,13.067,3.375Zm0,6.883a1.691,1.691,0,1,1,1.691-1.691A1.691,1.691,0,0,1,13.067,10.258Z" transform="translate(-7.875 -3.375)" fill="#e9962d"/>
                                            </svg>


                                            </div>


                                            <select class=" selectpicker" name="header_area" id="header-categories-select-2" onchange="this.form.submit()">
                                                <option value="" title="Location">Location</option>
                                                @forelse($headerCities as $city)
                                                    <optgroup label="{{$city->title['en']}}"></optgroup>
                                                    @forelse($city->areas as $area)
                                                        <option value="{{$area->id}}" title="{{$city->title[app()->getLocale()].', '.$area->title[app()->getLocale()]}}" {{(session('client_area') == $area->id) ? 'selected': ''}}>{{$area->title['en']}}</option>
                                                    @empty

                                                    @endforelse
                                                @empty
                                                @endforelse

                                            </select>
                                            <!-- <img src="{{asset('assets/web/img/icon-down.svg')}}" alt="" class="img-fluid "> -->


                                        </form>
                                    </div>


                        <!-- end location city select 2 -->
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 col-sm-12">
                    <div class="top-nav-right">
                        <ul class="top-listed-wrap d-flex justify-content-end">
                            <li class="list-item search-wrap">
                                <!-- <button class="btn-search" type="submit" id="btn-search-toggle">
                                  <img src="images/search-icon.svg" alt="">
                                </button> -->
                                <!--Form Start-->
{{--                                @php dd($headerCategories); @endphp--}}
                                <form method="get" class="form-search-outer" action="{{route('web.front.services')}}">
                                    <div class="input-style custom-select-form">
                                        <div class="custom-selct-icons-arow position-relative">
                                            <img src="{{asset('assets/web/img/down-chevron.svg')}}" class="img-fluid arrow-abs">
                                            <select class=" selectpicker" name="subcategories[]" id="header-categories-select">
                                                <option value="">Category</option>
                                                @forelse($headerCategories as $category)
                                                    <optgroup label="{{$category->title['en']}}"></optgroup>
                                                    @forelse($category->subcategories as $subcategory)
                                                        <option value="{{$subcategory->id}}" title="{{$category->title[app()->getLocale()].', '.$subcategory->title[app()->getLocale()]}}">{{$subcategory->title['en']}}</option>
                                                    @empty

                                                    @endforelse
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-search-wrap">
                                        <input type="text" placeholder="Search" name="keyword">
                                        <button class="btn-search btn-submit" type="submit">
                                            <img src="{{asset('assets/web/img/search-icon.svg')}}" alt="">
                                        </button>
                                    </div>
                                </form>
                                <!--Form End-->
                            </li>
                            @if($user)
                                <notification-bell view-all-page-link="{{route('web.dashboard.notifications')}}"></notification-bell>
                                @if($user->isUser())
                                    <cart-bell cart-page-link="{{route('web.dashboard.cart')}}"></cart-bell>
                                @endif
                            @endif
                            <!-- <li class="list-item login-wrap">
                              <a href="login.html" class="btn-style btn-login btn-effect1">
                                <img class="icon" src="images/user-icon.svg" alt="">
                                <span>SignUp/Login</span>
                              </a>
                            </li> -->
                            <li class="list-item login-wrap mt-dropdown">
                                @if(!$user)
                                    <a href="{{route('web.auth.login')}}" class="btn-style btn-login btn-effect1">
                                        <img class="icon" src="{{asset('assets/web/img/user-icon.svg')}}" alt="">
                                        <span>SignUp/Login</span>
                                    </a>
                                @elseif($user->isUser())
                                <a href="{{route('web.dashboard.profile')}}" class="btn-style btn-login btn-effect1" id="dropdownLogin" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">
                                    <img class="icon" src="{{asset('assets/web/img/user-icon.svg')}}" alt="">
                                    <span>{{$user->name}}</span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownLogin">
                                    <ul class="dropdown-listed">
                                        <li>
                                            <a class="dropdown-item" href="{{route('web.dashboard.profile')}}">Profile</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{route('web.dashboard.orders.index')}}">My Orders</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{route('web.dashboard.addresses')}}">Manage Addresses</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{route('web.dashboard.notifications')}}">Notifications</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{route('web.dashboard.change-password')}}">Change Password</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{route('web.dashboard.logout')}}">Logout</a>
                                        </li>
                                    </ul>
                                </div>
                                @elseif($user->isStore())
                                    <a href="{{route('web.dashboard.profile')}}" class="btn-style btn-login btn-effect1" id="dropdownLogin" data-toggle="dropdown"
                                       aria-haspopup="true" aria-expanded="false">
                                        <img class="icon" src="{{asset('assets/web/img/user-icon.svg')}}" alt="">
                                        <span>{{$user->store_name[app()->getLocale()]}}</span>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownLogin">
                                        <ul class="dropdown-listed">
                                            <li>
                                                <a class="dropdown-item" href="{{route('web.dashboard.profile')}}">Profile</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{route('web.dashboard.orders.index')}}">My Orders</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"  href="{{route('web.dashboard.store-areas.index')}}">Manage Service Areas</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{route('web.dashboard.store-services.index')}}">Manage Services</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{route('web.dashboard.store-ads.index', ['status' => 'pending'])}}">Manage Ads</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{route('web.dashboard.portfolios.index')}}">Manage Portfolio Images</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{route('web.dashboard.subscription')}}">Subscription Packages</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{route('web.dashboard.feature-packages.index')}}">Feature Packages</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{route('web.dashboard.notifications')}}">Notifications</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{route('web.dashboard.change-password')}}">Change Password</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{route('web.dashboard.logout')}}">Logout</a>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- Topbar End-->

    <!--Navigation Row Start-->
    <div class="navigation-row">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-9 col-sm-9 col-xs-9 col-9">
                    <strong class="logo">
                        <a href="{{route('web.front.index')}}">
                            <img src="{{asset('assets/web/img/logo.png')}}" alt="">
                        </a>
                    </strong>
                </div>
                <div class="col-lg-9 col-md-3 col-sm-3 col-xs-3 col-3">
                    <div class="navigation-wrap">
                        <nav class="navbar navbar-expand-lg mt-navbar-outer">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                                <ul class="navbar-nav">
                                    <li class="nav-item {{(Route::currentRouteName() == 'web.front.index') ? 'active' : ''}}">
                                        <a class="nav-link" href="{{route('web.front.index')}}">
                                            Home
                                            <span class="sr-only"></span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{(Route::currentRouteName() == 'web.front.categories') ? 'active' : ''}}">
                                        <a class="nav-link " href="{{route('web.front.categories')}}">
                                            Categories
                                        </a>
                                    </li>
                                    <li class="nav-item {{(Route::currentRouteName() == 'web.front.services') ? 'active' : ''}}">
                                        <a class="nav-link" href="{{route('web.front.services')}}">Services</a>
                                    </li>
                                    <li class="nav-item {{(Route::currentRouteName() == 'web.front.stores') ? 'active' : ''}}">
                                        <a class="nav-link" href="{{route('web.front.stores')}}">Service Providers</a>
                                    </li>
                                    <li class="nav-item {{(Route::currentRouteName() == 'web.front.offered-services') ? 'active' : ''}}">
                                        <a class="nav-link" href="{{route('web.front.offered-services')}}">Offer</a>
                                    </li>
                                    <li class="nav-item {{(Route::currentRouteName() == 'web.front.contact-us') ? 'active' : ''}}">
                                        <a class="nav-link" href="{{route('web.front.contact-us')}}">Contact Us</a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMore"
                                           data-toggle="dropdown"
                                           aria-haspopup="true" aria-expanded="false">
                                            More
                                            <span class="nav-icon">
                                                <img src="{{asset('assets/web/img/icon-down.svg')}}" alt="">
                                              </span>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMore">
                                            <ul class="dropdown-listed">
                                                <li class="{{(Route::currentRouteName() == 'web.front.about-us') ? 'active' : ''}}">
                                                    <a class="dropdown-item" href="{{route('web.front.about-us')}}">About
                                                        Us</a>
                                                </li>
                                                <li class="{{(Route::currentRouteName() == 'web.front.articles') ? 'active' : ''}}">
                                                    <a class="dropdown-item" href="{{route('web.front.articles')}}">Blogs</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Navigation Row End-->

    <!--Mobile Menu Start-->
    <div onclick="openNav()" class="menu-icon d-none"><i class="fas fa-bars"></i></div>
    <div id="mySidenav" class="mobile-menu d-none">
        <div onclick="closeNav()" class="cross-icon"><i class="fas fa-times"></i></div>
        <ul class="nav-ul align-items-center">
            <li class="nav-item {{(Route::currentRouteName() == 'web.front.index') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('web.front.index')}}">Home <span class="sr-only"></span></a>
            </li>
            <li class="nav-item {{(Route::currentRouteName() == 'web.front.categories') ? 'active' : ''}}">
                <a class="nav-link " href="{{route('web.front.categories')}}">
                    Categories
                </a>
            </li>
            <li class="nav-item {{(Route::currentRouteName() == 'web.front.services') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('web.front.services')}}">Services</a>
            </li>
            <li class="nav-item {{(Route::currentRouteName() == 'web.front.stores') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('web.front.stores')}}">Service Providers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Offer</a>
            </li>
            <li class="nav-item {{(Route::currentRouteName() == 'web.front.contact-us') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('web.front.contact-us')}}">Contact Us</a>
            </li>
            <li class="nav-item {{(Route::currentRouteName() == 'web.front.about-us') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('web.front.about-us')}}">About
                    Us</a>
            </li>
            <li class="nav-item {{(Route::currentRouteName() == 'web.front.articles') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('web.front.articles')}}">Blogs</a>
            </li>
        </ul>
    </div><!--Mobile Menu End-->

</header>


