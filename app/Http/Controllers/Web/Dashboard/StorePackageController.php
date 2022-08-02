<?php


namespace App\Http\Controllers\Web\Dashboard;


use App\Http\Controllers\Controller;
use App\Services\PackageService;
use Illuminate\Support\Facades\Auth;

class StorePackageController extends Controller
{
    public function index(PackageService $packageService)
    {
        return view('web.dashboard.store-feature-packages.index', ['packages' => $packageService->getFeaturePackages()]);
    }

    public function purchased(PackageService $packageService)
    {
//        dd($packageService->getPurchasedFeaturePackages(Auth::user()->id));
        return view('web.dashboard.store-feature-packages.purchased', ['packages' => $packageService->getPurchasedFeaturePackages(Auth::user()->id)]);
    }
}