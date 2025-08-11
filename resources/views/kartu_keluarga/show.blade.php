@php
    use Illuminate\Support\Str;

    function formatWilayah($nama)
    {
        if (in_array(strtoupper($nama), ['DKI JAKARTA', 'DI YOGYAKARTA'])) {
            return strtoupper(Str::substr($nama, 0, 3)) . ' ' . Str::title(Str::substr($nama, 4));
        }
        return Str::title(Str::lower($nama));
    }
@endphp

@extends('layouts.layout')

@section('title', 'Detail Kartu Keluarga')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Detail Kartu Keluarga</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-hover">
                        <tr>
                            <th width="30%">No KK</th>
                            <td>{{ $kartuKeluarga->no_kk }}</td>
                        </tr>
                        <tr>
                            <th>Kepala Keluarga</th>
                            <td>{{ $kartuKeluarga->kepala_keluarga }}</td>
                        </tr>
                        <tr>
                            <th>Rayon</th>
                            <td>{{ $kartuKeluarga->rayon->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Anggota</th>
                            <td>{{ $kartuKeluarga->jemaats_count ?? $kartuKeluarga->jemaats->count() }}</td>
                        </tr>
                        <tr>
                            <th>Provinsi</th>
                            <td>{{ $kartuKeluarga->provinsi ? formatWilayah($kartuKeluarga->provinsi->name) : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Kab/Kota</th>
                            <td>{{ $kartuKeluarga->kota ? formatWilayah($kartuKeluarga->kota->name) : '-' }}</td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-6">
                    <table class="table table-hover">
                        <tr>
                            <th>Kecamatan</th>
                            <td>{{ $kartuKeluarga->kecamatan ? formatWilayah($kartuKeluarga->kecamatan->name) : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Kelurahan</th>
                            <td>{{ $kartuKeluarga->kelurahan ? formatWilayah($kartuKeluarga->kelurahan->name) : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Kode POS</th>
                            <td>{{ $kartuKeluarga->kodepos_id ? formatWilayah($kartuKeluarga->kodepos_id) : '-' }}</td>
                        </tr>
                        <tr>
                            <th width="30%">RT / RW</th>
                            <td>
                                {{ $kartuKeluarga->alamat_rt ?? '-' }} / {{ $kartuKeluarga->alamat_rw ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th>Alamat Lengkap</th>
                            <td>{{ $kartuKeluarga->alamat_lengkap ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <h5 class="mt-4 mb-3">Anggota Keluarga</h5>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="text-nowrap">#</th>
                            <th class="text-nowrap">Nama</th>
                            <th class="text-nowrap">NIK</th>
                            <th class="text-nowrap">No KK</th>
                            <th class="text-nowrap">Status KK</th>
                            <th class="text-nowrap">Rayon</th>
                            <th class="text-nowrap">Gender</th>
                            <th class="text-nowrap">Tgl Lahir</th>
                            <th class="text-nowrap">Usia</th>
                            <th class="text-nowrap">Pelayanan</th>
                            <th class="text-nowrap">Baptis</th>
                            <th class="text-nowrap">Tgl Baptis</th>
                            <th class="text-nowrap">Pernikahan</th>
                            <th class="aksi-header">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kartuKeluarga->jemaats as $jemaat)
                            <tr>
                                <td class="text-nowrap">{{ $loop->iteration }}</td>
                                <td class="text-nowrap">{{ $jemaat->nama }}</td>
                                <td class="text-nowrap">{{ $jemaat->nik }}</td>
                                <td class="text-nowrap">{{ $jemaat->kartuKeluarga->no_kk ?? '-' }}</td>
                                <td class="text-nowrap">{{ \App\Models\Jemaat::STATUS_KK[$jemaat->status_kk] ?? '-' }}
                                </td>
                                <td class="text-nowrap">{{ $jemaat->kartuKeluarga->rayon->nama ?? '-' }}</td>
                                <td class="text-nowrap">{{ $jemaat->gender === 'L' ? 'L' : 'P' }}</td>
                                <td class="text-nowrap">
                                    {{ \Carbon\Carbon::parse($jemaat->tanggal_lahir)->format('d-m-Y') }}
                                </td>
                                <td class="text-nowrap">{{ \Carbon\Carbon::parse($jemaat->tanggal_lahir)->age }}</td>
                                <td class="text-nowrap">{{ ucwords(strtolower($jemaat->status_pelayanan ?? '-')) }}</td>
                                <td class="text-nowrap">{{ $jemaat->status_baptis ? 'Sudah' : 'Belum' }}</td>
                                <td class="text-nowrap">
                                    {{ $jemaat->tanggal_baptis ? \Carbon\Carbon::parse($jemaat->tanggal_baptis)->format('d-m-Y') : '-' }}
                                </td>
                                <td class="text-nowrap">{{ ucwords(strtolower($jemaat->status_kawin ?? '-')) }}</td>
                                <td class="text-end aksi-cell">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('jemaats.show', $jemaat->id) }}" class="btn btn-sm btn-info"
                                            title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="14" class="text-center">Tidak ada data jemaat</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
        <div class="card-footer">
            <a href="{{ route('kartu-keluarga.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
@endsection
