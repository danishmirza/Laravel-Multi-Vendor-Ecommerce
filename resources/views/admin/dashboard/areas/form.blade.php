<form action="{{$action}}" method="POST" class="m-form m-form--fit m-form--label-align-right">
    {{csrf_field()}}
<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Name in English') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <input type="text" name="title[en]" value="{{old('title.en', $area->title['en'])}}" class="form-control" placeholder="Title" required>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Name in Arabic') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <input type="text" name="title[ar]" value="{{old('title.ar', $area->title['ar'])}}" class="form-control" placeholder="Title" required>
        </div>
    </div>
    <div class="m-form__group row" style="margin-top:40px">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Select Location') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <div class="d-flex align-items-center justify-contnet-between mb-3">
                <input type="text" name="address" value="{{old('address', $area->address)}}" class="form-control" placeholder="Search map" required id='address'>
                <div class="ml-2">
                    <button type="button" onclick="recreateMap()" class="btn btn-accent m-btn m-btn--air m-btn--custom">
                        Reset
                    </button>
                </div>
                @if($area->id > 0)
                    <div class="ml-2">
                        <button type="button" onclick="editMap()" class="btn btn-accent m-btn m-btn--air m-btn--custom">
                            Edit
                        </button>
                    </div>
                @endif
            </div>
            <div id="map" style="height:400px; width:100%; margin-top:5px"></div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Selected Polygon lat/long
        </label>
        <div class="col-7">
            <textarea class="form-control" disabled name="vertices" id="vertices" cols="50"
                      rows="10">{{old('polygon',$area->polygon) ?? ''}}</textarea>
        </div>
    </div>
    <input type="text" name="latitude" id="latitude" value="{{$area->latitude}}" hidden>
    <input type="text" name="longitude" id="longitude" value="{{$area->longitude}}" hidden>
    <input type="text" name="polygon" id="polygon" value="{{old('polygon',$area->polygon)}}" hidden>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">
            <input type="hidden" value="PUT" name="_method">
            <div class="col-4"></div>
            <div class="col-7">
                <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-3">
                    @if($areaId == 0)
                        Add Areas
                    @else
                        Update Areas
                    @endif
                </button>
                <a href="{!! route('admin.dashboard.cities.index') !!}"
                   class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Cancel') !!}</a>
            </div>
        </div>
    </div>
</div>

</form>
