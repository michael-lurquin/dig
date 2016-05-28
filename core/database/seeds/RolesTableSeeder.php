<?php

use Illuminate\Database\Seeder;

use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['ecrivain', 'modérateur', 'admin'];
        $nbrRoles = count($roles);

        for ($i = 0; $i < $nbrRoles; $i++)
        {
            Role::create([
                'name' => $roles[$i],
                'weight' => $i,
            ]);

        }
    }
}
