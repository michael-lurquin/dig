<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
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

    // Relation N:N avec l'entité "Service"
    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    // Chaîne utilisé dans l'URL pour identifier la catégorie (par le nom et non par l'id)
    public function getRouteKeyName()
    {
        return 'name';
    }
}
