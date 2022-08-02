<?php


namespace App\Http\Controllers\Web;


use App\DTO\FilterServiceDTO;
use App\DTO\FilterStoreDTO;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\CategoryService;
use App\Services\StorePortfolioService;
use App\Services\StoreServiceService;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class StoreController extends Controller
{
    public function index(UserService $storeService, CategoryService $categoryService)
    {
        $data = request()->all();
        if(Session::has('client_area')){
            $data['area_id'] =  Session::get('client_area');
        }
        return view('web.front.stores.index', [
            'stores' => $storeService->searchStores(FilterStoreDTO::fromCollection(collect($data))),
            'categories' => $categoryService->getAllCategoriesWithSubcategories()
        ]);
    }

    public function detail(User $user, StoreServiceService $storeServiceService)
    {
        return view('web.front.stores.detail', [
            'store' => $user,
            'services' => $storeServiceService->filterServices(FilterServiceDTO::fromCollection(collect(['store_id' => $user->id]))),
        ]);
    }

    public function portfolio(User $user, StorePortfolioService $portfolioService)
    {
        return view('web.front.stores.portfolio', [
            'store' => $user,
            'images' => $portfolioService->getStorePortfolio($user->id)
        ]);
    }

    public function reviews(User $user, StoreServiceService $storeServiceService)
    {
        if(Auth::check()){
            $user->load(['storeReview' => function($query){
                $query->where(['user_id' => auth()->id(), 'is_given' => 0]);
            }]);
        }

        return view('web.front.stores.reviews', [
            'store' => $user,
            'reviews' => $storeServiceService->getStoreReviews($user->id)
        ]);
    }
}
