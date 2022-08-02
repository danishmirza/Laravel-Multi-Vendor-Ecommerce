<?php


namespace App\Actions\Dashboard\Notifications;


use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;

class NotificationSetting
{
    use AsAction;

    public function handle()
    {
        Auth::user()->update(['is_notification_enabled' => (Auth::user()->is_notification_enabled) ? 0: 1]);
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
        return responseBuilder()->success('Notification deleted successfully', ['is_notification_enabled' => Auth::user()->is_notification_enabled]);
    }

    public static function routes(Router $router)
    {
        $router->get('dashboard/notification-setting', static::class)->name('dashboard.notification-setting');
    }
}
