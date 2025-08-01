<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Jemaat extends Model
{
    protected $fillable = [
        'kartu_keluarga_id',
        'no_anggota',
        'nik',
        'nama',
        'telepon',
        'gender',
        'tanggal_lahir',
        'status_kawin',
        'tanggal_pernikahan',
        'is_menikah',
        'pendidikan',
        'gelar',
        'status_baptis',
        'tanggal_baptis',
        'pekerjaan',
        'tanggal_gabung',
        'status_pelayanan',
        'status_keaktifan',
        'tanggal_nonaktif',
        'status_kk',
        'foto',
    ];

    protected $casts = [
        'tanggal_lahir'         => 'date',
        'tanggal_baptis'        => 'date',
        'tanggal_gabung'        => 'date',
        'tanggal_nonaktif'      => 'date',
        'tanggal_pernikahan'    => 'date',
        'status_baptis'         => 'boolean',
    ];

    // ========================
    // 🔗 Relasi
    // ========================
    public function kartuKeluarga()
    {
        return $this->belongsTo(KartuKeluarga::class);
    }

    // ========================
    // 📜 Konstanta ENUM
    // ========================
    const STATUS_KK = [
        'KEPALA_KELUARGA' => 'Kepala Keluarga',
        'SUAMI'           => 'Suami',
        'ISTRI'           => 'Istri',
        'ANAK'            => 'Anak',
        'CUCU'            => 'Cucu',
        'ORANG_TUA'       => 'Orang Tua',
        'MENANTU'         => 'Menantu',
        'MERTUA'          => 'Mertua',
        'KELUARGA_LAIN'   => 'Anggota Keluarga Lainnya',
        'LAINNYA'         => 'Lainnya',
    ];

    const STATUS_KAWIN = [
        'LAJANG'      => 'Lajang',
        'MENIKAH'     => 'Menikah',
        'CERAI_HIDUP' => 'Cerai Hidup',
        'CERAI_MATI'  => 'Cerai Mati',
    ];

    const STATUS_PELAYANAN = [
        'MAJELIS' => 'Majelis',
        'AKTIVIS' => 'Aktivis',
        'JEMAAT'  => 'Jemaat',
    ];

    const STATUS_KEAKTIFAN = [
        'AKTIF'    => 'Aktif',
        'PINDAH'   => 'Pindah',
        'MENINGGAL' => 'Meninggal',
    ];

    const PENDIDIKAN = [
        'SD'     => 'SD',
        'SMP'    => 'SMP',
        'SMA'    => 'SMA',
        'SMK'    => 'SMK',
        'D1'     => 'Diploma I',
        'D2'     => 'Diploma II',
        'D3'     => 'Diploma III',
        'S1'     => 'Sarjana (S1)',
        'S2'     => 'Magister (S2)',
        'S3'     => 'Doktor (S3)',
    ];

    // ========================
    // 🔍 Scopes
    // ========================
    public function scopeAktif($query)
    {
        return $query->where('status_keaktifan', 'AKTIF');
    }

    public function scopeMajelis($query)
    {
        return $query->where('status_pelayanan', 'MAJELIS');
    }

    public function scopeKepalaKeluarga($query)
    {
        return $query->where('status_kk', 'KEPALA_KELUARGA');
    }

    // Scope untuk filter
    public function scopeSudahMenikah($query) {
        return $query->where('is_menikah', true);
    }

    public function scopeBelumMenikah($query) {
        return $query->where('is_menikah', false);
    }

    // ========================
    // 🧠 Accessors
    // ========================
    protected function statusKkLabel(): Attribute
    {
        return Attribute::make(
            get: fn() => self::STATUS_KK[$this->status_kk] ?? 'Tidak Diketahui'
        );
    }

    protected function statusKawinLabel(): Attribute
    {
        return Attribute::make(
            get: fn() => self::STATUS_KAWIN[$this->status_kawin] ?? 'Tidak Diketahui'
        );
    }

    protected function statusPelayananLabel(): Attribute
    {
        return Attribute::make(
            get: fn() => self::STATUS_PELAYANAN[$this->status_pelayanan] ?? 'Tidak Diketahui'
        );
    }

    protected function statusKeaktifanLabel(): Attribute
    {
        return Attribute::make(
            get: fn() => self::STATUS_KEAKTIFAN[$this->status_keaktifan] ?? 'Tidak Diketahui'
        );
    }

    public function getNamaGenderAttribute(): string
    {
        return $this->gender === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    // ========================
    // ✅ Helper Method
    // ========================
    public function isMajelis(): bool
    {
        return $this->status_pelayanan === 'MAJELIS';
    }

    public function isAktif(): bool
    {
        return $this->status_keaktifan === 'AKTIF';
    }
}
