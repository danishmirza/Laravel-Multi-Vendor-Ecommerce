<form action="{{$action}}" method="POST" class="m-form m-form--fit m-form--label-align-right">
    {{csrf_field()}}
<div class="m-portlet__body">

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Title in English
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <input type="text" name="title[en]" value="{{old('title.en', $article->title['en'])}}" class="form-control" placeholder="Title" required>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Title in Arabic
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <input type="text" name="title[ar]" value="{{old('title.ar', $article->title['ar'])}}" class="form-control" placeholder="Title" required>
        </div>
    </div>

    @include('admin.common.upload-image',[
    'imagePath'=>'articles',
    'image_name'=> 'image',
    'current_image'=> old('image', $article->image),
    'title'=>'Article image',
    'image_size'=>'Recommended size 555 x 445',
    'image_number'=>1
    ])

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Author name in English
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <input type="text" name="author[en]" value="{{old('author.en', $article->author['en'])}}" class="form-control" placeholder="Author" required>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Author name in Arabic
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <input type="text" name="author[ar]" value="{{old('author.ar', $article->author['ar'])}}" class="form-control" placeholder="Author" required>
        </div>
    </div>


    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Content in English
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <textarea name="content[en]" id="" cols="30" rows="10" class="form-control">{{old('content.en',$article->content['en'])}}</textarea>
        </div>
    </div>


    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Content in Arabic
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <textarea name="content[ar]" id="" cols="30" rows="10" class="form-control">{{old('content.ar',$article->content['ar'])}}</textarea>
        </div>
    </div>

</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">
            <input type="hidden" value="PUT" name="_method">
            <input type="hidden" name="article_id" value="{!! $articleId !!}">
            <div class="col-4"></div>
            <div class="col-7">
                <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-4">
                    @if($articleId ==0)
                        Add Article
                    @else
                        Update Article
                    @endif
                </button>
                <a href="{!! route('admin.dashboard.articles.index') !!}"
                   class="btn btn-secondary m-btn m-btn--air m-btn--custom">Cancel</a>
            </div>
        </div>
    </div>
</div>
</form>

