<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\SaveStoreAreaRequest;
use App\Models\StoreArea;
use App\Models\City;
use App\Models\User;
use App\Services\DatatableService;
use App\Services\StoreAreaService;
use Illuminate\Session\Store;

class StoreAreaController extends Controller
{
    public function index(User $store)
    {
        return view('admin.dashboard.store-areas.index', ['storeId' => $store->id]);
    }

    public function all(DatatableService $datatableService, $storeId){
        $areas = $datatableService->storeAreasDatatable($storeId);
        return response($areas);
    }

    public function create(User $store) {
        return view('admin.dashboard.store-areas.edit', [
            'method' => 'PUT',
            'storeId' => $store->id,
            'storeAreaId' => 0,
            'action' => route('admin.dashboard.stores.areas.update', ['store' => $store->id, 'area' => 0]),
            'heading' => 'Add Store Area',
            'storeArea' => new StoreArea(),
            'areas' => City::where('parent_id', $store->city_id)->select('id','title')->get()
        ]);
    }

    public function edit(User $store, $areaId) {
        $areaStore = StoreArea::findOrFail($areaId);
        return view('admin.dashboard.store-areas.edit', [
            'method' => 'PUT',
            'storeId' => $store->id,
            'storeAreaId' => $areaStore->id,
            'action' => route('admin.dashboard.stores.areas.update', ['store' => $store->id, 'area' => $areaStore->id]),
            'heading' => 'Edit Store Area',
            'storeArea' => $areaStore,
            'areas' => City::where('parent_id', $store->city_id)->get()
        ]);
    }

    public function update(SaveStoreAreaRequest $request, User $store, $id, StoreAreaService $storeAreaService) {
        try {
            $storeAreaService->save($request->get('area_id'), $request->get('price'), $store->id, $id);
            return redirect(route('admin.dashboard.stores.areas.index', ['store' => $store->id]))->with('status', ($id == 0) ? 'Store area added successfully.': 'Store area updated successfully.');
        }
        catch (\Exception $e){
            return response(['err'=>$e->getMessage()]);
        }
    }

    public function destroy($storeId, $areaStoreId) {
        try {
            $obj = StoreArea::where(['store_id' => $storeId, 'id' => $areaStoreId])->firstOrFail();
            $obj->delete();
            return response(['msg' => 'Store Area deleted']);
        }
        catch (\Exception $e){
            return response(['err'=>$e->getMessage()]);
        }
    }
}
