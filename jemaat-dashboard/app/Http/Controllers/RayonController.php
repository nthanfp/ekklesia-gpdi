<?php

namespace App\Http\Controllers;

use App\Models\Rayon;
use Illuminate\Http\Request;

class RayonController extends Controller
{
    public function index()
    {
        $query = Rayon::query()
            ->withCount(['kartuKeluargas', 'jemaats']);

        // Search
        if (request('search')) {
            $query->where('nama', 'like', '%' . request('search') . '%')
                ->orWhere('kode', 'like', '%' . request('search') . '%');
        }

        // Sorting
        if (in_array(request('sort_by'), ['nama', 'kode', 'kartu_keluargas_count', 'jemaats_count'])) {
            $query->orderBy(request('sort_by'), request('sort_order') === 'desc' ? 'desc' : 'asc');
        } else {
            $query->orderBy('nama');
        }

        $rayons = $query->paginate(10)->withQueryString();

        return view('rayons.index', compact('rayons'));
    }


    public function create()
    {
        $rayons = Rayon::all();
        return view('rayons.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|unique:rayons,kode',
            'nama' => 'required'
        ]);

        Rayon::create($validated);

        return redirect()->route('rayons.index')
            ->with('success', 'Rayon berhasil ditambahkan');
    }

    public function show(Rayon $rayon)
    {
        return view('rayons.show', compact('rayon'));
    }

    public function edit(Rayon $rayon)
    {
        return view('rayons.edit', compact('rayon'));
    }

    public function update(Request $request, Rayon $rayon)
    {
        $validated = $request->validate([
            'kode' => 'required|unique:rayons,kode,' . $rayon->id,
            'nama' => 'required'
        ]);

        $rayon->update($validated);

        return redirect()->route('rayons.index')
            ->with('success', 'Rayon berhasil diperbarui');
    }

    public function destroy(Rayon $rayon)
    {
        $rayon->delete();

        return redirect()->route('rayons.index')
            ->with('success', 'Rayon berhasil dihapus');
    }
}
