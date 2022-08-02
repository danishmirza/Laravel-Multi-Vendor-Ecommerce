<?php


namespace App\Actions\Dashboard\Notifications;


use App\Http\Resources\NotificationsCollection;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class ListNotifications
{
    use AsAction;

    public function handle($request)
    {
        $perpage =  $request->get('perpage', 15);
        $page =  $request->get('page', 1);
        $notifications = Auth::user()->notifications()->select('id', 'data', 'created_at')->paginate($perpage, ['*'], 'page', $page);
        return $notifications;
    }

    public function getControllerMiddleware(): array
    {
        return ['auth:sanctum'];
    }


    public function asController(ActionRequest $request)
    {
        return $this->handle($request);

    }

    public function jsonResponse($paramters)
    {
        return responseBuilder()->success('Notifications', new NotificationsCollection($paramters));
    }

    public static function routes(Router $router)
    {
        $router->get('dashboard/notifications', static::class)->name('dashboard.notifications');
    }
}
