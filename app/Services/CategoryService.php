<?php


namespace App\Services;


use App\DTO\SaveCategoryDTO;
use App\Models\Category;

class CategoryService
{
    public function getAllCategoriesWithOrWithoutSubcategories(){
        return Category::with('subcategories:id,title,parent_id')->where('parent_id', 0)->get();
    }

    public function getAllCategoriesWithSubcategories(){
        return Category::whereHas('subcategories')->with('subcategories:id,title,parent_id')->where('parent_id', 0)->get();
    }

    public function getParentCategories(){
        return Category::parent()->whereHas('subcategories')->select('id', 'title', 'image')->orderBy('id', 'asc')->paginate(8);
    }

    public function getSubCategories($categoryId){
        return Category::where(['parent_id' => $categoryId])->select('id', 'title', 'image')->orderBy('id', 'asc')->paginate(10);
    }

    public function getCategoriesAndSubcategories(){
        return Category::parent()->whereHas('subcategories')->with(['subcategories:id,parent_id,title'])->select('id', 'title', 'image', 'content')->orderBy('id', 'asc')->paginate(8);
    }

    public function getStoreCategories($storeId){
        return Category::parent()->whereHas('services', function($query) use($storeId){
            $query->where('store_id', $storeId);
        })->select('id', 'title', 'image')->orderBy('id', 'asc')->get();
    }

    public function save(SaveCategoryDTO $categoryDTO, $parent_id, $id)
    {
        try {
            $data = $categoryDTO->all();
            $data['parent_id'] = $parent_id;
            return Category::updateOrCreate(['id' => $id], $data);
        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }
    }
}
