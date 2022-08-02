<?php


namespace App\Http\Controllers\Web\Dashboard;


use App\Http\Controllers\Controller;
use App\Services\StorePortfolioService;
use Illuminate\Support\Facades\Auth;

class StorePortfolioController extends Controller
{
    public function index(StorePortfolioService $storePortfolioService)
    {
        return view('web.dashboard.store-portfolio.index', ['images' => $storePortfolioService->getStorePortfolio(Auth::user()->id)]);
    }

    public function create() {
        return view('web.dashboard.store-portfolio.form');
    }
}
