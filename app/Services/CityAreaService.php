<?php


namespace App\Services;


use App\DTO\SaveCityAreaDTO;
use App\Models\City;

class CityAreaService
{

    public function getAllCitiesWithAreas(){
        return City::with('areas:id,title,parent_id,polygon')->select('id', 'title')->where('parent_id', 0)->get();
    }

    public function save(SaveCityAreaDTO $cityAreaDTO, $parentId, $id)
    {
        try {
            $data = $cityAreaDTO->all();
            $data['parent_id'] = $parentId;
            return City::updateOrCreate(['id' => $id], $data);
        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }
    }

}
