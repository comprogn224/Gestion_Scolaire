<?php

namespace Database\Factories;

use App\Models\Professeur;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Classe>
 */
class ClasseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $niveaux = ['6ème', '5ème', '4ème', '3ème', '2nde', '1ère', 'Tle'];
        $sections = ['A', 'B', 'C', 'D'];
        
        return [
            'nom' => $this->faker->randomElement($sections),
            'niveau' => $this->faker->randomElement($niveaux),
            'annee_scolaire' => date('Y') . '-' . (date('Y') + 1),
            'salle' => $this->faker->numberBetween(100, 400),
            'effectif_max' => $this->faker->numberBetween(25, 35),
            'professeur_principal_id' => Professeur::factory(),
        ];
    }
}
