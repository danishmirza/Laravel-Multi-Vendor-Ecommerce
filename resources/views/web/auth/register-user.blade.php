@extends('web.layouts.app')

@section('content')
    <section class="login-section login-sec pd-tb100">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    @include('web.common.alerts')
                    <div class="authentication-wrap">
                        <div class="sec-heading mb-2">
                            <h4 class="title"> Sign Up As User</h4>
                        </div>
                        <form class="row" id="register-user-form" method="POST" action="{{route('web.auth.user-register.submit')}}">
                            @csrf
                            <div class="col-6 col-md-6 col-sm-12 mb-2">
                                <div class="input-style">
                                    <label class="d-block">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="ctm-input" placeholder="Name" name="name" required value="{{old('name')}}">
                                </div>
                            </div>
                            <div class="col-6 col-md-6 col-sm-12 mb-2">
                                <div class="input-style">
                                    <label class="d-block">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="ctm-input" placeholder="Email" name="email" required value="{{old('email')}}">
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 mb-2">
                                <div class="input-style">
                                    <label class="d-block">Phone Number <span class="text-danger">*</span></label>
                                    <input type="tel" class="ctm-input" placeholder="Phone Number" name="phone" required value="{{old('phone')}}">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-6 col-sm-6 mb-2">
                                <div class="input-style">
                                    <label class="d-block">Address <span class="text-danger">*</span>
                                    </label>
                                    <div class="type-pass">
                                        <input type="text" class="ctm-input" placeholder="Address" name="address"
                                               value="{{old('address')}}"
                                               id="address"
                                               readonly required
                                               data-target="#register-map-model"
                                               data-toggle="modal"
                                               data-latitude="#latitude"
                                               data-longitude="#longitude"
                                               data-address="#address"
                                        />
                                        <div class="icon-eye d-flex align-items-center justify-content-center primary-colorBg"
                                             data-target="#register-map-model"
                                             data-toggle="modal"
                                             data-latitude="#latitude"
                                             data-longitude="#longitude"
                                             data-address="#address"
                                        >
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="latitude" id="latitude" class="latitude"
                                   value="{{old('latitude')}}">
                            <input type="hidden" name="longitude" id="longitude" class="longitude"
                                   value="{{old('longitude')}}">
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
                                    <label class="d-block">Confirm Password <span class="text-danger">*</span> </label>
                                    <div class="type-pass">
                                        <input type="password" class="ctm-input" placeholder="Confirm Password" id="confirm-password-field" required minlength="6" maxlength="32" name="password_confirmation">
                                        <div class="icon-eye d-flex align-items-center justify-content-center toggle-password" data-toggle="#confirm-password-field" data-toggle-i="#confirm-password-eye">
                                            <i class="fas fa-eye" id="confirm-password-eye"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mb-2">
                                @include('web.common.image-uploader', [
                                    'imageLabel' => 'Add Your Display Picture',
                                    'isRequired' => false,
                                    'inputName' => 'image',
                                    'uploadedImage' => old('image', null),
                                    'allowDelete' => true,
                                    'recommendSize' => '250 x 250',
                                     'submitButtonId' => '#submit-id'
                                ])
                            </div>

                            <div class="col-md-12 mb-2">
                                <div class="remember-me">
                                    <label class="custom-check">By Signing up, I agree to
                                        <a href="{{route('web.front.page', ['page' => config('project_settings.privacy_policy')])}}" class="primary-color">Term & Conditions</a> and
                                        <a href="{{route('web.front.page', ['page' => config('project_settings.terms_and_condition')])}}" class="primary-color">Privacy Policy</a>.
                                        <input type="checkbox" name="terms_conditions" value="1" checked="checked" required>
                                        <span class="checkmark"></span>
                                    </label>
{{--                                    <div id="checkbox-errors"></div>--}}
                                </div>
                            </div>

                            <div class="col-12">
                                <button class="btn-style btn-auth" type="submit">Register <i class="fa fa-spinner fa-spin d-none" id="submit-id"></i></button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

    @include('web.common.location-picker')
@endsection

@push('script-end')
    <script src="{{asset('assets/web/js/parsley.min.js')}}"></script>
    <script src="{{asset('assets/web/js/website.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#register-user-form').parsley({
                errorPlacement: function (error, element) {
                    if (element.attr("name") == "terms_conditions") {
                        error.insertAfter(element.parent().siblings());

                    } else {
                        error.insertAfter(element);
                    }
                },
            });
        });
    </script>
@endpush
