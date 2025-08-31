<?php

namespace Database\Seeders;

use App\Models\Classe;
use App\Models\Professeur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProfesseurSeeder extends Seeder
{
    public function run(): void
    {
        // Créer 10 professeurs
        $noms = ['Dupont', 'Martin', 'Bernard', 'Petit', 'Durand', 'Leroy', 'Moreau', 'Simon', 'Laurent', 'Michel'];
        $prenoms = ['Jean', 'Marie', 'Pierre', 'Sophie', 'Thomas', 'Julie', 'Nicolas', 'Laura', 'Alexandre', 'Camille'];
        $sexes = ['M', 'F'];

        for ($i = 0; $i < 10; $i++) {
            $sexe = $sexes[array_rand($sexes)];
            $prenom = $prenoms[array_rand($prenoms)];
            $nom = $noms[array_rand($noms)];
            
            // S'assurer que le nom et le prénom sont différents pour chaque professeur
            while (Professeur::where('nom', $nom)->where('prenom', $prenom)->exists()) {
                $prenom = $prenoms[array_rand($prenoms)];
                $nom = $noms[array_rand($noms)];
            }
            
            // Créer le professeur avec des données aléatoires
            $professeur = Professeur::create([
                'nom' => $nom,
                'prenom' => $prenom,
                'date_naissance' => now()->subYears(rand(25, 65))->subMonths(rand(0, 12))->subDays(rand(0, 30)),
                'sexe' => $sexe,
                'photo' => null, // Vous pouvez ajouter la logique pour les photos plus tard
            ]);
        }
    }
}
