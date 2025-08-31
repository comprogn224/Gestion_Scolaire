<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vérifier si l'utilisateur admin existe déjà
        if (!User::where('email', 'admin@school.com')->exists()) {
            User::create([
                'name' => 'Administrateur',
                'email' => 'admin@school.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
            
            $this->command->info('Admin user created successfully!');
            $this->command->info('Email: admin@school.com');
            $this->command->info('Password: password');
        } else {
            $this->command->info('Admin user already exists!');
        }
    }
}
