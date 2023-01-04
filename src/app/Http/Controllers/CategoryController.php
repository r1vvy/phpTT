<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    //
    public function list()
    {
        $items = Category::orderBy('name', 'asc')->get();
        return view(
            'category.list',
            [
                'title' => 'Kategorijas',
                'items' => $items
            ]
        );
    }
    public function create()
    {
        return view(
            'category.form',
            [
                'title' => 'Pievienot kategoriju',
                'category' => new Category(),
            ]
        );
    }
    private function saveCategoryData(Category $category, CategoryRequest $request)
    {
        $validatedData = $request->validated();
        $category->fill($validatedData);
        $category->save();
    }
    public function put(CategoryRequest $request)
    {
        $category = new Category();
        $this->saveCategoryData($category, $request);
        return redirect('/categories');
    }
    public function patch(Category $category, CategoryRequest $request)
    {
        $this->savecategoryData($category, $request);
        return redirect('/categories/update/' . $category->id);
    }
    public function update(Category $category)
    {
        return view(
            'category.form',
            [
                'title' => 'Rediģēt kategoriju',
                'category' => $category,
            ]
        );
    }
    public function delete(Category $category)
    {
        $category->delete();
        return redirect('/categories');
    }
}
