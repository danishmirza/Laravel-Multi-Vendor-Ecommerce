<?php


namespace App\Http\Controllers\API\Dashboard;


use App\Http\Controllers\Controller;
use App\Http\Resources\PackageCollection;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\StoreAreasCollection;
use App\Models\User;
use App\Services\PackageService;
use App\Services\StoreAreaService;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile()
    {
        return responseBuilder()->success('Profile', new ProfileResource(Auth::user()));
    }

    public function subscriptionPackages(PackageService $packageService)
    {
        return responseBuilder()->success('Subscriptions', new PackageCollection($packageService->getSubscriptionPackages()));
    }

    public function featurePackages(PackageService $packageService)
    {
        return responseBuilder()->success('Featured Packages', new PackageCollection($packageService->getFeaturePackages()));
    }

    public function purchasedFeaturePackages(PackageService $packageService)
    {
        return responseBuilder()->success('Purchased Packages', new PackageCollection($packageService->getPurchasedFeaturePackages(Auth::user()->id)));
    }

    public function storeAreas(StoreAreaService $storeAreaService)
    {
        return responseBuilder()->success('Store Areas', new StoreAreasCollection($storeAreaService->storeAreas(Auth::user()->id)));
    }

}
