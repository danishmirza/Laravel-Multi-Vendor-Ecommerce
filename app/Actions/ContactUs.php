<?php


namespace App\Actions;


use App\Notifications\SendContactUsEmail;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Notification;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class ContactUs
{
    use AsAction;

    public function handle($data)
    {
        try {
            Notification::route('mail', config('project_settings.email'))
                ->notify(new SendContactUsEmail(
                    $data['name'],
                    $data['subject'],
                    $data['email'],
                    $data['content']
                ));
            return ['action' => 'status', 'msg' => 'We have received your query. Admin will get back to you.'];
        }catch (\Exception $exception){
            return ['action' => 'err', 'msg' => $exception->getMessage()];
        }
    }

    public function rules()
    {
        return [
            'name' => 'required|max:300',
            'email' => 'required|email',
            'content' => 'required|max:1000',
            'subject' => 'required'
        ];
    }

    public function asController(ActionRequest $request)
    {
        $data = $request->only('name', 'subject', 'email', 'content');
        return $this->handle($data);
    }

    public function htmlResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return redirect()->back()->withInput()->with($paramters['action'], $paramters['msg']);
        }
        return redirect(route('web.front.contact-us'))->with($paramters['action'], $paramters['msg']);
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
        $router->post('contact/submit', static::class)->name('contact.submit');
    }

}
