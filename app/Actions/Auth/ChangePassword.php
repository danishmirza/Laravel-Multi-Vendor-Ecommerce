<?php


namespace App\Actions\Auth;


use App\Models\User;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class ChangePassword
{

    use AsAction;

    public function handle($data)
    {
        try {
            User::where(['id' => Auth::user()->id])->update(['password' => bcrypt($data['password'])]);
            return ['action' => 'status', 'msg' => 'Password changed Successfully.'];
        }catch (\Exception $exception){
            return ['action' => 'err', 'msg' => $exception->getMessage()];
        }
    }

    public function getControllerMiddleware(): array
    {
        return ['auth:sanctum'];
    }

    public function rules()
    {
        return [
            'current_password' => 'required',
            'password' => 'required|confirmed',
        ];
    }

    public function withValidator(Validator $validator, ActionRequest $request): void
    {
        $validator->after(function (Validator $validator) use ($request) {
            if (! Hash::check($request->get('current_password'), $request->user()->password)) {
                $validator->errors()->add('current_password', 'Current password is wrong.');
            }
        });
    }

    public function asController(ActionRequest $request)
    {
        $request->validated();
        $data = $request->only( 'password');
        return $this->handle($data);
    }

    public function htmlResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return redirect()->back()->withInput()->with($paramters['action'], $paramters['msg']);
        }
        return redirect(route('web.dashboard.change-password'))->with($paramters['action'], $paramters['msg']);
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
        $router->post('dashboard/change-password', static::class)->name('dashboard.change-password.submit');
    }

}