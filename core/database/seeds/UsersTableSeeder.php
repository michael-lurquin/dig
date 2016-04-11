<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Service;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Génération d'un administrateur et d'un service qui l'a créé
        $user = User::create([
            'name' => 'Michaël LURQUIN',
            'email' => 'michael.lurquin@gmail.com',
            'password' => bcrypt('digESA123'),
        ]);
        $user->assign('admin', $user);
        $user->services()->create([
            'title' => 'Mon premier service',
            'slug' => 'mon-premier-service',
        ]);

        // Génération d'un écrivain et d'un service qui l'a créé
        factory(App\User::class)->create()->each(function($u) {
            $u->services()->save(factory(App\Service::class)->make());
        });

        // Génération d'un modérateur
        $moderator = factory(User::class)->create();
        $moderator->assign('modérateur');
    }
}
