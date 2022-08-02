<?php


namespace App\Actions\Dashboard\Conversations;


use App\Http\Resources\ConversationsCollection;
use App\Http\Resources\MessagesCollection;
use App\Http\Resources\MessagesListResource;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Routing\Router;
use Lorisleiva\Actions\Concerns\AsAction;

class ListMessages
{
    use AsAction;

    public function handle($conversationId, $skip)
    {
        try {
            $where = ['user_removed' => null, 'conversation_id' => $conversationId];
            if(auth()->user()->isStore()){
                $where = [ 'store_removed' => null, 'conversation_id' => $conversationId];
            }
            $messages = Message::where($where)->whereHas('sender')->with('sender:id,name,store_name,user_type')->orderBy('created_at', 'asc')->skip($skip)->take(100)->get();

            return ['action' => 'status', 'msg' => 'Messages.', 'messages' => $messages];
        }catch (\Exception $exception){
            return ['action' => 'err', 'msg' => $exception->getMessage()];
        }
    }

    public function getControllerMiddleware(): array
    {
        return ['auth:sanctum', 'verified'];
    }


    public function asController(Conversation $conversation, $skip=0)
    {
        return $this->handle($conversation->id, $skip);

    }

    public function jsonResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return responseBuilder()->error($paramters['msg']);
        }
        return responseBuilder()->success($paramters['msg'],  MessagesListResource::collection($paramters['messages']));
    }

    public static function routes(Router $router)
    {
        $router->get('dashboard/messages/{conversation}/{skip?}', static::class)->name('dashboard.messages');
    }
}
