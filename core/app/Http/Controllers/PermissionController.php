<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use Illuminate\Support\Facades\Lang;
use App\Behaviour\ListRoles;
use App\Permission;
use App\Role;

class PermissionController extends Controller
{
    use ListRoles;

    // Vérification des permissions de l'utilisateur, a-t-il la permission de gestion des permissions
    public function __construct()
    {
        $this->middleware('permission:manage_permissions');
    }

    // Retourne le tableau qui liste toutes les permissions : /permission : GET
    public function index()
    {
        $roles = $this->getListRoles();

        $permissions = Permission::with('roles')->get()->toArray();

        return view('permissions.index')->withRoles($roles)->withPermissions($permissions);
    }

    // Enregistrement des permissions cochées dans le tableau des permisisons
    public function update(Request $request)
    {
        $permissions = $request->get('permissions');

        if ( !is_null($permissions) )
        {
            $permission_role = [];

            foreach ($permissions as $value)
            {
                $tmp = explode('-', $value);
                $permission_role[$tmp[0]][] = $tmp[1];
            }

            foreach ($permission_role as $permission => $roles)
            {
                $perm = Permission::findOrFail($permission);
                $perm->roles()->sync($roles);
            }

            // For ADMIN => access all permissions
            $allPermissions = Permission::lists('id')->toArray();
            $admin = Role::whereName('admin')->first();
            $admin->permissions()->sync($allPermissions);
        }

        return redirect()->route('permission.index')->withSuccess('Les permissions ont été enregistrées');
    }
}
