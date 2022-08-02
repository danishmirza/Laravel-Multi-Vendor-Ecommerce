<?php


namespace App\Actions\Dashboard\Conversations;


use App\Models\Conversation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\Response;
use Illuminate\Routing\Router;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteConversation
{
    use AsAction;

    public function handle(Conversation $conversation)
    {
        try {
            $data = ['user_removed' => Carbon::now()->timestamp];
            if(auth()->user()->isStore()){
                $data = ['store_removed' => Carbon::now()->timestamp];
            }
            $conversation->update($data);
            return ['action' => 'status', 'msg' => 'Conversation deleted successfully.', 'conversationId' => $conversation->id];
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
        if (!(auth()->id() == $request->conversation->user_id || auth()->id == $request->conversation->store_id)) {
            return Response::deny('You are not allowed to perform this action', 404);
        }
        return Response::allow();
    }


    public function asController(Conversation $conversation)
    {
        return $this->handle($conversation);

    }

    public function htmlResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return redirect()->back()->withInput()->with($paramters['action'], $paramters['msg']);
        }
        return redirect(route('web.dashboard.chats.index', ['conversation' => $paramters['conversationId']]))->with($paramters['action'], $paramters['msg']);
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
        $router->get('dashboard/conversation/delete/{conversation}', static::class)->name('dashboard.conversation.delete');
    }
}
