<?php

function imageUrl($path, $width = NULL, $height = NULL, $quality = NULL, $crop = NULL)
{
    if(is_null($path) || !file_exists(public_path().'/' .$path)){
        return 'https://via.placeholder.com/'.$width.'x'.$height.'?text=Placeholder+Image';
//        $path = 'images/default-image.jpg';
    }

    if (!$width && !$height) {
        return $url = env('IMAGE_URL') . $path;
    } else {
        if (is_string($path)) {
            if (str_contains($path, url('/'))) {
                $path = str_replace(url('/'), '', $path);
            }
//            $url = env('APP_URL') . '/images/timthumb.php?src=' . env('APP_URL') . $path; // for IMAGE_LOCAL_PATH
            $url = env('APP_URL') . '/images/timthumb.php?src='. $path; // for IMAGE_LIVE_PATH
            if (isset($width)) {
                $url .= '&w=' . $width;
            }
            if (isset($height) && $height > 0) {
                $url .= '&h=' . $height;
            }
            if (isset($crop)) {
                $url .= "&zc=" . $crop;
            } else {
                $url .= "&zc=1";
            }
            if (isset($quality)) {
                $url .= '&q=' . $quality . '&s=0';
            } else {
                $url .= '&q=95&s=0';
            }
            return $url;
        }
    }
}
