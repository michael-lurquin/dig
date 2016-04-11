<?php namespace App\Behaviour;

use App\Service;

trait Sluggable {

    public function setSlugAttribute($value)
    {
        if ( empty($value) )
        {
            $slug = str_slug($this->title);

            // $this->attributes['slug'] = $this->makeSlugUnique($slug);
            $this->attributes['slug'] = $slug;
        }
        else
        {
            $this->attributes['slug'] = $value;
        }
    }

    private function makeSlugUnique($slug)
    {
        $list = $this->getExistingSlugs($slug)->toArray();

        if ( count($list) === 0 || !in_array($slug, $list) || (array_key_exists($this->getKey(), $list) && $list[$this->getKey()] === $slug) )
        {
            return $slug;
        }

        $suffix = $this->generateSuffix($slug, $list);

        return $slug . '-' . $suffix;
    }

    protected function generateSuffix($slug, $list)
    {
        $separator = '-';
        $len = strlen($slug . $separator);

        // If the slug already exists, but belongs to
        // our model, return the current suffix.
        if ( $this->id === array_search($this->slug, $list) )
        {
            $suffix = explode($separator, $this->slug);
            return end($suffix);
        }

        array_walk($list, function (&$value, $key) use ($len) {
            $value = intval(substr($value, $len));
        });

        // find the highest increment
        rsort($list);

        return reset($list) + 1;
    }

    private function getExistingSlugs($slug)
    {
        $instance = new static;

        //check for direct match or something that has a separator followed by a suffix
        $query = $instance->where(function($query) use($slug) {
            $query->where('slug', $slug);
            $query->orWhere('slug', 'LIKE', $slug . '-' . '%');
        });

        // get a list of all matching slugs
        $list = $query->lists('slug', $this->getKeyName());

        return $list instanceof Collection ? $list->all() : $list;
    }

}
