<?php


namespace App\Actions\Dashboard\StoreAd;


use App\DTO\SaveAdDTO;
use App\Models\Ad;
use Illuminate\Auth\Access\Response;
use Illuminate\Routing\Router;
use Illuminate\Validation\Validator;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateStoreAd
{
    use AsAction;

    public function handle(SaveAdDTO $data, $adId)
    {
        try {
            $ad = Ad::where(['id' => $adId, 'store_id' => $data->store_id])->firstOrFail();
            $ad->update($data->all());
            return ['action' => 'status', 'msg' => 'Ad request updated successfully.', 'status' => 'pending'];
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

    public function authorize(ActionRequest $request): Response
    {
        if ($request->user()->id != $request->ad->store_id) {
            return Response::deny('You are not authorize to update this ad.', 404);
        }
        return Response::allow();
    }

    public function asController(ActionRequest $request, Ad $ad)
    {
        $request->validated();
        $data = $request->all();
        $data['old_image'] = $ad->image;
        $data['store_id'] = $request->user()->id;
        return $this->handle(SaveAdDTO::fromCollection(collect($data)), $ad->id);

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
        $router->post('dashboard/store-ads/update/{ad}', static::class)->name('dashboard.store-ads.update.submit');
    }
}
