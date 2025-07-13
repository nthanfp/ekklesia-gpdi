<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WilayahController extends Controller
{
    public function getRegencies($province_id)
    {
        return Regency::where('province_id', $province_id)
            ->orderBy('name')
            ->get(['id', DB::raw("initcap(name) as name")]);
    }

    public function getDistricts($regency_id)
    {
        return District::where('regency_id', $regency_id)
            ->orderBy('name')
            ->get(['id', DB::raw("initcap(name) as name")]);
    }

    public function getVillages($district_id)
    {
        return Village::where('district_id', $district_id)
            ->orderBy('name')
            ->get(['id', DB::raw("initcap(name) as name")]);
    }
}
