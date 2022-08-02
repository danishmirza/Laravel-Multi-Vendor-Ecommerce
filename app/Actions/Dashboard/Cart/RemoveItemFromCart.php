<?php


namespace App\Actions\Dashboard\Cart;


use App\Models\Ad;
use App\Models\Cart;
use App\Notifications\CartChangedNotification;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class RemoveItemFromCart
{
    use AsAction;

    public function handle($id)
    {
        try {
            Cart::where(['id' => $id, 'user_id' => \auth()->id()])->firstOrFail()->delete();
            $cartItems = Cart::where(['user_id' => \auth()->id()])->get();
            if(count($cartItems) <= 0){
                auth()->user()->update(['cart_store_id' => null]);
            }
            auth()->user()->notify(new CartChangedNotification());
            return ['action' => 'status', 'msg' => 'Cart item deleted successfully.'];
        }catch (ModelNotFoundException $exception){
            return ['action' => 'err', 'msg' => 'No result found'];
        }catch (\Exception $exception){
            return ['action' => 'err', 'msg' => $exception->getMessage()];
        }
    }

    public function authorize(ActionRequest $request): Response
    {
        if ($request->user()->isStore()) {
            return Response::deny('You are not allowed to perform this action', 404);
        }
        if ($request->user()->id != $request->cart->user_id) {
            return Response::deny('You are not authorize to delete this cart item.', 404);
        }
        return Response::allow();
    }

    public function getControllerMiddleware(): array
    {
        return ['auth:sanctum', 'verified'];
    }

    public function asController(Cart $cart)
    {
        return $this->handle($cart->id);
    }

    public function htmlResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return redirect()->back()->withInput()->with($paramters['action'], $paramters['msg']);
        }
        return redirect(route('web.dashboard.cart'))->with($paramters['action'], $paramters['msg']);
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
        $router->get('dashboard/cart/delete/{cart}', static::class)->name('dashboard.cart.delete');
    }
}
