<?php


namespace App\Services;


use App\Models\Ad;

class StoreAdService
{
    public function storeAds($storeId = null, $status = null, $areaId = null){
        $params = [];
        if(!is_null($storeId)){
            $params['store_id'] = $storeId;
        }
        if(!is_null($status)){
            $params['ad_status'] = $status;
        }
        $query = Ad::where($params)->whereHas('store')->with('store:id,store_name');
        if(!is_null($areaId)){
            $query->whereHas('store', function ($query) use($areaId){
                $query->whereHas('storeAreas', function ($query) use($areaId){
                    $query->where('area_id', $areaId);
                });
            });
        }
        return $query->paginate(12);
    }
}
