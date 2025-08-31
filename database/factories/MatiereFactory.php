<?php

namespace Database\Factories;

use App\Models\Classe;
use App\Models\Professeur;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Matiere>
 */
class MatiereFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $couleurs = [
            '#FF5252', '#FF4081', '#E040FB', '#7C4DFF', '#536DFE',
            '#448AFF', '#40C4FF', '#18FFFF', '#64FFDA', '#69F0AE',
            '#B2FF59', '#EEFF41', '#FFFF00', '#FFD740', '#FFAB40',
            '#FF6E40', '#5D4037', '#9E9E9E', '#607D8B', '#455A64'
        ];
        
        $matieres = [
            'Mathématiques', 'Français', 'Anglais', 'Histoire-Géographie',
            'SVT', 'Physique-Chimie', 'Sciences Économiques et Sociales',
            'Philosophie', 'EPS', 'Arts Plastiques', 'Musique', 'Technologie',
            'Espagnol', 'Allemand', 'Italien', 'Latin', 'Grec', 'Informatique',
            'Sciences de l\'Ingénieur', 'Sciences de la Vie et de la Terre',
            'Éducation Civique', 'Éducation Musicale', 'Sciences Physiques'
        ];
        
        return [
            'nom' => $this->faker->randomElement($matieres),
            'code' => strtoupper($this->faker->unique()->bothify('???###')),
            'coefficient' => $this->faker->numberBetween(1, 5),
            'description' => $this->faker->sentence(),
            'classe_id' => Classe::factory(),
            'professeur_id' => Professeur::factory(),
            'couleur' => $this->faker->randomElement($couleurs),
        ];
    }
}
