<?php

namespace App\Http\Controllers\Admin;

use App\DTO\SaveCategoryDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    public function index(CategoryService $categoryService)
    {
        return view('admin.dashboard.categories.index', ['categories' => $categoryService->getAllCategoriesWithOrWithoutSubcategories()]);
    }

    public function create(Category $category)
    {
        return view('admin.dashboard.categories.edit', [
            'parent' => true,
            'heading' => 'Add Category',
            'categoryId' => 0,
            'category' => $category->getInitialObject(),
            'action' => route('admin.dashboard.categories.update', 0),
        ]);
    }

    public function edit(Category $category)
    {
        if(empty($category->content)){
            $category->content = ['en' => '', 'ar' => ''];
        }
        return view('admin.dashboard.categories.edit', [
            'parent' => true,
            'heading' => 'Edit Category',
            'categoryId' => $category->id,
            'category' => $category,
            'action' => route('admin.dashboard.categories.update', $category->id),
        ]);
    }

    public function update(SaveCategoryRequest $request, $id, CategoryService $categoryService)
    {
        try {
            $categoryService->save(SaveCategoryDTO::fromRequest($request), 0, $id);
            return redirect(route('admin.dashboard.categories.index'))->with('status', ($id == 0) ? 'Category added successfully.': 'Category updated successfully.');
        } catch (\Exception $e) {
            return response(['err'=>$e->getMessage()]);
        }
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return response(['msg' => 'Deleted Successfully']);
        } catch (\Exception $e) {
            return response(['err' => 'Unable to delete'], 400);
        }
    }

}
