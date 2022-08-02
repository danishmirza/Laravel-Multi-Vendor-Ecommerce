<?php

namespace App\Actions\Dashboard\StorePackage;

use App\Models\Package;
use App\Models\StorePurchasedPackage;
use Carbon\Carbon;
use Illuminate\Auth\Access\Response;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class PurchaseFeaturePackage
{
    use AsAction;

    public function handle($package, $userId, $paymentId = null)
    {
        try {
            $data = [
                'package_id' => $package->id,
                'package' => json_encode($package),
                'store_id' => $userId
            ];
            StorePurchasedPackage::create($data);
            return ['action' => 'status', 'msg' => 'Package subscribed successfully.'];
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
        if (!$request->package->isFeatured()) {
            return Response::deny('Please select feature package', 404);
        }
        return Response::allow();
    }

    public function asController(ActionRequest $request, Package $package)
    {
        return $this->handle($package, $request->user()->id);
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
        $router->get('dashboard/purchase-package/{package}', static::class)->name('dashboard.purchase-package.submit');
    }

}
