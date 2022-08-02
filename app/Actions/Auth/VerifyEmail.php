<?php


namespace App\Actions\Auth;


use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class VerifyEmail
{
    use AsAction;

    public function handle($data)
    {
        try {
            $user = User::where(['id' => Auth::user()->id, 'email_verification_code' => $data['code']])->firstOrFail();
            $user->update(['email_verification_code' => null, 'email_verified' => 1]);
            return ['action' => 'status', 'msg' => 'Email verified successfully.'];
        }
        catch (ModelNotFoundException $exception){
            return ['action' => 'err', 'msg' => 'Code is invalid. Please try again.'];
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

    public function rules()
    {
        return [
            'code' => 'required',
        ];
    }

    public function asController(ActionRequest $request)
    {
        $request->validated();
        $data = $request->only( 'code');
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
        return responseBuilder()->success($paramters['msg']);
    }

    public static function routes(Router $router)
    {
        $router->post('dashboard/verify-email', static::class)->name('dashboard.verify-email.submit');
    }

}