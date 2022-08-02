<?php


namespace App\Http\Controllers\Admin;


use App\DTO\SaveCityAreaDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveCityAreaRequest;
use App\Models\City;
use App\Services\CityAreaService;

class AreaController extends Controller
{

    public function create($cityId, City $area)
    {
        return view('admin.dashboard.areas.edit', [
            'heading' => 'Add Area',
            'areaId' => 0,
            'area' => $area->getInitialObject(),
            'action' => route('admin.dashboard.cities.areas.update', ['city' => $cityId, 'area' => 0]),
        ]);
    }

    public function edit($cityId, City $area)
    {
        return view('admin.dashboard.areas.edit', [
            'heading' => 'Edit Area',
            'areaId' => $area->id,
            'area' => $area,
            'action' => route('admin.dashboard.cities.areas.update',['city' => $cityId, 'area' => $area->id]),
        ]);
    }


    public function update(SaveCityAreaRequest $request, $cityId, $id, CityAreaService $cityAreaService)
    {
        try {
            $cityAreaService->save(SaveCityAreaDTO::fromRequest($request), $cityId, $id);
            return redirect(route('admin.dashboard.cities.index'))->with('status', ($id == 0) ? 'Area added successfully.': 'Area updated successfully.');
        } catch (\Exception $e) {
            return response(['err'=>$e->getMessage()]);
        }

    }

    public function destroy($cityId, City $area)
    {
        try {
            $area->delete();
            return response(['msg' => 'Area deleted Successfully']);
        } catch (\Exception $e) {
            return response(['err' => 'Unable to delete'], 400);
        }
    }
}
