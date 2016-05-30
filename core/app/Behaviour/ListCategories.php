<?php namespace App\Behaviour;

use App\Category;

trait ListCategories
{
    // Récupère la liste (id et nom) des catégories triés par poids
    private function getListCategories($paginate = FALSE)
    {
        return $paginate ? Category::orderBy('weight', 'asc')->paginate(10) : Category::orderBy('weight', 'asc')->lists('name', 'id')->toArray();
    }
}
