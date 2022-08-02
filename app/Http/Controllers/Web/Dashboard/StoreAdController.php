<?php


namespace App\Http\Controllers\Web\Dashboard;


use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Services\StoreAdService;
use Illuminate\Support\Facades\Auth;

class StoreAdController extends Controller
{
    public function index(StoreAdService $storeAdService, $status)
    {
        return view('web.dashboard.store-ads.index', ['status' => $status, 'ads' => $storeAdService->storeAds(Auth::user()->id, $status)]);
    }

    public function create(Ad $ad) {
        return view('web.dashboard.store-ads.form', [
            'heading' => 'Request Ad',
            'adId' => 0,
            'route' => route('web.dashboard.store-ads.store.submit'),
            'ad' => $ad->getInitialObject(),
        ]);
    }

    public function edit(Ad $ad) {
        return view('web.dashboard.store-ads.form', [
            'heading' => 'Update Request Ad',
            'adId' => $ad->id,
            'route' => route('web.dashboard.store-ads.update.submit', ['ad' => $ad->id]),
            'ad' => $ad,
        ]);
    }
}
