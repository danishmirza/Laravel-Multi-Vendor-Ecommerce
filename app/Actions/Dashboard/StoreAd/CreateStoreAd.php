<?php


namespace App\Actions\Dashboard\StoreAd;


use App\DTO\SaveAdDTO;
use App\Models\Ad;
use App\Models\Admin;
use App\Notifications\AdminAdRequest;
use Illuminate\Auth\Access\Response;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateStoreAd
{
    use AsAction;

    public function handle(SaveAdDTO $data)
    {
        try {
            $ad = Ad::create($data->all());
            $admin = Admin::first();
            $admin->notify(new AdminAdRequest($ad->store_id, $ad->id));
            return ['action' => 'status', 'msg' => 'Ad request created successfully.', 'status' => 'pending'];
        }catch (\Exception $exception){
            return ['action' => 'err', 'msg' => $exception->getMessage()];
        }
    }

    public function getControllerMiddleware(): array
    {
        return ['auth:sanctum', 'verified', 'subscribed'];
    }

    public function authorize(ActionRequest $request): Response
    {
        if ($request->user()->isUser()) {
            return Response::deny('You are not allowed to perform this action', 404);
        }
        return Response::allow();
    }

    public function rules(ActionRequest $request)
    {
        return [
            'title' => 'required|array|min:2|max:2',
            'sub_title' => 'required|array|min:2|max:2',
            'content' => 'required|array|min:2|max:2',
            'title.en' => 'required',
            'title.ar' => 'required',
            'sub_title.en' => 'required',
            'sub_title.ar' => 'required',
            'content.en' => 'required',
            'content.ar' => 'required',
            'image' => 'required'
        ];
    }

    public function withValidator(Validator $validator, ActionRequest $request): void
    {
        $validator->after(function (Validator $validator) use ($request) {
            if (!file_exists( public_path().'/' . $request->get('image'))) {
                $validator->errors()->add('image', 'Image was not uploaded correctly. Please upload again.');
            }
        });
    }

    public function asController(ActionRequest $request)
    {
        $request->validated();
        $data = $request->all();
        $data['store_id'] = $request->user()->id;
        return $this->handle(SaveAdDTO::fromCollection(collect($data)));

    }

    public function htmlResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return redirect()->back()->withInput()->with($paramters['action'], $paramters['msg']);
        }
        return redirect(route('web.dashboard.store-ads.index', ['status' => $paramters['status']]))->with($paramters['action'], $paramters['msg']);
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
        $router->post('dashboard/store-ads/store', static::class)->name('dashboard.store-ads.store.submit');
    }

}
