<?php namespace App\Behaviour;

use App\Role;

trait ListRoles
{
    private function getListRoles()
    {
        return Role::orderBy('weight', 'asc')->lists('name', 'id')->toArray();
    }
}
