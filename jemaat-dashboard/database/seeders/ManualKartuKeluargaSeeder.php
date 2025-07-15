<?php

namespace Database\Seeders;

use App\Models\Jemaat;
use App\Models\KartuKeluarga;
use Illuminate\Database\Seeder;

class ManualKartuKeluargaSeeder extends Seeder
{
    public function run(): void
    {
        // Buat KK baru
        $kk = KartuKeluarga::create([
            'rayon_id'         => 4,
            'no_kk'            => '3204320210060099',
            'kepala_keluarga'  => 'Warjo',
            'provinsi_id'      => 32,
            'kota_id'          => 3204,
            'kecamatan_id'     => 3204140,
            'kelurahan_id'     => 3204140007,
            'kodepos_id'       => 40375,
            'alamat_rt'        => 7,
            'alamat_rw'        => 18,
            'alamat_lengkap'   => 'Jl Melati 1 No. 8 Graha Rancamanyar, RT/RW 7/18',
            'tanggal_pernikahan' => now()->subYears(10)->format('Y-m-d'),
        ]);

        // Kepala Keluarga
        Jemaat::create([
            'kartu_keluarga_id' => $kk->id,
            'no_anggota'        => 'A001',
            'nik'               => '3204320705690018',
            'nama'              => 'Warjo',
            'telepon'           => '085721073946',
            'gender'            => 'L',
            'tanggal_lahir'     => '1969-05-07',
            'status_kawin'      => 'MENIKAH',
            'pendidikan'        => '',
            'gelar'             => '',
            'status_baptis'     => true,
            'tanggal_baptis'    => '2000-01-01',
            'pekerjaan'         => 'Karyawan Swasta',
            'tanggal_gabung'    => '2010-01-01',
            'status_pelayanan'  => 'MAJELIS',
            'status_keaktifan'  => 'AKTIF',
            'status_kk'         => 'KEPALA_KELUARGA',
            'foto'              => null,
        ]);

        // Anggota 1
        Jemaat::create([
            'kartu_keluarga_id' => $kk->id,
            'no_anggota'        => 'A002',
            'nik'               => '3204325001710019',
            'nama'              => 'Suyani',
            'telepon'           => '085295254750',
            'gender'            => 'P',
            'tanggal_lahir'     => '1971-01-10',
            'status_kawin'      => 'MENIKAH',
            'pendidikan'        => 'D3',
            'gelar'             => '',
            'status_baptis'     => true,
            'tanggal_baptis'    => '2005-05-05',
            'pekerjaan'         => 'Ibu Rumah Tangga',
            'tanggal_gabung'    => '2010-01-01',
            'status_pelayanan'  => 'JEMAAT',
            'status_keaktifan'  => 'AKTIF',
            'status_kk'         => 'ISTRI',
            'foto'              => null,
        ]);

        // Anggota 2
        Jemaat::create([
            'kartu_keluarga_id' => $kk->id,
            'no_anggota'        => 'A003',
            'nik'               => '3204321505030012',
            'nama'              => 'Nathanael Ferry Pratama',
            'telepon'           => '085646877046',
            'gender'            => 'L',
            'tanggal_lahir'     => '2003-05-15',
            'status_kawin'      => 'LAJANG',
            'pendidikan'        => 'S1',
            'gelar'             => '',
            'status_baptis'     => false,
            'tanggal_baptis'    => null,
            'pekerjaan'         => 'Mahasiswa',
            'tanggal_gabung'    => '2010-01-01',
            'status_pelayanan'  => 'JEMAAT',
            'status_keaktifan'  => 'AKTIF',
            'status_kk'         => 'ANAK',
            'foto'              => null,
        ]);
    }
}
