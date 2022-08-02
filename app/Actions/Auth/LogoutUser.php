<?php


namespace App\Actions\Auth;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class LogoutUser
{
    use AsAction;

    public function handle()
    {
        try {
           \auth()->guard('web')->logout();
            return ['action' => 'status', 'msg' => 'Logout Successful.'];
        }catch (\Exception $exception){
            return ['action' => 'err', 'msg' => $exception->getMessage()];
        }
    }

    public function getControllerMiddleware(): array
    {
        return ['auth:sanctum'];
    }

    public function asController()
    {
        return $this->handle();
    }

    public function htmlResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return redirect()->back()->with($paramters['action'], $paramters['msg']);
        }
        return redirect(route('web.auth.login'))->with($paramters['action'], $paramters['msg']);
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
        $router->get('dashboard/logout', static::class)->name('dashboard.logout');
    }
}