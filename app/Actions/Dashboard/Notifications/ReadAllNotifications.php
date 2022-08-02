<?php


namespace App\Actions\Dashboard\Notifications;


use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;

class ReadAllNotifications
{
    use AsAction;

    public function handle()
    {
        Auth::user()->unreadnotifications->markAsRead();
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
        return responseBuilder()->success('Notifications updated successfully');
    }

    public static function routes(Router $router)
    {
        $router->get('dashboard/read-all-notifications', static::class)->name('dashboard.read-all-notifications.count');
    }
}
