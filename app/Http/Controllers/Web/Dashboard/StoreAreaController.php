<?php


namespace App\Http\Controllers\Web\Dashboard;


use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\StoreArea;
use App\Models\User;
use App\Services\DatatableService;
use App\Services\StoreAreaService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StoreAreaController extends Controller
{
    public function index(StoreAreaService $storeAreaService)
    {
        return view('web.dashboard.store-areas.index', ['storeAreas' => $storeAreaService->storeAreas(Auth::user()->id)]);
    }

    public function create() {
        return view('web.dashboard.store-areas.form', [
            'heading' => 'Add Service Area',
            'storeAreaId' => 0,
            'route' => route('web.dashboard.store-area.create.submit'),
            'storeArea' => new StoreArea(),
            'areas' => City::where('parent_id', Auth::user()->city_id)->select('id','title')->get()
        ]);
    }

    public function edit(StoreArea $storeArea) {
        return view('web.dashboard.store-areas.form', [
            'heading' => 'Update Service Area',
            'storeAreaId' => $storeArea->id,
            'route' => route('web.dashboard.store-area.update.submit', ['store_area' => $storeArea->id]),
            'storeArea' => $storeArea,
            'areas' => City::where('parent_id', Auth::user()->city_id)->select('id', 'title')->get()
        ]);
    }
}
