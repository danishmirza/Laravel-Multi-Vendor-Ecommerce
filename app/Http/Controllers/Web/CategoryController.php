<?php


namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    public function index(CategoryService $categoryService)
    {
        return view('web.front.categories.index', ['categories' => $categoryService->getParentCategories()]);
    }

    public function subcategories(Category $category, CategoryService $categoryService)
    {
        return view('web.front.categories.subcategories',  ['categories' => $categoryService->getSubCategories($category->id)]);
    }

}
