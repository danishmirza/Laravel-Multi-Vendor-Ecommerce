<?php


namespace App\Actions\Dashboard\Notifications;


use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class UnreadNotificationsCount
{
    use AsAction;

    public function handle()
    {
        $notificationCount = Auth::user()->unreadnotifications()->count();
        return $notificationCount;
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
        return responseBuilder()->success('Unread Notifications', ['count' => $paramters]);
    }

    public static function routes(Router $router)
    {
        $router->get('dashboard/unread-notifications-count', static::class)->name('dashboard.unread-notifications.count');
    }
}
