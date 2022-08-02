@extends('web.layouts.app')

@section('content')
    <section class="login-section login-sec pd-tb100">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    @include('web.common.alerts')
                    <form class="authentication-wrap" id="forgot-password-form" action="{{route('web.auth.forgot-password.submit')}}" method="POST">
                        @csrf
                        <div class="sec-heading mb-2">
                            <h4 class="title"> Forgot Password? </h4>
                            <p>Enter your email address to recover password</p>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="input-style">
                                    <label class="d-block">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="ctm-input" placeholder="Email" required name="email">
                                </div>
                            </div>
                            <div class="col-12 mb-0">
                                <button class="btn-style btn-auth" type="submit">Submit</button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>

@endsection

@push('script-end')
    <script src="{{asset('assets/web/js/parsley.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#forgot-password-form').parsley();
        });
    </script>
@endpush
