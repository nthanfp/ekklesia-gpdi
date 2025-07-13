<?php

namespace App\Http\Controllers;

use App\Models\Jemaat;
use App\Models\KartuKeluarga;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $majelisCount = Jemaat::where('status', 'majelis')->count();
        // Data Statistik Utama
        $totalKepalaKeluarga = Jemaat::where('status', Jemaat::STATUS_KK_KEPALA)->count();
        $totalJemaat = Jemaat::count();
        $totalMajelis = Jemaat::where('status', Jemaat::STATUS_KK_MAJELIS)->count();
        
        // Data Pertumbuhan
        $lastMonthKK = KartuKeluarga::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();
        $growthKK = $lastMonthKK > 0 ? 
            round(($totalKepalaKeluarga - $lastMonthKK) / $lastMonthKK * 100, 1) : 0;

        $lastMonthJemaat = Jemaat::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();
        $growthJemaat = $lastMonthJemaat > 0 ?
            round(($totalJemaat - $lastMonthJemaat) / $lastMonthJemaat * 100, 1) : 0;

        $lastYearJemaat = Jemaat::whereYear('created_at', Carbon::now()->subYear()->year)
            ->count();
        $growthYear = $lastYearJemaat > 0 ?
            round(($totalJemaat - $lastYearJemaat) / $lastYearJemaat * 100, 1) : 0;
        
        // Data Ulang Tahun
        $ulangTahunCount = Jemaat::whereMonth('tanggal_lahir', Carbon::now()->month)->count();
        $ulangTahunBulanIni = Jemaat::whereMonth('tanggal_lahir', Carbon::now()->month)
                                  ->whereDay('tanggal_lahir', '>=', Carbon::now()->day)
                                  ->count();
        
        // Ulang Tahun Pernikahan
        $ulangTahunPernikahan = KartuKeluarga::whereMonth('tanggal_pernikahan', Carbon::now()->month)
                                           ->count();
        
        // Jemaat Terbaru (5 orang terdaftar)
        $recentJemaats = Jemaat::with(['kartuKeluarga' => function($query) {
                            $query->with('rayon');
                        }])
                        ->latest()
                        ->take(5)
                        ->get();

        // Majelis dengan ulang tahun bulan ini
        $majelisUlangTahun = Jemaat::where('status', Jemaat::STATUS_KK_MAJELIS)
                                 ->whereMonth('tanggal_lahir', Carbon::now()->month)
                                 ->get();

        return view('dashboard', compact(
            'totalKepalaKeluarga',
            'totalJemaat',
            'totalMajelis',
            'growthKK',
            'growthJemaat',
            'growthYear',
            'ulangTahunCount',
            'ulangTahunBulanIni',
            'ulangTahunPernikahan',
            'recentJemaats',
            'majelisUlangTahun'
        ));
    }
}