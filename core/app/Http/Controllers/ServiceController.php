<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ServiceRequest;
use App\Service;
use App\User;
use App\Behaviour\ListAvailability;
use App\Behaviour\ListCategories;
use PhpOffice\PhpWord\PhpWord;

class ServiceController extends Controller
{
    use ListAvailability;
    use ListCategories;

    // Liste des champs qui ne sont pas révisionnés
    private $dontKeepRevision = [
        'identifier',
        'slug',
        'category_id',
        'agent_responsable_suppleant',
        'autres_agents',
    ];

    // Vérification des permissions de l'utilisateur, a-t-il la permission de "supprimer un service" et "restaurer un service"
    public function __construct()
    {
        $this->middleware('permission:service_delete', ['only' => 'destroy']);
        $this->middleware('permission:service_restore', ['only' => 'restore']);
    }

    // Retourne la vue qui liste tous les services : /service : GET (avec pour les utilisateurs qui ont la permission de "restaurer un service", d'avoir aussi la liste des services supprimés)
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

    // Retourne la vue d'un service : /service/xxx : GET
    public function show(Service $service)
    {
        return view('services.show')->withService($service);
    }

    // Retourne la vue de création d'un service : /service/create : GET
    public function create()
    {
        $availability = $this->getListAvailability();
        $categories = $this->getListCategories();
        $users = User::poste();

        return view('services.create')->withAvailability($availability)->withCategories($categories)->withUsers($users);
    }

    // Enregistre la création d'un service : POST
    public function store(ServiceRequest $request)
    {
        // Lié automatiquement avec le user_id de l'utilisateur qui l'a créé
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

    // Retourne la vue d'édition d'un service : /service/xxx/edit
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

    // callback qui retourne la différence des valeurs des champs enregistrés et ceux saisies par l'utilisateur
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

    // Enregistre la modification d'un service : PUT
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

        // if ( $request->has('category_id') )
        // {
        //     foreach ($originalData['category_id'] as $id => $value)
        //     {
        //         $originalData['category_id'][$id] = (string) $value;
        //     }
        // }
        //
        // if ( $request->has('agent_responsable_suppleant') )
        // {
        //     foreach ($originalData['agent_responsable_suppleant'] as $id => $value)
        //     {
        //         $originalData['agent_responsable_suppleant'][$id] = (string) $value;
        //     }
        // }
        //
        // if ( $request->has('autres_agents') )
        // {
        //     foreach ($originalData['autres_agents'] as $id => $value)
        //     {
        //         $originalData['autres_agents'][$id] = (string) $value;
        //     }
        // }

        $updatedData = $request->only($fillable);

        $diff = $this->arrayRecursiveDiff($updatedData, $originalData);
        $diff = empty($diff) ? $this->arrayRecursiveDiff($originalData, $updatedData) : $diff;

        foreach ($diff as $field => $value)
        {
            if ( !in_array($field, $this->dontKeepRevision) ) {

                // if ( is_array($value) )
                // {
                //     foreach ($value as $id => $sub_value)
                //     {
                //         if ( !isset($originalData[$field][$id]) && !isset($updatedData[$field][$id]) )
                //         {
                //             if ( $originalData[$field][$id] != $updatedData[$field][$id] )
                //             {
                //                 $service->revisions()->create([
                //                     'name' => $request->get('name'),
                //                     'user_id' => $request->user()->id,
                //                     'field' => $field,
                //                     'old_value' => $originalData[$field][$id],
                //                     'new_value' => $updatedData[$field][$id],
                //                 ]);
                //             }
                //         }
                //         else
                //         {
                //             if ( $originalData[$field][$id] != $updatedData[$field][$id] )
                //             {
                //                 $service->revisions()->create([
                //                     'name' => $request->get('name'),
                //                     'user_id' => $request->user()->id,
                //                     'field' => $field,
                //                     'old_value' => isset($originalData[$field][$id]) ? $originalData[$field][$id] : NULL,
                //                     'new_value' => isset($updatedData[$field][$id]) ? $updatedData[$field][$id] : NULL,
                //                 ]);
                //             }
                //         }
                //     }
                // }
                // else
                // {
                    if ( $originalData[$field] != $updatedData[$field] )
                    {
                        $service->revisions()->create([
                            'name' => $request->get('name'),
                            'user_id' => $request->user()->id,
                            'field' => $field,
                            'old_value' => isset($originalData[$field]) ? $originalData[$field] : NULL,
                            'new_value' => isset($updatedData[$field]) ? $updatedData[$field] : NULL,
                        ]);
                    }
                // }
            }
        }

        return redirect()->route('service.index')->withSuccess("Le service : <strong>$service->title</strong> a été modifié avec succès");
    }

    // Supprime un service : /service/xxx : DELETE
    public function destroy(Request $request, Service $service)
    {
        $service->user_id = $request->user()->id;
        $service->save();
        $service->delete();

        return redirect()->route('service.index')->withSuccess("Le service : <strong>$service->title</strong> a été supprimé avec succès");
    }

    // Restauration d'un service : /service/xxx/restore : GET
    public function restore(Request $request, $slug)
    {
  		$service = Service::withTrashed()->whereSlug($slug)->first();
  		$service->user_id = $request->user()->id;
  		$service->deleted_at = NULL;
  		$service->save();

  		return redirect()->route('service.index')->withSuccess("Le service : <strong>$service->title</strong> a été restauré avec succès");
    }

