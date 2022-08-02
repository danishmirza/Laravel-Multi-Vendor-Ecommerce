<?php


namespace App\Actions\Dashboard\Addresses;


use App\Models\Address;
use Illuminate\Auth\Access\Response;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class DefaultAddress
{
    use AsAction;

    public function handle($addressId)
    {
        try {
            \auth()->user()->update(['default_address_id' => $addressId]);
            return ['action' => 'status', 'msg' => 'Default address selected.'];
        }catch (\Exception $exception){
            return ['action' => 'err', 'msg' => $exception->getMessage()];
        }
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



    public function asController(Address $address)
    {
//        $request->validated();
        return $this->handle($address->id);

    }

    public function jsonResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return responseBuilder()->error($paramters['msg']);
        }
        return responseBuilder()->success($paramters['msg']);
    }

    public static function routes(Router $router)
    {
        $router->get('dashboard/addresses/default/{address}', static::class)->name('dashboard.addresses.default');
    }
}