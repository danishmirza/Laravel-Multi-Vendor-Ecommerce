<?php


namespace App\Actions\Dashboard\Addresses;


use App\Models\Address;
use Illuminate\Auth\Access\Response;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateAddress
{
    use AsAction;

    public function handle($name, $phone, $city_id, $area_id, $address, $latitude, $longitude, $detail, $id)
    {
        try {
            Address::where(['id' => $id])->update([
                'area_id' => $area_id,
                'city_id' => $city_id,
                'name' => $name,
                'phone' => $phone,
                'address' => $address,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'detail' => $detail
            ]);
            return ['action' => 'status', 'msg' => 'Address updated successfully.'];
        }catch (\Exception $exception){
            return ['action' => 'err', 'msg' => $exception->getMessage()];
        }
    }

    public function getControllerMiddleware(): array
    {
        return ['auth:sanctum', 'verified'];
    }

    public function rules(ActionRequest $request)
    {
        return [
            'city_id' => 'required|exists:cities,id',
            'area_id' => [
                'required',
                'exists:cities,id,parent_id,'.$request->get('city_id'),
            ],
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ];
    }

    public function withValidator(Validator $validator, ActionRequest $request): void
    {
        $validator->after(function (Validator $validator) use ($request) {
            if ($request->filled('city_id') &&
                $request->filled('city_id') &&
                $request->filled('area_id') &&
                $request->filled('longitude') &&
                $request->filled('latitude') &&
                !checkPolygon(
                    $request->get('city_id'),
                    $request->get('area_id'),
                    $request->get('longitude'),
                    $request->get('latitude')
                )
            ){

                $validator->errors()->add('address', 'Address is not inside the selected area.');
            }
        });
    }

    public function authorize(ActionRequest $request): Response
    {
        if ($request->user()->isStore()) {
            return Response::deny('You are not authorized to perform this action.', 404);
        }
        if ($request->user()->id != $request->mainAddress->user_id) {
            return Response::deny('You are not authorize to update this address.', 404);
        }
        return Response::allow();
    }

    public function asController(ActionRequest $request, Address $mainAddress)
    {
        $request->validated();
        return $this->handle(
            $request->get('name'),
            $request->get('phone'),
            $request->get('city_id'),
            $request->get('area_id'),
            $request->get('address'),
            $request->get('latitude'),
            $request->get('longitude'),
            $request->get('detail'),
            $mainAddress->id,
        );

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
        $router->post('dashboard/addresses/update/{mainAddress}', static::class)->name('dashboard.addresses.update.submit');
    }
}
