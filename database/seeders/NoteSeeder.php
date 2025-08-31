<?php

namespace Database\Seeders;

use App\Models\Eleve;
use App\Models\Matiere;
use App\Models\Note;
use App\Models\Professeur;
use Illuminate\Database\Seeder;

class NoteSeeder extends Seeder
{
    public function run(): void
    {
        $eleves = Eleve::all();
        $matieres = Matiere::all();
        $professeurs = Professeur::all();
        
        $typesNotes = ['DS', 'Devoir', 'Composition', 'Oral', 'TP'];
        $appreciations = [
            'Très bien', 'Bien', 'Assez bien', 'Passable', 'Insuffisant',
            'Travail satisfaisant', 'Peut mieux faire', 'En progrès', 'À revoir'
        ];
        
        foreach ($eleves as $eleve) {
            // Pour chaque élève, sélectionner les matières de sa classe
            $matieresClasse = $matieres->where('classe_id', $eleve->classe_id);
            
            foreach ($matieresClasse as $matiere) {
                // Générer entre 2 et 5 notes par matière
                $nombreNotes = rand(2, 5);
                
                for ($i = 0; $i < $nombreNotes; $i++) {
                    $typeNote = $typesNotes[array_rand($typesNotes)];
                    $coefficient = $typeNote === 'DS' ? 2 : ($typeNote === 'Composition' ? 3 : 1);
                    
// Sélectionner un professeur au hasard
                    $professeur = $professeurs->random();
                    
                    Note::create([
                        'eleve_id' => $eleve->id,
                        'matiere_id' => $matiere->id,
                        'professeur_id' => $professeur->id,
                        'classe_id' => $eleve->classe_id,
                        'note' => $this->generateRealisticNote($typeNote),
                    ]);
                }
            }
        }
    }
    
    /**
     * Génère une note réaliste en fonction du type de note
     */
    private function generateRealisticNote($typeNote)
    {
        // Les notes sont généralement plus élevées pour les devoirs que pour les DS
        $moyenne = $typeNote === 'DS' ? 12 : ($typeNote === 'Composition' ? 10 : 14);
        $ecartType = 3; // Écart type pour la distribution normale
        
        // Générer une note avec une distribution normale
        $note = $this->gaussianRandom($moyenne, $ecartType);
        
        // S'assurer que la note est entre 0 et 20
        $note = max(0, min(20, $note));
        
        // Arrondir à 1 ou 2 décimales
        return round($note, rand(0, 1) ? 1 : 0);
    }
    
    /**
     * Génère un nombre aléatoire avec une distribution normale (loi normale)
     */
    private function gaussianRandom($mean, $sd, $n = 6)
    {
        $x = 0;
        for ($i = 0; $i < $n; $i++) {
            $x += mt_rand() / mt_getrandmax();
        }
        return $mean + $sd * (sqrt(12 / $n) * ($x - $n / 2));
    }
}
