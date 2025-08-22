<?php

namespace App\Http\Controllers;

use App\Models\Jemaat;
use App\Models\KartuKeluarga;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Utama
        $totalKepalaKeluarga = Jemaat::where('status_kk', 'KEPALA_KELUARGA')->count();
        $totalJemaat = Jemaat::count();
        $totalMajelis = Jemaat::where('status_pelayanan', 'MAJELIS')->count();

        // Calculate wedding anniversaries this month
        $ulangTahunPernikahanBulanIniCount = KartuKeluarga::whereMonth('tanggal_pernikahan', now()->month)
            ->whereYear('tanggal_pernikahan', '<=', now()->year)
            ->count();
         // masih pengembangan(Development) bisa digunakan    
        // Pertumbuhan KK Bulan Ini
        $lastMonthKK = KartuKeluarga::whereMonth('created_at', Carbon::now()->subMonth()->month)->count();
        $growthKK = $lastMonthKK > 0
            ? round(($totalKepalaKeluarga - $lastMonthKK) / $lastMonthKK * 100, 1)
            : 0;

        // Pertumbuhan Jemaat Bulan Ini
        $lastMonthJemaat = Jemaat::whereMonth('created_at', Carbon::now()->subMonth()->month)->count();
        $growthJemaat = $lastMonthJemaat > 0
            ? round(($totalJemaat - $lastMonthJemaat) / $lastMonthJemaat * 100, 1)
            : 0;

        // Pertumbuhan Jemaat Tahun Ini vs Tahun Lalu
        $lastYearJemaat = Jemaat::whereYear('created_at', Carbon::now()->subYear()->year)->count();
        $growthYear = $lastYearJemaat > 0
            ? round(($totalJemaat - $lastYearJemaat) / $lastYearJemaat * 100, 1)
            : 0;

        // Ulang Tahun
        $ulangTahunCount = Jemaat::whereMonth('tanggal_lahir', Carbon::now()->month)->count();
        $ulangTahunBulanIni = Jemaat::whereMonth('tanggal_lahir', Carbon::now()->month)
            ->whereDay('tanggal_lahir', '>=', Carbon::now()->day)
            ->count();

        // Ulang Tahun Pernikahan
        $ulangTahunPernikahan = KartuKeluarga::whereMonth('tanggal_pernikahan', Carbon::now()->month)->count();

        // Jemaat Terbaru
        $recentJemaats = Jemaat::with(['kartuKeluarga.rayon'])
            ->latest('tanggal_gabung')
            ->take(5)
            ->get();

        // Majelis yang ulang tahun bulan ini
        $majelisUlangTahun = Jemaat::where('status_pelayanan', 'MAJELIS')
            ->whereMonth('tanggal_lahir', Carbon::now()->month)
            ->get();

        return view('dashboard', compact(
            'totalKepalaKeluarga',
            'totalJemaat',
            'totalMajelis',
            'growthKK',
            'growthJemaat',
            //'growthYear',
            'ulangTahunCount',
            'ulangTahunBulanIni',
            'ulangTahunPernikahan',
            'recentJemaats',
            'majelisUlangTahun'
        ));
    }
}
