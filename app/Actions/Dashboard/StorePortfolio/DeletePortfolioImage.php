<?php


namespace App\Actions\Dashboard\StorePortfolio;


use App\Models\Portfolio;
use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class DeletePortfolioImage
{
    use AsAction;

    public function handle($portfolio)
    {
        try {
            $portfolio->delete();
            return ['action' => 'status', 'msg' => 'Portfolio image deleted successfully.'];
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
        if ($request->user()->id != $request->portfolio->store_id) {
            return Response::deny('You are not authorize to delete this portfolio image.');
        }
        return Response::allow();
    }

    public function asController(ActionRequest $request, Portfolio $portfolio)
    {
        $request->validated();
        return $this->handle($portfolio);
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
        $router->get('dashboard/portfolios/delete/{portfolio}', static::class)->name('dashboard.portfolios.delete');
    }
}

