<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ServiceRequest;
use App\Service;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:service_delete', ['only' => 'destroy']);
        $this->middleware('permission:service_restore', ['only' => 'restore']);
    }

    public function index(Request $request)
    {
    		if ( $request->user()->can('service_restore') )
    		{
    		  $services = Service::withTrashed()->with('user')->get();
    		}
    		else
    		{
    		  $services = Service::with('user')->get();
    		}

        return view('services.index')->withServices($services);
    }

    public function show(Service $service)
    {
        return view('services.show')->withService($service);
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(ServiceRequest $request)
    {
        $request->user()->services()->create([
            'title' => $request->title,
            'slug' => $request->slug,
        ]);

        return redirect()->route('service.index')->withSuccess("Le service : <strong>$request->title</strong> a été créé avec succès");
    }

    public function edit(Service $service)
    {
        return view('services.edit')->withService($service);
    }

    public function update(ServiceRequest $request, Service $service)
    {
        // Pas de modifications réel sans validation
        $fillable = $service['fillable'];

        $original = $service->toArray();
        $originalData = [];

        foreach($fillable as $field)
        {
            if ( isset($original[$field]) )
            {
                $originalData[$field] = $original[$field];
            }
        }

        $updatedData = $request->only($fillable);

        $diff = array_diff($updatedData, $originalData);

        foreach ($diff as $field => $value)
        {
            $service->revisions()->create([
                'user_id' => $request->user()->id,
                'field' => $field,
                'old_value' => $originalData[$field],
                'new_value' => $updatedData[$field],
            ]);
        }

        return redirect()->route('service.index')->withSuccess("Le service : <strong>$service->title</strong> a été modifié avec succès");
    }

    public function destroy(Request $request, Service $service)
    {
    		$service->user_id = $request->user()->id;
    		$service->save();
        $service->delete();

        return redirect()->route('service.index')->withSuccess("Le service : <strong>$service->title</strong> a été supprimé avec succès");
    }
    
    public function restore(Request $request, $slug)
    {
    		$service = Service::withTrashed()->whereSlug($slug)->first();
    		$service->user_id = $request->user()->id;
    		$service->deleted_at = NULL;
    		$service->save();
    		
    		return redirect()->route('service.index')->withSuccess("Le service : <strong>$service->title</strong> a été restauré avec succès");
    }
}
