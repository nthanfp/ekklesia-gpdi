<?php

namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\Province;
use App\Models\Rayon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KartuKeluargaController extends Controller
{
    public function index(Request $request)
    {
        $query = KartuKeluarga::with(['rayon'])
            ->withCount('jemaats');

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_kk', 'ILIKE', "%$search%")
                  ->orWhere('kepala_keluarga', 'ILIKE', "%$search%");
            });
        }

        // Filter ulang tahun pernikahan
         if ($request->filter == 'ulangtahunpernikahan') {
             $query->whereMonth('tanggal_pernikahan', now()->month)
             ->whereYear('tanggal_pernikahan', '<=', now()->year);
        }

        // Filter Rayon
        if ($request->filled('rayon_id')) {
            $query->where('rayon_id', $request->rayon_id);
        }

        // Sorting
        $sortable = ['no_kk', 'kepala_keluarga', 'jemaats_count', 'tanggal_pernikahan'];
        $sortBy = in_array($request->sort_by, $sortable) ? $request->sort_by : 'created_at';
        $sortOrder = $request->sort_order === 'asc' ? 'asc' : 'desc';

        $kartuKeluargas = $query->orderBy($sortBy, $sortOrder)
            ->paginate(10)
            ->withQueryString();

        $rayons = Rayon::all();

        return view('kartu_keluarga.index', compact('kartuKeluargas', 'rayons'));
    }

    public function create()
    {
        $rayons = Rayon::all();
        $provinces = Province::orderBy('name')->get()
            ->map(function ($prov) {
                $name = ucwords(strtolower($prov->name));
                if (Str::startsWith($name, 'Dki ')) {
                    $name = 'DKI ' . substr($name, 4);
                } elseif (Str::startsWith($name, 'Di ')) {
                    $name = 'DI ' . substr($name, 3);
                }
                $prov->name = $name;
                return $prov;
            });

        return view('kartu_keluarga.create', compact('rayons', 'provinces'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_kk' => 'required|string|max:20|unique:kartu_keluargas,no_kk',
            'kepala_keluarga' => 'required|string|max:255',
            'rayon_id' => 'required|exists:rayons,id',
            'provinsi_id' => 'nullable|exists:provinces,id',
            'kota_id' => 'nullable|exists:regencies,id',
            'kecamatan_id' => 'nullable|exists:districts,id',
            'kelurahan_id' => 'nullable|exists:villages,id',
            'kodepos_id' => 'nullable|numeric',
            'alamat_rt' => 'nullable|integer|min:1|max:9999',
            'alamat_rw' => 'nullable|integer|min:1|max:9999',
            'alamat_lengkap' => 'nullable|string',
            'tanggal_pernikahan' => 'nullable|date|before_or_equal:today',
        ]);

        KartuKeluarga::create($validated);

        return redirect()->route('kartu-keluarga.index')
            ->with('success', 'Data kartu keluarga berhasil ditambahkan');
    }

    public function show(KartuKeluarga $kartuKeluarga)
    {
        $kartuKeluarga->load([
            'rayon',
            'provinsi',
            'kota',
            'kecamatan',
            'kelurahan',
            'jemaats' => function ($query) {
                $query->orderBy('status_kk', 'desc')
                      ->orderBy('nama');
            }
        ]);

        return view('kartu_keluarga.show', compact('kartuKeluarga'));
    }

    public function edit(KartuKeluarga $kartuKeluarga)
    {
        $rayons = Rayon::all();
        $provinces = Province::orderBy('name')->get()
            ->map(function ($prov) {
                $name = ucwords(strtolower($prov->name));
                if (Str::startsWith($name, 'Dki ')) {
                    $name = 'DKI ' . substr($name, 4);
                } elseif (Str::startsWith($name, 'Di ')) {
                    $name = 'DI ' . substr($name, 3);
                }
                $prov->name = $name;
                return $prov;
            });

        return view('kartu_keluarga.edit', compact('kartuKeluarga', 'rayons', 'provinces'));
    }

    public function update(Request $request, KartuKeluarga $kartuKeluarga)
    {
        $validated = $request->validate([
            'no_kk' => 'required|string|max:20|unique:kartu_keluargas,no_kk,'.$kartuKeluarga->id,
            'kepala_keluarga' => 'required|string|max:255',
            'rayon_id' => 'required|exists:rayons,id',
            'provinsi_id' => 'nullable|exists:provinces,id',
            'kota_id' => 'nullable|exists:regencies,id',
            'kecamatan_id' => 'nullable|exists:districts,id',
            'kelurahan_id' => 'nullable|exists:villages,id',
            'kodepos_id' => 'nullable|numeric',
            'alamat_rt' => 'nullable|integer|min:1|max:9999',
            'alamat_rw' => 'nullable|integer|min:1|max:9999',
            'alamat_lengkap' => 'nullable|string',
            'tanggal_pernikahan' => 'nullable|date|before_or_equal:today',
        ]);

        $kartuKeluarga->update($validated);

        return redirect()->route('kartu-keluarga.index')
            ->with('success', 'Data kartu keluarga berhasil diperbarui');
    }

    public function destroy(KartuKeluarga $kartuKeluarga)
    {
        $kartuKeluarga->delete();

        return redirect()->route('kartu-keluarga.index')
            ->with('success', 'Data kartu keluarga berhasil dihapus');
    }
}