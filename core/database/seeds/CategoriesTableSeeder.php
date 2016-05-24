<?php

use Illuminate\Database\Seeder;

use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Aide juridique',
            'Application cartographique web',
            'Carte statique',
            'Catalogue de métadonnées',
            'Coordination et gouvernance',
            'Directive INSPIRE',
            'Encadrement de la production de données',
            'Environnement informatique de développement',
            'Formation et sensibilisation',
            'Géoportail de la Wallonie',
            'Géoréférentiel',
            'Géotraitement',
            'Mutualisation, échange et diffusion interne et externe des géodonnées',
            'Outils SIG bureautique',
            'Service web géographique de visualisation',
            'Support aux utilisateurs',
            'Diffusion',
            'Métadonnées',
            'Référencement',
        ];

        $nbrCatgories = count($categories);

        for ($i = 0; $i < $nbrCatgories; $i++) {

            Category::create([
                'name' => $categories[$i],
                'weight' => $i,
            ]);

        }
    }
}
