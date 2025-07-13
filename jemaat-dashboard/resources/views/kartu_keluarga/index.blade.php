@extends('layouts.layout')

@section('title', 'Daftar Kartu Keluarga')

@section('action-buttons')
    <a href="{{ route('kartu-keluarga.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Tambah KK
    </a>
@endsection

@section('content')
    {{-- @section('action-buttons') --}}
    <form method="GET" class="row g-2 align-items-end mb-3">
        <div class="col-md-2">
            <label for="search" class="form-label">Pencarian</label>
            <input type="text" name="search" id="search" class="form-control"
                placeholder="Cari No KK / Kepala Keluarga" value="{{ request('search') }}">
        </div>

        <div class="col-md-2">
            <label for="rayon_id" class="form-label">Rayon</label>
            <select name="rayon_id" id="rayon_id" class="form-select">
                <option value="">Semua Rayon</option>
                @foreach ($rayons as $rayon)
                    <option value="{{ $rayon->id }}" {{ request('rayon_id') == $rayon->id ? 'selected' : '' }}>
                        {{ $rayon->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label for="sort_by" class="form-label">Urut Berdasarkan</label>
            <select name="sort_by" id="sort_by" class="form-select">
                <option value="">Pilih</option>
                <option value="no_kk" {{ request('sort_by') == 'no_kk' ? 'selected' : '' }}>Nomor KK</option>
                <option value="kepala_keluarga" {{ request('sort_by') == 'kepala_keluarga' ? 'selected' : '' }}>
                    Kepala Keluarga</option>
                <option value="jemaats_count" {{ request('sort_by') == 'jemaats_count' ? 'selected' : '' }}>
                    Jumlah Anggota</option>
            </select>
        </div>

        <div class="col-md-2">
            <label for="sort_order" class="form-label">Arah Urutan</label>
            <select name="sort_order" id="sort_order" class="form-select">
                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Naik (A-Z / Terendah)</option>
                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Turun (Z-A / Tertinggi)
                </option>
            </select>
        </div>

        <div class="col-md-2 d-grid">
            <button type="submit" class="btn btn-primary"><i class="bi bi-filter"></i> Tampilkan</button>
        </div>

        <div class="col-md-2 d-grid">
            <a href="{{ route('kartu-keluarga.index') }}" class="btn btn-secondary"><i class="bi bi-x-circle"></i>
                Reset</a>
        </div>
    </form>
    {{-- @endsection --}}

    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nomor KK</th>
                            <th>Kepala Keluarga</th>
                            <th>Rayon</th>
                            <th>Kecamatan</th>
                            <th>Kelurahan</th>
                            <th>Anggota</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kartuKeluargas as $kk)
                            <tr>
                                <td>{{ $loop->iteration + ($kartuKeluargas->currentPage() - 1) * $kartuKeluargas->perPage() }}
                                </td>
                                <td>{{ $kk->no_kk }}</td>
                                <td>{{ $kk->kepala_keluarga }}</td>
                                <td>{{ $kk->rayon->nama }}</td>
                                <td>{{ $kk->kecamatan?->name ? Str::title(strtolower($kk->kecamatan->name)) : '-' }}</td>
                                <td>{{ $kk->kelurahan?->name ? Str::title(strtolower($kk->kelurahan->name)) : '-' }}</td>
                                <td>{{ $kk->jemaats_count }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('kartu-keluarga.show', $kk->id) }}" class="btn btn-sm btn-info"
                                            title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('kartu-keluarga.edit', $kk->id) }}"
                                            class="btn btn-sm btn-warning" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('kartu-keluarga.destroy', $kk->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus Kartu Keluarga ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">Tidak ada data Kartu Keluarga</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-center">
                {{ $kartuKeluargas->links() }}
            </div>
        </div>
    </div>
@endsection
