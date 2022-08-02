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
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <div class="input-style custom-drop-contact">
                            <label class="d-block">Select Area <span class="text-danger">*</span></label>
                            <div class="custom-selct-icons-arow position-relative height-select-2-custom">
                                 <img src="{{asset('assets/web/img/down-chevron.svg')}}" class="img-fluid arrow-abs">
                                <select class="form-control selectpicker" id="area" name="area_id" required data-parsley-errors-container="#checkbox-errors">
                                    <option value="">Select Area</option>
                                    @forelse($areas as $area)
                                        <option value="{{$area->id}}" {{(old('area_id', $storeArea->area_id) == $area->id) ? 'selected': ''}}>{{$area->title[app()->getLocale()]}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div id="checkbox-errors"></div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-2">
                        <div class="input-style">
                            <label class="d-block">Price <span class="text-danger">*</span></label>
                            <input type="tel" class="ctm-input" placeholder="Price"
                                   name="price"
                                   required
                                   min="1"
                                   step="100"
                                   data-parsley-validation-threshold="1"
                                   data-parsley-trigger="keyup"
                                   data-parsley-type="number"
                                   value="{{old('price', $storeArea->price)}}"
                            >
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="hidden" name="id" value="{{$storeAreaId}}">
                        <button class="btn-style btn-auth w-100" type="submit">Add</button>
                    </div>
                </div>
            </form>
            <!--Profile Address Outer End-->
        </div>
    </div>
@endsection

@push('script-end')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{asset('assets/web/js/parsley.min.js')}}"></script>
    <script src="{{asset('assets/web/js/website.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#area').select2({
                minimumResultsForSearch: -1
            });
            $('#save-delivery-area').parsley();
        });
    </script>
@endpush
