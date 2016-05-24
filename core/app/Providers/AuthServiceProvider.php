<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Permission;
use DB;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        // Vérifie dans l'ensemble des permissions, si l'utilisateur (via son rôle) possède bien la permission qui est demandée
        foreach ($this->getPermissions() as $permission) {
            $gate->define($permission->name, function($user) use($permission) {
                return $user->hasRole($permission->roles);
            });
        }
    }

    /*
     * Retourne l'ensemble des permissions ainsi que les rôles associés
     */
    protected function getPermissions()
    {
        $check = DB::select('SELECT COUNT(*) as `exists` FROM information_schema.tables WHERE table_name = "permissions" AND table_schema = database()')[0];

        if ( $check->exists === '1' )
        {
            return Permission::with('roles')->get();
        }

        return [];
    }
}
