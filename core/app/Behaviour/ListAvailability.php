<?php namespace App\Behaviour;

use App\Availability;

trait ListAvailability
{
    // Récupère la liste (id et nom) des disponibilitées triés par poids
    private function getListAvailability($paginate = FALSE)
    {
        return $paginate ? Availability::orderBy('weight', 'asc')->paginate(10) : Availability::orderBy('weight', 'asc')->lists('name', 'id')->toArray();
    }
}
