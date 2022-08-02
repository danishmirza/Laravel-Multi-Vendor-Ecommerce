<form action="{{$action}}" method="POST" class="m-form m-form--fit m-form--label-align-right">
    {{csrf_field()}}
<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Question In English
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <input type="text" name="question[en]" value="{{old('question.en', $faq->question['en'])}}" class="form-control" placeholder="Question" required>

        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Question In Arabic
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <input type="text" name="question[ar]" value="{{old('question.ar', $faq->question['ar'])}}" class="form-control" placeholder="Question" required>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Answer In English
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <textarea name="answer[en]" id="" cols="30" rows="10" class="form-control">{{old('answer.en',$faq->answer['en'])}}</textarea>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Answer In English
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <textarea name="answer[ar]" id="" cols="30" rows="10" class="form-control">{{old('answer.ar',$faq->answer['ar'])}}</textarea>
        </div>
    </div>

</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">
            <input type="hidden" value="PUT" name="_method">
            <div class="col-4"></div>
            <div class="col-7">
                <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom button-margin">
                    @if($faqId == 0)
                        Add FAQ
                    @else
                        Update FAQ
                    @endif
                </button>
                <a href="{!! route('admin.dashboard.faqs.index') !!}"
                   class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Cancel') !!}</a>
            </div>
        </div>
    </div>
</div>

</form>



