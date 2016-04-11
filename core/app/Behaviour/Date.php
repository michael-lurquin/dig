<?php namespace App\Behaviour;

use Carbon\Carbon;

trait Date
{
    public function getCreatedAtAttribute($value)
    {
        return $this->getDateFormated($value);
    }

    public function getUpdatedAtAttribute($value)
    {
        return $this->getDateFormated($value);
    }

    public function getDeletedAtAttribute($value)
    {
        return $this->getDateFormated($value);
    }

    private function getDateFormated($value)
    {
        return !empty($value) ? Carbon::parse($value)->format('d/m/Y') : '';
    }


    public function setCreatedAtAttribute($value)
    {
        return $this->setDateFormated($value, 'created_at');
    }

    public function setUpdatedAtAttribute($value)
    {
        return $this->setDateFormated($value, 'updated_at');
    }

    public function setDeletedAtAttribute($value)
    {
        return $this->setDateFormated($value, 'deleted_at');
    }

    public function setDateFormated($value, $field)
    {
        $this->attributes[$field] = !empty($value) ? Carbon::createFromFormat('Y-m-d H:i:s', $value) : NULL;
    }
}
