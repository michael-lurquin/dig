<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'service_id', 'user_id', 'field', 'old_value', 'new_value', 'valid'];

    // Relation 1:N avec l'entité "User"
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation 1:N avec l'entité "Service"
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Liste des champs avec le label adéquat pour les afficher dans la page de révision
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

    // Retourne le label du champ correspondant dans la liste des $fieldFormatter
    public function getField()
    {
        return isset($this->fieldFormatter[$this->field]) ? $this->fieldFormatter[$this->field] : '-';
    }

    // Retourne la valeur du champ correspondant dans la liste des $fieldFormatter
    public function getValue($value)
    {
        if ( isset($this->fieldFormatter[$this->field]) )
        {
            // if ( $this->field == 'category_id' )
            // {
            //     return \App\Category::findOrFail($value)->name;
            // }
            // elseif ( $this->field == 'availability_id' )
            // {
            //     return ucfirst(\App\Availability::findOrFail($value)->name);
            // }
            if ( $this->field == 'agent_responsable' /* || $this->field == 'agent_responsable_suppleant' || $this->field == 'autres_agents' */ )
            {
                // Retourne le nom de l'utilisateur (agent_responsable) au lieu de son ID
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
