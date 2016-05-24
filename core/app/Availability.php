<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    public $table = 'availability';

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

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
