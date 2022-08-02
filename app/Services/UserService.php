<?php


namespace App\Services;


use App\DTO\FilterStoreDTO;
use App\DTO\SaveStoreDTO;
use App\DTO\SaveUserDTO;
use App\Models\User;

class UserService
{
    public function save(SaveUserDTO|SaveStoreDTO $userDTO, $id)
    {
        try {
            return User::updateOrCreate(['id' => $id], array_filter($userDTO->all(), function($v) { return !is_null($v);}));
        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }
    }

    public function searchStores(FilterStoreDTO $filterStoreDTO){
        $query = User::query()->stores()->whereHas('city')->with('city:id,title')->select('id', 'store_name', 'image', 'slug', 'address', 'latitude', 'longitude', 'city_id', 'average_rating');
        if(!is_null($filterStoreDTO->keyword)){
            $query->whereRaw('LOWER(store_name->>"$.en") LIKE ?', "%".strtolower($filterStoreDTO->keyword)."%");
        }
        if($filterStoreDTO->latitude > 0 && $filterStoreDTO->longitude > 0){
//            $query->select( \DB::raw('(6371*acos(cos(radians(' . $filterStoreDTO->latitude . '))*cos(radians(latitude))*cos(radians(longitude)-radians(' . $filterStoreDTO->longitude . '))+sin(radians(' . $filterStoreDTO->latitude . '))*sin(radians(latitude)))) as distance'));
            $query->whereRaw('(6371*acos(cos(radians(' . $filterStoreDTO->latitude . '))*cos(radians(latitude))*cos(radians(longitude)-radians(' . $filterStoreDTO->longitude . '))+sin(radians(' . $filterStoreDTO->latitude . '))*sin(radians(latitude)))) <= ?', 15);
        }
        if (count($filterStoreDTO->subcategories) > 0) {
            $subcategories = $filterStoreDTO->subcategories;
            $query->whereHas('services', function ($q) use ($subcategories) {
                $q->whereIn('services.subcategory_id', $subcategories);
            });
        }
        if($filterStoreDTO->areaId > 0){
            $query->whereHas('storeAreas', function ($query) use($filterStoreDTO){
                $query->where('area_id', $filterStoreDTO->areaId);
            });
        }
//        dd($query->paginate(6));
//        $query->select($select);
        return $query->paginate(6);
    }
}
