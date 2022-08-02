<?php


namespace App\Actions\Dashboard\Addresses;


use App\Http\Resources\AddressesCollection;
use App\Models\Address;
use Illuminate\Auth\Access\Response;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class AddressListing
{
    use AsAction;

    public function handle($request)
    {
        $perpage =  $request->get('perpage', 15);
        $page =  $request->get('page', 1);
        $cityId =  $request->get('city_id', null);
        $areaId =  $request->get('area_id', null);
        $filter = ['user_id' => \auth()->id()];
        if(!is_null($cityId)){
            $filter['city_id'] = $cityId;
        }
        if(!is_null($areaId)){
            $filter['area_id'] = $areaId;
        }
        $addresses = Address::where($filter)->with(['city:id,title', 'area:id,title'])->orderBy('updated_at', 'desc')->paginate($perpage, ['*'], 'page', $page);
        return $addresses;
    }

    public function getControllerMiddleware(): array
    {
        return ['auth:sanctum', 'verified'];
    }

    public function authorize(ActionRequest $request): Response
    {
        if ($request->user()->isStore()) {
            return Response::deny('You are not authorized to perform this action.', 404);
        }
        return Response::allow();
    }


    public function asController(ActionRequest $request)
    {
        return $this->handle($request);

    }

    public function jsonResponse($paramters)
    {
        return responseBuilder()->success('Addresses', new AddressesCollection($paramters));
    }

    public static function routes(Router $router)
    {
        $router->get('dashboard/addresses', static::class)->name('dashboard.addresses');
    }
}
