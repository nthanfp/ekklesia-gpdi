@extends('layouts.layout')

@section('title', 'Daftar Jemaat')

@section('action-buttons')
    <a href="{{ route('jemaats.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Tambah Jemaat
    </a>
@endsection

@push('styles')
    <style>
        /* Pastikan scroll hanya dalam table wrapper */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        /* Buat kolom aksi sticky kanan */
        .aksi-header {
            position: sticky;
            right: 0;
            background-color: #f8f9fa;
            /* warna header */
            z-index: 10;
            text-align: right;
        }

        .aksi-cell {
            position: sticky;
            right: 0;
            background-color: #fff;
            z-index: 9;
        }
    </style>
@endpush

@section('content')
    <div class="mb-3">
        <form method="GET" class="row g-2 align-items-end">

            <div class="col-md-3 col-6">
                <label for="search" class="form-label">Nama / NIK / No KK</label>
                <input type="text" name="search" id="search" class="form-control" placeholder="Cari..."
                    value="{{ request('search') }}">
            </div>

            <div class="col-md-3 col-6">
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

            <div class="col-md-3 col-6">
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

            <div class="col-md-3 col-6">
                <label for="gender" class="form-label">Gender</label>
                <select name="gender" id="gender" class="form-select">
                    <option value="">Semua</option>
                    <option value="L" {{ request('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ request('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div class="col-md-3 col-6">
                <label for="status_pelayanan" class="form-label">Status Pelayanan</label>
                <select name="status_pelayanan" id="status_pelayanan" class="form-select">
                    <option value="">Semua</option>
                    @foreach (\App\Models\Jemaat::STATUS_PELAYANAN as $value => $label)
                        <option value="{{ $value }}" {{ request('status_pelayanan') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 col-6">
                <label for="status_baptis" class="form-label">Status Baptis</label>
                <select name="status_baptis" id="status_baptis" class="form-select">
                    <option value="">Semua</option>
                    <option value="1" {{ request('status_baptis') === '1' ? 'selected' : '' }}>Sudah</option>
                    <option value="0" {{ request('status_baptis') === '0' ? 'selected' : '' }}>Belum</option>
                </select>
            </div>

            <div class="col-md-3 col-6">
                <label for="status_kawin" class="form-label">Status Pernikahan</label>
                <select name="status_kawin" id="status_kawin" class="form-select">
                    <option value="">Semua</option>
                    @foreach (\App\Models\Jemaat::STATUS_KAWIN as $value => $label)
                        <option value="{{ $value }}" {{ request('status_kawin') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 col-6">
                <label for="pendidikan" class="form-label">Pendidikan</label>
                <select name="pendidikan" id="pendidikan" class="form-select">
                    <option value="">Semua</option>
                    @foreach (\App\Models\Jemaat::PENDIDIKAN as $value => $label)
                        <option value="{{ $value }}" {{ request('pendidikan') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 col-6">
                <label for="sort_by" class="form-label">Urut Berdasarkan</label>
                <select name="sort_by" id="sort_by" class="form-select">
                    <option value="nama" {{ request('sort_by') == 'nama' ? 'selected' : '' }}>Nama</option>
                    <option value="nik" {{ request('sort_by') == 'nik' ? 'selected' : '' }}>NIK</option>
                    <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Tanggal Input
                    </option>
                </select>
            </div>

            <div class="col-md-3 col-6">
                <label for="sort_order" class="form-label">Arah Urutan</label>
                <select name="sort_order" id="sort_order" class="form-select">
                    <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Naik (A-Z)</option>
                    <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Turun (Z-A)</option>
                </select>
            </div>

            <div class="col-md-3 col-6 d-grid">
                <button type="submit" class="btn btn-primary mt-2">
                    <i class="bi bi-filter"></i> Tampilkan
                </button>
            </div>

            <div class="col-md-3 col-6 d-grid">
                <a href="{{ route('jemaats.index') }}" class="btn btn-secondary mt-2">
                    <i class="bi bi-x-circle"></i> Reset
                </a>
            </div>

        </form>
    </div>

    <div class="card">
        <div class="card-body">

            @if (collect(request()->only([
                        'search',
                        'rayon_id',
                        'status_kk',
                        'gender',
                        'status_pelayanan',
                        'status_baptis',
                        'status_kawin',
                        'pendidikan',
                    ]))->filter()->isNotEmpty())
                <div class="alert alert-info">
                    <strong><small>Filter Aktif:</small></strong>
                    <ul class="mb-0">
                        @if (request('search'))
                            <li><small><strong>Cari:</strong> {{ request('search') }}</small></li>
                        @endif
                        @if (request('rayon_id'))
                            <li><small><strong>Rayon:</strong>
                                    {{ $rayons->firstWhere('id', request('rayon_id'))?->nama ?? '-' }}</small></li>
                        @endif
                        @if (request('status_kk'))
                            <li><small><strong>Status KK:</strong>
                                    {{ \App\Models\Jemaat::STATUS_KK[request('status_kk')] ?? '-' }}</small></li>
                        @endif
                        @if (request('gender'))
                            <li><small><strong>Gender:</strong>
                                    {{ request('gender') == 'L' ? 'Laki-laki' : 'Perempuan' }}</small></li>
                        @endif
                        @if (request('status_pelayanan'))
                            <li><small><strong>Status Pelayanan:</strong>
                                    {{ \App\Models\Jemaat::STATUS_PELAYANAN[request('status_pelayanan')] ?? '-' }}</small>
                            </li>
                        @endif
                        @if (request('status_baptis') !== null)
                            <li><small><strong>Status Baptis:</strong>
                                    {{ request('status_baptis') == '1' ? 'Sudah' : 'Belum' }}</small></li>
                        @endif
                        @if (request('status_kawin'))
                            <li><small><strong>Status Pernikahan:</strong>
                                    {{ \App\Models\Jemaat::STATUS_KAWIN[request('status_kawin')] ?? '-' }}</small></li>
                        @endif
                        @if (request('pendidikan'))
                            <li><small><strong>Pendidikan:</strong>
                                    {{ \App\Models\Jemaat::PENDIDIKAN[request('pendidikan')] ?? '-' }}</small></li>
                        @endif
                    </ul>
                </div>
            @endif
            <small class="text-muted mb-2 d-block">
                Menampilkan {{ $jemaats->count() }} dari total {{ $jemaats->total() }} data
            </small>


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
                        @forelse($jemaats as $jemaat)
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
                                        <a href="{{ route('jemaats.edit', $jemaat->id) }}" class="btn btn-sm btn-warning"
                                            title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('jemaats.destroy', $jemaat->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                                onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center">Tidak ada data jemaat</td>
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
