<?php

namespace App\Actions\Dashboard\StoreArea;

use App\Models\StoreArea;
use App\Models\User;
use App\Rules\CheckStoreAreaDuplicateRule;
use Illuminate\Auth\Access\Response;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateStoreArea
{
    use AsAction;

    public function handle($data, $id)
    {
        try {
            StoreArea::where(['id' => $id])->firstOrFail()->update([
                'area_id' => $data['area_id'],
                'price' => $data['price'],
            ]);
            return ['action' => 'status', 'msg' => 'Service area updated successfully.'];
        }catch (\Exception $exception){
            return ['action' => 'err', 'msg' => $exception->getMessage()];
        }
    }

    public function getControllerMiddleware(): array
    {
        return ['auth:sanctum', 'verified', 'subscribed'];
    }

    public function rules(ActionRequest $request)
    {
        return [
            'area_id' => [
                'required',
                'exists:cities,id,parent_id,'.$request->user()->city_id,
                new CheckStoreAreaDuplicateRule($request->store_area->id, $request->user()->id)
            ],
            'price' => 'required|integer|min:1'
        ];
    }

    public function authorize(ActionRequest $request): Response
    {
        if ($request->user()->isUser()) {
            return Response::deny('You are not allowed to perform this action', 404);
        }
        if ($request->user()->id != $request->store_area->store_id) {
            return Response::deny('You are not authorize to update this delivery area.', 404);
        }
        return Response::allow();
    }

    public function asController(ActionRequest $request, StoreArea $storeArea)
    {
        $request->validated();
        $data = $request->only( 'area_id', 'price');
        return $this->handle($data, $storeArea->id);
    }

    public function htmlResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return redirect()->back()->withInput()->with($paramters['action'], $paramters['msg']);
        }
        return redirect(route('web.dashboard.store-areas.index'))->with($paramters['action'], $paramters['msg']);
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
        $router->post('dashboard/store-areas/update/{store_area}', static::class)->name('dashboard.store-area.update.submit');
    }
}
