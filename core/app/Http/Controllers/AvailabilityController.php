<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AvailabilityRequest;

use App\Availability;
use App\Behaviour\ListAvailability;

class AvailabilityController extends Controller
{
    use ListAvailability;

    // Vérification des permissions de l'utilisateur, a-t-il la permission de gestion des disponibilitées
    public function __construct()
    {
        $this->middleware('permission:manage_availabilities');
    }

    // Retourne la vue qui liste toutes les disponibilitées : /availability : GET
    public function index(Request $request)
    {
        return view('availabilities.index')->withAvailabilities($this->getListAvailability(TRUE));
    }

    // Retourne la vue de création d'une disponibilitée : /availability/create : GET
    public function create()
    {
        return view('availabilities.create');
    }

    // Enregistre la création d'une disponibilitée : POST
    public function store(AvailabilityRequest $request)
    {
        $availability = Availability::create([
          'name'      => $request->name,
          'weight'    => count($this->getListAvailability()),
        ]);

        return redirect()->route('availability.index')->withSuccess("La disponibilité : <strong>$request->name</strong> a été créée avec succès");
    }

    // Retourne la vue d'édition d'une disponibilitées : /availability/xxx/edit
    public function edit(Availability $availability)
    {
        return view('availabilities.edit')->withAvailability($availability);
    }

    // Enregistre la modification d'une disponibilitée : PUT
    public function update(AvailabilityRequest $request, Availability $availability)
    {
        $availability->name = $request->name;
        $availability->save();

        return redirect()->route('availability.index')->withSuccess("La disponibilité : <strong>$request->name</strong> a été modifiée avec succès");
    }

    // Supprime une disponibilitée : /availability/xxx : DELETE
    public function destroy(Request $request, Availability $availability)
    {
        $availability->delete();

        return redirect()->route('availability.index')->withSuccess("La disponibilité : <strong>$availability->name</strong> a été supprimée avec succès");
    }
}
