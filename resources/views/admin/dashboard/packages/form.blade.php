<form action="{{$action}}" method="POST" class="m-form m-form--fit m-form--label-align-right">
    {{csrf_field()}}
<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <div class="col-lg-3 col-md-3">
            <label for="example-text-input" class="col-form-label">
                Title English
                <span class="text-danger">*</span>
            </label>
        </div>
        <div class="col-lg-7 col-md-7">
            <input type="text" name="title[en]" value="{{old('title.en', $package->title['en'])}}" class="form-control" placeholder="Title" required>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-3 col-md-3">
            <label for="example-text-input" class="col-form-label">
                Title Arabic
                <span class="text-danger">*</span>
            </label>
        </div>
        <div class="col-lg-7 col-md-7">
            <input type="text" name="title[ar]" value="{{old('title.ar', $package->title['ar'])}}" class="form-control" placeholder="Title" required>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-lg-3 col-md-3">
            Is free
            <span class="text-danger">*</span>
        </label>
        <div class="col-9 d-flex">
            <label class="check text-capitalize black gothic-normel option-g mr-3 mb-0 p-c d-flex align-items-center">
                <input type="radio" {!! (old('is_free',$package->is_free) == '1' ) ? 'checked' : '' !!} name="is_free"
                       required
                       value="1">
                <span class="log checkmark ml-1"></span>Yes
            </label>

            <label class="check mr-3 text-capitalize black gothic-normel option-g mb-0 p-c d-flex align-items-center">
                <input type="radio" {!! (old('is_free',$package->is_free) == '0' ) ? 'checked' : '' !!} name="is_free"
                       required
                       @if($id =="0") checked @endif  value="0">
                <span class="log checkmark ml-1"></span>No
            </label>

        </div>
    </div>

    <div class="form-group m-form__group row" id="Price_input">
        <div class="col-lg-3 col-md-3">
            <label for="example-text-input" class="col-form-label">
                Price
                <span class="text-danger">*</span>
            </label>
        </div>
        <div class="col-lg-7 col-md-7">
            <input type="number" name="price" class="form-control" value="{{old('price',$package->price)}}"
                   id="price_field" placeholder="240" min="0" max="999999">
            {{--            {!! Form::number('price', old('price',$package->price), ['class' => 'form-control','type'=>'number', 'placeholder' => '240', 'max'=>999999, 'min'=>'1']) !!}--}}
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-3 col-md-3">
            <label for="example-text-input" class="col-form-label">
                {!! __('Duration') !!}
                <span class="text-danger">*</span>
            </label>
        </div>
        <div class="col-lg-7 col-md-7">
            <div class="subscripton-number mb-2">
                @if(old('duration_type', $package->duration_type) == 'years' )
                    <input type="text" name="duration" value="{{old('duration', $package->duration)}}" class="form-control duration_number" placeholder="Duration" id="duration_number" required min="1" max="9">
                @else
                    <input type="text" name="duration" value="{{old('duration', $package->duration)}}" class="form-control duration_number" placeholder="Duration" id="duration_number" required min="1" max="99">
                @endif
            </div>
            <div class="subscripton-checkbox">
                <input type="radio" class="duration_day" id="duration_day"
                       {{old('duration_type',$package->duration_type) == 'days'? 'checked':''}} name="duration_type"
                       value="days"> {!! __('Days') !!}&nbsp;&nbsp;&nbsp;
                <input type="radio" class="duration_month" id="duration_month"
                       {{old('duration_type',$package->duration_type) == 'months'? 'checked':''}}  name="duration_type"
                       value="months"> {!! __('Months') !!}&nbsp;&nbsp;&nbsp;
                <input type="radio" class="duration_year" id="duration_year"
                       {{old('duration_type',$package->duration_type) == 'years'? 'checked':''}} name="duration_type"
                       value="years"> {!! __('Years') !!}
            </div>
            <!-- </div> -->
        </div>
    </div>

    <input type="hidden" name="subscription_type" value="subscription">
    <div class="form-group m-form__group row">
        <div class="col-lg-3 col-md-3">
            <label for="example-text-input" class="col-form-label">
                Description English
                <span class="text-danger">*</span>
            </label>
        </div>
        <div class="col-lg-7 col-md-7">
            <textarea name="description[en]" id="" cols="30" rows="10" class="form-control">{{old('description.en',$package->description['en'])}}</textarea>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-3 col-md-3">
            <label for="example-text-input" class="col-form-label">
                Description Arabic
                <span class="text-danger">*</span>
            </label>
        </div>
        <div class="col-lg-7 col-md-7">
            <textarea name="description[ar]" id=""  class="form-control">{{old('description.ar',$package->description['ar'])}}</textarea>
        </div>
    </div>


</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">
            <input type="hidden" value="POST" name="_method">
            <input type="hidden" value="{{$type}}" name="package_type">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-2">
                    @if($packageId ==0)
                        Add {{ucfirst($type)}} Package
                    @else
                        Update {{ucfirst($type)}} Package
                    @endif
                </button>
                <a href="{!! route('admin.dashboard.packages.index', $type) !!}"
                   class="btn btn-secondary m-btn m-btn--air m-btn--custom mx-2">Cancel</a>
            </div>
        </div>
    </div>
</div>
</form>
