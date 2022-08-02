@extends('web.layouts.app')

@section('content')

    <section class="login-section login-sec pd-tb100">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    @include('web.common.alerts')
                    <div class="authentication-wrap">
                        <div class="sec-heading mb-2">
                            <h4 class="title"> Enter Code </h4>
                            <p>
                                Please enter verification code you received at <a href="mailto:{{$user->email}}">{{$user->email}}</a>
                            </p>
                        </div>
                        <form class="row" id="verify-email-form" action="{{route('web.dashboard.verify-email.submit')}}" method="POST">
                            @csrf
                            <div class="col-12 mb-2">
                                <div class="input-style">
                                    <label class="d-block">Code <span class="text-danger">*</span></label>
                                    <input type="text" class="ctm-input" placeholder="1234" required name="code">
                                </div>
                                <div class="forgot-password text-right">
                                    <a href="{{route('web.dashboard.resend-verification-code')}}">Resend Code?</a>
                                </div>
                            </div>

                            <div class="col-12 mb-0">
                                <button class="btn-style btn-auth" type="submit">Submit</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script-end')
    <script src="{{asset('assets/web/js/parsley.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#verify-email-form').parsley();
        });
    </script>
@endpush
