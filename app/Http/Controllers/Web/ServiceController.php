<?php


namespace App\Http\Controllers\Web;


use App\DTO\FilterServiceDTO;
use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceReview;
use App\Services\CategoryService;
use App\Services\StoreAreaService;
use App\Services\StoreServiceService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ServiceController extends Controller
{
    public function index(StoreServiceService $storeServiceService, CategoryService $categoryService)
    {
        $data = request()->all();
        if(Session::has('client_area')){
            $data['area_id'] =  Session::get('client_area');
        }
        return view('web.front.services.index', [
            'services' => $storeServiceService->filterServices(FilterServiceDTO::fromCollection(collect($data))),
            'categories' => $categoryService->getAllCategoriesWithSubcategories(),
            'route' => 'web.front.services'
        ]);
    }

    public function offered(StoreServiceService $storeServiceService, CategoryService $categoryService)
    {
        $data = request()->all();
        if(Session::has('client_area')){
            $data['area_id'] =  Session::get('client_area');
        }
        $data['is_offered'] = 1;
        return view('web.front.services.index', [
            'services' => $storeServiceService->filterServices(FilterServiceDTO::fromCollection(collect($data))),
            'categories' => $categoryService->getAllCategoriesWithSubcategories(),
            'route' => 'web.front.offered-services'
        ]);
    }

    public function detail(Service $service, StoreServiceService $serviceService, StoreAreaService $storeAreaService)
    {
        if(Auth::check()){
            $service->load(['serviceReview' => function($query){
                $query->where(['user_id' => auth()->id(), 'is_given' => 0]);
            }]);
        }
        $service->whereHas('category')->whereHas('subcategory')->whereHas('store');
        $service->load(['category:id,title', 'subcategory:id,title', 'store:id,store_name,slug,image,average_rating,address,latitude,longitude']);
        $reviews = $serviceService->getServiceReviews($service->id);
        $storeAreas = $storeAreaService->storeAreas($service->store->id, false);
        return view('web.front.services.detail', ['service' => $service, 'reviews' => $reviews, 'storeAreas' => $storeAreas]);
    }
}
