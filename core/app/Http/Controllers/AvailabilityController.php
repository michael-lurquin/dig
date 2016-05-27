<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AvailabilityRequest;

use App\Availability;

class AvailabilityController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage_availabilities');
        $this->list_availabilities = Availability::all();
    }

    public function index(Request $request)
    {
        return view('availabilities.index')->withAvailabilities($this->list_availabilities);
    }

    public function create()
    {
        return view('availabilities.create');
    }

    public function store(AvailabilityRequest $request)
    {
        $availability = Availability::create([
          'name'      => $request->name,
          'weight'    => count($this->list_availabilities),
        ]);

        return redirect()->route('availability.index')->withSuccess("La disponibilité : <strong>$request->name</strong> a été créée avec succès");
    }

    public function edit(Availability $availability)
    {
        return view('availabilities.edit')->withAvailability($availability);
    }

    public function update(AvailabilityRequest $request, Availability $availability)
    {
        $availability->name = $request->name;
        $availability->save();

        return redirect()->route('availability.index')->withSuccess("La disponibilité : <strong>$request->name</strong> a été modifiée avec succès");
    }

    public function destroy(Request $request, Availability $availability)
    {
        $availability->delete();

        return redirect()->route('availability.index')->withSuccess("La disponibilité : <strong>$availability->name</strong> a été supprimée avec succès");
    }
}
