<?php namespace App\Behaviour;

use App\Availability;

trait ListAvailability
{
    private function getListAvailability()
    {
        return Availability::orderBy('weight', 'asc')->lists('name', 'id')->toArray();
    }
}
