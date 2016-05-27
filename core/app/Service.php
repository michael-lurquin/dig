<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// use App\Behaviour\Date;
use App\Behaviour\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Service extends Model
{
    // use Date;
    use Sluggable;
    use SoftDeletes;

    protected $fillable = [
      'title',
      'slug',
      'identifier',
      'availability_id',
      'description_categorie',
      'contexte',
      'description',
      'exclus_perimetre',
      'prerequis',
      'contact_general',
      'cout_client',
      'delai_charge',
      'delai_oeuvre',
      'delai_tiers',
      'marge_securite',
      'remarque_delai',
      'rh_interne',
      'cout_externalisation',
      'agent_responsable',
      'intervenants_externes',
      'identifiant_procedure',
      'resume_procedure',
    ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function availability()
    {
        return $this->belongsTo(Availability::class);
    }

    public function revisions()
    {
        return $this->hasMany(Revision::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function ars()
    {
        return $this->belongsToMany(User::class, 'ars_service', 'service_id', 'user_id');
    }

    public function aai()
    {
        return $this->belongsToMany(User::class, 'aai_service', 'service_id', 'user_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public static function boot()
    {
        parent::boot();

        // Révisions
        static::created(function($instance) {
            $instance->postCreate();
        });

        // Services
        // static::created(function($instance) {
        //     $instance->identifier = "DIG-CATEG-$instance->id";
        //     $instance->save();
        // });
    }

    private function postCreate()
    {
        $this->revisions()->create([
            'name' => 'Création',
            'user_id' => $this->getUserId(),
            'field' => 'created_at',
            'new_value' => $this->created_at,
        ]);
    }

    private function getUserId()
    {
        return Auth::check() ? Auth::user()->id : NULL;
    }

    public function getDelaiRealisation()
    {
        return $this->delai_charge + $this->delai_oeuvre + $this->delai_tiers + $this->marge_securite;
    }
}
