<?php

namespace App\Http\Controllers;

use App\Exports\JemaatExport;
use App\Models\Jemaat;
use App\Models\KartuKeluarga;
use App\Models\Rayon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel;

class JemaatController extends Controller
{
    public function index()
    {
        $search = request('search');
        $rayonId = request('rayon_id');
        $statusKk = request('status_kk');
        $gender = request('gender');
        $statusPelayanan = request('status_pelayanan');
        $statusBaptis = request('status_baptis');
        $statusKawin = request('status_kawin');
        $pendidikan = request('pendidikan');
        $sortBy = request('sort_by', 'nama');
        $sortOrder = request('sort_order', 'asc');

        $jemaats = Jemaat::with(['kartuKeluarga.rayon'])
            ->when(
                $search,
                fn($q) =>
                $q->where(
                    fn($qq) =>
                    $qq->whereRaw("nama ILIKE ?", ["%$search%"])
                        ->orWhereRaw("nik ILIKE ?", ["%$search%"])
                        ->orWhereHas(
                            'kartuKeluarga',
                            fn($kk) =>
                            $kk->whereRaw("no_kk ILIKE ?", ["%$search%"])
                        )
                )
            )
            ->when($rayonId, fn($q) => $q->whereHas('kartuKeluarga', fn($qq) => $qq->where('rayon_id', $rayonId)))
            ->when($statusKk, fn($q) => $q->where('status_kk', $statusKk))
            ->when($gender, fn($q) => $q->where('gender', $gender))
            ->when($statusPelayanan, fn($q) => $q->where('status_pelayanan', $statusPelayanan))
            ->when($statusBaptis !== null, fn($q) => $q->where('status_baptis', $statusBaptis))
            ->when($statusKawin, fn($q) => $q->where('status_kawin', $statusKawin))
            ->when($pendidikan, fn($q) => $q->where('pendidikan', $pendidikan))
            ->orderBy($sortBy, $sortOrder)
            ->paginate(10)
            ->appends(request()->query());

        $rayons = Rayon::orderBy('nama')->get();

        return view('jemaats.index', compact('jemaats', 'rayons'));
    }

    // Metode untuk ekspor PDF
    public function exportPdf()
    {
        $search = request('search');
        $rayonId = request('rayon_id');
        $statusKk = request('status_kk');
        $gender = request('gender');
        $statusPelayanan = request('status_pelayanan');
        $statusBaptis = request('status_baptis');
        $statusKawin = request('status_kawin');
        $pendidikan = request('pendidikan');
        $sortBy = request('sort_by', 'nama');
        $sortOrder = request('sort_order', 'asc');

        // Re-use the query logic from the index method
        $jemaats = Jemaat::with(['kartuKeluarga.rayon'])
            ->when(
                $search,
                fn($q) =>
                $q->where(
                    fn($qq) =>
                    $qq->whereRaw("nama ILIKE ?", ["%$search%"])
                        ->orWhereRaw("nik ILIKE ?", ["%$search%"])
                        ->orWhereHas(
                            'kartuKeluarga',
                            fn($kk) =>
                            $kk->whereRaw("no_kk ILIKE ?", ["%$search%"])
                        )
                )
            )
            ->when($rayonId, fn($q) => $q->whereHas('kartuKeluarga', fn($qq) => $qq->where('rayon_id', $rayonId)))
            ->when($statusKk, fn($q) => $q->where('status_kk', $statusKk))
            ->when($gender, fn($q) => $q->where('gender', $gender))
            ->when($statusPelayanan, fn($q) => $q->where('status_pelayanan', $statusPelayanan))
            ->when($statusBaptis !== null, fn($q) => $q->where('status_baptis', $statusBaptis))
            ->when($statusKawin, fn($q) => $q->where('status_kawin', $statusKawin))
            ->when($pendidikan, fn($q) => $q->where('pendidikan', $pendidikan))
            ->orderBy($sortBy, $sortOrder)
            ->get(); // Use get() for all data

        $pdf = Pdf::loadView('jemaats.export_pdf', compact('jemaats'));
        return $pdf->download('data_jemaat_' . date('Ymd_His') . '.pdf');
    }

