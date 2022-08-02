@extends('web.layouts.app')

@section('content')
    <section class="login-section login-sec pd-tb100">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="authentication-wrap">

                        <div class="authentication-tabs-wrap">
                            <ul class="nav nav-pills mb-3 register-tabs">
                                <li class="nav-item" >
                                    <a class="nav-link active">Login</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('web.auth.register')}}">Registration</a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content authentication-tabs-content">
                            <div class="tab-pane fade show active" >
                                @include('web.common.alerts')
                                <form class="row" id="login-form" action="{{route('web.auth.login.submit')}}" method="POST">
                                    @csrf
                                    <div class="col-12 mb-2">
                                        <div class="input-style">
                                            <label class="d-block">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="ctm-input" placeholder="Email" required name="email" value="{{old('email')}}"/>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-style">
                                            <label class="d-block">Password <span class="text-danger">*</span></label>
                                            <div class="type-pass">
                                                <input type="password" class="ctm-input" placeholder="Password" name="password" required id="password-field"/>
                                                <div class="icon-eye d-flex align-items-center justify-content-center toggle-password" data-toggle="#password-field" data-toggle-i="#password-eye">
                                                    <!-- <i class="far fa-eye"></i> -->
                                                    <i class="fas fa-eye" id="password-eye"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <div class="forgot-password text-right">
                                            <a href="{{route('web.auth.forgot-password')}}">forgot your password?</a>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <button class="btn-style btn-auth" type="submit">Login</button>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="remember-me">
                                            <label class="custom-check">Remember Me
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>

                                </form>
                            </div>


                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('script-end1')
    <script src="{{asset('assets/web/js/parsley.min.js')}}"></script>
    <script src="{{asset('assets/web/js/website.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#login-form').parsley();
        });
    </script>
@endpush
