<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use App\Http\Resources\AdsCollection;
use App\Http\Resources\CategoriesCollection;
use App\Http\Resources\FaqsCollection;
use App\Http\Resources\PageResource;
use App\Models\City;
use App\Models\Page;
use App\Services\CategoryService;
use App\Services\CityAreaService;
use App\Services\FaqService;
use App\Services\StoreAdService;
use App\Services\UploaderService;
use Illuminate\Http\Request;

//use Illuminate\Support\Facades\Request;

class IndexController extends Controller
{
    public function uploadImage(ImageRequest $request, $path, UploaderService $uploaderService)
    {
        try {
            $input = null;
            $isTinyMCEImage = false;
            if ($request->filled('path')) {
                $path = $request->path;
            }
            if ($request->hasFile('image')) {
                $input = $request->file('image');
            }
            if ($request->hasFile('file')) {
                $isTinyMCEImage = true;
                $input = $request->file('file');
            }
            if (!is_null($input)){
                $image = $uploaderService->uploadImage($input, $path, $input);
            }else{
                throw new \Exception(__('Something went wrong test'));
            }
            if($isTinyMCEImage){
                return response(['location' => $image['file_path']]);
            }
            return responseBuilder()->success(__('Image Uploaded'), $image);
        }catch (\Exception $e){
            return responseBuilder()->error($e->getMessage());
        }


    }

    public function adsSearch(StoreAdService $storeAdService){
        return responseBuilder()->success('success', new AdsCollection($storeAdService->storeAds(\request('store_id', null), \request('status', null), \request('area_id', null))));
    }

    public function citiesAndAreas(CityAreaService $areaService){
        return responseBuilder()->success('success', $areaService->getAllCitiesWithAreas());
    }

    public function categories(CategoryService $categoryService){
        return responseBuilder()->success('success', new CategoriesCollection($categoryService->getParentCategories()));
    }

    public function subcategories($id, CategoryService $categoryService){
        return responseBuilder()->success('success', new CategoriesCollection($categoryService->getSubCategories($id)));
    }

    public function settings(){
        return responseBuilder()->success('Settings', config('project_settings'));
    }

    public function page(Page $page){
        return responseBuilder()->success('Page', new PageResource($page));
    }

    public function faqs(FaqService $faqService){
        return responseBuilder()->success('Faqs', new FaqsCollection($faqService->getFaqs()));
    }
}
