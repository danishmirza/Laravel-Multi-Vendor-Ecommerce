<?php


namespace App\Actions\Dashboard\Conversations;


use App\Models\Conversation;
use Carbon\Carbon;
use Illuminate\Auth\Access\Response;
use Illuminate\Routing\Router;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteAllConversations
{
    use AsAction;

    public function handle()
    {
        try {
            $data = ['user_removed' => Carbon::now()->timestamp];
            $where = ['user_id' => auth()->id()];
            if(auth()->user()->isStore()){
                $data = ['store_removed' => Carbon::now()->timestamp];
                $where = ['store_id' => auth()->id()];
            }
            Conversation::where($where)->update($data);
            return ['action' => 'status', 'msg' => 'All Conversations deleted successfully.'];
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

    public function htmlResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return redirect()->back()->withInput()->with($paramters['action'], $paramters['msg']);
        }
        return redirect(route('web.dashboard.chats.index'))->with($paramters['action'], $paramters['msg']);
    }

    public function jsonResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return responseBuilder()->error($paramters['msg']);
        }
        return responseBuilder()->success($paramters['msg']);
    }

    public static function routes(Router $router)
    {
        $router->get('dashboard/conversations/delete-all', static::class)->name('dashboard.conversation.delete-all');
    }
}
