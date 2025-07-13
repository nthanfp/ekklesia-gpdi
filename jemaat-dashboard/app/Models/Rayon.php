<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rayon extends Model
{
    protected $fillable = [
        'kode',
        'nama'
    ];

    public function kartuKeluargas()
    {
        return $this->hasMany(KartuKeluarga::class);
    }

    public function jemaats()
    {
        return $this->hasManyThrough(Jemaat::class, KartuKeluarga::class);
    }
}