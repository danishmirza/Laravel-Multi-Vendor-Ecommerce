<?php


namespace App\Actions\Dashboard\Conversations;


use App\Http\Resources\ConversationsCollection;
use App\Models\Conversation;
use Illuminate\Routing\Router;
use Lorisleiva\Actions\Concerns\AsAction;

class ListConversations
{
    use AsAction;

    public function handle()
    {
        try {
            $where = ['user_id' => auth()->id(), 'user_removed' => null];
            if(auth()->user()->isStore()){
                $where = ['store_id' => auth()->id(), 'store_removed' => null];
            }
            $conversations = Conversation::where($where)->whereHas('user')->whereHas('store')->with('lastMessage:id,message,message_type,conversation_id,created_at', 'user:id,name,image', 'store:id,store_name,image')->paginate(30);
            return ['action' => 'status', 'msg' => 'Conversations.', 'conversations' => $conversations];
        }catch (\Exception $exception){
            return ['action' => 'err', 'msg' => $exception->getMessage()];
        }
    }

    public function getControllerMiddleware(): array
    {
        return ['auth:sanctum', 'verified'];
    }


    public function asController()
    {
        return $this->handle();

    }

    public function jsonResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return responseBuilder()->error($paramters['msg']);
        }
        return responseBuilder()->success($paramters['msg'], new ConversationsCollection($paramters['conversations']));
    }

    public static function routes(Router $router)
    {
        $router->get('dashboard/conversations', static::class)->name('dashboard.conversations');
    }
}
