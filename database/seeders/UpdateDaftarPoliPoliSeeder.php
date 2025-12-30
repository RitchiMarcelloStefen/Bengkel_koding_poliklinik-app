<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateDaftarPoliPoliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\DaftarPoli::with('jadwalPeriksa.dokter')->chunk(100, function ($daftarPolis) {
            foreach ($daftarPolis as $daftarPoli) {
                if ($daftarPoli->jadwalPeriksa && $daftarPoli->jadwalPeriksa->dokter) {
                    $daftarPoli->update(['id_poli' => $daftarPoli->jadwalPeriksa->dokter->id_poli]);
                }
            }
        });
    }
}
