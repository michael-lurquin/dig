<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Service;
use App\Behaviour\ListRoles;
use App\Behaviour\ListCategories;

class UsersTableSeeder extends Seeder
{
    use ListRoles;
    use ListCategories;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Liste des rôles
        $roles = array_flip($this->getListRoles());

        // Génération d'un administrateur
        $admin = User::create([
            'name' => 'Michaël LURQUIN',
            'email' => 'michael.lurquin@gmail.com',
            'password' => bcrypt('digESA123'),
            'poste' => 'Informaticien / Développeur',
        ]);

        // Attribution du rôle
        $admin->assign('admin');

        // Génération de 2 modérateurs
        $users = factory(User::class, 2)->create([
            'role_id' => $roles['modérateur'],
        ]);

        // Génération de 2 écrivains
        $users = factory(User::class, 2)->create([
            'role_id' => $roles['écrivain'],
        ]);

        // Génération de 10 services
        $services = factory(Service::class, 10)->create();

        $faker = Faker\Factory::create();

        $categories = array_flip($this->getListCategories());
        $userList = User::lists('id')->toArray();

        foreach($services as $service)
        {
            // Attachement d'une ou plusieurs "catégories" à chaque service
            $service->categories()->attach($faker->randomElements($categories, $faker->numberBetween(1, 5)));

            // Attachement d'un ou plusieurs "Agent DIG responsable suppléant" à chaque service
            $service->ars()->attach($faker->randomElements($userList, $faker->numberBetween(1, count($userList))));
            $service->ars()->detach($service->agent_responsable);
            $service->ars()->detach($service->user_id);

            // Attachement d'un ou plusieurs "Autres agents DIG impliqués" à chaque service
            $service->aai()->attach($faker->randomElements($userList, $faker->numberBetween(1, count($userList))));
            $ars = array_column($service->ars->toArray(), 'id', 'id');
            foreach($service->aai as $aai)
            {
                $pos = array_search($aai->id, $ars);
                if ($pos) $service->aai()->detach($ars[$pos]);
            }
        }
    }
}
