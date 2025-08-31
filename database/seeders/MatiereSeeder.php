<?php

namespace Database\Seeders;

use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Professeur;
use Illuminate\Database\Seeder;

class MatiereSeeder extends Seeder
{
    public function run(): void
    {
        $matieresParNiveau = [
            '6ème' => [
                'Français' => '5',
                'Mathématiques' => '5',
                'Histoire-Géographie' => '3',
                'SVT' => '2',
                'Technologie' => '2',
                'Anglais' => '3',
                'EPS' => '3',
                'Arts Plastiques' => '2',
                'Musique' => '1',
            ],
            '5ème' => [
                'Français' => '5',
                'Mathématiques' => '5',
                'Histoire-Géographie' => '3',
                'SVT' => '2',
                'Physique-Chimie' => '2',
                'Technologie' => '2',
                'Anglais' => '3',
                'EPS' => '3',
                'Arts Plastiques' => '1',
                'Musique' => '1',
            ],
            '4ème' => [
                'Français' => '5',
                'Mathématiques' => '5',
                'Histoire-Géographie' => '3',
                'SVT' => '2',
                'Physique-Chimie' => '2',
                'Technologie' => '2',
                'Anglais' => '3',
                'Espagnol' => '3',
                'EPS' => '3',
            ],
            '3ème' => [
                'Français' => '5',
                'Mathématiques' => '5',
                'Histoire-Géographie' => '3',
                'SVT' => '2',
                'Physique-Chimie' => '2',
                'Technologie' => '2',
                'Anglais' => '3',
                'Espagnol' => '3',
                'EPS' => '3',
            ],
            '2nde' => [
                'Français' => '4',
                'Mathématiques' => '4',
                'Histoire-Géographie' => '3',
                'SVT' => '3',
                'Physique-Chimie' => '3',
                'SES' => '3',
                'Anglais' => '3',
                'Espagnol' => '3',
                'EPS' => '2',
                'Sciences Numériques et Technologie' => '2',
            ],
            '1ère' => [
                'Français' => '4',
                'Mathématiques' => '4',
                'Histoire-Géographie' => '3',
                'SVT' => '3',
                'Physique-Chimie' => '3',
                'SES' => '3',
                'Anglais' => '3',
                'Philosophie' => '4',
                'EPS' => '2',
                'Spécialité 1' => '4',
                'Spécialité 2' => '4',
            ],
            'Tle' => [
                'Philosophie' => '4',
                'Français' => '4',
                'Mathématiques' => '4',
                'Histoire-Géographie' => '3',
                'SVT' => '3',
                'Physique-Chimie' => '3',
                'SES' => '3',
                'Anglais' => '3',
                'EPS' => '2',
                'Spécialité 1' => '6',
                'Spécialité 2' => '6',
            ],
        ];

        $couleurs = [
            '#FF5252', '#FF4081', '#E040FB', '#7C4DFF', '#536DFE',
            '#448AFF', '#40C4FF', '#18FFFF', '#64FFDA', '#69F0AE',
            '#B2FF59', '#EEFF41', '#FFFF00', '#FFD740', '#FFAB40',
            '#FF6E40', '#5D4037', '#9E9E9E', '#607D8B', '#455A64'
        ];

        $professeurs = Professeur::all();
        $classes = Classe::all();

        foreach ($classes as $classe) {
            $niveau = $classe->niveau;
            if (!isset($matieresParNiveau[$niveau])) continue;

            foreach ($matieresParNiveau[$niveau] as $matiere => $coefficient) {
                $professeur = $professeurs->random();

                Matiere::create([
                    'nom' => $matiere,
                    'coefficient' => $coefficient,
                    'classe_id' => $classe->id,
                ]);
            }
        }
    }
}
