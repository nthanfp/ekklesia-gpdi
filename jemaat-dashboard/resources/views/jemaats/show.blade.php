@extends('layouts.layout')

@section('title', 'Detail Jemaat')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Detail Jemaat</h5>
        </div>
        <div class="card-body">
            <div class="row">

                {{-- 🔹 1. INFORMASI PRIBADI --}}
                <h4 class="text-primary fw-bold">Informasi Pribadi</h4>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Nama</th>
                            <td>{{ $jemaat->nama }}</td>
                        </tr>
                        <tr>
                            <th>No Anggota</th>
                            <td>{{ $jemaat->no_anggota ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>NIK</th>
                            <td>{{ $jemaat->nik ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>{{ $jemaat->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Lahir</th>
                            <td>{{ $jemaat->tanggal_lahir?->format('d-m-Y') ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status Kawin</th>
                            <td>{{ \App\Models\Jemaat::STATUS_KAWIN[$jemaat->status_kawin] ?? '-' }}</td>
                        </tr>
                    </table>
                </div>

                {{-- 🔹 2. DATA KELUARGA --}}
                <div class="col-md-6">
                    <h4 class="text-primary fw-bold">Data Keluarga</h4>
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">No KK</th>
                            <td>
                                @if ($jemaat->kartuKeluarga)
                                    {{ $jemaat->kartuKeluarga->no_kk }} - {{ $jemaat->kartuKeluarga->kepala_keluarga }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Rayon</th>
                            <td>{{ $jemaat->kartuKeluarga->rayon->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status dalam KK</th>
                            <td>{{ \App\Models\Jemaat::STATUS_KK[$jemaat->status_kk] ?? '-' }}</td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-12 mt-4">
                    <hr>
                </div>

                {{-- 🔹 3. STATUS GEREJAWI --}}
                <div class="col-md-6">
                    <h4 class="text-primary fw-bold">Status Gerejawi</h4>
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Status Pelayanan</th>
                            <td>{{ \App\Models\Jemaat::STATUS_PELAYANAN[$jemaat->status_pelayanan] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status Keaktifan</th>
                            <td>{{ \App\Models\Jemaat::STATUS_KEAKTIFAN[$jemaat->status_keaktifan] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Gabung</th>
                            <td>{{ $jemaat->tanggal_gabung?->format('d-m-Y') ?? '-' }}</td>
                        </tr>
                    </table>
                </div>

                {{-- 🔹 4. KONTAK & FOTO --}}
                <div class="col-md-6">
                    <h4 class="text-primary fw-bold">Kontak & Foto</h4>
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Telepon</th>
                            <td>{{ $jemaat->telepon ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Foto</th>
                            <td>
                                @if ($jemaat->foto)
                                    <img src="{{ asset('storage/' . $jemaat->foto) }}" alt="Foto Jemaat"
                                        class="img-thumbnail" width="120">
                                @else
                                    Tidak ada foto
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('jemaats.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
