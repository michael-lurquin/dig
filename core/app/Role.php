<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
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

    /**
     * Ajoute une permission ou un ensemble de permissions au rôle
     */
    public function attachPermission($permissions_id)
    {
        if ( !empty($permissions_id) )
        {
            $this->permissions()->attach($permissions_id);
        }
    }

    /**
     * Supprimer une permission ou un ensemble de permissions au rôle
     */
    public function detachPermission($permissions_id)
    {
        if ( !empty($permissions_id) )
        {
            $this->permissions()->detach($permissions_id);
        }
    }

    /**
     * Relationships
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
