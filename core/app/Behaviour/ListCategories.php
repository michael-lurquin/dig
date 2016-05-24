<?php namespace App\Behaviour;

use App\Category;

trait ListCategories
{
    private function getListCategories()
    {
        return Category::orderBy('weight', 'asc')->lists('name', 'id')->toArray();
    }
}
