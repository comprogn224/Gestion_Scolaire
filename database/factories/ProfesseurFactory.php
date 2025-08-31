<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Professeur>
 */
class ProfesseurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sexe = $this->faker->randomElement(['Masculin', 'Féminin']);
        $prenom = $sexe === 'Masculin' 
            ? $this->faker->firstNameMale 
            : $this->faker->firstNameFemale;
            
        $specialites = [
            'Sciences', 'Lettres', 'Langues', 'Sciences Humaines',
            'Arts', 'Technologie', 'Éducation Physique et Sportive'
        ];
        
        return [
            'nom' => $this->faker->lastName,
            'prenom' => $prenom,
            'date_naissance' => $this->faker->dateTimeBetween('-65 years', '-25 years')->format('Y-m-d'),
            'sexe' => $sexe,
            'adresse' => $this->faker->address,
            'telephone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail(),
            'specialite' => $this->faker->randomElement($specialites),
            'date_embauche' => $this->faker->dateTimeBetween('-30 years', 'now'),
            'photo' => null,
        ];
    }
}
