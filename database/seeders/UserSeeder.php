<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::firstOrCreate(
            ['email' => 'admin@umred.com'],
            [
                'prenom' => 'Super',
                'name' => 'Admin',
                'adresse' => '123 Admin Street',
                'telephone' => '0123456789',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Chercheur
        User::firstOrCreate(
            ['email' => 'chercheur@umred.com'],
            [
                'prenom' => 'Mamadou',
                'name' => 'Soumoudou',
                'adresse' => '123 Chercheur Street',
                'telephone' => '0123456789',
                'password' => Hash::make('password'),
                'role' => 'chercheur',
                'email_verified_at' => now(),
            ]
        );

        // Technicien
        User::firstOrCreate(
            ['email' => 'technicien@umred.com'],
            [
                'prenom' => 'Ousmane',
                'name' => 'Ndiaye',
                'adresse' => '123 Technicien Street',
                'telephone' => '0123456789',
                'password' => Hash::make('password'),
                'role' => 'technicien',
                'email_verified_at' => now(),
            ]
        );

    }
}
