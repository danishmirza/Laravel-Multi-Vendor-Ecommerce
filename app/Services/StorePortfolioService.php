<?php


namespace App\Services;


use App\Libraries\Uploader;
use App\Models\Portfolio;

class StorePortfolioService
{

    public function getStorePortfolio($storeId){
        return Portfolio::where(['store_id' => $storeId])->paginate(20);
    }

    public function save($images, $store)
    {
        try {
            $uploader = new Uploader();
            if (count($images) > 0) {
                foreach ($images as $key => $img) {
                    $uploader->setFile($img);
                    if ($uploader->isValidFile()) {
                        $uploader->upload('store-portfolio', $uploader->fileName);
                        if ($uploader->isUploaded()) {
                            $productImages[] = new Portfolio([
                                'image' => $uploader->getUploadedPath(),
                            ]);
                        }
                    }
                    if (!$uploader->isUploaded()) {
                        throw new \Exception(__('Something went wrong'));
                    }
                }
            }
            if (count($productImages) > 0) {
                $store->portfolio()->saveMany($productImages);
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

    }

}
