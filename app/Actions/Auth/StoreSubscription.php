<?php


namespace App\Actions\Auth;


use App\Models\Package;
use App\Models\StoreSubscription as StoreSubscriptionModel;
use Carbon\Carbon;
use Illuminate\Auth\Access\Response;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class StoreSubscription
{
    use AsAction;

    public function handle($package, $user, $paymentId = null)
    {
        if(!$package->isSubscription()){
            throw new \Exception('Please select subscription package.');
        }
        DB::beginTransaction();
        try {
            $data = [
                'package_id' => $package->id,
                'package' => json_encode($package),
            ];
            StoreSubscriptionModel::where('store_id', $user->id)->update(['subscription_status' => 'ended']);
            $user->packageSubscribed()->create($data);
            $expiryDate = Carbon::now()->addDays($package->total_days)->timestamp;
            if($user->isSubscribed() && !$user->isSubscriptionExpired()){
                $expiryDate =  Carbon::parse(auth()->user()->subscription_ends_date)->addDays($package->total_days)->timestamp;
            }
            $user->update(['subscription_ends_date' => $expiryDate]);
            DB::commit();
            return ['action' => 'status', 'msg' => 'Package subscribed successfully.'];
        }catch (\Exception $exception){
            DB::rollBack();
            return ['action' => 'err', 'msg' => $exception->getMessage()];
        }
    }

    public function getControllerMiddleware(): array
    {
        return ['auth:sanctum'];
    }

    public function authorize(ActionRequest $request): Response
    {
        if ($request->user()->isUser()) {
            return Response::deny('You are not allowed to perform this action', 404);
        }
        return Response::allow();
    }

    public function asController(ActionRequest $request, Package $package)
    {
        return $this->handle($package, auth()->user());
    }

    public function htmlResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return redirect()->back()->withInput()->with($paramters['action'], $paramters['msg']);
        }
        if(\Illuminate\Support\Facades\Session::has('url.intended')){
            return redirect()->intended()->with($paramters['action'], $paramters['msg']);
        }
        return redirect(route('web.dashboard.profile'))->with($paramters['action'], $paramters['msg']);
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
        $router->get('dashboard/subscribe-to-package/{package:id}', static::class)->name('dashboard.subscribe-to-package.submit');
    }
}
