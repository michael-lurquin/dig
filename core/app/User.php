<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Behaviour\Date;

class User extends Authenticatable
{
    use Date;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'role_id', 'poste'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function getRouteKeyName()
    {
        return 'email';
    }

    /**
     * Scope a query to only include poste users active.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePoste($query)
    {
        return $query->select('id', 'name', 'poste')->where('active', TRUE)->orderBy('name', 'asc')->get();
    }

    /*
     * Vérifie si l'utilisateur courant possède le role donné
     */
    public function hasRole($role)
    {
        if ( is_string($role) )
        {
            return $this->role->name == $role;
        }

        // Est utilisé pour les permissions : la permission peut-être attribuée à plusieurs rôles et chacun de ces rôles sont vérifié sur l'utilisateurcourant
        foreach ($role as $r)
        {
            if ( $this->hasRole($r->name) )
            {
                return TRUE;
            }
        }

        return FALSE;
    }

    /*
     * Assigne un rôle (ou l'ID du rôle) donné à l'utilisateur courant
     */
    public function assign($role)
    {
        if ( is_string($role) )
        {
            $this->update([
                'role_id' => Role::whereName($role)->firstOrFail()->id
            ]);
        }

        if ( is_numeric($role) )
        {
            $this->update(['role_id' => $role]);
        }
    }
}
