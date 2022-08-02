<form class="m-form m-form--fit m-form--label-align-right">

<div class="m-portlet__body">

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Title In English
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <input type="text" value="{{ $ad->title['en']}}" class="form-control"  readonly>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Title In Arabic
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <input type="text" value="{{ $ad->title['ar']}}" class="form-control"  readonly>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Sub Title In English
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <input type="text" value="{{ $ad->sub_title['en']}}" class="form-control"  readonly>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Sub Title In Arabic
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <input type="text" value="{{ $ad->sub_title['ar']}}" class="form-control"  readonly>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
           Detail In English
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <textarea type="text" class="form-control"  readonly> {{ $ad->content['en']}}</textarea>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Detail In English
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <textarea type="text"  class="form-control"  readonly>{{ $ad->content['ar']}}</textarea>
        </div>
    </div>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">
            <div class="col-4"></div>
            <div class="col-7">
                <a href="{!! route('admin.dashboard.stores.ads.index', ['store' => $storeId]) !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Cancel') !!}</a>
                @if($ad->ad_status == 'pending')
                <a href="{!! route('admin.dashboard.stores.ads.status', ['store' => $storeId, 'ad' => $ad->id, 'status' => 'approved', 'page' => 1]) !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Approved') !!}</a>
                <a href="{!! route('admin.dashboard.stores.ads.status', ['store' => $storeId, 'ad' => $ad->id, 'status' => 'rejected', 'page' => 1]) !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Rejected') !!}</a>
                @elseif($ad->ad_status == 'approved')
                    <a href="{!! route('admin.dashboard.stores.ads.status', ['store' => $storeId, 'ad' => $ad->id, 'status' => 'completed', 'page' => 1]) !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Completed') !!}</a>
                @endif
            </div>
        </div>
    </div>
</div>
</form>