    // Export word d'un service : /service/xxx/export : GET
    public function export(Request $request, Service $service)
    {
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        $header = $section->addHeader();

        // Logo
        $header->addWatermark('img/COQ_SPW.png', ['marginTop' => 0, 'marginLeft' => -50]);

        // Styles
        $phpWord->addTitleStyle(1, ['name' => 'Calibri', 'size' => 26], ['align' => 'center']);
        $phpWord->addTitleStyle(2, ['name' => 'Calibri', 'size' => 16], ['align' => 'center']);
        $phpWord->addFontStyle('title', ['name' => 'Calibri', 'size' => 11, 'bold' => TRUE]);
        $phpWord->addFontStyle('text', ['name' => 'Calibri', 'size' => 11]);

        // Titre
        $section->addTextBreak(5);
        $section->addTitle($service->title, 1);

        // Description du service
        $section->addTextBreak(2);
        $section->addText('Identifiant du service : ', 'title');
        $section->addText('DIG-CATEG-' . $service->identifier, 'text');

        $section->addTextBreak();
        $section->addText('Disponibilité : ', 'title');
        $section->addText($service->availability->name, 'text');

        $section->addTextBreak();
        $section->addTitle('Description du service', 2);

        $section->addTextBreak();
        $section->addText('Catégorie(s) :', 'title');
        foreach($service->categories as $category)
        {
          $section->addListItem($category->name, 0, 'text');
        }

        $section->addTextBreak();
        $section->addText('Description de(s) (la) catégorie(s) : ', 'title');
        $section->addText($service->description_categorie, 'text');

        $section->addTextBreak();
        $section->addText('Contexte : ', 'title');
        $section->addText($service->contexte, 'text');

        $section->addTextBreak();
        $section->addText('Description : ', 'title');
        $section->addText($service->description, 'text');

        $section->addTextBreak();
        $section->addText('Éléments exclus du primètre : ', 'title');
        $section->addText($service->exclus_perimetre, 'text');

        $section->addTextBreak();
        $section->addText('Prérequis : ', 'title');
        $section->addText($service->prerequis, 'text');

        $section->addTextBreak();
        $section->addText('Contact général : ', 'title');
        $section->addText($service->contact_general, 'text');

        // Délais et coûts
        $section->addPageBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTitle('Délais et coûts', 2);

        $section->addTextBreak();
        $section->addText('Coût pour le client : ', 'title');
        $section->addText($service->cout_client . ' €', 'text');

        $section->addTextBreak();
        $section->addText('Délai de prise en charge : ', 'title');
        $section->addText($service->delai_charge . ' jour(s)', 'text');

        $section->addTextBreak();
        $section->addText('Délai de mise en oeuvre par la DIG : ', 'title');
        $section->addText($service->delai_oeuvre . ' jour(s)', 'text');

        $section->addTextBreak();
        $section->addText('Délai dépendant de tiers : ', 'title');
        $section->addText($service->delai_tiers . ' jour(s)', 'text');

        $section->addTextBreak();
        $section->addText('Marge de sécurité : ', 'title');
        $section->addText($service->marge_securite . ' jour(s)', 'text');

        $section->addTextBreak();
        $section->addText('Délai de réalisation : ', 'title');
        $section->addText($service->getDelaiRealisation() . ' jour(s)', 'text');

        $section->addTextBreak();
        $section->addText('Remarque éventuelle sur le délai de réalisation : ', 'title');
        $section->addText($service->remarque_delai, 'text');

        $section->addTextBreak();
        $section->addText('RH interne : ', 'title');
        $section->addText($service->rh_interne, 'text');

        $section->addTextBreak();
        $section->addText('Coût d\'externalisation : ', 'title');
        $section->addText($service->cout_externalisation . ' €', 'text');

        // Intervenants et procédure
        $section->addPageBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTitle('Intervenants et procédure', 2);

        $section->addTextBreak();
        $section->addText('Agent DIG responsable : ', 'title');
        $section->addText(User::findOrFail($service->agent_responsable)->name, 'text');

        $section->addTextBreak();
        $section->addText('Agent DIG responsable suppléant : ', 'title');
        foreach($service->ars as $ars)
        {
          $section->addListItem($ars->name, 0, 'text');
        }

        $section->addTextBreak();
        $section->addText('Autres agents DIG impliqués : ', 'title');
        foreach($service->aai as $aai)
        {
          $section->addListItem($aai->name, 0, 'text');
        }

        $section->addTextBreak();
        $section->addText('Intervenants externes : ', 'title');
        $section->addText($service->intervenants_externes, 'text');

        $section->addTextBreak();
        $section->addText('Identifiant procédure : ', 'title');
        $section->addText($service->identifiant_procedure, 'text');

        $section->addTextBreak();
        $section->addText('Résumé de la procédure : ', 'title');
        $section->addText($service->resume_procedure, 'text');

        $section->addTextBreak();
        $section->addTextBreak();
        $section->addText('Auteur / Dernière validation par : ', 'title');
        $section->addText(User::findOrFail($service->user_id)->name, 'text');

        // Save
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $filename = $service->slug . ".docx";
        $filePath = "tmp/$filename";

        $objWriter->save($filePath);

        if (file_exists($filePath))
        {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header("Content-Disposition: attachment; filename=$filename");
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));

            readfile($filePath);
            unlink($filePath);
        }
        else
        {
            return redirect('/')->withError("Impossible d'exporter le service : <strong>$service->title</strong> !");
        }
    }
}
