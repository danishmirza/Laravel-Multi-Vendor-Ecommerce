<?php

use Illuminate\Support\Facades\File;


function moveImage($image, $directory){
    if (file_exists( public_path().'/' . $image)) {
        $imageStringExploded = explode('/', $image);
        $movesTo = 'uploads/'.$directory.'/'.$imageStringExploded[count($imageStringExploded)-1];
        File::move(public_path($image), public_path($movesTo));
        return $movesTo;
    }else{
        return '';
    }
}
function removeImage($image){
    if(file_exists( public_path().'/' . $image)){
        File::delete(public_path().'/' . $image);
    }
    return true;
}
