<?php


namespace App\Actions\Auth;


use App\Models\User;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class RegisterUser
{
    use AsAction;

    public function handle($data)
    {
        try {
            $user = User::create([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'image' => (isset($data['image'])) ? moveImage($data['image'], 'users') : ''
            ]);
            Auth::login($user);
            SendVerificationCode::run();
            $token = Auth::user()->createToken('auth')->plainTextToken;
            return ['action' => 'status', 'msg' => 'You have registered successfully.', 'token' => $token];
        }catch (\Exception $exception){
            return ['action' => 'err', 'msg' => $exception->getMessage()];
        }
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'phone' => 'required|regex:/^(?:\+)[0-9]/',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'email' => 'required|email|unique:users,email,NULL,deleted_at',
            'password' => 'required|confirmed',
            'terms_conditions' => 'required'
        ];
    }

    public function withValidator(Validator $validator, ActionRequest $request): void
    {
        $validator->after(function (Validator $validator) use ($request) {
            if ($request->has('image') && !file_exists( public_path().'/' . $request->get('image'))) {
                $validator->errors()->add('image', 'Image was not correctly uploaded. Please upload again.');
            }
        });
    }

    public function getValidationMessages(): array
    {
        return [
            'terms_conditions.required' => 'Please accept terms and conditions.'
        ];
    }

    public function asController(ActionRequest $request)
    {
        $request->validated();
        $data = $request->all();
        return $this->handle($data);
    }

    public function htmlResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return redirect()->back()->withInput()->with($paramters['action'], $paramters['msg']);
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
        $router->post('auth/user-register', static::class)->name('auth.user-register.submit');
    }
}
