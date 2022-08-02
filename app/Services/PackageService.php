<?php


namespace App\Services;


use App\DTO\SavePackageDTO;
use App\Models\Package;

class PackageService
{
    public function save(SavePackageDTO $packageDTO, $id)
    {
        try {
            return Package::updateOrCreate(['id' => $id], $packageDTO->all());
        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }
    }

    public function getSubscriptionPackages(){
        return Package::subscriptions()->paginate(12);
    }

    public function getFeaturePackages(){
        return Package::featured()->paginate(12);
    }

    public function getPurchasedFeaturePackages($storeId){
        $callBack = function ($query) use($storeId){
            $query->where(['store_id' => $storeId, 'package_status' => 'purchased']);
        };
        return Package::featured()
            ->whereHas('purchasedPackages', $callBack)
            ->withCount(['purchasedPackages'=> $callBack])
            ->withTrashed()
            ->paginate(12);
    }
}
