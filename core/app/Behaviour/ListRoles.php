<?php namespace App\Behaviour;

use App\Role;

trait ListRoles
{
    // Récupère la liste (id et nom) des rôles triés par poids
    private function getListRoles()
    {
        return Role::orderBy('weight', 'asc')->lists('name', 'id')->toArray();
    }
}
