<?php


namespace App\Actions\Dashboard\Notifications;


use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteNotification
{
    use AsAction;

    public function handle($id)
    {
        Auth::user()->notifications()->where(['id' => $id])->delete();
        return true;
    }

    public function getControllerMiddleware(): array
    {
        return ['auth:sanctum'];
    }


    public function asController($id)
    {
        return $this->handle($id);

    }

    public function jsonResponse($paramters)
    {
        return responseBuilder()->success('Notification deleted successfully');
    }

    public static function routes(Router $router)
    {
        $router->get('dashboard/delete-notification/{id}', static::class)->name('dashboard.delete-notification.count');
    }
}
