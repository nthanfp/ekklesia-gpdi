<?php

namespace Database\Seeders;

use App\Models\Jemaat;
use App\Models\KartuKeluarga;
use App\Models\Rayon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KartuKeluargaSeeder extends Seeder
{
    public function run(): void
    {
        $rayons = Rayon::pluck('id')->toArray();

        // Generate 10 KK
        for ($i = 1; $i <= 10; $i++) {
            $kk = KartuKeluarga::create([
                'rayon_id'        => fake()->randomElement($rayons),
                'no_kk'           => fake()->unique()->numerify('3276##########'),
                'kepala_keluarga' => fake()->name(),
                'provinsi_id'     => 32,           // Contoh ID untuk Jawa Barat
                'kota_id'         => 3276,         // Contoh ID untuk Kota Bandung
                'kecamatan_id'    => 3204270,      // Pastikan ID valid jika pakai relasi asli
                'kelurahan_id'    => 3204270001,   // Sama
                'kodepos_id'      => null,
                'alamat_rt'       => fake()->numberBetween(1, 10),
                'alamat_rw'       => fake()->numberBetween(1, 10),
                'alamat_lengkap'  => fake()->address(),
            ]);

            // Tambahkan 2–5 anggota jemaat
            $jumlahAnggota = rand(2, 5);
            for ($j = 0; $j < $jumlahAnggota; $j++) {
                $isKepala = $j === 0;

                // Umur antara 5–70 tahun
                $birthdate = fake()->dateTimeBetween('-70 years', '-5 years')->format('Y-m-d');
                $age = now()->diffInYears($birthdate);

                // Status Kawin: default Lajang kalau umur < 18
                $statusKawin = $age < 18 ? 'LAJANG' : fake()->randomElement(['MENIKAH', 'CERAI_HIDUP', 'CERAI_MATI']);

                Jemaat::create([
                    'kartu_keluarga_id' => $kk->id,
                    'no_anggota'        => fake()->unique()->numerify('A###'),
                    'nik'               => fake()->unique()->numerify('3276############'),
                    'nama'              => $isKepala ? $kk->kepala_keluarga : fake()->name(),
                    'telepon'           => fake()->phoneNumber(),
                    'gender'            => fake()->randomElement(['L', 'P']),
                    'tanggal_lahir'     => $birthdate,
                    'status_kawin'      => $statusKawin,
                    'pendidikan'        => fake()->randomElement(['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2']),
                    'gelar'             => fake()->randomElement(['', 'S.T.', 'M.Kom.', 'Ir.']),
                    'status_baptis'     => fake()->boolean(80),
                    'tanggal_baptis'    => fake()->dateTimeBetween('-10 years', '-1 years')->format('Y-m-d'),
                    'pekerjaan'         => fake()->jobTitle(),
                    'tanggal_gabung'    => fake()->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
                    'status_pelayanan'  => fake()->randomElement(['MAJELIS', 'AKTIVIS', 'JEMAAT']),
                    'status_keaktifan'  => fake()->randomElement(['AKTIF', 'PINDAH', 'MENINGGAL']),
                    'status_kk'         => $isKepala ? 'KEPALA_KELUARGA' : fake()->randomElement([
                        'SUAMI',
                        'ISTRI',
                        'ANAK',
                        'CUCU',
                        'ORANG_TUA',
                        'MENANTU',
                        'MERTUA',
                    ]),
                    'foto'              => null,
                ]);
            }
        }
    }
}
