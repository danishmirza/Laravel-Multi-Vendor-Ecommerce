<?php


namespace App\Actions\Dashboard\Conversations;


use App\Http\Resources\MessageResource;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Notifications\NewMessageNotification;
use Illuminate\Auth\Access\Response;
use Illuminate\Routing\Router;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class SendMessage
{
    use AsAction;

    public function handle($conversationId, $message, $messageType)
    {
        try {
            $message = Message::create([
                'sender_id' => auth()->id(),
                'conversation_id' => $conversationId,
                'message' => $message,
                'message_type' => $messageType
            ]);
            $message->load(['sender:id,name,store_name,image,user_type']);
            $message1 = MessageResource::make($message);
            if(auth()->user()->isStore()){
                $message->conversation->user->notify(new NewMessageNotification($message1, $message->conversation->user->id));
            }else{
                $message->conversation->store->notify(new NewMessageNotification($message1, $message->conversation->store->id));
            }

            return ['action' => 'status', 'msg' => 'Message sent successfully.', 'message' => $message1];
        }catch (\Exception $exception){
            return ['action' => 'err', 'msg' => $exception->getMessage()];
        }
    }

    public function getControllerMiddleware(): array
    {
        return ['auth:sanctum', 'verified'];
    }

    public function rules(){
        return [
            'conversation_id' => 'required|exists:conversations,id',
            'message' => 'required',
            'message_type' => 'required|in:text,image'
        ];
    }


    public function asController(ActionRequest $request)
    {
        return $this->handle($request->get('conversation_id'), $request->get('message'), $request->get('message_type'));

    }

    public function jsonResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return responseBuilder()->error($paramters['msg']);
        }
        return responseBuilder()->success($paramters['msg'], $paramters['message']);
    }

    public static function routes(Router $router)
    {
        $router->post('dashboard/message/send-message', static::class)->name('dashboard.send-message');
    }
}
