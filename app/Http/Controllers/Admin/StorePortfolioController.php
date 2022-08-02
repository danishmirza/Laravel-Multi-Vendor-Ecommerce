<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\User;
use App\Services\StorePortfolioService;
use Illuminate\Http\Request;

class StorePortfolioController extends Controller
{
    public function index(User $store)
    {
        $images = $store->portfolio;
        return view('admin.dashboard.store-portfolio.index', ['images' => $images, 'storeId' => $store->id]);
    }

    public function store(Request $request, User $store, StorePortfolioService $portfolioService)
    {
        try {
            $portfolioService->save($request->file('images'), $store);
            return redirect()->back()->with('status', 'Portfolio images insert successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err', $e->getMessage());
        }

    }

    public function destroy(User $store, Portfolio $portfolio)
    {
        try {
            $portfolio->delete();
            return responseBuilder()->success(__('Image deleted'));
        } catch (\Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }
}
