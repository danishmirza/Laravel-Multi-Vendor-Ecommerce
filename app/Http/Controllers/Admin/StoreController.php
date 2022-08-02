<?php


namespace App\Http\Controllers\Admin;


use App\DTO\SaveStoreDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveStoreRequest;
use App\Models\Category;
use App\Models\City;
use App\Models\User;
use App\Services\DatatableService;
use App\Services\UserService;

class StoreController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.stores.index');
    }

    public function all(DatatableService $datatableService)
    {
        $users = $datatableService->storeDatatable();
        return response($users);
    }

    public function create(User $store)
    {
        return view('admin.dashboard.stores.edit', [
            'storeId' => 0,
            'action' => route('admin.dashboard.stores.update', 0),
            'heading' => 'Add Supplier',
            'store' => $store->getInitialObject(),
            'cities' => City::where('parent_id', 0)->get(),
        ]);
    }

    public function edit(User $store)
    {
        return view('admin.dashboard.stores.edit', [
            'storeId' => $store->id,
            'action' => route('admin.dashboard.stores.update', $store->id),
            'heading' => 'Edit Supplier',
            'store' => $store,
            'cities' => City::where('parent_id', 0)->get(),
        ]);
    }

    public function update(SaveStoreRequest $request, $id, UserService $userService)
    {
        try {
            $userService->save(SaveStoreDTO::fromRequest($request), $id);
            return redirect(route('admin.dashboard.stores.index'))->with('status', ($id == 0) ? 'Supplier added successfully.' : 'Supplier updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err', $e->getMessage());
        }
    }

    public function destroy(User $store)
    {
        try {
            $store->delete();
            return response(['msg' => 'Supplier deleted']);
        } catch (\Exception $e) {
            return response(['err' => $e->getMessage()]);
        }
    }
}
