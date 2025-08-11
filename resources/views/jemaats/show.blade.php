@extends('layouts.layout')

@section('title', 'Detail Jemaat')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Detail Jemaat</h5>
        </div>

        <div class="card-body">
            <div class="row g-4">

                {{-- 🔹 INFORMASI PRIBADI --}}
                <div class="col-md-6">
                    <h5 class="text-primary border-bottom pb-2 mb-3">Informasi Pribadi</h5>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th>No Anggota</th>
                                <td>{{ $jemaat->no_anggota ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <td>{{ $jemaat->nama }}</td>
                            </tr>
                            <tr>
                                <th>NIK</th>
                                <td>{{ $jemaat->nik ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>{{ $jemaat->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Lahir</th>
                                <td>{{ $jemaat->tanggal_lahir?->format('d-m-Y') ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Pekerjaan</th>
                                <td>{{ $jemaat->pekerjaan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Status Kawin</th>
                                <td>{{ \App\Models\Jemaat::STATUS_KAWIN[$jemaat->status_kawin] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Pernikahan</th>
                                <td>{{ $jemaat->tanggal_pernikahan?->format('d-m-Y') ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Pendidikan</th>
                                <td>{{ \App\Models\Jemaat::PENDIDIKAN[$jemaat->pendidikan] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Gelar</th>
                                <td>{{ $jemaat->gelar ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- 🔹 DATA KELUARGA --}}
                <div class="col-md-6">
                    <h5 class="text-primary border-bottom pb-2 mb-3">Data Keluarga</h5>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th>Kartu Keluarga</th>
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
                        </tbody>
                    </table>
                    <h5 class="text-primary border-bottom pb-2 mb-3">Alamat</h5>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th>Provinsi</th>
                                <td>{{ $jemaat->kartuKeluarga->provinsi->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Kota/Kab</th>
                                <td>{{ $jemaat->kartuKeluarga->kota->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Kecamatan</th>
                                <td>{{ $jemaat->kartuKeluarga->kecamatan->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Kelurahan/Desa</th>
                                <td>{{ $jemaat->kartuKeluarga->kelurahan->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Provinsi</th>
                                <td>{{ $jemaat->kartuKeluarga->provinsi->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Alamat Lengkap</th>
                                <td>{{ $jemaat->kartuKeluarga->alamat_lengkap ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12">
                    <hr>
                </div>

                {{-- 🔹 STATUS GEREJAWI --}}
                <div class="col-md-6">
                    <h5 class="text-primary border-bottom pb-2 mb-3">Status Gerejawi</h5>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th>Status Pelayanan</th>
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
                            <tr>
                                <th>Tanggal Nonaktif</th>
                                <td>{{ $jemaat->tanggal_nonaktif?->format('d-m-Y') ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Status Baptis</th>
                                <td>{{ $jemaat->status_baptis ? 'Sudah' : 'Belum' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Baptis</th>
                                <td>{{ $jemaat->tanggal_baptis?->format('d-m-Y') ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- 🔹 KONTAK & FOTO --}}
                <div class="col-md-6">
                    <h5 class="text-primary border-bottom pb-2 mb-3">Kontak & Foto</h5>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th>Telepon</th>
                                <td>{{ $jemaat->telepon ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Foto</th>
                                <td>
                                    @if ($jemaat->foto)
                                        <img src="{{ asset('storage/' . $jemaat->foto) }}" alt="Foto Jemaat"
                                            class="img-thumbnail" width="130">
                                    @else
                                        <span class="text-muted">Tidak ada foto</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <div class="card-footer text-end">
            <a href="{{ route('jemaats.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
