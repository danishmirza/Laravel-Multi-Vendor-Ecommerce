@extends('web.dashboard.layouts.dashboard')

@push('style-end')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content-dashboard')
    <div class="tab-content profile-tabs-content">
        <div class="tab-pane-wrap">
            @include('web.common.alerts')
            <form class="user-profile profile-edit-wrap" id="edit-store-profile" action="{{route('web.dashboard.update-store-profile.submit')}}" method="POST">
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
                                <label class="d-block">Company Name In English <span class="text-danger">*</span></label>
                                <input type="text" class="ctm-input" placeholder="Company Name In English" name="store_name[en]" required value="{{old('store_name[en]', $user->store_name['en'])}}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                            <div class="input-style">
                                <label class="d-block">Company Name In Arabic</label>
                                <input type="text" class="ctm-input" placeholder="Company Name In Arabic" name="store_name[ar]" value="{{old('store_name[ar]', $user->store_name['ar'])}}">
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
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                            <div class="input-style custom-drop-contact">
                                <label class="d-block">Select City <span class="text-danger">*</span></label>
                                <div class="custom-selct-icons-arow position-relative height-select-2-custom">
                                <img src="{{asset('assets/web/img/down-chevron.svg')}}" class="img-fluid arrow-abs">
                                    <select class="form-control selectpicker" id="city" name="city_id" required data-parsley-errors-container="#checkbox-errors">
                                        <option value="">Select City</option>
                                        @forelse($cities as $city)
                                            <option value="{{$city->id}}" {{(old('city_id', $user->city_id) == $city->id) ? 'selected': ''}}>{{$city->title[app()->getLocale()]}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div id="checkbox-errors"></div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12 mb-2">
                            <div class="input-style">
                                <label class="d-block">Description In English
                                </label>
                                <textarea class="ctm-textarea" placeholder="Description In English" name="detail[en]">{{old('detail[en]', $user->detail['en'])}}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12 mb-2">
                            <div class="input-style">
                                <label class="d-block">Description In Arabic
                                </label>
                                <textarea class="ctm-textarea" placeholder="Description In Arabic" name="detail[ar]">{{old('detail[ar]', $user->detail['ar'])}}</textarea>
                            </div>
                        </div>
                        <div class="col-6 col-md-6 col-sm-12 mb-2 upload-sec_right">
                            @include('web.common.image-uploader', [
                                   'imageLabel' => 'Add Your Trade License',
                                   'isRequired' => true,
                                   'inputName' => 'trade_license',
                                   'uploadedImage' => old('trade_license', $user->trade_license),
                                   'allowDelete' => true,
                                   'submitButtonId' => '#submit-id'
                               ])
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{asset('assets/web/js/parsley.min.js')}}"></script>
    <script src="{{asset('assets/web/js/website.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#city').select2({
                minimumResultsForSearch: -1
            });
            $('#edit-store-profile').parsley({
                errorPlacement: function (error, element) {
                    console.log(element)
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
