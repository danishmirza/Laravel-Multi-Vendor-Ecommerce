<?php


namespace App\Actions\Auth;


use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateUserProfile
{
    use AsAction;

    public function handle($params)
    {
        try {
            $data = [
                'name' => $params['name'],
                'phone' => $params['phone'],
                'address' => $params['address'],
                'latitude' => $params['latitude'],
                'longitude' => $params['longitude'],
//                'email' => $data['email'],
            ];
            if(isset($params['image']) && \auth()->user()->image != $params['image']){
                removeImage(\auth()->user()->image);
                $data['image'] = moveImage($params['image'], 'users');
            }
            $user = User::where(['id' => \auth()->user()->id])->firstOrFail();
            $user->update($data);
            return ['action' => 'status', 'msg' => 'Profile updated successfully.'];
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
            'name' => 'required',
            'phone' => 'required|regex:/^(?:\+)[0-9]/',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
//            'email' => 'required|email|unique:users,email,'.\auth()->user()->id.',id,deleted_at,NULL',
        ];
    }

    public function authorize(ActionRequest $request): Response
    {
        if ($request->user()->isStore()) {
            return Response::deny('You are not authorized to perform this action.', 404);
        }
        return Response::allow();
    }

    public function withValidator(Validator $validator, ActionRequest $request): void
    {
        $validator->after(function (Validator $validator) use ($request) {
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
        return responseBuilder()->success($paramters['msg']);
    }

    public static function routes(Router $router)
    {
        $router->post('dashboard/update-user-profile', static::class)->name('dashboard.update-user-profile.submit');
    }
}
