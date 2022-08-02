<?php

namespace App\Http\Controllers\Admin;

use App\DTO\SavePackageDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\SavePackageRequest;
use App\Models\Package;
use App\Services\DatatableService;
use App\Services\PackageService;

class PackageController extends Controller
{

    public function index($type)
    {

        return view('admin.dashboard.packages.index', ['type' => $type]);
    }

    public function all(DatatableService $datatableService, $type)
    {
        $packages = $datatableService->packageDatatable($type);
        return response($packages);
    }

    public function create($type, Package $package)
    {
        return view('admin.dashboard.packages.edit', [
            'packageId' => 0,
            'action' => route('admin.dashboard.packages.update', 0),
            'heading' => 'Add '.ucfirst($type).' Package',
            'id' => 0,
            'package' => $package->getInitialObject(),
            'type' => $type
        ]);
    }

    public function edit($type, $packageId)
    {
        return view('admin.dashboard.packages.edit', [
            'packageId' => $packageId,
            'action' => route('admin.dashboard.packages.update', $packageId),
            'heading' => 'Edit '.ucfirst($type).' Package',
            'id' => $packageId,
            'package' => Package::find($packageId),
            'type' => $type
        ]);
    }

    public function update(SavePackageRequest $request, $id, PackageService $packageService)
    {
        try {
            $packageService->save(SavePackageDTO::fromRequest($request), $id);
            return redirect(route('admin.dashboard.packages.index', $request->get('package_type')))->with('status', ($id == 0) ? 'Package added successfully.': 'Package updated successfully.');
        } catch (\Exception $e) {
            return response(['err'=>$e->getMessage()]);
        }

    }

    public function destroy(Package $package)
    {
        try {
            $package->delete();
            return response(['msg' => 'Deleted successfully']);
        } catch (\Exception $e) {
            return response(['err' => $e->getMessage()],400);
        }
    }
}
