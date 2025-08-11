<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KartuKeluarga extends Model
{
    use HasFactory;

    protected $fillable = [
        'rayon_id',
        'no_kk',
        'kepala_keluarga',
        'provinsi_id',
        'kota_id',
        'kecamatan_id',
        'kelurahan_id',
        'kodepos_id',
        'alamat_rt',
        'alamat_rw',
        'alamat_lengkap',
    ];

    public function rayon()
    {
        return $this->belongsTo(Rayon::class);
    }

    public function provinsi()
    {
        return $this->belongsTo(\App\Models\Province::class, 'provinsi_id');
    }

    public function kota()
    {
        return $this->belongsTo(\App\Models\Regency::class, 'kota_id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(\App\Models\District::class, 'kecamatan_id');
    }

    public function kelurahan()
    {
        return $this->belongsTo(\App\Models\Village::class, 'kelurahan_id');
    }

    public function jemaats()
    {
        return $this->hasMany(Jemaat::class);
    }

    public function kepalaKeluarga()
    {
        return $this->hasOne(Jemaat::class)->where('status_kk', 'KEPALA_KELUARGA');
    }
}
