<?php


namespace App\Http\Controllers\Admin;


use App\DTO\SaveServiceDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveServiceRequest;
use App\Models\Category;
use App\Models\Service;
use App\Models\User;
use App\Services\DatatableService;
use App\Services\StoreServiceService;


class ServiceController extends Controller
{
    public function allServices(User $store)
    {
        return view('admin.dashboard.services.index', ['storeId'=> 0]);
    }
    public function index(User $store)
    {
        return view('admin.dashboard.services.index', ['storeId'=> $store->id]);
    }

    public function all(DatatableService $datatableService, $storeId = 0)
    {
        $articles = $datatableService->servicesDatatable($storeId);
        return response($articles);
    }

    public function create(User $store, Service $service)
    {
        return view('admin.dashboard.services.edit', [
            'heading' => 'Add Service',
            'action' => route('admin.dashboard.stores.services.update', ['store' => $store->id, 'service' => 0]),
            'service' => $service->getInitialObject(),
            'serviceId' => 0,
            'storeId' => $store->id,
            'categories' => Category::parent()->select('id','title', 'parent_id')->with('subcategories:id,title')->get()
        ]);
    }

    public function edit(User $store, Service $service)
    {
        return view('admin.dashboard.services.edit', [
            'heading' => 'Edit Service',
            'action' => route('admin.dashboard.stores.services.update', ['store' => $store->id, 'service' => $service->id]),
            'service' => $service,
            'serviceId' => $service->id,
            'storeId' => $store->id,
            'categories' => Category::parent()->select('id','title', 'parent_id')->with('subcategories:id,title,parent_id')->get()
        ]);
    }

    public function update(SaveServiceRequest $request, User $store, $id, StoreServiceService $storeServiceService)
    {
        try {
            $storeServiceService->save(SaveServiceDTO::fromRequest($request), $store->id, $id);
            return redirect(route('admin.dashboard.stores.services.index', ['store' => $store->id]))->with('status', ($id == 0) ? 'Service added successfully.': 'Service updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err', $e->getMessage());
        }
    }

    public function destroy(User $store, Service $service)
    {
        try {
            $service->delete();
            return response(['msg' => 'Successfully deleted']);
        }catch (\Exception $e){
            return response(['err' => $e->getMessage()], 400);
        }

    }
}
