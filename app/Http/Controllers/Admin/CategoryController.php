<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function showNewCategoryForm() {
        return view('admin.categories.new-category-form');
    }

    public function createNewCategory (AddCategoryRequest $request) {
        $category = new Category();
        $category->title = $request->title;
        $category->save();
        return redirect(route('show-categories'));
    }

    public function showCategories() {
        $categories = Category::all()->sortBy('title')->paginate(8); ;
        return view('admin.categories.categories')->with('categories', $categories);
    }

    public function showEditCategoryForm($categoryId) {
        $category = Category::findOrFail($categoryId);
        return view('admin.categories.edit-category-form')->with('category', $category);
    }

    public function updateCategory(AddCategoryRequest $request, $categoryId) {
        $category = Category::findOrFail($categoryId);
        $category->title = $request->title;
        $category->save();
        return redirect(route('show-categories'));
    }

    public function deleteCategory($categoryId) {
        $category = Category::findOrFail($categoryId);
        $category->delete();
        return redirect(route('show-categories'));
    }    
}
