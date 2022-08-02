@if(!isset($imageAsBackground))
<div class="input-style">
    <label class="d-block">{{$imageLabel}} @if($isRequired)<span class="text-danger"> *</span>@endif</label>
</div>
@endif
<div class="upload-sec d-flex align-items-center flex-wrap {{(isset($imageAsBackground)) ? 'justify-content-center': ''}} {{(isset($isGallery)) ? 'justify-content-center': ''}}" >
    <!-- image upload -->
    <div class="qust-filed mr-2">
        <div class="form-control py-2 d-flex align-items-center justify-content-center {{(isset($imageAsBackground)) ? 'upload-img': ''}}" id="profile-image" >
            <input type="file" id="choose-file-{{$inputName}}" class="input-file d-none">
            <label for="choose-file-{{$inputName}}"
                   class="btn-tertiary js-labelFile d-flex align-items-center flex-column">
                <i class="icon fa fa-plus-circle plus-icon"></i>
                <span class="js-fileName heading">{{ __('Upload Image') }}</span>
            </label>
        </div>
    </div>
    @if(!isset($imageAsBackground))
    <div class="upload position-relative {{(is_null($uploadedImage) ? 'd-none' : '')}}" id="selected-div-{{$inputName}}">
        <div class="demo-img d-flex align-items-center justify-content-center">
            <img src="{{imageUrl($uploadedImage, 158, 158, 95, 1)}}" alt="" class="img-fluid" id="selected-image-{{$inputName}}">
            @if($allowDelete)
{{--                <a href="javascript:void(0)" class="del-img" id="delete-icon-{{$inputName}}">--}}
{{--                    <svg id="Icon_metro-cross" data-name="Icon metro-cross"--}}
{{--                         xmlns="http://www.w3.org/2000/svg" width="8.594" height="8.594"--}}
{{--                         viewBox="0 0 8.594 8.594">--}}
{{--                        <path id="Icon_metro-cross-2" data-name="Icon metro-cross"--}}
{{--                              d="M11.086,8.832h0L8.479,6.225l2.607-2.607h0a.269.269,0,0,0,0-.38L9.854,2.007a.269.269,0,0,0-.38,0h0L6.868,4.614,4.261,2.007h0a.269.269,0,0,0-.38,0L2.649,3.238a.269.269,0,0,0,0,.38h0L5.256,6.225,2.649,8.832h0a.269.269,0,0,0,0,.38l1.232,1.232a.269.269,0,0,0,.38,0h0L6.868,7.836l2.607,2.607h0a.269.269,0,0,0,.38,0l1.232-1.232a.269.269,0,0,0,0-.38Z"--}}
{{--                              transform="translate(-2.571 -1.928)" fill="#ccc"/>--}}
{{--                    </svg>--}}
{{--                </a>--}}
            @endif
        </div>
    </div>
    @endif
</div>
@if(isset($recommendSize))
<label class="d-block text-danger {{(isset($imageAsBackground)) ? 'text-center': ''}}">{{__("Recommended Size")." ".$recommendSize}}</label>
@endif
<input type="text" class="d-none" name="{{ $inputName }}"
       id="selected-image-url-{{$inputName}}" value="{{ $uploadedImage }}" {{$isRequired ? 'required': ''}}>





@push('script-end')
    <script>
        $(document).ready(function (){
            let imageAsBackground = {{isset($imageAsBackground) ? 'true': 'false'}}
            if(imageAsBackground){
                console.log(1)
                $('#profile-image').css("background", "url(" + imageUrl('{{$uploadedImage}}', 158, 158, 95, 1) + ")");
            }

            $(document).on('click', '#selected-div-' + '{{ $inputName }}', function () {
                var imagePath = $('#selected-image-url-' + '{{ $inputName }}').val();
                if ({{$allowDelete}}){
                    if (imagePath.length > 0) {
                        $('#selected-image-url-' + '{{ $inputName }}').val(null);
                        let url = window.Laravel.apiUrl + 'remove-image';
                        $.ajax({
                            url: url,
                            type: 'post',
                            data: 'image= ' + imagePath,
                            headers: {
                                'X-CSRF-TOKEN': window.Laravel.csrfToken
                            },
                        }).done(function (res) {
                            if (res.success == false) {
                                toastr.error(res.message);
                            } else {
                                toastr.success(res.message);
                                $('#selected-div-' + '{{$inputName}}').addClass('d-none');
                            }
                        })
                            .fail(function (res) {
                                toastr.error("{{ __('Something went wrong, please refresh.') }}");
                            });

                    }
                }else{
                    toastr.success('{{__('Image successfully deleted')}}');
                    $('#selected-image-url-{{$inputName}}').val('');
                    $('#selected-div-' + '{{$inputName}}').addClass('d-none');
                }
            });

            $(document).on('change', '#choose-file-' + '{{ $inputName }}', function () {
                $('{{$submitButtonId}}').removeClass('d-none')
                $('{{$submitButtonId}}').parent().attr('disabled', 'disabled')
                let url = window.Laravel.apiUrl + 'upload-image/media';
                let fileData = $(this).prop("files")[0];
                if (fileData !== undefined) {
                    let formData = new FormData();
                    {{--if (!{{$allowVideo}}) {--}}
                    {{--    if (fileData.type.includes('video')) {--}}
                    {{--        toastr.error('{{ __('Error') }}', '{{__('You can only upload images')}}');--}}
                    {{--        return false;--}}
                    {{--    }--}}
                    {{--}--}}
                    formData.append("image", fileData);
                    if (url.length > 0) {
                        jQuery.ajax({
                            url: url,
                            type: 'post',
                            dataType: 'json',
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: formData,
                            headers: {
                                'X-CSRF-TOKEN': window.Laravel.csrfToken
                            },
                        }).done(function (res) {
                            $('{{$submitButtonId}}').addClass('d-none')
                            $('{{$submitButtonId}}').parent().removeAttr('disabled')
                            if (res.success == false) {
                                toastr.error(res.message);
                            } else {
                                console.log(res.data.file_name)
                                // toastr.success(res.message);
                                {{--$("#selected-image-url-" + '{{ $imageNumber }}').hide();--}}
                                $(this).val("");
                                $('#choose-file-' + '{{ $inputName }}').val(null);
                                $('#selected-image-url-{{ $inputName }}').attr('value', res.data.file_name);
                                if(imageAsBackground){
                                    $('#profile-image').css("background", "url(" + imageUrl(res.data.file_name, 158, 158, 95, 1) + ")");
                                }else{
                                    $('#selected-image-' + '{{ $inputName }}').attr('src', imageUrl(res.data.file_name, 158, 158, 95, 1));
                                    $('#selected-div-' + '{{ $inputName }}').removeClass('d-none');
                                    $('#delete-icon-' + '{{ $inputName }}').removeClass('d-none');
                                    $('.single-img-upload').removeClass('d-none');
                                }
                                console.log($('#selected-image-url-' + '{{ $inputName }}').value);

                            }
                        }).fail(function (res) {
                            $('{{$submitButtonId}}').addClass('d-none')
                            $('{{$submitButtonId}}').parent().removeAttr('disabled')
                            alert('{{ __('Something went wrong, please try later.') }}');
                        });
                    }
                }

            });
        })

    </script>
@endpush