    // Metode untuk ekspor XLS
    public function exportXls(Excel $excel) // Injeksi instance ExcelService
    {
        $search = request('search');
        $rayonId = request('rayon_id');
        $statusKk = request('status_kk');
        $gender = request('gender');
        $statusPelayanan = request('status_pelayanan');
        $statusBaptis = request('status_baptis');
        $statusKawin = request('status_kawin');
        $pendidikan = request('pendidikan');
        $sortBy = request('sort_by', 'nama');
        $sortOrder = request('sort_order', 'asc');

        return $excel->download( // Panggil metode download pada instance $excel
            new JemaatExport(
                $search,
                $rayonId,
                $statusKk,
                $gender,
                $statusPelayanan,
                $statusBaptis,
                $statusKawin,
                $pendidikan,
                $sortBy,
                $sortOrder
            ),
            'data_jemaat_' . date('Ymd_His') . '.xlsx'
        );
    }

    public function show(Jemaat $jemaat)
    {
        return view('jemaats.show', compact('jemaat'));
    }

    public function create()
    {
        $kartuKeluargas = KartuKeluarga::with('rayon')->orderBy('no_kk')->get();
        return view('jemaats.create', compact('kartuKeluargas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'no_anggota' => 'required|string|max:20|unique:jemaats',
            'nik' => 'nullable|string|max:20|unique:jemaats',
            'kartu_keluarga_id' => 'required|exists:kartu_keluargas,id',
            'status_kk' => 'required',
            'gender' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'status_kawin' => 'required',
            'pendidikan' => 'nullable|string|max:50',
            'gelar' => 'nullable|string|max:50',
            'status_baptis' => 'boolean',
            'tanggal_baptis' => 'nullable|date',
            'pekerjaan' => 'nullable|string|max:100',
            'tanggal_gabung' => 'nullable|date',
            'status_pelayanan' => 'required',
            'status_keaktifan' => 'required',
            'tanggal_nonaktif' => 'nullable|date',
            'telepon' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:2048',
        ]);

        try {
            if ($request->hasFile('foto')) {
                $validated['foto'] = $request->file('foto')->store('foto_jemaat', 'public');
            }

            Jemaat::create($validated);

            return redirect()->route('jemaats.index')->with('success', 'Data jemaat berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data.' . $e->getMessage());
        }
    }


    public function edit(Jemaat $jemaat)
    {
        $kartuKeluargas = KartuKeluarga::orderBy('no_kk')->get();
        return view('jemaats.edit', compact('jemaat', 'kartuKeluargas'));
    }

    public function update(Request $request, Jemaat $jemaat)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'no_anggota' => 'required|string|max:20|unique:jemaats,no_anggota,' . $jemaat->id,
            'nik' => 'nullable|string|max:20|unique:jemaats,nik,' . $jemaat->id,
            'kartu_keluarga_id' => 'required|exists:kartu_keluargas,id',
            'status_kk' => 'required',
            'gender' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'status_kawin' => 'required',
            'pendidikan' => 'nullable|string|max:50',
            'gelar' => 'nullable|string|max:50',
            'status_baptis' => 'boolean',
            'tanggal_baptis' => 'nullable|date',
            'pekerjaan' => 'nullable|string|max:100',
            'tanggal_gabung' => 'nullable|date',
            'status_pelayanan' => 'required',
            'status_keaktifan' => 'required',
            'tanggal_nonaktif' => 'nullable|date',
            'telepon' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($jemaat->foto) {
                Storage::disk('public')->delete($jemaat->foto);
            }
            $validated['foto'] = $request->file('foto')->store('foto_jemaat', 'public');
        }

        $jemaat->update($validated);

        return redirect()->route('jemaats.index')->with('success', 'Data jemaat berhasil diperbarui.');
    }

    public function destroy(Jemaat $jemaat)
    {
        if ($jemaat->foto) {
            Storage::disk('public')->delete($jemaat->foto);
        }

        $jemaat->delete();

        return redirect()->route('jemaats.index')->with('success', 'Data jemaat berhasil dihapus.');
    }
}
