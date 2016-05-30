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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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

    // Relation 1:N avec l'entité "User"
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation 1:N avec l'entité "Availability"
    public function availability()
    {
        return $this->belongsTo(Availability::class);
    }

    // Relation N:1 avec l'entité "Revision"
    public function revisions()
    {
        return $this->hasMany(Revision::class);
    }

    // Relation N:N avec l'entité "Category"
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    // Relation N:N avec l'entité "User" pour les "agents responsables suppléants"
    public function ars()
    {
        return $this->belongsToMany(User::class, 'ars_service', 'service_id', 'user_id');
    }

    // Relation N:N avec l'entité "User" pour les "autres agents impliqués"
    public function aai()
    {
        return $this->belongsToMany(User::class, 'aai_service', 'service_id', 'user_id');
    }

    // Chaîne utilisé dans l'URL pour identifier le nom du service (par le nom et non par l'id)
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Événement sur la création de service
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

    // callback apellé après la création d'un service
    private function postCreate()
    {
        $this->revisions()->create([
            'name' => 'Création',
            'user_id' => $this->getUserId(),
            'field' => 'created_at',
            'new_value' => $this->created_at,
        ]);
    }

    // Retourne l'ID de l'utilisateur connecté ou NULL
    private function getUserId()
    {
        return Auth::check() ? Auth::user()->id : NULL;
    }

    // Calcul le total du délai de réalisation
    public function getDelaiRealisation()
    {
        return $this->delai_charge + $this->delai_oeuvre + $this->delai_tiers + $this->marge_securite;
    }
}
