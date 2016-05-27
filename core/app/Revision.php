<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    protected $fillable = ['name', 'service_id', 'user_id', 'field', 'old_value', 'new_value', 'valid'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    private $fieldFormatter = [
        'identifier' => 'Identifiant',
        'title' => 'Titre',
        'slug' => 'Chemin',
        'availability_id' => 'Statut',
        'category_id' => 'Catégorie',
        'description_categorie' => 'Decription de la catégorie',
        'contexte' => 'Contexte',
        'description' => 'Description',
        'exclus_perimetre' => 'Élements exclus du périmètre',
        'prerequis' => 'Prérequis',
        'contact_general' => 'Contact général',
        'cout_client' => 'Coût pour le client',
        'delai_charge' => 'Délai de prise en charge',
        'delai_oeuvre' => 'Délai de mise en oeuvre par la DIG',
        'delai_tiers' => 'Délai dépendant de tiers',
        'marge_securite' => 'Marge de sécurité',
        'remarque_delai' => 'Remarque sur le délai',
        'rh_interne' => 'RH interne',
        'cout_externalisation' => 'Coût d\'externalisation',
        'agent_responsable' => 'Agent DIG responsable',
        'agent_responsable_suppleant' => 'Agent DIG responsable supléant',
        'autres_agents' => 'Autres agents DIG impliqués',
        'intervenants_exrternes' => 'Intervenants externes',
        'identifiant_procedure' => 'Identifiant procédure',
        'resume_procedure' => 'Résumé de la procédure',
    ];

    public function getField()
    {
        return isset($this->fieldFormatter[$this->field]) ? $this->fieldFormatter[$this->field] : '-';
    }

    public function getValue($value)
    {
        if ( isset($this->fieldFormatter[$this->field]) )
        {
            if ( $this->field == 'category_id' )
            {
                return \App\Category::findOrFail($value)->name;
            }
            elseif ( $this->field == 'availability_id' )
            {
                return ucfirst(\App\Availability::findOrFail($value)->name);
            }
            elseif ( $this->field == 'agent_responsable' || $this->field == 'agent_responsable_suppleant' || $this->field == 'autres_agents' )
            {
                return \App\User::findOrFail($value)->name;
            }
            else
            {
              return $value;
            }
        }

        return '-';
    }
}
