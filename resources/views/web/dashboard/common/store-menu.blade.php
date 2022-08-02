<ul class="nav nav-pills mb-3 profile-tabs">
    <li class="nav-item">
        <a class="nav-link
            {{(Route::currentRouteName() == 'web.dashboard.profile') ? 'active' : ''}}
            {{(Route::currentRouteName() == 'web.dashboard.edit-store-profile') ? 'active' : ''}}"
            href="{{route('web.dashboard.profile')}}">
            Profile
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link
            {{(Route::currentRouteName() == 'web.dashboard.store-areas.index') ? 'active' : ''}}
            {{(Route::currentRouteName() == 'web.dashboard.store-areas.create') ? 'active' : ''}}
            {{(Route::currentRouteName() == 'web.dashboard.store-areas.edit') ? 'active' : ''}}"
            href="{{route('web.dashboard.store-areas.index')}}">
            Manage Service Areas
        </a>
    </li>
{{--    @php dd(Route::currentRouteName()) @endphp--}}
    <li class="nav-item">
        <a class="nav-link
        {{(Route::currentRouteName() == 'web.dashboard.store-services.index') ? 'active' : ''}}
        {{(Route::currentRouteName() == 'web.dashboard.store-services.create') ? 'active' : ''}}
        {{(Route::currentRouteName() == 'web.dashboard.store-services.edit') ? 'active' : ''}}"
        href="{{route('web.dashboard.store-services.index')}}"
        >Manage Services</a>
    </li>
    <li class="nav-item">
        <a class="nav-link
         {{(Route::currentRouteName() == 'web.dashboard.store-ads.index') ? 'active' : ''}}
        {{(Route::currentRouteName() == 'web.dashboard.store-ads.create') ? 'active' : ''}}
        {{(Route::currentRouteName() == 'web.dashboard.store-ads.edit') ? 'active' : ''}}"
           href="{{route('web.dashboard.store-ads.index', ['status' => 'pending'])}}"
        >Manage Ads</a>
    </li>
    <li class="nav-item">
        <a class="nav-link
        {{(Route::currentRouteName() == 'web.dashboard.portfolios.index') ? 'active' : ''}}
        {{(Route::currentRouteName() == 'web.dashboard.portfolios.create') ? 'active' : ''}}"
        href="{{route('web.dashboard.portfolios.index')}}"
        >Manage Portfolio Images</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('web.dashboard.subscription')}}">Subscription Packages</a>
    </li>
    <li class="nav-item">
        <a class="nav-link
        {{(Route::currentRouteName() == 'web.dashboard.feature-packages.index') ? 'active' : ''}}
        {{(Route::currentRouteName() == 'web.dashboard.feature-packages.purchased') ? 'active' : ''}}"
           href="{{route('web.dashboard.feature-packages.index')}}"
        >Feature Packages</a>
    </li>
    <li class="nav-item">
        <a class="nav-link
        {{(Route::currentRouteName() == 'web.dashboard.orders.index') ? 'active' : ''}}
        {{(Route::currentRouteName() == 'web.dashboard.orders.detail') ? 'active' : ''}}"
           href="{{route('web.dashboard.orders.index')}}">Manage Orders</a>
    </li>
    <li class="nav-item">
        <a class="nav-link
        {{(Route::currentRouteName() == 'web.dashboard.notifications') ? 'active' : ''}}"
        href="{{route('web.dashboard.notifications')}}"
        >Notifications</a>
    </li>
    <li class="nav-item">
        <a class="nav-link
         {{(Route::currentRouteName() == 'web.dashboard.chats.index') ? 'active' : ''}}
        {{(Route::currentRouteName() == 'web.dashboard.chats.messages') ? 'active' : ''}}"
           href="{{route('web.dashboard.chats.index')}}">Chat</a>
    </li>
{{--    <li class="nav-item">--}}
{{--        <a class="nav-link">Payment Profile</a>--}}
{{--    </li>--}}
    <li class="nav-item">
        <a class="nav-link {{(Route::currentRouteName() == 'web.dashboard.change-password') ? 'active' : ''}}" href="{{route('web.dashboard.change-password')}}">Change Password</a>
    </li>
    <li class="nav-item btn-logout-item text-center">
        <a class="nav-link btn-logout" href="{{route('web.dashboard.logout')}}">Logout</a>
    </li>
</ul>
