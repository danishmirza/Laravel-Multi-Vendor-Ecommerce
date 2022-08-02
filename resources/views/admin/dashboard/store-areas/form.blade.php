<form action="{{$action}}" method="POST" class="m-form m-form--fit m-form--label-align-right">
    {{csrf_field()}}
<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Select Area
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <select name="area_id" id="" class="form-control" required>
                <option value="">Select</option>
                @forelse($areas as $area)
                    <option value="{{$area->id}}" {{(old('area_id', $storeArea->area_id) == $area->id) ? 'selected': ''}}>{{$area->title['en']}}</option>
                @empty
                @endforelse
            </select>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Delivery Price
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <input type="text" name="price" value="{{old('price', $storeArea->price)}}" class="form-control" placeholder="Price" required>
        </div>
    </div>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">
            <input type="hidden" value="PUT" name="_method">
            <input type="hidden" value="{{$storeAreaId}}" name="store_area_id">
            <input type="hidden" value="{{$storeId}}" name="store_id">
            <input type="hidden" value="PUT" name="_method">
            <div class="col-4"></div>
            <div class="col-7">
                <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-4">
                    @if($storeAreaId ==0)
                        Add Store Area
                        @else
                        Update Store Area
                        @endif
                </button>
                <a href="{!! route('admin.dashboard.stores.areas.index', ['store' => $storeId]) !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Cancel') !!}</a>
            </div>
        </div>
    </div>
</div>
</form>

