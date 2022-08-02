<?php

namespace App\Http\Controllers\Admin;

use App\DTO\SaveAdminProfileDTO;
use App\Http\Dtos\AdminDto;
use App\Http\Libraries\Uploader;
use App\Http\Repositories\AdminRepository;
use App\Http\Requests\AdminRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveAdminProfileRequest;
use App\Http\Requests\ImageRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\City;
use App\Models\Faq;
use App\Models\Service;
use App\Models\User;
use App\Services\AdminService;
use Exception;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $userCount = User::where('user_type', User::$USER)->count();
        $storesCount = User::where('user_type', User::$STORE)->count();
        $servicesCount = Service::count();
        $categoriesCount = Category::parent()->count();
        $faqCount = Faq::count();
        $articlesCount = Article::count();
        $citiesCount = City::parent()->count();
        return view('admin.dashboard.index', [
            'users' => $userCount,
            'stores' => $storesCount,
            'services' => $servicesCount,
            'categories' => $categoriesCount,
            'faqs' => $faqCount,
            'articles' => $articlesCount,
            'cities' => $citiesCount
        ]);
    }

    public function editProfile()
    {
        return view('admin.dashboard.profile.edit_profile',['languageId'=> 1]);
    }

    public function updateProfile(SaveAdminProfileRequest $request, AdminService $adminService)
    {
        try {
            $adminDto = SaveAdminProfileDTO::fromRequest($request);
            $admin = $adminService->save($adminDto);
            return redirect(route('admin.dashboard.edit-profile'))->with('status', 'Profile update successfully');
        }catch (Exception $e){
            return back()->withErrors($e->getMessage());

        }
    }



}
