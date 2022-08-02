@extends('web.dashboard.layouts.dashboard')

@push('style-end')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content-dashboard')
    @include('web.common.alerts')
    @if($service->featured())
        <div class="alert alert-info" role="alert">
            Feature Package is applied on this service and will expire on {{$service->package_expire_on->format('Y-m-d')}}.
        </div>
    @endif
    <div class="tab-content profile-tabs-content">
        <form method="POST"
              action="{{$route}}"
              class="user-profile add-service-wrap profile-form"
              id="save-service">
            @csrf
            <h4 class="title mb-2">{{$heading}}</h4>
            <div class="d-flex flex-row flex-md-row">
                <div class="row">
                    <div class="col-12 col-md-12 col-sm-12 mb-2 upload-sec_right">
                        @include('web.common.image-uploader', [
                           'imageLabel' => 'Upload Service Image',
                           'isRequired' => false,
                           'inputName' => 'image',
                           'uploadedImage' => old('image', $service->image),
                           'allowDelete' => true,
                           'recommendSize' => '250 x 250',
                           'submitButtonId' => '#submit-id'
                       ])
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <div class="input-style">
                            <label class="d-block">Service Name <span class="text-danger">*</span></label>
                            <input type="text" class="ctm-input" placeholder="Service Name" name="title[en]" required value="{{old('title.en', $service->title['en'])}}">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <div class="input-style">
                            <label class="d-block">Service Name Arabic </label>
                            <input type="text" class="ctm-input" placeholder="Service Name Arabic" name="title[ar]" required value="{{old('title.ar', $service->title['ar'])}}">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <div class="input-style">
                            <label class="d-block">Price <span class="text-danger">*</span></label>
                            <input type="text" class="ctm-input" placeholder="Price" name="price" required value="{{old('price', $service->price)}}">
                        </div>
                    </div>
                    @php

                        if(count($categories) > 0){
                           foreach($categories as $category){
                               if(count($category->subcategories) > 0){
                                   foreach($category->subcategories as $subcategory){
                                       $subcategory->category_with_subcategory = $category->title['en'].', '. $subcategory->title['en'];
                                   }
                               }
                           }
                       }

                    @endphp
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <div class="input-style custom-drop-contact">
                            <label class="d-block">Select Category <span class="text-danger">*</span></label>
                            <div class="custom-selct-icons-arow position-relative">
{{--                                <img src="images/arrow-down.png" class="img-fluid arrow-abs">--}}
                                <select class="form-control selectpicker" name="subcategory_id" id="category" required data-parsley-errors-container="#checkbox-errors">
                                    <option value="" title="Select">Select</option>
                                    @forelse($categories as $category)
                                        <optgroup label="{{$category->title['en']}}"></optgroup>
                                        @forelse($category->subcategories as $subcategory)
                                            <option value="{{$subcategory->id}}" title="{{$subcategory->category_with_subcategory}}" {{(old('subcategory_id', $service->subcategory_id) == $subcategory->id) ? 'selected': ''}}>{{$subcategory->title['en']}}</option>
                                        @empty
                                        @endforelse
                                    @empty
                                    @endforelse
                                </select>
                                <div id="checkbox-errors"></div>
                            </div>
                        </div>
                    </div>
                    @if(!$service->featured())
                    <div class="col-md-12 mb-2">
                        <div class="input-style custom-drop-contact">
                            <div class="d-flex">
                                <label class="d-block">Featured Product</label>
                                <a href="{{route('web.dashboard.feature-packages.index')}}" class="primary-color btn-package ml-auto"> Buy Package<i
                                            class="fas fa-angle-double-right"></i></a>
                            </div>
                            <div class="custom-selct-icons-arow position-relative">
{{--                                <img src="images/arrow-down.png" class="img-fluid arrow-abs">--}}
                                <select class="form-control selectpicker" name="package_id" id="package">
                                    <option value="">Select package to feature product</option>
                                    @forelse($packages as $package)
                                        <option value="{{$package->id}}" {{(old('package_id') == $package->id) ? 'selected': ''}}>{{$package->title[app()->getLocale()]}} ({{($package->purchased_packages_count > 1) ? $package->purchased_packages_count: '' }})</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-12 mb-2">
                        <label class="custom-check apply-custom">Apply Offer
                            <input type="checkbox" id="is_offer" {!! (old('has_offer',$service->has_offer) == '1')?'checked':'' !!} name="has_offer"  value="1">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div id="show-discount-fields" class="row col-12 {{(old('has_offer',$service->has_offer) == '1') ? '' : 'd-none'}}">
                        <div  class="col-lg-6 col-md-6 col-sm-12 mb-2 ">
                            <div class="input-style">
                                <label class="d-block">Offer Percentage <span class="text-danger {!! (old('has_offer',$service->has_offer) == '1')?'':'d-none' !!}" id="is_offer_applied">*</span></label>
                                <input type="text" class="ctm-input" placeholder="Offer Percentage"
                                       name="discount_percentage"
                                       value="{{old('discount_percentage',$service->discount_percentage)}}"
                                        {!! (old('has_offer',$service->has_offer) == '1')?'required':'' !!}
                                >
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                            <div class="input-style">
                                <label class="d-block">Offer Expiration Date <span class="text-danger {!! (old('has_offer',$service->has_offer) == '1')?'':'d-none' !!}" id="is_offer_applied1" >*</span></label>
                                <input type="date" name="discount_expiry_date" class="ctm-input"
                                       placeholder="Offer Expiration Date"
                                       value="{{old('discount_expiry_date',$service->discount_expiry_date->format('Y-m-d'))}}"
                                       {!! (old('has_offer',$service->has_offer) == '1')?'required':'' !!}
                                       data-parsley-type="date"
                                       data-parsley-mindate="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-12 mb-2">
                        <div class="input-style">
                            <label class="d-block">Description In English <span class="text-danger">*</span>
                            </label>
                            <textarea class="ctm-textarea" placeholder="Description In English" name="content[en]" required>{{old('content.en', $service->content['en'])}}</textarea>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12 mb-2">
                        <div class="input-style">
                            <label class="d-block">Description In Arabic
                            </label>
                            <textarea class="ctm-textarea" placeholder="Description In Arabic" name="content[ar]">{{old('content.ar', $service->content['ar'])}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex">
                <button type="submit" class="btn-style btn-add-service">{{$heading}} <i class="fa fa-spinner fa-spin d-none" id="submit-id"></i></button>
            </div>
        </form>
    </div>
@endsection

@push('script-end')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{asset('assets/web/js/parsley.min.js')}}"></script>
    <script src="{{asset('assets/web/js/website.js')}}"></script>
    <script>
        window.ParsleyValidator
            .addValidator('mindate', function (value, requirement) {
                // is valid date?
                if(!$("[name=discount_expiry_date]").prop("required")){
                    return true;
                };
                var timestamp = Date.parse(value),
                    minTs = Date.parse(requirement);

                let test = isNaN(timestamp) ? false : timestamp > minTs;
                console.log(test)
                return test
            }, 32)
            .addMessage('en', 'mindate', 'This date should be greater than %s');

        function formatState (state) {
            if (!state.id) {
                return state.text;
            }
            return state.title;
        };
        $(document).ready(function() {
            $('#category').select2({
                minimumResultsForSearch: -1,
                templateSelection: formatState
            });
            $('#package').select2({
                minimumResultsForSearch: -1,
            });
            $('#save-service').parsley();
            $("[name=has_offer]").on('change', function () {
                // Which option was welected?
                var val = $(this).is(':checked');
                console.log(val);

                switch (val) {
                    case true:
                        $('#show-discount-fields').removeClass('d-none')
                        $('#is_offer_applied, #is_offer_applied1').removeClass('d-none')
                        $("[name=discount_percentage]").attr("required", "required");
                        $("[name=discount_expiry_date]").attr("required", 'required');
                        break;
                    case false:
                        $('#show-discount-fields').addClass('d-none')
                        $('#is_offer_applied, #is_offer_applied1').addClass('d-none')
                        $("[name=discount_percentage]").removeAttr("required");
                        $("[name=discount_expiry_date]").removeAttr("required");
                        break;
                }

                $("#save-service").parsley().reset();
            });

        });
    </script>
@endpush