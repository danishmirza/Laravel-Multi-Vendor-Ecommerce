<?php


namespace App\Services;


use App\DTO\SaveServiceDTO;
use App\DTO\FilterServiceDTO;
use App\Models\Service;
use App\Models\ServiceReview;
use App\Models\StoreReview;

class StoreServiceService
{
    public function save(SaveServiceDTO $serviceDTO, $storeId, $id)
    {
        try {
            $data = array_filter($serviceDTO->all(), function($v) { return !is_null($v);});
            $data['store_id'] = $storeId;
            return Service::updateOrCreate(['id' => $id], $data);
        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }
    }

    public function filterServices(FilterServiceDTO $serviceDTO){
        $query = Service::query()
            ->select('id','store_id', 'title', 'average_rating', 'image', 'package_id', 'has_offer',
                'price','discount_percentage')
            ->selectRaw('(price - (price * discount_percentage / 100)) AS actual_price')
            ->whereHas('store')
            ->with('store:id,store_name,slug');
        if(!is_null($serviceDTO->keyword)){
            $query->whereRaw('LOWER(title->>"$.en") LIKE ?', "%".strtolower($serviceDTO->keyword)."%");
        }
        if(!is_null($serviceDTO->store_id)){
            $query->where('store_id', $serviceDTO->store_id);
        }
        if(!is_null($serviceDTO->is_featured)){
            $query->where('package_id', '>', 0);
        }
        if(!is_null($serviceDTO->is_offered)){
            $query->where('has_offer', '>', 0);
        }

        if(!is_null($serviceDTO->category_id)){
            $query->where('category_id',$serviceDTO->category_id);
        }
        if(!is_null($serviceDTO->subcategory_id)){
            $query->where('subcategory_id',$serviceDTO->subcategory_id);
        }
        if(count($serviceDTO->subcategories) > 0){
//            dd($serviceDTO->all());
            $query->whereIn('subcategory_id',$serviceDTO->subcategories);
        }
        if(!is_null($serviceDTO->min_price) && is_null($serviceDTO->max_price)){
            $query->whereRaw('(price - (price * discount_percentage / 100)) >= ?',$serviceDTO->min_price);
        }
        if(is_null($serviceDTO->min_price) && !is_null($serviceDTO->max_price)){
            $query->whereRaw('(price - (price * discount_percentage / 100)) <= ?',$serviceDTO->max_price);
        }
        if(!is_null($serviceDTO->min_price) && !is_null($serviceDTO->max_price)){
            $query->whereRaw('(price - (price * discount_percentage / 100)) between ? and ?', [$serviceDTO->min_price, $serviceDTO->max_price]);
        }
        if (!is_null($serviceDTO->areaId)){
            $areaId = $serviceDTO->areaId;
            $query->whereHas('store', function ($query) use($areaId){
               $query->whereHas('storeAreas', function ($query) use($areaId){
                   $query->where('area_id', $areaId);
               });
            });
        }
//        dd($query->paginate(10));
        return $query->paginate(10);
    }

    public function getStoreReviews($storeId){
        return StoreReview::whereHas('user')->with('user:id,name,image')
            ->where('store_id', $storeId)
            ->where('is_given', 1)
            ->select('id', 'user_id', 'rating', 'comment', 'updated_at')
            ->orderByDesc('updated_at')
            ->paginate(5);
    }

    public function getServiceReviews($serviceId){
        return ServiceReview::whereHas('user')->with('user:id,name,image')
            ->where('service_id', $serviceId)
            ->where('is_given', 1)
            ->select('id', 'user_id', 'rating', 'comment', 'updated_at')
            ->orderByDesc('updated_at')
            ->paginate(5);
    }
}
