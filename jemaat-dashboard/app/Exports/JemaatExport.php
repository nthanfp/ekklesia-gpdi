<?php

namespace App\Exports;

use App\Models\Jemaat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

use Illuminate\Support\Collection;

class JemaatExport implements FromCollection, WithHeadings, WithMapping
{
    protected $search;
    protected $rayonId;
    protected $statusKk;
    protected $gender;
    protected $statusPelayanan;
    protected $statusBaptis;
    protected $statusKawin;
    protected $pendidikan;
    protected $sortBy;
    protected $sortOrder;

    public function __construct(
        $search, $rayonId, $statusKk, $gender, $statusPelayanan,
        $statusBaptis, $statusKawin, $pendidikan, $sortBy, $sortOrder
    ) {
        $this->search = $search;
        $this->rayonId = $rayonId;
        $this->statusKk = $statusKk;
        $this->gender = $gender;
        $this->statusPelayanan = $statusPelayanan;
        $this->statusBaptis = $statusBaptis;
        $this->statusKawin = $statusKawin;
        $this->pendidikan = $pendidikan;
        $this->sortBy = $sortBy;
        $this->sortOrder = $sortOrder;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(): Collection
    {
        // Re-use the query logic from the index method in JemaatController
        return Jemaat::with(['kartuKeluarga.rayon'])
            ->when(
                $this->search,
                fn($q) =>
                $q->where(
                    fn($qq) =>
                    $qq->whereRaw("nama ILIKE ?", ["%{$this->search}%"])
                        ->orWhereRaw("nik ILIKE ?", ["%{$this->search}%"])
                        ->orWhereHas(
                            'kartuKeluarga',
                            fn($kk) =>
                            $kk->whereRaw("no_kk ILIKE ?", ["%{$this->search}%"])
                        )
                )
            )
            ->when($this->rayonId, fn($q) => $q->whereHas('kartuKeluarga', fn($qq) => $qq->where('rayon_id', $this->rayonId)))
            ->when($this->statusKk, fn($q) => $q->where('status_kk', $this->statusKk))
            ->when($this->gender, fn($q) => $q->where('gender', $this->gender))
            ->when($this->statusPelayanan, fn($q) => $q->where('status_pelayanan', $this->statusPelayanan))
            ->when($this->statusBaptis !== null, fn($q) => $q->where('status_baptis', $this->statusBaptis))
            ->when($this->statusKawin, fn($q) => $q->where('status_kawin', $this->statusKawin))
            ->when($this->pendidikan, fn($q) => $q->where('pendidikan', $this->pendidikan))
            ->orderBy($this->sortBy, $this->sortOrder)
            ->get(); // Use get() instead of paginate() for export
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No. Anggota',
            'NIK',
            'Nama',
            'Telepon',
            'Gender',
            'Tanggal Lahir',
            'Status Kawin',
            'Pendidikan',
            'Gelar',
            'Status Baptis',
            'Tanggal Baptis',
            'Pekerjaan',
            'Tanggal Gabung',
            'Status Pelayanan',
            'Status Keaktifan',
            'Tanggal Nonaktif',
            'Status KK',
            'No. KK',
            'Rayon',
        ];
    }

    /**
     * @param mixed $jemaat
     * @return array
     */
    public function map($jemaat): array
    {
        return [
            $jemaat->no_anggota,
            $jemaat->nik,
            $jemaat->nama,
            $jemaat->telepon,
            $jemaat->getNamaGenderAttribute(), // Menggunakan accessor
            $jemaat->tanggal_lahir ? $jemaat->tanggal_lahir->format('d-m-Y') : '-',
            $jemaat->statusKawinLabel, // Menggunakan accessor
            $jemaat->pendidikan,
            $jemaat->gelar,
            $jemaat->status_baptis ? 'Sudah' : 'Belum',
            $jemaat->tanggal_baptis ? $jemaat->tanggal_baptis->format('d-m-Y') : '-',
            $jemaat->pekerjaan,
            $jemaat->tanggal_gabung ? $jemaat->tanggal_gabung->format('d-m-Y') : '-',
            $jemaat->statusPelayananLabel, // Menggunakan accessor
            $jemaat->statusKeaktifanLabel, // Menggunakan accessor
            $jemaat->tanggal_nonaktif ? $jemaat->tanggal_nonaktif->format('d-m-Y') : '-',
            $jemaat->statusKkLabel, // Menggunakan accessor
            $jemaat->kartuKeluarga->no_kk ?? '-',
            $jemaat->kartuKeluarga->rayon->nama ?? '-',
        ];
    }
}
