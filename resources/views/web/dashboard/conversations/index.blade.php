@extends('web.dashboard.layouts.dashboard')

@section('content-dashboard')
    @if($conversationCount > 0)
        <div class="tab-content profile-tabs-content" >
            <div class="tab-pane-wrap">
                <div class="chat-wrap-outer">
                    <conversations conversation-id="null" user-id="{{auth()->id()}}" user-type="{{auth()->user()->user_type}}"></conversations>
                </div>
            </div>
        </div>
    @else
        @include('web.common.not-found', ['message' => 'No conversations found'])
    @endif
@endsection
