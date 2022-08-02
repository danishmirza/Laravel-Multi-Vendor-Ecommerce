<form action="{{$action}}" method="POST"  class="m-form m-form--fit m-form--label-align-right">

@csrf
<input type="hidden" name="type" value="store">
<div class="m-portlet__body mt-3">
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Title (English)') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            <input type="text" name="name[en]" value="{{old('name.en', $coupon->name['en'])}}" class="form-control" placeholder="Coupon Name" required>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Title (Arabic)') !!}
            <span class="text-danger">*</span>
        </label>


        <div class="col-9">

            <input type="text" name="name[ar]" value="{{old('name.ar', $coupon->name['ar'])}}" class="form-control" placeholder="Coupon Name" required>
        </div>
    </div>


    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Coupon Code') !!}
            <span class="text-danger">*</span>
        </label>


        <div class="col-9">
            <input type="text" name="coupon_code" value="{{old('coupon_code', $coupon->coupon_code)}}" class="form-control" placeholder="Coupon Code" required readonly>

        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Discount In Percentage') !!}
            <span class="text-danger">*</span>
        </label>

        <div class="col-9">
            <input type="number" name="discount" value="{{old('discount', $coupon->discount)}}" class="form-control" placeholder="Coupon Discount" required >
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Coupon Type') !!}
            <span class="text-danger">*</span>
        </label>


        <div class="col-9">
            <select id="brand_id" name="coupon_type" class="form-control category_id" required>

                <option {{(old('coupon_type', $coupon->coupon_type) =="infinite") ? "selected": ""}} value="infinite">{{ __('Infinite') }}</option>

                <option {{(old('coupon_type', $coupon->coupon_type) =="number") ? "selected": ""}}  value="number">{{ __('Number') }}</option>

            </select>
        </div>
    </div>

    <div class="form-group m-form__group row {{(old('coupon_type', $coupon->coupon_type) =="infinite")? 'd-none': ''}}" id="show-coupon">
        <label for="example-text-input" class="col-3 col-form-label js-toggle-class " >
            {!! __('No of Coupon') !!}
            <span class="text-danger">*</span>
        </label>

        <div class="col-9">
            <input type="number" name="coupon_number" value="{{old('coupon_number', $coupon->coupon_number)}}" class="form-control" placeholder="No of Coupons" id="coupon_number">
        </div>

    </div>


    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Expiry Date') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            <input type="date" name="end_date" value="{{old('end_date', Carbon\Carbon::parse($coupon->end_date)->format('Y-m-d'))}}" class="form-control" placeholder="Expiry Date" required autocomplete="off">
        </div>
    </div>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">
            <input type="hidden" value="PUT" name="_method">
            <input type="hidden" value="{!! $coupon->id !!}" name="coupon_id">
            <div class="col-4"></div>
            <div class="col-7 mb-5 mt-5">
                @if ($coupon->id > 0)
                    <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-4">
                        Update Coupon
                    </button>
                @else
                    <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-4">
                        Add Coupon
                    </button>
                @endif
                <a href="{!! route('admin.dashboard.coupons.index') !!}"
                   class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Cancel') !!}</a>

            </div>
        </div>
    </div>
</div>
</form>
