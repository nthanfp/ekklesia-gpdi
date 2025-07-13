@extends('layouts.layout')

@section('title', 'Daftar Jemaat')

@section('action-buttons')
    <a href="{{ route('jemaats.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Tambah Jemaat
    </a>
@endsection

@section('content')
    <div class="mb-3">
        <form method="GET" class="row g-2 align-items-end">

            <div class="col-md-3">
                <label for="search" class="form-label">Pencarian</label>
                <input type="text" name="search" id="search" class="form-control"
                    placeholder="Cari nama, NIK, atau No Anggota" value="{{ request('search') }}">
            </div>

            <div class="col-md-2">
                <label for="rayon_id" class="form-label">Rayon</label>
                <select name="rayon_id" id="rayon_id" class="form-select">
                    <option value="">Semua</option>
                    @foreach ($rayons as $rayon)
                        <option value="{{ $rayon->id }}" {{ request('rayon_id') == $rayon->id ? 'selected' : '' }}>
                            {{ $rayon->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label for="kartu_keluarga_id" class="form-label">Kartu Keluarga</label>
                <select name="kartu_keluarga_id" id="kartu_keluarga_id" class="form-select">
                    <option value="">Semua</option>
                    @foreach ($kartuKeluargas as $kk)
                        <option value="{{ $kk->id }}" {{ request('kartu_keluarga_id') == $kk->id ? 'selected' : '' }}>
                            {{ $kk->no_kk }} - {{ $kk->kepala_keluarga }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label for="status_kk" class="form-label">Status KK</label>
                <select name="status_kk" id="status_kk" class="form-select">
                    <option value="">Semua</option>
                    @foreach (\App\Models\Jemaat::STATUS_KK as $value => $label)
                        <option value="{{ $value }}" {{ request('status_kk') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label for="sort_by" class="form-label">Urut Berdasarkan</label>
                <select name="sort_by" id="sort_by" class="form-select">
                    <option value="nama" {{ request('sort_by') == 'nama' ? 'selected' : '' }}>Nama</option>
                    <option value="nik" {{ request('sort_by') == 'nik' ? 'selected' : '' }}>NIK</option>
                    <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Tanggal Input
                    </option>
                </select>
            </div>

            <div class="col-md-2">
                <label for="sort_order" class="form-label">Arah Urutan</label>
                <select name="sort_order" id="sort_order" class="form-select">
                    <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Naik (A-Z)</option>
                    <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Turun (Z-A)</option>
                </select>
            </div>

            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-filter"></i> Tampilkan
                </button>
            </div>

            <div class="col-md-2 d-grid">
                <a href="{{ route('jemaats.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>Jenis Kelamin</th>
                            <th>Rayon</th>
                            <th>Kartu Keluarga</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jemaats as $jemaat)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $jemaat->nama }}</td>
                                <td>{{ $jemaat->nik }}</td>
                                <td>{{ $jemaat->gender }}</td>
                                <td>{{ $jemaat->kartuKeluarga->rayon->nama }}</td>
                                <td>{{ $jemaat->kartuKeluarga->no_kk }}</td>
                                <td class="table-actions">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('jemaats.show', $jemaat->id) }}"
                                            class="btn btn-sm btn-info btn-action" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('jemaats.edit', $jemaat->id) }}"
                                            class="btn btn-sm btn-warning btn-action" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('jemaats.destroy', $jemaat->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger btn-action" title="Hapus"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus jemaat ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data jemaat</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $jemaats->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
