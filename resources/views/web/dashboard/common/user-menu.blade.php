<ul class="nav nav-pills mb-3 profile-tabs">
    <li class="nav-item">
        <a class="nav-link
        {{(Route::currentRouteName() == 'web.dashboard.profile') ? 'active' : ''}}
        {{(Route::currentRouteName() == 'web.dashboard.edit-user-profile') ? 'active' : ''}}"
           href="{{route('web.dashboard.profile')}}">
            Profile
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link
        {{(Route::currentRouteName() == 'web.dashboard.orders.index') ? 'active' : ''}}
        {{(Route::currentRouteName() == 'web.dashboard.orders.detail') ? 'active' : ''}}"
           href="{{route('web.dashboard.orders.index')}}">My Orders</a>
    </li>
    <li class="nav-item">
        <a class="nav-link
         {{(Route::currentRouteName() == 'web.dashboard.chats.index') ? 'active' : ''}}
        {{(Route::currentRouteName() == 'web.dashboard.chats.messages') ? 'active' : ''}}"
           href="{{route('web.dashboard.chats.index')}}">Chat</a>
    </li>
    <li class="nav-item">
        <a class="nav-link
        {{(Route::currentRouteName() == 'web.dashboard.addresses') ? 'active' : ''}}"
           href="{{route('web.dashboard.addresses')}}">
            Manage Addresses
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link
        {{(Route::currentRouteName() == 'web.dashboard.notifications') ? 'active' : ''}}"
           href="{{route('web.dashboard.notifications')}}"
        >Notifications
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link
        {{(Route::currentRouteName() == 'web.dashboard.change-password') ? 'active' : ''}}"
           href="{{route('web.dashboard.change-password')}}">
            Change Password
        </a>
    </li>
    <li class="nav-item btn-logout-item text-center">
        <a class="nav-link btn-logout" href="{{route('web.dashboard.logout')}}">Logout</a>
    </li>
</ul>
