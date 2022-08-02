@extends('web.layouts.app')

@section('content')
    <notification-page is-notification-enabled="{{$user->is_notification_enabled == 1}}"></notification-page>
@endsection
