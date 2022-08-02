@extends('web.layouts.app')

@section('content')
    <section class="login-section login-sec pd-tb100">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="authentication-wrap">

                        <div class="authentication-tabs-wrap">
                            <ul class="nav nav-pills mb-3 register-tabs">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('web.auth.login')}}">Login</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active">Registration</a>
                                </li>
                            </ul>
                        </div>


                        <div class="tab-content authentication-tabs-content">
                            <!-- tab2 -->
                            <div class="tab-pane fade show active" >
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <a class="btn-style btn-auth" href="{{route('web.auth.register-user')}}">User</a>
                                    </div>
                                    <div class="col-12">
                                        <a class="btn-style btn-style-tp btn-auth" href="{{route('web.auth.register-store')}}">Service Provider</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
