<?php

namespace App\Actions\Dashboard\StoreServices;

use App\Actions\Dashboard\StorePackage\AssignFeaturePackage;
use App\DTO\SaveServiceDTO;
use App\Models\Service;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateService
{
    use AsAction;

    public function handle(SaveServiceDTO $serviceDTO)
    {

        DB::beginTransaction();
        try {
            $data = array_filter($serviceDTO->all(), function($v) { return !is_null($v);});
            unset($data['package_id']);
            $service = Service::create($data);
            if(!is_null($serviceDTO->package_id)){
                AssignFeaturePackage::run($serviceDTO->package_id, $service);
            }
            DB::commit();
            return ['action' => 'status', 'msg' => 'Service created successfully.'];
        }catch (\Exception $exception){
            DB::rollBack();
            return ['action' => 'err', 'msg' => $exception->getMessage()];
        }
    }

    public function getControllerMiddleware(): array
    {
        return ['auth:sanctum', 'verified', 'subscribed'];
    }

    public function rules(ActionRequest $request)
    {
        $rules = [
            'subcategory_id' => [
                'required',
                Rule::exists('categories', 'id')
                    ->whereNot('parent_id',0)
                    ->where('deleted_at',null),
            ],
            'title' => 'required|array|min:2|max:2',
            'title.en' => 'required',
            'price' => 'required|min:1',
            'content' => 'required|array|min:2|max:2',
            'content.en' => 'required',
        ];
        if($request->has('has_offer') && $request->get('has_offer') > 0){
            $rules['discount_percentage'] = 'required|min:1|max:99';
            $rules['discount_expiry_date'] = 'required|after:today';
        }
        return $rules;
    }

    public function asController(ActionRequest $request)
    {
        $request->validated();
        $data = $request->all();
        $data['store_id'] = $request->user()->id;
        return $this->handle(SaveServiceDTO::fromCollection(collect($data)));

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
        $router->post('dashboard/store-services/create', static::class)->name('dashboard.store-services.create.submit');
    }
}
