<?php


namespace App\Actions\Auth;


use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class ResetPassword
{
    use AsAction;

    public function handle($data)
    {
        try {
            User::where(['password_reset_code' => $data['code']])->firstOrFail()->update(['password' => bcrypt($data['password'])]);
            return ['action' => 'status', 'msg' => 'Password changed Successfully.'];
        }catch (ModelNotFoundException $exception){
            return ['action' => 'err', 'msg' => 'Code is wrong.'];
        }catch (\Exception $exception){
            return ['action' => 'err', 'msg' => $exception->getMessage()];
        }
    }

    public function rules()
    {
        return [
            'code' => 'required',
            'password' => 'required|confirmed',
        ];
    }

    public function asController(ActionRequest $request)
    {
        $request->validated();
        $data = $request->only( 'password', 'code');
        return $this->handle($data);
    }

    public function htmlResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return redirect()->back()->withInput()->with($paramters['action'], $paramters['msg']);
        }
        return redirect(route('web.auth.login'))->with($paramters['action'], $paramters['msg']);
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
        $router->post('auth/reset-password', static::class)->name('auth.reset-password.submit');
    }
}
