<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    protected $fillable = ['service_id', 'user_id', 'field', 'old_value', 'new_value', 'valid'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    private $fieldFormatter = [
        'title' => 'Titre',
        'slug' => 'Chemin',
    ];

    public function getField()
    {
        return isset($this->fieldFormatter[$this->field]) ? $this->fieldFormatter[$this->field] : '-';
    }
}
