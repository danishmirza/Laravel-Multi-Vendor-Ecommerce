@extends('web.dashboard.layouts.dashboard')

@section('content-dashboard')
    <div class="tab-content profile-tabs-content" >
        <div class="tab-pane-wrap">
            <div class="chat-wrap-outer">

                <conversations conversation-id="{{$conversationId}}" user-id="{{auth()->id()}}" user-type="{{auth()->user()->user_type}}"></conversations>
                <messages conversation-id="{{$conversationId}}" user-id="{{auth()->id()}}" user-type="{{auth()->user()->user_type}}"></messages>
            </div>
        </div>
    </div>

@endsection
