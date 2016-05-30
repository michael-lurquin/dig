<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'weight'];

    /**
     * Indicates if the model should be timestamped
     *
     * @var bool
     */
    public $timestamps = FALSE;

    // Relation N:1 avec l'entité "Service"
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    // Chaîne utilisé dans l'URL pour identifier la disponibilité (par le nom et non par l'id)
    public function getRouteKeyName()
    {
        return 'name';
    }

    // Retourne le nom de la disponibilité avec la première lettre en majuscule
    public function getNameAttribute($value)
    {
      return ucfirst($value);
    }
}
