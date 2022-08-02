<?php


namespace App\Actions\Dashboard\StoreArea;


use App\Models\StoreArea;
use App\Rules\CheckStoreAreaDuplicateRule;
use Illuminate\Auth\Access\Response;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateStoreArea
{
    use AsAction;

    public function handle($data)
    {
        try {
            StoreArea::create([
                'area_id' => $data['area_id'],
                'price' => $data['price'],
                'store_id' => Auth::user()->id
            ]);
            return ['action' => 'status', 'msg' => 'Service area created successfully.'];
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
                'exists:cities,id,parent_id,'.Auth::user()->city_id,
                new CheckStoreAreaDuplicateRule(0, Auth::user()->id)
            ],
            'price' => 'required|integer|min:1'
        ];
    }

    public function authorize(ActionRequest $request): Response
    {
        if ($request->user()->isUser()) {
            return Response::deny('You are not allowed to perform this action', 404);
        }
        return Response::allow();
    }

    public function asController(ActionRequest $request)
    {
        $request->validated();
        $data = $request->only( 'area_id', 'price');
        return $this->handle($data);

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
        $router->post('dashboard/store-areas/create', static::class)->name('dashboard.store-area.create.submit');
    }
}
