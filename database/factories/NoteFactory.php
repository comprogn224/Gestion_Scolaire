<?php

namespace Database\Factories;

use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Matiere;
use App\Models\Professeur;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $typesNote = ['DS', 'Devoir', 'Composition', 'Oral', 'TP', 'Projet'];
        $typeNote = $this->faker->randomElement($typesNote);
        
        // Définir le coefficient en fonction du type de note
        $coefficient = match($typeNote) {
            'Composition' => 3,
            'DS' => 2,
            default => 1,
        };
        
        $appreciations = [
            'Très bien', 'Bien', 'Assez bien', 'Passable', 'Insuffisant',
            'Travail satisfaisant', 'Peut mieux faire', 'En progrès', 'À revoir'
        ];
        
        return [
            'valeur' => $this->faker->randomFloat(2, 0, 20),
            'coefficient' => $coefficient,
            'type_note' => $typeNote,
            'date_evaluation' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'appreciation' => $this->faker->randomElement($appreciations),
            'eleve_id' => Eleve::factory(),
            'matiere_id' => Matiere::factory(),
            'classe_id' => Classe::factory(),
            'professeur_id' => Professeur::factory(),
            'est_publie' => $this->faker->boolean(90), // 90% de chance d'être publié
        ];
    }
}
