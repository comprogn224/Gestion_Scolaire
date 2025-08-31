<?php

namespace Database\Factories;

use App\Models\Classe;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Eleve>
 */
class EleveFactory extends Factory
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
            
        return [
            'nom' => $this->faker->lastName,
            'prenom' => $prenom,
            'date_naissance' => $this->faker->dateTimeBetween('-18 years', '-10 years')->format('Y-m-d'),
            'sexe' => $sexe,
            'adresse' => $this->faker->address,
            'telephone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail(),
            'classe_id' => Classe::factory(),
            'photo' => null,
            'date_inscription' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
