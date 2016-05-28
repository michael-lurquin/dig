<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ServiceRequest;
use App\Service;
use App\User;
use App\Behaviour\ListAvailability;
use App\Behaviour\ListCategories;

class ServiceController extends Controller
{
    use ListAvailability;
    use ListCategories;

    private $dontKeepRevision = [
        'identifier',
        'slug',
        'delai_realisation',
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
        $users = User::poste();

        return view('services.create')->withAvailability($availability)->withCategories($categories)->withUsers($users);
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
            'cout_client' => $request->cout_client,
            'delai_charge' => $request->delai_charge,
            'delai_oeuvre' => $request->delai_oeuvre,
            'delai_tiers' => $request->delai_tiers,
            'marge_securite' => $request->marge_securite,
            'remarque_delai' => $request->remarque_delai,
            'rh_interne' => $request->rh_interne,
            'cout_externalisation' => $request->cout_externalisation,
            'agent_responsable' => $request->agent_responsable,
            'intervenants_externes' => $request->intervenants_externes,
            'identifiant_procedure' => $request->identifiant_procedure,
            'resume_procedure' => $request->resume_procedure,
        ]);

        if ( $request->has('category_id') )
        {
            $service->categories()->sync($request->category_id);
        }

        if ( $request->has('agent_responsable_suppleant') )
        {
            $service->ars()->sync($request->agent_responsable_suppleant);
        }

        if ( $request->has('autres_agents') )
        {
            $service->aai()->sync($request->autres_agents);
        }

        return redirect()->route('service.index')->withSuccess("Le service : <strong>$request->title</strong> a été créé avec succès");
    }

    public function edit(Service $service)
    {
        $availability = $this->getListAvailability();
        $categories = $this->getListCategories();

        $service->categories_used = $service->categories->lists('id')->toArray();
        $service->ars = $service->ars->lists('id')->toArray();
        $service->aai = $service->aai->lists('id')->toArray();

        $users = User::poste();

        return view('services.edit')->withService($service)->withAvailability($availability)->withCategories($categories)->withUsers($users);
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
        $fillable[] = 'agent_responsable_suppleant';
        $fillable[] = 'autres_agents';

        $original = $service->toArray();
        $original['category_id'] = $service->categories->lists('id')->toArray();
        $original['agent_responsable_suppleant'] = $service->ars()->lists('id')->toArray();
        $original['autres_agents'] = $service->aai()->lists('id')->toArray();
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

        if ( $request->has('agent_responsable_suppleant') )
        {
            foreach ($originalData['agent_responsable_suppleant'] as $id => $value)
            {
                $originalData['agent_responsable_suppleant'][$id] = (string) $value;
            }
        }

        if ( $request->has('autres_agents') )
        {
            foreach ($originalData['autres_agents'] as $id => $value)
            {
                $originalData['autres_agents'][$id] = (string) $value;
            }
        }

        $updatedData = $request->only($fillable);

        $diff = $this->arrayRecursiveDiff($updatedData, $originalData);
        $diff = empty($diff) ? $this->arrayRecursiveDiff($originalData, $updatedData) : $diff;

        foreach ($diff as $field => $value)
        {
            if ( !in_array($field, $this->dontKeepRevision) ) {

                if ( is_array($value) )
                {
                    foreach ($value as $id => $sub_value)
                    {
                        if ( !isset($originalData[$field][$id]) && !isset($updatedData[$field][$id]) )
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

    public function export(Request $request, Service $service)
    {

    }
}
