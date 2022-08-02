<form action="{{$action}}" method="POST" class="m-form m-form--fit m-form--label-align-right">
    {{csrf_field()}}
<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Title English
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <input type="text" name="name[en]" value="{{old('name[en]', $page->name['en'])}}" class="form-control" placeholder="Title" required>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Title Arabic
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <input type="text" name="name[ar]" value="{{old('name[ar]', $page->name['ar'])}}" class="form-control" placeholder="Title" required>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Content English
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <textarea name="content[en]" id="" cols="30" rows="10" class="form-control">{{old('content[en]',$page->content['en'])}}</textarea>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Content Arabic
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <textarea name="content[ar]" id="" cols="30" rows="10" class="form-control">{{old('content[ar]',$page->content['ar'])}}</textarea>
        </div>
    </div>

</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">
            <input type="hidden" value="PUT" name="_method">
{{--            <input type="hidden" name="language_id" value="{!! $languageId !!}">--}}
            <input type="hidden" name="page_id" value="{!! $pageId !!}">
            <div class="col-4"></div>
            <div class="col-7">
                <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-4">
                    @if($pageId ==0)
                        Add Info Page
                        @else
                        Update Info Page
                        @endif
                </button>
                <a href="{!! route('admin.dashboard.pages.index') !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Cancel') !!}</a>
            </div>
        </div>
    </div>
</div>
</form>

