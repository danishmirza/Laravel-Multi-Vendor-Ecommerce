<?php

namespace App\Actions\Auth;

use App\Models\Fcm;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use MongoDB\Driver\Session;

class LoginUser
{

    use AsAction;

    public function handle($data)
    {
        try {
            if(!Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
                return ['action' => 'err', 'msg' => 'Credentials does not match.'];
            }
            if(isset($data['fcm_token']) && $data['fcm_token']){
                Fcm::create(['fcm_token' => $data['fcm_token'], 'user_id' => \auth()->user()->id]);
            }
            $token = Auth::user()->createToken('auth')->plainTextToken;
            return ['action' => 'status', 'msg' => 'Login Successful.', 'token' => $token];
        }catch (\Exception $exception){
            return ['action' => 'err', 'msg' => $exception->getMessage()];
        }
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required'
        ];
    }

    public function asController(ActionRequest $request)
    {
        $data = $request->only( 'email', 'password', 'fcm_token');
        return $this->handle($data);
    }

    public function htmlResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return redirect()->back()->withInput()->with($paramters['action'], $paramters['msg']);
        }

        if(\Illuminate\Support\Facades\Session::has('url.intended')){
            return redirect()->intended()->with($paramters['action'], $paramters['msg']);
        }
        return redirect(route('web.dashboard.profile'))->with($paramters['action'], $paramters['msg']);
    }

    public function jsonResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return responseBuilder()->error($paramters['msg']);
        }
        return responseBuilder()->success($paramters['msg'], ['token' => $paramters['token']]);
    }

    public static function routes(Router $router)
    {
        $router->post('login', static::class)->name('auth.login.submit');
    }

}
