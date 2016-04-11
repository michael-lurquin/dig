<?php

use Illuminate\Database\Seeder;

use App\Permission;
use App\Behaviour\ListRoles;
use App\Role;

class PermissionsTableSeeder extends Seeder
{
    use ListRoles;

    private $permissions;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->permissions = [
            'manage_permission' => [
                'label' => 'Gestion des permissions',
                'description' => 'Permet d\'attribuer des permissions à un ou plusieurs rôles',
            ],
            'service_delete' => [
                'label' => 'Supprimer un service',
                'description' => NULL,
            ],
            'revision_validate' => [
                'label' => 'Valider une révision d\'un service',
                'description' => NULL,
            ],
            'revision_restore' => [
                'label' => 'Restaurer une révision validée d\'un service',
                'description' => NULL,
            ],
            'revision_delete' => [
                'label' => 'Supprimer une révision d\'un service',
                'description' => NULL,
            ],
            'service_restore' => [
                'label' => 'Restaurer un service',
                'description' => NULL,
            ],
        ];

        foreach ($this->permissions as $slug => $permission)
        {
            Permission::create([
                'name' => strtolower($slug),
                'label' => ucfirst($permission['label']),
                'description' => ucfirst($permission['description']),
            ]);
        }

        // Admin => TOUTES LES PERMISSIONS
        $this->fillPermissions($this->permissions, 'admin');

        // Tous les rôles : manage_profile
        $permissions_allowed = [
            'service_delete',
            'revision_validate',
            'revision_restore',
            'revision_delete',
        ];
        $this->fillPermissions($permissions_allowed, 'modérateur');
    }

    /**
     * Prépare une liste de permissions pour un rôle donné
     */
    private function fillPermissions($permissions_allowed, $role_name)
    {
        $role_id = array_search($role_name, $this->getListRoles());
        $role = Role::findOrFail($role_id);

        $all_permissions = array_keys($this->permissions);

        if ( $role )
        {
            $permissions_id = [];
            foreach ($permissions_allowed as $k => $permission)
            {
                if ( $role->name == 'admin' )
                {
                    $permissions_id[] = array_search($k, $all_permissions) + 1;
                }
                else
                {
                    $permissions_id[] = array_search($permission, $all_permissions) + 1;
                }
            }
            $this->addPermissions($permissions_id, $role);
        }
    }

    /**
     * Attache une liste de permissions au rôle
     */
    private function addPermissions($permissions_id, $role)
    {
        if ( !empty($permissions_id) && $role )
        {
            $role->attachPermission($permissions_id);
        }
    }
}
