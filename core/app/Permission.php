<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['name', 'label', 'description'];

    /**
     * Indicates if the model should be timestamped
     *
     * @var bool
     */
    public $timestamps = FALSE;

    /**
     * Relationships
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
