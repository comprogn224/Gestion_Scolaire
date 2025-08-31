<?php

namespace Database\Seeders;

use App\Models\Classe;
use App\Models\Professeur;
use Illuminate\Database\Seeder;

class ClasseSeeder extends Seeder
{
    public function run(): void
    {
        $niveaux = ['6ème', '5ème', '4ème', '3ème', '2nde', '1ère', 'Tle'];
        $sections = ['A', 'B', 'C'];
        
        // Créer un professeur par défaut si aucun n'existe
        $professeur = Professeur::first();
        
        if (!$professeur) {
            $professeur = Professeur::create([
                'nom' => 'Dupont',
                'prenom' => 'Jean',
                'date_naissance' => now()->subYears(30),
                'sexe' => 'M',
                'photo' => null,
            ]);
        }
        
        foreach ($niveaux as $niveau) {
            foreach ($sections as $section) {
                // Créer 2-3 classes par niveau
                if (rand(0, 1) || $section === 'A') { // Toujours créer au moins la section A
                    Classe::create([
                        'nom' => $section,
                        'niveau' => $niveau,
                        'professeur_id' => $professeur->id,
                    ]);
                }
            }
        }
    }
}
