<?php


namespace App\Actions\Auth;


use App\Models\StoreArea;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateStoreProfile
{
    use AsAction;

    public function handle($params)
    {   DB::beginTransaction();
        try {
            $data = [
                'store_name' => $params['store_name'],
                'detail' => $params['detail'],
                'phone' => $params['phone'],
                'address' => $params['address'],
                'latitude' => $params['latitude'],
                'longitude' => $params['longitude'],
                'city_id' => $params['city_id'],
            ];
            if(isset($params['image']) && \auth()->user()->image != $params['image']){
                removeImage(\auth()->user()->image);
                $data['image'] = moveImage($params['image'], 'users');
            }
            if(\auth()->user()->trade_license != $params['trade_license']){
                removeImage(\auth()->user()->trade_license);
                $data['trade_license'] = moveImage($params['trade_license'], 'trade_licenses');
                $data['trade_license_verified'] = 0;
            }
            if(\auth()->user()->city_id != $params['city_id']){
                StoreArea::where(['user_id' => \auth()->user()->id])->destroy();
            }
            $user = User::where(['id' => \auth()->user()->id])->firstOrFail();
            $user->update($data);
            DB::commit();
            return ['action' => 'status', 'msg' => 'Profile updated successfully.'];
        }catch (\Exception $exception){
            DB::rollBack();
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
            'store_name' => 'required|array|min:2|max:2',
            'detail' => 'required|array|min:2|max:2',
            'store_name.en' => 'required',
            'phone' => 'required|regex:/^(?:\+)[0-9]/',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
//            'email' => 'required|email|unique:users,email,'.\auth()->user()->id.',id,deleted_at,NULL',
            'trade_license' => 'required',
            'city_id' => 'required|exists:cities,id,parent_id,0,deleted_at,NULL'
        ];
    }

    public function authorize(ActionRequest $request): Response
    {
        if ($request->user()->isUser()) {
            return Response::deny('You are not authorized to perform this action.', 404);
        }
        return Response::allow();
    }

    public function withValidator(Validator $validator, ActionRequest $request): void
    {
        $validator->after(function (Validator $validator) use ($request) {
            if (!file_exists( public_path().'/' . $request->get('trade_license'))) {
                $validator->errors()->add('trade_license', 'Trade License was not uploaded correctly. Please upload again.');
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
        $router->post('dashboard/update-store-profile', static::class)->name('dashboard.update-store-profile.submit');
    }
}
