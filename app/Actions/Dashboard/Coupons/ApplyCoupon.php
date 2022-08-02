<?php


namespace App\Actions\Dashboard\Coupons;


use App\Models\Coupon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Auth\Access\Response;

class ApplyCoupon
{
    use AsAction;

    public function handle($couponCode)
    {
        DB::beginTransaction();
        try {
            $coupon = Coupon::where(['coupon_code' => $couponCode])->firstOrFail();
            auth()->user()->update(['applied_coupon_id' => $coupon->id]);
            if($coupon->isNumber()){
                $coupon->decrement('coupon_number');
            }
            DB::commit();
            return ['action' => 'status', 'msg' => 'Coupon Applied successfully.', 'coupon' => $coupon];
        }
        catch (ModelNotFoundException $exception){
            DB::rollBack();
            return ['action' => 'err', 'msg' => 'No coupon found.'];
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
        if ($request->user()->isUser() && $request->user()->isCouponApplied()) {
            return Response::deny('A coupon is already applied. Please remove the previous applied coupon.', 404);
        }
        return Response::allow();
    }

    public function rules(ActionRequest $request)
    {
        return [
            'code' => 'required',

        ];
    }

    public function asController(ActionRequest $request)
    {
        return $this->handle($request->get('code'));

    }

    public function jsonResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return responseBuilder()->error($paramters['msg']);
        }
        return responseBuilder()->success($paramters['msg'], $paramters['coupon']);
    }

    public static function routes(Router $router)
    {
        $router->post('dashboard/coupon/apply', static::class)->name('dashboard.coupons.apply');
    }
}
