@extends('web.layouts.app')

@section('content')
    <section class="login-section login-sec pd-tb100">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="authentication-wrap">
                        <div class="sec-heading mb-2">
                            <h4 class="title"> Change Password? </h4>
                        </div>
                        @include('web.common.alerts')
                        <form class="row" id="change-password-form" action="{{route('web.dashboard.change-password.submit')}}" method="POST">
                            @csrf
                            <div class="col-12 mb-2">
                                <div class="input-style">
                                    <label class="d-block">Current Password <span class="text-danger">*</span></label>
                                    <div class="type-pass">
                                        <input type="password" class="ctm-input" placeholder="Current Password" required id="current-password-field" name="current_password">
                                        <div class="icon-eye d-flex align-items-center justify-content-center toggle-password" data-toggle="#current-password-field" data-toggle-i="#current-password-eye">
                                            <i class="fas fa-eye" id="current-password-eye"></i>
                                        </div>
                                    </div>
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
            $('#change-password-form').parsley();
        });
    </script>
@endpush
