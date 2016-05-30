<?php namespace App\Behaviour;

use App\Availability;

trait ListAvailability
{
    // Récupère la liste (id et nom) des disponibilitées triés par poids
    private function getListAvailability()
    {
        return Availability::orderBy('weight', 'asc')->lists('name', 'id')->toArray();
    }
}
