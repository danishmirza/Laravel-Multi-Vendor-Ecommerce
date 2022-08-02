<?php


namespace App\Http\Controllers\Admin;


use App\DTO\SaveCategoryDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;

class SubcategoryController extends Controller
{

    public function create(Category $category)
    {
        $subcategory = new Category();
        return view('admin.dashboard.categories.edit', [
            'parent' => false,
            'heading' => 'Add Subcategory',
            'categoryId' => 0,
            'category' => $subcategory->getInitialObject(),
            'action' => route('admin.dashboard.categories.subcategories.update', ['category' => $category->id, 'subcategory' => 0]),
        ]);
    }

    public function edit(Category $category, Category $subcategory)
    {
        return view('admin.dashboard.categories.edit', [
            'parent' => false,
            'heading' => 'Edit Subcategory',
            'categoryId' => $subcategory->id,
            'category' => $subcategory,
            'action' => route('admin.dashboard.categories.subcategories.update', ['category' => $category->id, 'subcategory' => $subcategory->id]),
        ]);
    }

    public function update(SaveCategoryRequest $request, $categoryId, $id, CategoryService $categoryService)
    {
        try {
            $categoryService->save(SaveCategoryDTO::fromRequest($request), $categoryId, $id);
            return redirect(route('admin.dashboard.categories.index'))->with('status', ($id == 0) ? 'Category added successfully.': 'Category updated successfully.');
        } catch (\Exception $e) {
            return response(['err'=>$e->getMessage()]);
        }
    }

}
