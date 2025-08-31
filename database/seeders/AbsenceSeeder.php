<?php

namespace Database\Seeders;

use App\Models\Absence;
use App\Models\Eleve;
use App\Models\Matiere;
use Illuminate\Database\Seeder;

class AbsenceSeeder extends Seeder
{
    public function run(): void
    {
        $eleves = Eleve::all();
        $matieres = Matiere::all();
        
        $motifs = [
            'Maladie', 'Rendez-vous médical', 'Raison familiale', 'Absence injustifiée',
            'Problème de transport', 'Activité sportive', 'Voyage familial', 'Autre'
        ];
        
        // Générer des absences pour environ 30% des élèves
        $nombreElevesAvecAbsences = (int) ($eleves->count() * 0.3);
        $elevesAvecAbsences = $eleves->random($nombreElevesAvecAbsences);
        
        foreach ($elevesAvecAbsences as $eleve) {
            // Sélectionner 1 à 3 matières pour lesquelles l'élève est absent
            $matieresAbsences = $matieres->where('classe_id', $eleve->classe_id)->random(rand(1, 3));
            
            foreach ($matieresAbsences as $matiere) {
                // Générer entre 1 et 3 absences par matière
                $nombreAbsences = rand(1, 3);
                
                for ($i = 0; $i < $nombreAbsences; $i++) {
                    $dateAbsence = now()->subDays(rand(1, 180));
                    $estJustifie = (bool) rand(0, 1);
                    
                    Absence::create([
                        'eleve_id' => $eleve->id,
                        'matiere_id' => $matiere->id,
                        'classe_id' => $eleve->classe_id,
                        'professeur_id' => $matiere->professeur_id,
                        'date' => $dateAbsence,
                        'motif' => $estJustifie ? $motifs[array_rand($motifs)] : 'Absence non justifiée',
                        'justifiee' => $estJustifie,
                        'commentaire' => $estJustifie ? 'Motif fourni' : null,
                    ]);
                }
            }
        }
    }
}
