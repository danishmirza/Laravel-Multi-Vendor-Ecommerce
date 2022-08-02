<?php

namespace App\Actions\Dashboard\StorePortfolio;

use App\Models\Portfolio;
use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class UploadPortfolioImage
{
    use AsAction;

    public function handle($image)
    {
        try {
            Portfolio::create(['store_id' => Auth::user()->id, 'image' => moveImage($image, 'store-portfolio')]);
            return ['action' => 'status', 'msg' => 'Portfolio image uploaded successfully.'];
        }catch (\Exception $exception){
            return ['action' => 'err', 'msg' => $exception->getMessage()];
        }
    }

    public function rules()
    {
        return [
            'image' => 'required',
        ];
    }

    public function getControllerMiddleware(): array
    {
        return ['auth:sanctum', 'verified', 'subscribed'];
    }

    public function authorize(ActionRequest $request): Response
    {
        if ($request->user()->isUser()) {
            return Response::deny('You are not authorized to perform this action.', 404);
        }
        return Response::allow();
    }

    public function withValidator(Validator $validator, ActionRequest $request): void
    {
        $validator->after(function (Validator $validator) use ($request) {
            if (!file_exists( public_path().'/' . $request->get('image'))) {
                $validator->errors()->add('image', 'Image not uploaded correctly. Please upload again.');
            }
        });
    }


    public function asController(ActionRequest $request)
    {
        $request->validated();
        return $this->handle($request->get('image'));
    }

    public function htmlResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return redirect()->back()->withInput()->with($paramters['action'], $paramters['msg']);
        }
        return redirect(route('web.dashboard.portfolios.index'))->with($paramters['action'], $paramters['msg']);
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
        $router->post('dashboard/portfolios/create', static::class)->name('dashboard.portfolios.store.submit');
    }
}
