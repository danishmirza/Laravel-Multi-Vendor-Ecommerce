<?php


namespace App\Actions\Dashboard\Cart;


use App\Models\Cart;
use App\Models\Service;
use App\Notifications\CartChangedNotification;
use Illuminate\Auth\Access\Response;
use Illuminate\Routing\Router;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class CartCount
{
    use AsAction;

    public function handle()
    {
        try {
            $cartCount = Cart::where(['user_id' => auth()->id()])->count();
            return ['action' => 'status', 'msg' => 'Service added to cart successfully.', 'count' => $cartCount];
        }catch (\Exception $exception){
            return ['action' => 'err', 'msg' => $exception->getMessage()];
        }
    }

    public function getControllerMiddleware(): array
    {
        return ['auth:sanctum'];
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
        return responseBuilder()->success($paramters['msg'], ['count' => $paramters['count']]);
    }

    public static function routes(Router $router)
    {
        $router->get('dashboard/cart-count', static::class)->name('dashboard.cart.count');
    }
}
