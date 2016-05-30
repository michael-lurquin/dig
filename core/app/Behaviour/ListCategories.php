<?php namespace App\Behaviour;

use App\Category;

trait ListCategories
{
    // Récupère la liste (id et nom) des catégories triés par poids
    private function getListCategories()
    {
        return Category::orderBy('weight', 'asc')->lists('name', 'id')->toArray();
    }
}
