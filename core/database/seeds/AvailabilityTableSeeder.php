<?php

use Illuminate\Database\Seeder;

use App\Availability;

class AvailabilityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $availability = ['disponible', 'partiellement disponible', 'non disponible'];
        $nbrAvailability = count($availability);

        for ($i = 0; $i < $nbrAvailability; $i++) {

            Availability::create([
                'name' => $availability[$i],
                'weight' => $i,
            ]);

        }
    }
}
