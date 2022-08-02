<div class="form-group m-form__group row">
    <label for="example-text-input" class="col-3 col-form-label">
        {{$title}}
        <span class="text-danger">*</span>
    </label>
    <div class="col-7">
        <div class="tab-pane fade show  home{!! $image_number !!}" id="home{!! $image_number !!}" role="tabpanel"
             aria-labelledby="home-tab">
            <div class="container-h">
                <button type="button" id="upload-image-{{$image_number}}"
                        class="btn btn-accent m-btn m-btn--air m-btn--custom upload-image upload-trade-image-h">
                    Upload {{$title}}
                </button>
                <input type="file" id="upload_image_input_{{$image_number}}" class="hide upload_image_input" accept="image/*">
            </div>
        </div>
        <input type="hidden" id="public_select_image_{{$image_number}}" name="{{$image_name}}" class="public_select_image" value="{{$current_image}}">

        @if($image_size != '' )
        <p class=" mt-3 text-danger smaller-font-size">{{$image_size}}</p>
        @endif
    </div>
</div>

<div class="form-group m-form__group row">
    <label for="example-text-input" class="col-3 col-form-label">
        Current {{$title}}
    </label>

    <div class="col-3" id="display-selected-file-{{$image_number}}" style="padding-top: 140px">
        @if (pathinfo($current_image, PATHINFO_EXTENSION) == 'mp4')
            <video width="320" height="240" controls muted> <source src="{{ $current_image }}" type="video/mp4"> Your browser does not support the video tag. </video>
        @else
            <img style="width:120px;height: 120px; " src="{{imageUrl($current_image, 120, 120)}}" id="selected-image-{{$image_number}}"
                 class="selected-image img-fluid">
        @endif

    </div>
</div>


@push('script-page-level')

    <script>
        $('#upload-image-{{$image_number}}').on('click', function () {
            $(this).next().click();
        });

        $('#upload_image_input_{{$image_number}}').on('change', function () {
            console.log("On change function is cladded");
            var fileData = $(this).prop("files")[0];
            var formData = new FormData();
            formData.append("image", fileData);
            var url = window.Laravel.apiUrl+'upload-image/'+'{{$imagePath}}';
            if (url.length > 0) {
                $.ajax({
                    url: url,
                    type: 'post',
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data : formData,
                    headers: {
                        'X-CSRF-TOKEN': window.Laravel.csrfToken
                    }
                })
                    .done(function (res) {
                        console.log("image is being uploaded");

                        $('#public_select_image_{{$image_number}}').val(res.data.file_name);

                        {{--$('#selected-image-{{$image_number}}').attr('src', imageUrl(window.Laravel.base+res.data, 120, 120, 100, 1));--}}
                        if (res.success == false ) {
                            toastr.error(res.message, 'Error');
                        }
                        else {
                            console.log(res.data)
                            $('#display-selected-file-{{$image_number}}').empty();
                            // console.log("Is the returned file and image =>",res.data.match(/\.(jpeg|jpg|gif|png)$/) != null);
                            if(res.data.file_name.match(/\.(jpeg|jpg|gif|png)$/) != null){
                                let imageTage = `<img style="width:120px;height: 120px; " src="`+ imageUrl(res.data.file_name, 120, 120, 100, 1) +`" class="selected-image{{$image_number}} img-fluid">`
                                $('#display-selected-file-{{$image_number}}').append(imageTage);
                            }else{
                                let videoTag = `<video width="320" height="240" controls muted> <source src="`+ res.data.file_name +`" type="video/mp4"> Your browser does not support the video tag. </video>`
                                $('#display-selected-file-{{$image_number}}').append(videoTag);
                            }

                            $("#selected-image-{{$image_number}}").show();
                            $("#display-selected-file-{{$image_number}}").removeAttr('style');
                            toastr.success(res.message, 'Success');
                        }
                        $('button.close').click();
                    })
                    .fail(function (res) {
                        alert('Something went wrong, please try later.');
                    });
            }
        });

        function checkURL(url) {
            return(url.match(/\.(jpeg|jpg|gif|png)$/) != null);
        }
    </script>

@endpush
