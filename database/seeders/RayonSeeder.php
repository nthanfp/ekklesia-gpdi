<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

use App\Models\Rayon;

class RayonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rayons = [
            'Rayon Kopo Permai',
            'Rayon Cibaduyut',
            'Rayon Taman Kopo Indah',
            'Rayon Rancamanyar',
            'Rayon Permata Kopo',
            'Rayon Singawangi',            
        ];

        foreach ($rayons as $nama) {
            Rayon::create([
                'kode' => Str::slug($nama),
                'nama' => $nama,
            ]);
        }
    }
}
