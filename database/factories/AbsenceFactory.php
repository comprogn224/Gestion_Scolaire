<?php

namespace Database\Factories;

use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Matiere;
use App\Models\Professeur;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Absence>
 */
class AbsenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $motifs = [
            'Maladie', 'Rendez-vous médical', 'Raison familiale', 'Absence injustifiée',
            'Problème de transport', 'Activité sportive', 'Voyage familial', 'Autre'
        ];
        
        $estJustifiee = $this->faker->boolean(70); // 70% de chance d'être justifiée
        $motif = $estJustifiee 
            ? $this->faker->randomElement(array_slice($motifs, 0, 6)) // Prendre un motif justifié
            : 'Absence non justifiée';
        
        return [
            'eleve_id' => Eleve::factory(),
            'matiere_id' => Matiere::factory(),
            'classe_id' => Classe::factory(),
            'professeur_id' => Professeur::factory(),
            'date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'motif' => $motif,
            'justifiee' => $estJustifiee,
            'commentaire' => $estJustifiee ? $this->faker->sentence() : null,
        ];
    }
}
