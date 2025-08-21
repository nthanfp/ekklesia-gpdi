@extends('layouts.layout')

@section('title', 'Daftar Rayon')

@section('action-buttons')
    <a href="{{ route('rayons.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Tambah Rayon
    </a>
@endsection

@section('content')
    <form method="GET" class="row g-2 align-items-end mb-3">
        <div class="col-md-3">
            <label for="search" class="form-label">Pencarian</label>
            <input type="text" name="search" id="search" class="form-control" placeholder="Cari nama atau kode..."
                value="{{ request('search') }}">
        </div>

        <div class="col-md-3">
            <label for="sort_by" class="form-label">Urut Berdasarkan</label>
            <select name="sort_by" id="sort_by" class="form-select">
                <option value="">Pilih</option>
                <option value="nama" {{ request('sort_by') == 'nama' ? 'selected' : '' }}>Nama</option>
                <option value="kode" {{ request('sort_by') == 'kode' ? 'selected' : '' }}>Kode</option>
                <option value="kartu_keluargas_count" {{ request('sort_by') == 'kartu_keluargas_count' ? 'selected' : '' }}>
                    Jumlah KK</option>
                <option value="jemaats_count" {{ request('sort_by') == 'jemaats_count' ? 'selected' : '' }}>
                    Jumlah Jemaat</option>
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

        <div class="col-md-4 d-flex">
            <button type="submit" class="btn btn-primary me-2 w-100"><i class="bi bi-filter"></i> Tampilkan</button>
            <a href="{{ route('rayons.index') }}" class="btn btn-secondary w-100"><i class="bi bi-x-circle"></i> Reset</a>
        </div>
    </form>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            {{-- <th>Kode</th> --}}
                            <th>Nama Rayon</th>
                            <th>Jumlah Keluarga</th>
                            <th>Jumlah Jemaat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rayons as $rayon)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                {{-- <td>{{ $rayon->kode }}</td> --}}
                                <td>{{ $rayon->nama }}</td>
                                <td>{{ $rayon->kartu_keluargas_count }} Keluarga</td>
                                <td>{{ $rayon->jemaats_count }}</td>
                                <td>
                                    <a href="{{ route('rayons.edit', $rayon->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('rayons.destroy', $rayon->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus rayon ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data rayon</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $rayons->links() }}
            </div>
        </div>
    </div>
@endsection
