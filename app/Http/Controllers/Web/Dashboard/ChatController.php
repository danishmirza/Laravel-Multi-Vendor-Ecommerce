<?php


namespace App\Http\Controllers\Web\Dashboard;


use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Order;
use App\Services\OrderService;

class ChatController extends Controller
{
    public function conversations()
    {
        try {
            $where = ['user_id' => auth()->id(), 'user_removed' => null];
            if(auth()->user()->isStore()){
                $where = ['store_id' => auth()->id(), 'store_removed' => null];
            }
            $conversationsCount = Conversation::where($where)->whereHas('user')->whereHas('store')->with('lastMessage:id,message,message_type')->count();
            return view('web.dashboard.conversations.index', ['conversationCount' => $conversationsCount]);
        } catch (\Exception $e) {
            return redirect()->route('web.dashboard.profile')->with('err', $e->getMessage());
        }
    }

    public function messages(Conversation $conversation)
    {

        try {
            if(!($conversation->user_id == auth()->id() || $conversation->store_id == auth()->id())){
                abort(404);
            }
            return view('web.dashboard.conversations.messages', ['conversationId' => $conversation->id]);
        } catch (\Exception $e) {
            return redirect()->route('web.dashboard.profile')->with('err', $e->getMessage());
        }
    }
}
