<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;

use App\Category;
use App\Behaviour\ListCategories;

class CategoryController extends Controller
{
    use ListCategories;

    public function __construct()
    {
        $this->middleware('permission:manage_categories');
    }

    public function index(Request $request)
    {
        $categories = $this->getListCategories();

        return view('categories.index')->withCategories($categories);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(CategoryRequest $request)
    {
        $category = Category::create([
          'name'      => $request->name,
        ]);

        return redirect()->route('category.index')->withSuccess("La catégorie : <strong>$request->name</strong> a été créée avec succès");
    }

    public function edit(Category $category)
    {
        return view('categories.edit')->withCategory($category);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->name = $request->name;
        $category->save();

        return redirect()->route('category.index')->withSuccess("La catégorie : <strong>$request->name</strong> a été modifiée avec succès");
    }

    public function destroy(Request $request, Category $category)
    {
        $category->delete();

        return redirect()->route('category.index')->withSuccess("La catégorie : <strong>$category->name</strong> a été supprimée avec succès");
    }
}
