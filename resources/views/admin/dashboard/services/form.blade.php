<form action="{{$action}}" method="POST" class="m-form m-form--fit m-form--label-align-right">
    {{csrf_field()}}
<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Select Category/Subcategory
            <span class="text-danger">*</span>
        </label>
        @php

            if(count($categories) > 0){
               foreach($categories as $category){
                   if(count($category->subcategories) > 0){
                       foreach($category->subcategories as $subcategory){
                           $subcategory->category_with_subcategory = $category->title['en'].'->'. $subcategory->title['en'];
                       }
                   }
               }
           }

        @endphp
        <div class="col-9">
            <select name="subcategory_id" id="" class="form-control categories-subcategories" required>
                <option value="">Select</option>
                @forelse($categories as $category)
                <optgroup label="{{$category->title['en']}}"></optgroup>
                    @forelse($category->subcategories as $subcategory)
                        <option value="{{$subcategory->id}}" title="{{$subcategory->category_with_subcategory}}" {{(old('subcategory_id', $service->subcategory_id) == $subcategory->id) ? 'selected': ''}}>{{$subcategory->title['en']}}</option>
                    @empty
                    @endforelse
                @empty
                @endforelse
            </select>

        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Title In English
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            <input type="text" name="title[en]" value="{{old('title.en', $service->title["en"])}}" class="form-control" placeholder="Title" required />
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Title In Arabic
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            <input type="text" name="title[ar]" value="{{old('title.ar', $service->title["ar"])}}" class="form-control" placeholder="Title" required />
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Price
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            <input type="tel" name="price" value="{{old('price',$service->price)}}"
                   class="form-control  f-input-cls dir rt-phone" id="#"
                   placeholder="Price" required>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Is Active
            <span class="text-danger"></span>
        </label>
        <div class="col-9 d-flex">
            <label class="check text-capitalize black gothic-normel option-g mr-3 mb-0 p-c d-flex align-items-center">
                <input type="radio" {!! (old('is_active',$service->is_active) == '1')?'checked':'' !!} name="is_active" checked value="1">
                <span class="log checkmark ml-1"></span>Yes
            </label>
            <label class="check mr-3 text-capitalize black gothic-normel option-g mb-0 p-c d-flex align-items-center">
                <input type="radio" {!! (old('is_active',$service->is_active) == '0')?'checked':'' !!} name="is_active"  value="0">
                <span class="log checkmark ml-1"></span>No
            </label>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Apply Offer
            <span class="text-danger"></span>
        </label>
        <div class="col-9 d-flex">
            <label class="check text-capitalize black gothic-normel option-g mr-3 mb-0 p-c d-flex align-items-center">
                <input type="radio" {!! (old('has_offer',$service->has_offer) == '1')?'checked':'' !!} name="has_offer"  value="1">
                <span class="log checkmark ml-1"></span>Yes
            </label>
            <label class="check mr-3 text-capitalize black gothic-normel option-g mb-0 p-c d-flex align-items-center">
                <input type="radio" {!! (old('has_offer',$service->has_offer) == '0')?'checked':'' !!} name="has_offer" {{(old('has_offer') || $serviceId > 0) ? '': 'checked'}}  value="0">
                <span class="log checkmark ml-1"></span>No
            </label>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Offer Discount
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            <input type="text" name="discount_percentage"  class="form-control" placeholder="Discount" value="{{old('discount_percentage',$service->discount_percentage)}}">
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Offer Expiry Date
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            <input type="date" name="discount_expiry_date"  class="form-control" placeholder="Expiry Date" value="{{old('discount_expiry_date',$service->discount_expiry_date->format('Y-m-d'))}}">
        </div>
    </div>
    @include('admin.common.upload-image',[
    'imagePath' => 'services',
    'image_name'=> 'image',
    'current_image' =>old('image', $service->image),
    'title'=>'Image',
    'image_size'=>'',
    'image_number'=>1
    ])
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Detail In English
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <textarea name="content[en]" id="" cols="30" rows="10" class="form-control">{{old('content.en',$service->content['en'])}}</textarea>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Detail In English
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <textarea name="content[ar]" id="" cols="30" rows="10" class="form-control">{{old('content.ar',$service->content['ar'])}}</textarea>
        </div>
    </div>

</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">
            <input type="hidden" value="PUT" name="_method">
            <input type="hidden" value="{{$serviceId}}" name="service_id">
            <div class="col-4"></div>
            <div class="col-7 mb-3 mt-3">
                @if($service->id > 0)
                    <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-4">
                        Update Service
                    </button>
                @else
                    <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-4">
                        Add Service
                    </button>
                @endif
                <a href="{!! route('admin.dashboard.stores.services.index', ['store' => $storeId]) !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Cancel') !!}</a>

            </div>
        </div>
    </div>
</div>
</form>



