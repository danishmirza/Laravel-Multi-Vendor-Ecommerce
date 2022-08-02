<form action="{{$action}}" method="POST" class="m-form m-form--fit m-form--label-align-right">
    {{csrf_field()}}
<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Setting Key
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <input type="text" name="setting_key" value="{{old('setting_key', $setting->setting_key)}}" class="form-control" placeholder="Setting Key" required {{($settingId > 0) ? 'readonly': ''}}>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Setting Value
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <input type="text" name="setting_value" value="{{old('setting_value', $setting->setting_value)}}" class="form-control" placeholder="Setting Value" required>
        </div>
    </div>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">
            <input type="hidden" value="PUT" name="_method">
{{--            <input type="hidden" name="language_id" value="{!! $languageId !!}">--}}
            <input type="hidden" name="setting_id" value="{!! $settingId !!}">
            <div class="col-4"></div>
            <div class="col-7">
                <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-4">
                    @if($settingId ==0)
                        Add Setting
                        @else
                        Update Setting
                        @endif
                </button>
                <a href="{!! route('admin.dashboard.settings.index') !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Cancel') !!}</a>
            </div>
        </div>
    </div>
</div>
</form>

