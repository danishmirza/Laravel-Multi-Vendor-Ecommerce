<?php


namespace App\Actions\Auth;


use App\Models\User;
use App\Notifications\SendPasswordResetCode;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class ForgotPassword
{
    use AsAction;

    public function handle($data)
    {
        try {
            $code = generateRandomNumber(5);
            $user = User::where(['email' => $data['email']])->firstOrFail();
            $user->update(['password_reset_code' => $code]);
            $user->notify(new SendPasswordResetCode($code, ($user->isUser()) ? $user->name : $user->store_name['en']));
            return ['action' => 'status', 'msg' => 'We have send you the code in email.', 'email' => $user->email, 'code' => $code];
        }
        catch (ModelNotFoundException $exception){
            return ['action' => 'err', 'msg' => 'Email is wrong.'];
        }catch (\Exception $exception){
            return ['action' => 'err', 'msg' => $exception->getMessage()];
        }
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
        ];
    }

    public function asController(ActionRequest $request)
    {
        $request->validated();
        $data = $request->only( 'email');
        return $this->handle($data);
    }

    public function htmlResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return redirect()->back()->withInput()->with($paramters['action'], $paramters['msg']);
        }
        return redirect(route('web.auth.reset-password', ['email' => $paramters['email'], 'code' => $paramters['code']]))->with($paramters['action'], $paramters['msg']);
    }

    public function jsonResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return responseBuilder()->error($paramters['msg']);
        }
        return responseBuilder()->success($paramters['msg'], ['email' => $paramters['email'], 'code' => $paramters['code']]);
    }

    public static function routes(Router $router)
    {
        $router->post('auth/forgot-password', static::class)->name('auth.forgot-password.submit');
        $router->get('auth/resend-forgot-password', static::class)->name('auth.resend-forgot-password.submit');
    }
}
