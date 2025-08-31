<?php

namespace Database\Seeders;

use App\Models\Classe;
use App\Models\Eleve;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EleveSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('fr_FR');
        $classes = Classe::all();
        
        foreach ($classes as $classe) {
            // Générer entre 20 et 35 élèves par classe
            $nombreEleves = rand(20, 35);
            
            for ($i = 0; $i < $nombreEleves; $i++) {
                $sexe = $faker->randomElement(['Masculin', 'Féminin']);
                $prenom = $sexe === 'Masculin' ? $faker->firstNameMale : $faker->firstNameFemale;
                
                Eleve::create([
                    'nom' => $faker->lastName,
                    'prenom' => $prenom,
                    'date_naissance' => $faker->dateTimeBetween('-18 years', '-10 years')->format('Y-m-d'),
                    'sexe' => $sexe,
                    'classe_id' => $classe->id,
                ]);
            }
        }
    }
}
