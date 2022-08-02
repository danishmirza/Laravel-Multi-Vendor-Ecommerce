<?php


namespace App\Actions\Dashboard\Addresses;


use App\Models\Address;
use App\Models\StoreArea;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteAddress
{
    use AsAction;

    public function handle($id)
    {
        try {
            Address::where(['id' => $id, 'user_id' => Auth::user()->id])->firstOrFail()->delete();
            return ['action' => 'status', 'msg' => 'Address deleted successfully.'];
        }catch (ModelNotFoundException $exception){
            return ['action' => 'err', 'msg' => 'No result found'];
        }catch (\Exception $exception){
            return ['action' => 'err', 'msg' => $exception->getMessage()];
        }
    }


    public function authorize(ActionRequest $request): Response
    {
        if ($request->user()->isStore()) {
            return Response::deny('You are not authorized to perform this action.', 404);
        }
        if ($request->user()->id != $request->address->user_id) {
            return Response::deny('You are not authorize to delete this address.', 404);
        }
        return Response::allow();
    }

    public function getControllerMiddleware(): array
    {
        return ['auth:sanctum', 'verified'];
    }

    public function asController(Address $address)
    {
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
        $router->get('dashboard/addresses/delete/{address}', static::class)->name('dashboard.addresses.delete');
    }
}
