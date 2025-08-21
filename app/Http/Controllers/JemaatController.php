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
    /**
     * Tampilkan daftar jemaat dengan filter, sorting, dan pagination.
     *
     * @return \Illuminate\Contracts\View\View
     */
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

    /**
     * Pencarian Kartu Keluarga (AJAX).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchKK(Request $request)
    {
        $search = $request->get('search', '');

        $kartuKeluargas = KartuKeluarga::with('rayon')
            ->when($search, function ($query) use ($search) {
                $query->where('no_kk', 'ILIKE', "%{$search}%")
                    ->orWhere('kepala_keluarga', 'ILIKE', "%{$search}%");
            })
            ->orderBy('kepala_keluarga')
            ->paginate(10);

        return response()->json($kartuKeluargas);
    }

    /**
     * Ekspor data jemaat ke PDF.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
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
            ->get();

        $pdf = Pdf::loadView('jemaats.export_pdf', compact('jemaats'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('data_jemaat_' . date('Ymd_His') . '.pdf');
    }

    /**
     * Ekspor data jemaat ke Excel.
     *
     * @param  \Maatwebsite\Excel\Excel  $excel
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportXls(Excel $excel)
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

        return $excel->download(
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

    /**
     * Detail jemaat.
     *
     * @param  \App\Models\Jemaat  $jemaat
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Jemaat $jemaat)
    {
        return view('jemaats.show', compact('jemaat'));
    }

    /**
     * Form tambah jemaat.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $kartuKeluargas = KartuKeluarga::with('rayon')->orderBy('no_kk')->get();
        return view('jemaats.create', compact('kartuKeluargas'));
    }

    /**
     * Simpan jemaat baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'nik' => 'nullable|string|max:20|unique:jemaats',
            'kartu_keluarga_id' => 'required|exists:kartu_keluargas,id',
            'status_kk' => 'required',
            'gender' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'status_kawin' => 'required',
            'pendidikan' => 'nullable|string|max:50',
            'gelar' => 'nullable|string|max:50',
            'tanggal_pernikahan' => 'nullable|date',
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
            $validated['no_anggota'] = $this->generateNoAnggota();

            if ($request->hasFile('foto')) {
                $validated['foto'] = $request->file('foto')->store('foto_jemaat', 'public');
            }

            Jemaat::create($validated);

            return redirect()->route('jemaats.index')->with('success', 'Data jemaat berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data. ' . $e->getMessage());
        }
    }

    /**
     * Form edit jemaat.
     *
     * @param  \App\Models\Jemaat  $jemaat
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Jemaat $jemaat)
    {
        $kartuKeluargas = KartuKeluarga::orderBy('no_kk')->get();
        return view('jemaats.edit', compact('jemaat', 'kartuKeluargas'));
    }

    /**
     * Update data jemaat.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jemaat        $jemaat
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Jemaat $jemaat)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'nik' => 'nullable|string|max:20|unique:jemaats,nik,' . $jemaat->id,
            'kartu_keluarga_id' => 'required|exists:kartu_keluargas,id',
            'status_kk' => 'required',
            'gender' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'status_kawin' => 'required',
            'pendidikan' => 'nullable|string|max:50',
            'gelar' => 'nullable|string|max:50',
            'tanggal_pernikahan' => 'nullable|date',
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

        unset($validated['no_anggota']);

        $jemaat->update($validated);

        return redirect()->route('jemaats.index')->with('success', 'Data jemaat berhasil diperbarui.');
    }

    /**
     * Hapus data jemaat.
     *
     * @param  \App\Models\Jemaat  $jemaat
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Jemaat $jemaat)
    {
        if ($jemaat->foto) {
            Storage::disk('public')->delete($jemaat->foto);
        }

        $jemaat->delete();

        return redirect()->route('jemaats.index')->with('success', 'Data jemaat berhasil dihapus.');
    }

    /**
     * Generate nomor anggota unik (A0001 - A9999).
     *
     * @return string
     */
    private function generateNoAnggota(): string
    {
        do {
            $number = rand(1, 9999);
            $noAnggota = 'A' . str_pad($number, 4, '0', STR_PAD_LEFT);
        } while (Jemaat::where('no_anggota', $noAnggota)->exists());

        return $noAnggota;
    }
}
