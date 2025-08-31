<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\ClasseSeeder;
use Database\Seeders\ProfesseurSeeder;
use Database\Seeders\MatiereSeeder;
use Database\Seeders\EleveSeeder;
use Database\Seeders\NoteSeeder;
use Database\Seeders\AbsenceSeeder;
use Database\Seeders\AdminUserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Désactiver les contraintes de clé étrangère
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Vider les tables existantes
        $tables = [
            'users',
            'professeurs',
            'classes',
            'matieres',
            'eleves',
            'notes',
            'absences',
            'password_reset_tokens',
            'sessions',
            'failed_jobs',
        ];

        foreach ($tables as $table) {
            if (\Schema::hasTable($table)) {
                \DB::table($table)->truncate();
            }
        }

        // Réactiver les contraintes de clé étrangère
        \DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Créer les utilisateurs par défaut
        $this->call([
            AdminUserSeeder::class,
        ]);

        // Appeler les autres seeders
        $this->call([
            ClasseSeeder::class,
            ProfesseurSeeder::class,
            MatiereSeeder::class,
            EleveSeeder::class,
            NoteSeeder::class,
            AbsenceSeeder::class,
        ]);
    }
}
