@extends('web.dashboard.layouts.dashboard')

@section('content-dashboard')
    <dashboard-addresses cities="{{json_encode($cities)}}"></dashboard-addresses>
@endsection


@push('script-end')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNcTmnS323hh7tSQzFdwlnB4EozA3lwcA&libraries=places&language=en"></script>
@endpush
