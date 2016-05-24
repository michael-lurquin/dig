<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ServiceRequest;
use App\Service;
use App\Behaviour\ListAvailability;
use App\Behaviour\ListCategories;

class ServiceController extends Controller
{
    use ListAvailability;
    use ListCategories;

    private $dontKeepRevision = [
        'identifier',
        'slug',
    ];

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
        $availability = $this->getListAvailability();
        $categories = $this->getListCategories();

        return view('services.create')->withAvailability($availability)->withCategories($categories);
    }

    public function store(ServiceRequest $request)
    {
        $service = $request->user()->services()->create([
            'identifier' => $request->identifier,
            'title' => $request->title,
            'slug' => $request->slug,
            'availability_id' => $request->availability_id,
            'description_categorie' => $request->description_categorie,
            'contexte' => $request->contexte,
            'description' => $request->description,
            'exclus_perimetre' => $request->exclus_perimetre,
            'prerequis' => $request->prerequis,
            'contact_general' => $request->contact_general,
        ]);

        if ( $request->has('category_id') )
        {
            $service->categories()->sync($request->category_id);
        }

        return redirect()->route('service.index')->withSuccess("Le service : <strong>$request->title</strong> a été créé avec succès");
    }

    public function edit(Service $service)
    {
        $availability = $this->getListAvailability();
        $categories = $this->getListCategories();

        $service->categories_used = $service->categories->lists('id')->toArray();

        return view('services.edit')->withService($service)->withAvailability($availability)->withCategories($categories);
    }

    private function arrayRecursiveDiff($aArray1 = [], $aArray2 = [])
    {
        $aReturn = [];

        foreach ($aArray1 as $mKey => $mValue)
        {
            if ( array_key_exists($mKey, $aArray2) )
            {
                if ( is_array($mValue) )
                {
                    $aRecursiveDiff = $this->arrayRecursiveDiff($mValue, $aArray2[$mKey]);

                    if ( count($aRecursiveDiff) )
                    {
                        $aReturn[$mKey] = $aRecursiveDiff;
                    }
                }
                else
                {
                    if ( $mValue != $aArray2[$mKey] )
                    {
                        $aReturn[$mKey] = $mValue;
                    }
                }
            }
            else
            {
                $aReturn[$mKey] = $mValue;
            }
        }

        return $aReturn;
    }

    public function update(ServiceRequest $request, Service $service)
    {
        // Pas de modifications réel sans validation (depuis l'écran de révision)
        $fillable = $service['fillable'];
        $fillable[] = 'category_id';

        $original = $service->toArray();
        $original['category_id'] = $service->categories->lists('id')->toArray();
        $originalData = [];

        foreach($fillable as $field)
        {
            if ( isset($original[$field]) )
            {
                $originalData[$field] = $original[$field];
            }
        }

        if ( $request->has('category_id') )
        {
            foreach ($originalData['category_id'] as $id => $value)
            {
                $originalData['category_id'][$id] = (string) $value;
            }
        }

        $updatedData = $request->only($fillable);

        var_dump($updatedData);
        var_dump($originalData);
        $diff = $this->arrayRecursiveDiff($updatedData, $originalData);
        // dd($diff);
        $diff = empty($diff) ? $this->arrayRecursiveDiff($originalData, $updatedData) : $diff;

        foreach ($diff as $field => $value)
        {
            if ( !in_array($field, $this->dontKeepRevision) ) {

                if ( is_array($value) )
                {
                    foreach ($value as $id => $sub_value)
                    {
                        if ( isset($originalData[$field][$id]) && isset($updatedData[$field][$id]) )
                        {
                            if ( $originalData[$field][$id] != $updatedData[$field][$id] )
                            {
                                $service->revisions()->create([
                                    'name' => $request->get('name'),
                                    'user_id' => $request->user()->id,
                                    'field' => $field,
                                    'old_value' => $originalData[$field][$id],
                                    'new_value' => $updatedData[$field][$id],
                                ]);
                            }
                        }
                        else
                        {
                            $service->revisions()->create([
                                'name' => $request->get('name'),
                                'user_id' => $request->user()->id,
                                'field' => $field,
                                'old_value' => isset($originalData[$field][$id]) ? $originalData[$field][$id] : NULL,
                                'new_value' => isset($updatedData[$field][$id]) ? $updatedData[$field][$id] : NULL,
                            ]);
                        }
                    }
                }
                else
                {
                    $service->revisions()->create([
                        'name' => $request->get('name'),
                        'user_id' => $request->user()->id,
                        'field' => $field,
                        'old_value' => isset($originalData[$field]) ? $originalData[$field] : NULL,
                        'new_value' => isset($updatedData[$field]) ? $updatedData[$field] : NULL,
                    ]);
                }
            }
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
