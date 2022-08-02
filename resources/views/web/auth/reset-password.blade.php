@extends('web.layouts.app')

@section('content')
    <section class="login-section login-sec pd-tb100">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    @include('web.common.alerts')
                    <div class="authentication-wrap">
                        <div class="sec-heading mb-2">
                            <h4 class="title"> Reset Password? </h4>
                            <p>
                                Please enter code sent at <a href="mailto:example@mail.com">example@mail.com</a> and choose a password
                            </p>
                        </div>
                        <form class="row" id="reset-password-form" action="{{route('web.auth.reset-password.submit')}}" method="POST">
                            @csrf
                            <div class="col-12 mb-2">
                                <div class="input-style">
                                    <label class="d-block">Code <span class="text-danger">*</span></label>
                                    <input type="text" class="ctm-input" placeholder="1234" name="code" value="{{old('code', $code)}}" required>
                                </div>
                                <div class="forgot-password text-right">
                                    <a href="{{route('web.auth.resend-forgot-password.submit', ['email' => $email])}}">Resend Code?</a>
                                </div>

                            </div>

                            <div class="col-12 mb-2">
                                <div class="input-style">
                                    <label class="d-block">Password <span class="text-danger">*</span></label>
                                    <div class="type-pass">
                                        <input type="password" class="ctm-input" placeholder="Password" required id="password-field" minlength="6" maxlength="32" name="password">
                                        <div class="icon-eye d-flex align-items-center justify-content-center toggle-password" data-toggle="#password-field" data-toggle-i="#password-eye">
                                            <i class="fas fa-eye" id="password-eye"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="input-style">
                                    <label class="d-block">Confirm Password <span class="text-danger">*</span></label>
                                    <div class="type-pass">
                                        <input type="password" class="ctm-input" placeholder="Confirm Password" id="confirm-password-field" required minlength="6" maxlength="32" name="password_confirmation">
                                        <div class="icon-eye d-flex align-items-center justify-content-center toggle-password" data-toggle="#confirm-password-field" data-toggle-i="#confirm-password-eye">
                                            <i class="fas fa-eye" id="confirm-password-eye"></i>
                                        </div>
                                    </div>
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
    <script src="{{asset('assets/web/js/website.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#reset-password-form').parsley();
        });
    </script>
@endpush
