$(document).ready(function() {
    $(".toggle-password").click(function () {
        var input = $($(this).data("toggle"));
        var iTag = $($(this).data("toggle-i"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
            iTag.removeClass("fa-eye");
            iTag.addClass("fa-eye-slash");
        } else {
            input.attr("type", "password");
            iTag.removeClass("fa-eye-slash");
            iTag.addClass("fa-eye");

        }
    });

    $('.delete-confirm').on('click', function (event) {
        console.log(1111)
        event.preventDefault();
        const url = $(this).attr('href');
        console.log(url)
        const message = $(this).attr('data-message');
        Swal.fire({
            title: 'Are you sure?',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Continue',
        }).then(function(value) {
            console.log(value);
            if (value.isConfirmed) {
                window.location.href = url;
            }else{

            }
        });
    });
});


function imageUrl(path, width, height, quality, crop) {
    if (typeof (width) === 'undefined')
        width = null;
    if (typeof (height) === 'undefined')
        height = null;
    if (typeof (quality) === 'undefined')
        quality = null;
    if (typeof (crop) === 'undefined')
        crop = null;

    var basePath = window.Laravel.base;
    var url = null;
    if (!width && !height) {
        url = path;
    } else {
        // url = basePath + '/images/timthumb.php?src=' +basePath+ path; // IMAGE_LOCAL_PATH
        url = basePath + '/images/timthumb.php?src='+ path; // IMAGE_LIVE_PATH
        if (width !== null) {
            url += '&w=' + width;
        }
        if (height !== null && height > 0) {
            url += '&h=' + height;
        }
        if (crop !== null) {
            url += "&zc=" + crop;
        } else {
            url += "&zc=1";
        }
        if (quality !== null) {
            url += '&q=' + quality + '&s=1';
        } else {
            url += '&q=95&s=1';
        }
    }
    return url;
}
