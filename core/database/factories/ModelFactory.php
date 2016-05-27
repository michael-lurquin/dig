<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt('digESA123'),
        'poste' => 'Secrétaire',
    ];
});

$factory->define(App\Service::class, function (Faker\Generator $faker) {
    $title = implode(' ', $faker->words(3));
    return [
        'identifier' => mt_rand(2, 10),
        'title' => ucfirst($title),
        'slug' => str_slug($title),
        'agent_responsable' => 1,
    ];
});
