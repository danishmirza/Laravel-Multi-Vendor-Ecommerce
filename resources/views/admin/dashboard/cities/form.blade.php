<form action="{{$action}}" method="POST" class="m-form m-form--fit m-form--label-align-right">
    {{csrf_field()}}
<div class="m-portlet__body">
    <div class="form-group m-form__group row pb-3">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Name in English') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <input type="text" name="title[en]" value="{{old('title.en', $city->title['en'])}}" class="form-control" placeholder="Title" required>
        </div>
    </div>
    <input type="hidden" name="parent_id" value="0">

    <div class="form-group m-form__group row pb-3">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Name in Arabic') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <input type="text" name="title[ar]" value="{{old('title.ar', $city->title['ar'])}}" class="form-control" placeholder="Title" required>
        </div>
    </div>

</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">

            <input type="hidden" value="PUT" name="_method">
            <div class="col-4"></div>
            <div class="col-7">
                @if($cityId == 0)
                    <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-3">
                        Add City
                    </button>
                @else
                    <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-3">
                        Update City
                    </button>
                @endif
                <a href="{!! route('admin.dashboard.cities.index') !!}"
                   class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Cancel') !!}</a>
            </div>
        </div>
    </div>
</div>

</form>
