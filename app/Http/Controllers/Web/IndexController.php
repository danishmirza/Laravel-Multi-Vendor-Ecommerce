<?php

namespace App\Http\Controllers\Web;

use App\DTO\FilterServiceDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactUsRequest;
use App\Models\Page;
use App\Notifications\SendContactUsEmail;
use App\Services\CategoryService;
use App\Services\FaqService;
use App\Services\PageService;
use App\Services\StoreAdService;
use App\Services\StoreServiceService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller
{
    public function index(
        StoreServiceService $serviceService,
        FaqService $faqService,
        CategoryService $categoryService,
        StoreAdService $storeAdService
    )
    {
        $featuredData = ['is_featured' => 1];
        $offeredData = ['is_offered' => 1];
        if(Session::has('client_area')){
            $featuredData['area_id'] =  Session::get('client_area');
            $offeredData['area_id'] =  Session::get('client_area');
        }
//        dd( $categoryService->getCategoriesAndSubcategories()[0]->subcategories->pluck('id')->toArray());
        return view('web.front.index', [
            'featuredServices' => $serviceService->filterServices(FilterServiceDTO::fromCollection(collect($featuredData))),
            'offeredServices' => $serviceService->filterServices(FilterServiceDTO::fromCollection(collect($offeredData))),
            'faqs' => $faqService->getFaqs(5),
            'categories' => $categoryService->getCategoriesAndSubcategories(),
            'ads' => $storeAdService->storeAds(null, 'approved', Session::get('client_area', null))
        ]);
    }

    public function aboutUs(PageService $pageService)
    {
//        dd($pageService->getAboutUs());
        return view('web.front.about-us', ['pages' => $pageService->getAboutUs()]);
    }

    public function page(Page $page)
    {
        return view('web.front.page', ['page' => $page]);
    }

    public function contactUs(){
        $subjects = config('project_settings.contact_us_subjects_'.app()->getLocale());
        $subjects = explode(',', $subjects);
        return view('web.front.contact-us', ['subjects' => $subjects]);
    }

    public function selectArea(Request $request){
        if($request->has('header_area')){
            Session::put('client_area', $request->get('header_area'));
        }
        return redirect()->back()->with('success', 'Area selected successfully');
    }

}
