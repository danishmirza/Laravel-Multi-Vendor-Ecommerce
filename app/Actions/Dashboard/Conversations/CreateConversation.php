<?php


namespace App\Actions\Dashboard\Conversations;


use App\Http\Resources\ConversationsCollection;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Routing\Router;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateConversation
{
    use AsAction;

    public function handle($storeId)
    {
        try {
            $conversation = Conversation::firstOrCreate([
                'user_id' => auth()->id(),
                'store_id' => $storeId
            ]);
            if(auth()->user()->isStore()){
                $conversation->update(['store_removed' => null]);
            }else{
                $conversation->update(['user_removed' => null]);
            }
            return ['action' => 'status', 'msg' => 'Conversation started successfully.', 'conversationId' => $conversation->id];
        }catch (\Exception $exception){
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
        return Response::allow();
    }


    public function asController(User $user)
    {
        return $this->handle($user->id);

    }

    public function htmlResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return redirect()->back()->withInput()->with($paramters['action'], $paramters['msg']);
        }
        return redirect(route('web.dashboard.chats.messages', ['conversation' => $paramters['conversationId']]))->with($paramters['action'], $paramters['msg']);
    }

    public function jsonResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return responseBuilder()->error($paramters['msg']);
        }
        return responseBuilder()->success($paramters['msg'], ['conversation' => $paramters['conversationId']]);
    }

    public static function routes(Router $router)
    {
        $router->get('dashboard/start-conversation/{user}', static::class)->name('dashboard.start-conversation');
    }
}
