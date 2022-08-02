<?php


namespace App\Services;


use App\Libraries\Uploader;

class UploaderService
{
    /**
     * @throws \Exception
     */
    function uploadImage($file, $path = 'media', $input = 'image')
    {
        try {
            $imageUploadedPath = '';
            $uploader = new Uploader();
            $uploader->setFile($file);
            if ($uploader->isValidFile()) {
                $uploader->upload($path, $uploader->fileName);
                if ($uploader->isUploaded()) {
                    $imageUploadedPath = $uploader->getUploadedPath();
                }
            }
            if (!$uploader->isUploaded()) {
                throw new \Exception(__('Something went wrong'));
            }
            $data['file_name'] = $imageUploadedPath;
            $data['file_path'] = url($imageUploadedPath);

            return $data;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
