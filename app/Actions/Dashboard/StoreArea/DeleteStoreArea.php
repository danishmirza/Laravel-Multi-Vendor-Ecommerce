<?php


namespace App\Actions\Dashboard\StoreArea;


use App\Models\StoreArea;
use App\Rules\CheckStoreAreaDuplicateRule;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteStoreArea
{
    use AsAction;

    public function handle($id)
    {
        try {
            StoreArea::where(['id' => $id, 'store_id' => Auth::user()->id])->firstOrFail()->delete();
            return ['action' => 'status', 'msg' => 'Service area deleted successfully.'];
        }catch (ModelNotFoundException $exception){
            return ['action' => 'err', 'msg' => 'No result found'];
        }catch (\Exception $exception){
            return ['action' => 'err', 'msg' => $exception->getMessage()];
        }
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

    public function getControllerMiddleware(): array
    {
        return ['auth:sanctum', 'verified', 'subscribed'];
    }

    public function asController(StoreArea $storeArea)
    {
        return $this->handle($storeArea->id);
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
        $router->get('dashboard/store-areas/delete/{store_area}', static::class)->name('dashboard.store-area.delete');
    }
}
