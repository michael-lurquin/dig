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
    ];

    public function getField()
    {
        return isset($this->fieldFormatter[$this->field]) ? $this->fieldFormatter[$this->field] : '-';
    }
}
