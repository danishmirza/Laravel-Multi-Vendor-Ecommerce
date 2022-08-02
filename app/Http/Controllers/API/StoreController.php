<?php


namespace App\Http\Controllers\API;


use App\DTO\FilterServiceDTO;
use App\DTO\FilterStoreDTO;
use App\Http\Controllers\Controller;
use App\Http\Resources\PortfoliosCollection;
use App\Http\Resources\ReviewsCollection;
use App\Http\Resources\StoreAreasCollection;
use App\Http\Resources\StoreResource;
use App\Http\Resources\StoresCollection;
use App\Models\User;
use App\Services\CategoryService;
use App\Services\StoreAreaService;
use App\Services\StorePortfolioService;
use App\Services\StoreServiceService;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function __construct()
    {
        if (array_key_exists('HTTP_AUTHORIZATION', $_SERVER)) {
            $this->middleware('auth:sanctum');
        }
    }

    public function index(UserService $storeService)
    {
        try {
            $stores = new StoresCollection($storeService->searchStores(FilterStoreDTO::fromCollection(collect(request()->all()))));
            return responseBuilder()->success('Stores', $stores);
        }catch (\Exception $exception){
            return responseBuilder()->error($exception->getMessage());
        }
    }

    public function detail(User $user)
    {
        if(Auth::check()){
            $user->load(['storeReview' => function($query){
                $query->where(['user_id' => auth()->id(), 'is_given' => 0]);
            }]);
        }
        return responseBuilder()->success('Store Detail', StoreResource::make($user));
    }

    public function portfolio(User $store, StorePortfolioService $portfolioService){
        try {
            return responseBuilder()->success('Store Portfolio', new PortfoliosCollection($portfolioService->getStorePortfolio($store->id)));
        }catch (\Exception $exception){
            return responseBuilder()->error($exception->getMessage());
        }
    }

    public function reviews(User $user, StoreServiceService $storeServiceService)
    {
        try {
            $reviews = new ReviewsCollection($storeServiceService->getStoreReviews($user->id));
            return responseBuilder()->success('Store Reviews', $reviews);
        }catch (\Exception $exception){
            return responseBuilder()->error($exception->getMessage());
        }
    }

    public function areas(User $user, StoreAreaService $storeAreaService){
        try {
            $areas = new StoreAreasCollection($storeAreaService->storeAreas($user->id));
            return responseBuilder()->success('Store Areas', $areas);
        }catch (\Exception $exception){
            return responseBuilder()->error($exception->getMessage());
        }
    }

    public function categories(User $user, CategoryService $categoryService){
        try {
            $categories = $categoryService->getStoreCategories($user->id);
            return responseBuilder()->success('Store Categories', $categories);
        }catch (\Exception $exception){
            return responseBuilder()->error($exception->getMessage());
        }
    }
}
