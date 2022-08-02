<?php


namespace App\Http\Controllers\API;


use App\DTO\FilterServiceDTO;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewsCollection;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\ServicesCollection;
use App\Models\Service;
use App\Models\User;
use App\Services\StoreServiceService;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function __construct()
    {
        if (array_key_exists('HTTP_AUTHORIZATION', $_SERVER)) {
            $this->middleware('auth:sanctum');
        }
    }

    public function search(StoreServiceService $storeServiceService){
        try {
            $services = new ServicesCollection($storeServiceService->filterServices(FilterServiceDTO::fromCollection(collect(\request()->all()))));
            return responseBuilder()->success('success', $services);
        }catch (\Exception $exception){
            return responseBuilder()->error($exception->getMessage());
        }
    }

    public function detail(Service $service)
    {
        if(Auth::check()){
            $service->load(['serviceReview' => function($query){
                $query->where(['user_id' => auth()->id(), 'is_given' => 0]);
            }]);
        }
        $service->load(['category:id,title', 'subcategory:id,title', 'store:id,store_name,slug,image,average_rating,address,latitude,longitude']);
        return responseBuilder()->success('Service', ServiceResource::make($service));
    }

    public function reviews(Service $service, StoreServiceService $storeServiceService)
    {
        try {
            $reviews = new ReviewsCollection($storeServiceService->getServiceReviews($service->id));
            return responseBuilder()->success('Store Reviews', $reviews);
        }catch (\Exception $exception){
            return responseBuilder()->error($exception->getMessage());
        }
    }

}
