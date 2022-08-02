@extends('web.dashboard.layouts.dashboard')

@push('style-end')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content-dashboard')
    @include('web.common.alerts')
    <div class="tab-content profile-tabs-content">
        <div class="tab-pane-wrap">
            <form method="POST"
                  action="{{$route}}"
                  id="save-delivery-area"
                  class="user-profile profile-address-outer profile-manage-address-outer mt-3 profile-form">
                @csrf
                {{--                <input type="hidden" name="_method" value="PUT">--}}
                <div class="sec-heading mb-2">
                    <h4 class="title">{{$heading}}</h4>
                </div>
                <div class="row">
                    <div class="col-12 col-md-12 col-sm-12 mb-2 upload-sec_right">
                        @include('web.common.image-uploader', [
                               'imageLabel' => 'Upload Ad Image',
                               'isRequired' => true,
                               'inputName' => 'image',
                               'uploadedImage' => old('image', $ad->image),
                               'allowDelete' => true,
                               'submitButtonId' => '#submit-id'
                           ])
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <div class="input-style">
                            <label class="d-block">Ad Title In English <span class="text-danger">*</span></label>
                            <input type="text" class="ctm-input" placeholder="Ad Title In English"
                                   name="title[en]"
                                   required
                                   value="{{old('title.en', $ad->title['en'])}}"
                            >
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <div class="input-style">
                            <label class="d-block">Ad Title In Arabic <span class="text-danger">*</span></label>
                            <input type="text" class="ctm-input" placeholder="Ad Title In Arabic"
                                   name="title[ar]"
                                   required
                                   value="{{old('title.ar', $ad->title['ar'])}}"
                            >
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <div class="input-style">
                            <label class="d-block">Ad Sub Title In English <span class="text-danger">*</span></label>
                            <input type="text" class="ctm-input" placeholder="Ad Sub Title In English"
                                   name="sub_title[en]"
                                   required
                                   value="{{old('sub_title.en', $ad->sub_title['en'])}}"
                            >
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <div class="input-style">
                            <label class="d-block">Ad Sub Title In Arabic <span class="text-danger">*</span></label>
                            <input type="text" class="ctm-input" placeholder="Ad Sub Title In Arabic"
                                   name="sub_title[ar]"
                                   required
                                   value="{{old('sub_title.ar', $ad->sub_title['ar'])}}"
                            >
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12 mb-2">
                        <div class="input-style">
                            <label class="d-block">Description In English
                            </label>
                            <textarea class="ctm-textarea" placeholder="Description In English" name="content[en]" required>{{old('content.en', $ad->content['en'])}}</textarea>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12 mb-2">
                        <div class="input-style">
                            <label class="d-block">Description In Arabic
                            </label>
                            <textarea class="ctm-textarea" placeholder="Description In Arabic" name="content[ar]" required>{{old('content.ar', $ad->content['ar'])}}</textarea>
                        </div>
                    </div>
                    <div class="col-12">
{{--                        <input type="hidden" name="id" value="{{$storeAreaId}}">--}}
                        <button class="btn-style btn-auth w-100" type="submit">{{$heading}} <i class="fa fa-spinner fa-spin d-none" id="submit-id"></i></button>
                    </div>
                </div>
            </form>
            <!--Profile Address Outer End-->
        </div>
    </div>
@endsection

@push('script-end')
    <script src="{{asset('assets/web/js/parsley.min.js')}}"></script>
    <script src="{{asset('assets/web/js/website.js')}}"></script>
    <script>
        $(document).ready(function() {

            $('#save-delivery-area').parsley();
        });
    </script>
@endpush
