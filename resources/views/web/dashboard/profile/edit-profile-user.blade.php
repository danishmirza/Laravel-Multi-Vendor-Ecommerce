@extends('web.dashboard.layouts.dashboard')

@section('content-dashboard')
    <div class="tab-content profile-tabs-content">
        <div class="tab-pane-wrap">
            @include('web.common.alerts')
            <form class="user-profile profile-edit-wrap" id="edit-user-profile" action="{{route('web.dashboard.update-user-profile.submit')}}" method="POST">
                @csrf
                <div class="d-flex flex-row flex-md-row">
                    <div class="row">
                        <div class="col-lg-12">
                            @include('web.common.image-uploader', [
                                    'imageLabel' => 'Add Your Display Picture',
                                    'isRequired' => false,
                                    'inputName' => 'image',
                                    'uploadedImage' => old('image', $user->image),
                                    'allowDelete' => true,
                                    'recommendSize' => '250 x 250',
                                    'imageAsBackground' => true,
                                    'submitButtonId' => '#submit-id'
                                ])
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                            <div class="input-style">
                                <label class="d-block">Name <span class="text-danger">*</span></label>
                                <input type="text" class="ctm-input" placeholder="Name" name="name" required value="{{old('name', $user->name)}}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                            <div class="input-style">
                                <label class="d-block">Email <span class="text-danger">*</span></label>
                                <input type="email" class="ctm-input" placeholder="Email" required readonly name="email" value="{{old('email', $user->email)}}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                            <div class="input-style">
                                <label class="d-block">Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" class="ctm-input" placeholder="Phone Number" required name="phone" value="{{old('phone', $user->phone)}}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                            <div class="input-style">
                                <label class="d-block">Address <span class="text-danger">*</span>
                                </label>
                                <div class="type-pass">
                                    <input type="text" class="ctm-input" placeholder="Address" name="address" value="{{old('address', $user->address)}}"
                                           id="address"
                                           readonly required
                                           data-target="#register-map-model"
                                           data-toggle="modal"
                                           data-latitude="#latitude"
                                           data-longitude="#longitude"
                                           data-address="#address"
                                    >
                                    <div
                                        class="icon-eye d-flex align-items-center justify-content-center primary-colorBg btn-marker"
                                        data-target="#register-map-model"
                                        data-toggle="modal"
                                        data-latitude="#latitude"
                                        data-longitude="#longitude"
                                        data-address="#address"
                                    >
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <input type="hidden" name="latitude" id="latitude" class="latitude" value="{{old('latitude', $user->latitude)}}">
                                    <input type="hidden" name="longitude" id="longitude" class="longitude" value="{{old('longitude', $user->longitude)}}">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="d-flex">
                    <button type="submit" class="btn-style profile-btn btn-update"> Update <i class="fa fa-spinner fa-spin d-none" id="submit-id"></i></button>
                </div>
            </form>
        </div>

    </div>
    @include('web.common.location-picker')
@endsection

@push('script-end')
    <script src="{{asset('assets/web/js/parsley.min.js')}}"></script>
    <script src="{{asset('assets/web/js/website.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#edit-user').parsley();
        });
    </script>
@endpush
