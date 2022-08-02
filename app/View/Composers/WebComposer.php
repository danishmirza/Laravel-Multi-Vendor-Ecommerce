<?php


namespace App\View\Composers;


use App\Services\CategoryService;
use App\Services\CityAreaService;
use Illuminate\View\View;

class WebComposer
{
    public function compose(View $view)
    {
        $categoryService = New CategoryService();
        $citiesAndAreas = New CityAreaService();
        $view->with([
            'user' => auth()->user(),
            'headerCategories'=> $categoryService->getCategoriesAndSubcategories(),
            'headerCities' => $citiesAndAreas->getAllCitiesWithAreas()
        ]);
    }

}
