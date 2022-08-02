<?php


namespace App\Actions\Dashboard\StoreAd;


use App\Models\Ad;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteStoreAd
{
    use AsAction;

    public function handle($id)
    {
        try {
            Ad::where(['id' => $id, 'store_id' => Auth::user()->id])->firstOrFail()->delete();
            return ['action' => 'status', 'msg' => 'Ad deleted successfully.'];
        }catch (ModelNotFoundException $exception){
            return ['action' => 'err', 'msg' => 'No result found'];
        }catch (\Exception $exception){
            return ['action' => 'err', 'msg' => $exception->getMessage()];
        }
    }

    public function authorize(ActionRequest $request): Response
    {
        if ($request->user()->id != $request->ad->store_id) {
            return Response::deny('You are not authorize to delete this ad.', 404);
        }
        return Response::allow();
    }

    public function getControllerMiddleware(): array
    {
        return ['auth:sanctum', 'verified', 'subscribed'];
    }

    public function asController(Ad $ad)
    {
        return $this->handle($ad->id);
    }

    public function htmlResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return redirect()->back()->withInput()->with($paramters['action'], $paramters['msg']);
        }
        return redirect()->back()->with($paramters['action'], $paramters['msg']);
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
        $router->get('dashboard/store-ads/delete/{ad}', static::class)->name('dashboard.store-ads.delete');
    }
}
