<?php

namespace App\Http\Controllers\Admin;

use App\DTO\SaveCityAreaDTO;
use App\Http\Controllers\Controller;
use App\Http\Repositories\CityRepository;
use App\Http\Requests\SaveCityAreaRequest;
use App\Http\Requests\CityRequest;
use App\Models\City;
use App\Services\CityAreaService;
use Exception;
use http\Env\Request;

class CityController extends Controller
{
    public function index(CityAreaService $cityAreaService)
    {
        $cities = $cityAreaService->getAllCitiesWithAreas();
        return view('admin.dashboard.cities.index', ['cities' => $cities]);
    }

    public function create(City $city)
    {
        return view('admin.dashboard.cities.edit', [
            'heading' => 'Add City',
            'cityId' => 0,
            'city' => $city->getInitialObject(),
            'action' => route('admin.dashboard.cities.update', 0),
        ]);
    }

    public function edit(City $city)
    {
        return view('admin.dashboard.cities.edit', [
            'heading' => 'Edit City',
            'cityId' => $city->id,
            'city' => $city,
            'action' => route('admin.dashboard.cities.update', $city->id),
        ]);
    }


    public function update(SaveCityAreaRequest $request, $id, CityAreaService $cityAreaService)
    {
        try {
            $cityAreaService->save(SaveCityAreaDTO::fromRequest($request), 0, $id);
            return redirect(route('admin.dashboard.cities.index'))->with('status', ($id == 0) ? 'City added successfully.': 'City updated successfully.');
        } catch (\Exception $e) {
            return response(['err'=>$e->getMessage()]);
        }

    }

    public function destroy(City $city)
    {
        try {
            $city->delete();
            return response(['msg' => 'City deleted Successfully']);
        } catch (\Exception $e) {
            return response(['err' => 'Unable to delete'], 400);
        }
    }
}
