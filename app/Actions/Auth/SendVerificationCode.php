<?php


namespace App\Actions\Auth;


use App\Http\Middleware\EnsureEmailIsVerified;
use App\Models\User;
use App\Notifications\SendEmailVerificationCode;
use Illuminate\Auth\Access\Response;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class SendVerificationCode
{
    use AsAction;

    public function handle()
    {
        try {
            $code = generateRandomNumber(5);
            User::where(['id' => Auth::user()->id])->update(['email_verification_code' => $code]);
            \auth()->user()->notify(new SendEmailVerificationCode($code, (Auth::user()->isUser()) ? Auth::user()->name : Auth::user()->store_name['en']));
            return ['action' => 'status', 'msg' => 'Verification code sent successfully.'];
        }catch (\Exception $exception){
            return ['action' => 'err', 'msg' => $exception->getMessage()];
        }
    }

    public function getControllerMiddleware(): array
    {
        return ['auth:sanctum'];
    }

    public function authorize(ActionRequest $request): Response
    {
        if ($request->user()->isEmailVerified()) {
            return Response::deny('Your email is already verified.', 404);
        }
        return Response::allow();
    }

    public function asController()
    {
        return $this->handle();
    }

    public function htmlResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return redirect()->back()->with($paramters['action'], $paramters['msg']);
        }
        return redirect(route('web.dashboard.verify-email'))->with($paramters['action'], $paramters['msg']);
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
        $router->get('dashboard/resend-verification-code', static::class)->name('dashboard.resend-verification-code');
    }

}