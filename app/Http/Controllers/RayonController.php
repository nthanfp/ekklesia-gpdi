<?php

namespace App\Http\Controllers;

use App\Models\Rayon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RayonController extends Controller
{
    public function index()
    {
        $query = Rayon::query()
            ->withCount(['kartuKeluargas', 'jemaats']);

        if (request('search')) {
            $query->where('nama', 'like', '%' . request('search') . '%')
                ->orWhere('kode', 'like', '%' . request('search') . '%');
        }

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
        return view('rayons.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required'
        ]);

        $slug = Str::slug($validated['nama']);
        $originalSlug = $slug;
        $count = 1;

        while (Rayon::where('kode', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        $validated['kode'] = $slug;

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
            'nama' => 'required'
        ]);

        if ($validated['nama'] !== $rayon->nama) {
            $slug = Str::slug($validated['nama']);
            $originalSlug = $slug;
            $count = 1;

            while (Rayon::where('kode', $slug)->where('id', '!=', $rayon->id)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }
            $validated['kode'] = $slug;
        }

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
