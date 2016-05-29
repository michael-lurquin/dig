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
        'email' => $faker->email,
        'password' => bcrypt('digESA123'),
        'remember_token' => str_random(60),
        'poste' => $faker->jobTitle,
        'role_id' => 1,
    ];
});

$factory->define(App\Service::class, function (Faker\Generator $faker) {
    $title = implode(' ', $faker->words(3));
    return [
        'identifier' => $faker->randomNumber(3),
        'title' => ucfirst($title),
        'slug' => str_slug($title),
        'availability_id' => $faker->numberBetween(1, 3),
        'user_id' => $faker->numberBetween(1, \App\User::count()),
        'description_categorie' => $faker->paragraph(),
        'contexte' => $faker->paragraph(),
        'description' => $faker->paragraph(),
        'exclus_perimetre' => $faker->paragraph(),
        'prerequis' => $faker->paragraph(),
        'contact_general' => $faker->streetAddress . ' - ' . $faker->postcode . ' ' . $faker->city,
        'cout_client' => $faker->numberBetween(10, 1000),
        'delai_charge' => $faker->numberBetween(0, 50),
        'delai_oeuvre' => $faker->numberBetween(0, 50),
        'delai_tiers' => $faker->numberBetween(0, 50),
        'marge_securite' => $faker->numberBetween(0, 50),
        'remarque_delai' => $faker->paragraph(),
        'rh_interne' => $faker->paragraph(),
        'cout_externalisation' => $faker->numberBetween(10, 1000),
        'agent_responsable' => $faker->numberBetween(1, \App\User::count()),
        'intervenants_externes' => $faker->name,
        'identifiant_procedure' => $faker->paragraph(),
        'resume_procedure' => $faker->paragraph(),
    ];
});
