<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;

use App\Category;
use App\Behaviour\ListCategories;

class CategoryController extends Controller
{
    use ListCategories;

    // Vérification des permissions de l'utilisateur, a-t-il la permission de gestion des categories
    public function __construct()
    {
        $this->middleware('permission:manage_categories');
    }

    // Retourne la vue qui liste toutes les catégories : /category : GET
    public function index(Request $request)
    {
        $categories = $this->getListCategories(TRUE);

        return view('categories.index')->withCategories($categories);
    }

    // Retourne la vue de création d'une catégorie : /category/create : GET
    public function create()
    {
        return view('categories.create');
    }

    // Enregistre la création d'une catégorie : POST
    public function store(CategoryRequest $request)
    {
        $category = Category::create([
          'name'      => $request->name,
        ]);

        return redirect()->route('category.index')->withSuccess("La catégorie : <strong>$request->name</strong> a été créée avec succès");
    }

    // Retourne la vue d'édition d'une catégorie : /category/xxx/edit
    public function edit(Category $category)
    {
        return view('categories.edit')->withCategory($category);
    }

    // Enregistre la modification d'une catégorie : PUT
    public function update(CategoryRequest $request, Category $category)
    {
        $category->name = $request->name;
        $category->save();

        return redirect()->route('category.index')->withSuccess("La catégorie : <strong>$request->name</strong> a été modifiée avec succès");
    }

    // Supprime une catégorie : /category/xxx : DELETE
    public function destroy(Request $request, Category $category)
    {
        $category->delete();

        return redirect()->route('category.index')->withSuccess("La catégorie : <strong>$category->name</strong> a été supprimée avec succès");
    }
}
