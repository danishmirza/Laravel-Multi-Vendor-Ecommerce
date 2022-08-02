<?php


namespace App\Actions\Dashboard\Coupons;


use App\Models\Coupon;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class RemoveCoupon
{
    use AsAction;

    public function handle()
    {
        DB::beginTransaction();
        try {
            $coupon = Coupon::where(['id' => auth()->user()->applied_coupon_id])->first();
            if($coupon){
                $coupon->increment('coupon_number');
            }
            auth()->user()->update(['applied_coupon_id' => null]);
            DB::commit();
            return ['action' => 'status', 'msg' => 'Coupon removed successfully.', 'coupon' => $coupon];
        }catch (\Exception $exception){
            DB::rollBack();
            return ['action' => 'err', 'msg' => $exception->getMessage()];
        }
    }

    public function getControllerMiddleware(): array
    {
        return ['auth:sanctum', 'verified'];
    }

    public function authorize(ActionRequest $request): Response
    {
        if ($request->user()->isStore()) {
            return Response::deny('You are not allowed to perform this action', 404);
        }
        return Response::allow();
    }


    public function asController()
    {
        return $this->handle();

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
        $router->get('dashboard/coupon/remove', static::class)->name('dashboard.coupons.remove');
    }
}
