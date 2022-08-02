<?php


namespace App\Http\Controllers\Web\Dashboard;


use App\DTO\FilterServiceDTO;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use App\Services\CategoryService;
use App\Services\PackageService;
use App\Services\StoreServiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreServiceController extends Controller
{
    public function index(Request $request, StoreServiceService $storeServiceService)
    {
        $showTab = 'all';
        $params = ['store_id' => Auth::user()->id];
        if($request->filled('offered')){
            $showTab = 'offered';
            $params['is_offered'] = 1;
        }elseif ($request->filled('featured')){
            $showTab = 'featured';
            $params['is_featured'] = 1;
        }
        $services = $storeServiceService->filterServices(new FilterServiceDTO($params));
        return view('web.dashboard.store-services.index', ['services' => $services, 'showTab' => $showTab]);
    }

    public function create(CategoryService $categoryService, PackageService $packageService, Service $service) {
        return view('web.dashboard.store-services.form', [
            'heading' => 'Add Service',
            'route' => route('web.dashboard.store-services.create.submit'),
            'serviceId' => 0,
            'service' => $service->getInitialObject(),
            'categories' => $categoryService->getAllCategoriesWithSubcategories(),
            'packages' => $packageService->getPurchasedFeaturePackages(Auth::user()->id)
        ]);
    }

    public function edit(CategoryService $categoryService, PackageService $packageService, Service $service) {
        return view('web.dashboard.store-services.form', [
            'heading' => 'Update Service',
            'route' => route('web.dashboard.store-services.update.submit', ['service' => $service->id]),
            'serviceId' => $service->id,
            'service' => $service,
            'categories' => $categoryService->getAllCategoriesWithSubcategories(),
            'packages' => $packageService->getPurchasedFeaturePackages(Auth::user()->id)
        ]);
    }
}