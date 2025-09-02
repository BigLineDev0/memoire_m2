<?php

namespace Database\Seeders;

use App\Models\Horaire;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HoraireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plages = [
            ['08:00', '10:00'],
            ['10:00', '12:00'],
            ['12:00', '14:00'],
            ['14:00', '16:00'],
            ['16:00', '18:00'],
            ['18:00', '20:00'],
        ];

        foreach ($plages as $p) {
            Horaire::create(['debut' => $p[0], 'fin' => $p[1]]);
        }
    }
}
