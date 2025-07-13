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
                $q->whereRaw('CAST(no_kk AS TEXT) ILIKE ?', ["%$search%"])
                    ->orWhereRaw('LOWER(kepala_keluarga) LIKE ?', ["%" . strtolower($search) . "%"]);
            });
        }

        // Filter Rayon
        if ($request->filled('rayon_id')) {
            $query->where('rayon_id', (int) $request->rayon_id);
        }

        // Sort
        $sortable = ['no_kk', 'kepala_keluarga', 'jemaats_count'];
        $sortBy = in_array($request->sort_by, $sortable) ? $request->sort_by : 'created_at';
        $sortOrder = $request->sort_order === 'asc' ? 'asc' : 'desc';

        $kartuKeluargas = $query->orderBy($sortBy, $sortOrder)
            ->paginate(10)
            ->appends($request->query());

        $rayons = \App\Models\Rayon::all();

        return view('kartu_keluarga.index', compact('kartuKeluargas', 'rayons'));
    }


    public function create()
    {
        $rayons = Rayon::all();
        $provinces = Province::orderBy('name')->get(['id', 'name'])->map(function ($prov) {
            $name = ucwords(strtolower($prov->name));

            if (stripos($name, 'Dki ') === 0) {
                $name = 'DKI ' . substr($name, 4);
            } elseif (stripos($name, 'Di ') === 0) {
                $name = 'DI ' . substr($name, 3);
            }

            $prov->name = $name;
            return $prov;
        });

        return view('kartu_keluarga.create', compact('rayons', 'provinces'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_kk' => 'required|string|max:20|unique:kartu_keluargas,no_kk',
            'kepala_keluarga' => 'required|string|max:255',
            'rayon_id' => 'required|exists:rayons,id',
            'provinsi_id' => 'nullable|exists:provinces,id',
            'kota_id' => 'nullable|exists:regencies,id',
            'kecamatan_id' => 'nullable|exists:districts,id',
            'kelurahan_id' => 'nullable|exists:villages,id',
            'kodepos_id' => 'nullable|numeric',
            'alamat_rt' => 'nullable|integer|max:9999',
            'alamat_rw' => 'nullable|integer|max:9999',
            'alamat_lengkap' => 'nullable|string',
        ]);

        KartuKeluarga::create($request->only([
            'no_kk',
            'kepala_keluarga',
            'rayon_id',
            'provinsi_id',
            'kota_id',
            'kecamatan_id',
            'kelurahan_id',
            'kodepos_id',
            'alamat_rt',
            'alamat_rw',
            'alamat_lengkap',
        ]));

        return redirect()->route('kartu-keluarga.index')->with('success', 'Data kartu keluarga berhasil ditambahkan');
    }

    public function show(KartuKeluarga $kartuKeluarga)
    {
        return view('kartu_keluarga.show', compact('kartuKeluarga'));
    }

    public function edit(KartuKeluarga $kartuKeluarga)
    {
        $rayons = Rayon::all();
        $provinces = Province::all();

        return view('kartu_keluarga.edit', compact('kartuKeluarga', 'rayons', 'provinces'));
    }

    public function update(Request $request, KartuKeluarga $kartuKeluarga)
    {
        $request->validate([
            'no_kk' => 'required|string|max:20|unique:kartu_keluargas,no_kk,' . $kartuKeluarga->id,
            'kepala_keluarga' => 'required|string|max:255',
            'rayon_id' => 'required|exists:rayons,id',
            'provinsi_id' => 'nullable|exists:provinces,id',
            'kota_id' => 'nullable|exists:regencies,id',
            'kecamatan_id' => 'nullable|exists:districts,id',
            'kelurahan_id' => 'nullable|exists:villages,id',
            'kodepos_id' => 'nullable|numeric',
            'alamat_rt' => 'nullable|integer|max:9999',
            'alamat_rw' => 'nullable|integer|max:9999',
            'alamat_lengkap' => 'nullable|string',
        ]);

        $kartuKeluarga->update($request->only([
            'no_kk',
            'kepala_keluarga',
            'rayon_id',
            'provinsi_id',
            'kota_id',
            'kecamatan_id',
            'kelurahan_id',
            'kodepos_id',
            'alamat_rt',
            'alamat_rw',
            'alamat_lengkap',
        ]));

        return redirect()->route('kartu-keluarga.index')->with('success', 'Data kartu keluarga berhasil diperbarui');
    }

    public function destroy(KartuKeluarga $kartuKeluarga)
    {
        $kartuKeluarga->delete();

        return redirect()->route('kartu-keluarga.index')->with('success', 'Data kartu keluarga berhasil dihapus');
    }
}
