<?php


namespace App\Actions\Dashboard\Notifications;


use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteAllNotifications
{
    use AsAction;

    public function handle()
    {
        Auth::user()->notifications()->delete();
        return true;
    }

    public function getControllerMiddleware(): array
    {
        return ['auth:sanctum'];
    }


    public function asController()
    {
        return $this->handle();

    }

    public function jsonResponse($paramters)
    {
        return responseBuilder()->success('Notifications deleted successfully');
    }

    public static function routes(Router $router)
    {
        $router->get('dashboard/delete-all-notification', static::class)->name('dashboard.delete-all-notification.count');
    }
}
