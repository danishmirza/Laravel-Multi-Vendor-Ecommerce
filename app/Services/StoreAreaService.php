<?php


namespace App\Services;


use App\Models\StoreArea;

class StoreAreaService
{
    public function save($areaId, $price, $storeId, $id = 0)
    {
        try {
            return StoreArea::updateOrCreate(['id' => $id], ['area_id' => $areaId, 'price' => $price, 'store_id' => $storeId]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function storeAreas($storeId, $isPaginated = true){
        $query =  StoreArea::where(['store_id' => $storeId])->with(['area:id,title']);
        if(!$isPaginated){
            return $query->get();
        }
        return $query->paginate(10);
    }
}
