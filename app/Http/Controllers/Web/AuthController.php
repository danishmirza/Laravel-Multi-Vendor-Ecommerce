<?php


namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Services\CityAreaService;

class AuthController extends Controller
{
    public function login()
    {
        return view('web.auth.login');
    }

    public function register()
    {
        return view('web.auth.register');
    }

    public function registerUser()
    {
        return view('web.auth.register-user');
    }

    public function registerStore(CityAreaService $cityAreaService)
    {
        return view('web.auth.register-store', ['cities' => $cityAreaService->getAllCitiesWithAreas()]);
    }

    public function forgotPassword()
    {
        return view('web.auth.forgot-password');
    }

    public function resetPassword()
    {
        return view('web.auth.reset-password', [
            'email'=> request('email', ''),
            'code' => request('code', '')
        ]);
    }
}
