<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\User;
use App\Notifications\AdRequestStatusChanged;
use App\Services\DatatableService;

class StoreAdController extends Controller
{
    public function allAds()
    {
        return view('admin.dashboard.store-ads.index', ['storeId' => 0]);
    }

    public function index(User $store)
    {
        return view('admin.dashboard.store-ads.index', ['storeId' => $store->id]);
    }

    public function all(DatatableService $datatableService, $storeId = 0)
    {
        $articles = $datatableService->storeAdDatatable($storeId);
        return response($articles);
    }

    public function show(User $store, Ad $ad) {
        return view('admin.dashboard.store-ads.edit', [
            'storeId' => $store->id,
            'adId' => $ad->id,
            'heading' => 'View Ad',
            'ad' => $ad,
        ]);
    }


    public function changeStatus(User $store, Ad $ad, $status)
    {
        try {

            $ad->update(['ad_status' => $status]);
            $store->notify(new AdRequestStatusChanged($status, $ad->id));
            if(!request()->has('page')){
                return responseBuilder()->success('Status change successfully');
            }
            return redirect()->back()->with('status', 'Status change successfully');
        } catch (\Exception $e) {
            if(!request()->has('page')) {
                return responseBuilder()->error($e->getMessage());
            }
        }

    }
}
