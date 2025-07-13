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
                    <table class="table table-bordered">
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
                    <table class="table table-bordered">
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
                <table class="table table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>Jenis Kelamin</th>
                            <th>Status KK</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kartuKeluarga->jemaats as $jemaat)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $jemaat->nama }}</td>
                                <td>{{ $jemaat->nik }}</td>
                                <td>{{ $jemaat->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                <td>{{ Str::title($jemaat->status_kk) }}</td>
                                <td>
                                    <a href="{{ route('jemaats.show', $jemaat->id) }}" class="btn btn-sm btn-info"
                                        title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">Tidak ada anggota keluarga</td>
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
