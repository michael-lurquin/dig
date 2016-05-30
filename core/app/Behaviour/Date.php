<?php namespace App\Behaviour;

use Carbon\Carbon;

trait Date
{
    // Récupère la date de création sous un autre format
    public function getCreatedAtAttribute($value)
    {
        return $this->getDateFormated($value);
    }

    // Récupère la date de modification sous un autre format
    public function getUpdatedAtAttribute($value)
    {
        return $this->getDateFormated($value);
    }

    // Récupère la date de suppression sous un autre format
    public function getDeletedAtAttribute($value)
    {
        return $this->getDateFormated($value);
    }

    // callback qui récupère la date passée en paramètre avec le format voulu
    private function getDateFormated($value)
    {
        return !empty($value) ? Carbon::parse($value)->format('d/m/Y') : '';
    }

    // Enregistre la date de création sous un autre format
    public function setCreatedAtAttribute($value)
    {
        return $this->setDateFormated($value, 'created_at');
    }

    // Enregistre la date de modification sous un autre format
    public function setUpdatedAtAttribute($value)
    {
        return $this->setDateFormated($value, 'updated_at');
    }

    // Enregistre la date de suppression sous un autre format
    public function setDeletedAtAttribute($value)
    {
        return $this->setDateFormated($value, 'deleted_at');
    }

    // callback qui enregistre la date passée en paramètre avec le format voulu
    public function setDateFormated($value, $field)
    {
        $this->attributes[$field] = !empty($value) ? Carbon::createFromFormat('Y-m-d H:i:s', $value) : NULL;
    }
}
