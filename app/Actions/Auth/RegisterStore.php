<?php


namespace App\Actions\Auth;


use App\Models\User;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class RegisterStore
{
    use AsAction;

    public function handle($data)
    {
        try {
            $user = User::create([
                'store_name' => ['en' => $data['store_name'], 'ar' => ''],
                'detail' => ['en' => (isset($data['detail']) ? $data['detail']: ''), 'ar' => ''],
                'city_id' => $data['city_id'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'email' => $data['email'],
                'user_type' => 'store',
                'password' => bcrypt($data['password']),
                'image' => (isset($data['image'])) ? moveImage($data['image'], 'users') : '',
                'trade_license' => moveImage($data['trade_license'], 'trade_licenses')
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
            'store_name' => 'required',
            'phone' => 'required|regex:/^(?:\+)[0-9]/',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'email' => 'required|email|unique:users,email,NULL,deleted_at',
            'password' => 'required|confirmed',
            'terms_conditions' => 'required',
            'trade_license' => 'required',
            'city_id' => 'required|exists:cities,id,parent_id,0,deleted_at,NULL'
        ];
    }

    public function withValidator(Validator $validator, ActionRequest $request): void
    {
        $validator->after(function (Validator $validator) use ($request) {
            if (!file_exists( public_path().'/' . $request->get('trade_license'))) {
                $validator->errors()->add('trade_license', 'Trade License was not uploaded correctly. Please upload again.');
            }
            if ($request->has('image') && !file_exists( public_path().'/' . $request->get('image'))) {
                $validator->errors()->add('image', 'Image was not correctly uploaded. Please upload again.');
            }
        });
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
        $router->post('auth/store-register', static::class)->name('auth.store-register.submit');
    }
}
