<?php

namespace App\Actions\Dashboard\StoreServices;

use App\Actions\Dashboard\StorePackage\AssignFeaturePackage;
use App\DTO\SaveServiceDTO;
use App\Models\Service;
use Illuminate\Auth\Access\Response;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateService
{
    use AsAction;

    public function handle(SaveServiceDTO $serviceDTO, $id)
    {
        DB::beginTransaction();
        try {
            $data = array_filter($serviceDTO->all(), function($v) { return !is_null($v);});
            unset($data['package_id']);
            $service = Service::where(['id' => $id])->firstOrFail();
               $service->update($data);
            if(!is_null($serviceDTO->package_id)){
                AssignFeaturePackage::run($serviceDTO->package_id, $service);
            }
            DB::commit();
            return ['action' => 'status', 'msg' => 'Service updated successfully.'];
        }catch (\Exception $exception){
            DB::rollBack();
            return ['action' => 'err', 'msg' => $exception->getMessage()];
        }
    }

    public function getControllerMiddleware(): array
    {
        return ['auth:sanctum', 'verified', 'subscribed'];
    }

    public function authorize(ActionRequest $request): Response
    {
        if ($request->user()->id != $request->service->store_id) {
            return Response::deny('You are not authorize to update this service.');
        }
        return Response::allow();
    }

    public function rules(ActionRequest $request)
    {
        $rules = [
            'subcategory_id' => 'required|exists:categories,id',
            'title' => 'required|array|min:2|max:2',
            'title.en' => 'required',
            'price' => 'required|min:1',
//            'is_active' => 'required',
            'content' => 'required|array|min:2|max:2',
            'content.en' => 'required',
        ];
        if($request->has('has_offer') && $request->get('has_offer') > 0){
            $rules['discount_percentage'] = 'required|min:1|max:99';
            $rules['discount_expiry_date'] = 'required|after:today';
        }
        return $rules;
    }

    public function asController(ActionRequest $request, Service $service)
    {
        $request->validated();
        $data = $request->all();
        $data['store_id'] = $request->user()->id;
        if(!empty($request->service->image) && !is_null($request->service->image)){
            $data['old_image'] = $request->service->image;
        }
        return $this->handle(SaveServiceDTO::fromCollection(collect($data)), $service->id);

    }

    public function htmlResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return redirect()->back()->withInput()->with($paramters['action'], $paramters['msg']);
        }
        return redirect(route('web.dashboard.store-services.index'))->with($paramters['action'], $paramters['msg']);
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
        $router->post('dashboard/store-services/update/{service}', static::class)->name('dashboard.store-services.update.submit');
    }
}
