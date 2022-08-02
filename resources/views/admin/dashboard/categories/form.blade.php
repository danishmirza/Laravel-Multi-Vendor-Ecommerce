<form action="{{$action}}" method="POST" class="m-form m-form--fit m-form--label-align-right">
    {{csrf_field()}}
<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Name in English
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <input type="text" name="title[en]" value="{{old('title.en', $category->title['en'])}}" class="form-control" placeholder="Title" required>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Name in Arabic
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <input type="text" name="title[ar]" value="{{old('title.ar', $category->title['ar'])}}" class="form-control" placeholder="Title" required>
        </div>
    </div>
    <input type="hidden" name="parent_id" value="0">

    @include('admin.common.upload-image',[
    'imagePath'=>'categories',
    'image_name'=> 'image',
    'current_image' => old('image', $category->image),
     'title'=>'Category Image',
     'image_size'=>'Recommended size 555 x 400',
     'image_number'=>1
    ])
    @if($parent)
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Content in English
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <textarea name="content[en]" id="" cols="30" rows="10" class="form-control">{{old('content.en',$category->content['en'])}}</textarea>
        </div>
    </div>


    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Content in Arabic
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <textarea name="content[ar]" id="" cols="30" rows="10" class="form-control">{{old('content.ar',$category->content['ar'])}}</textarea>
        </div>
    </div>
    @endif
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">

            <input type="hidden" value="PUT" name="_method">
{{--            <input type="hidden" name="language_id" value="{!! $languageId !!}">--}}
            <div class="col-4"></div>
            <div class="col-7">
                @if($categoryId == 0)
                    <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-3">
                        Add Category
                    </button>
                @else
                    <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-3">
                        Update Category
                    </button>
                @endif
                <a href="{!! route('admin.dashboard.categories.index') !!}"
                   class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Cancel') !!}</a>
            </div>
        </div>
    </div>
</div>

</form>
