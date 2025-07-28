@extends('layouts.layout')

@section('title', 'Daftar Kartu Keluarga')

@section('action-buttons')
    <a href="{{ route('kartu-keluarga.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Tambah KK
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-address-card me-2"></i>Daftar Kartu Keluarga
                </h5>
                <a href="{{ route('kartu-keluarga.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Tambah KK
                </a>
            </div>
        </div>
        
        <div class="card-body">
            <form method="GET" class="row g-3 mb-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Pencarian</label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari No KK/Nama" value="{{ request('search') }}">
                </div>
                
                <div class="col-md-3">
                    <label for="rayon_id" class="form-label">Rayon</label>
                    <select name="rayon_id" class="form-select">
                        <option value="">Semua Rayon</option>
                        @foreach($rayons as $rayon)
                            <option value="{{ $rayon->id }}" {{ request('rayon_id') == $rayon->id ? 'selected' : '' }}>
                                {{ $rayon->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label for="sort_by" class="form-label">Urut Berdasarkan</label>
                    <select name="sort_by" class="form-select">
                        <option value="">Default</option>
                        <option value="no_kk" {{ request('sort_by') == 'no_kk' ? 'selected' : '' }}>No KK</option>
                        <option value="kepala_keluarga" {{ request('sort_by') == 'kepala_keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                        <option value="jemaats_count" {{ request('sort_by') == 'jemaats_count' ? 'selected' : '' }}>Jumlah Anggota</option>
                        <option value="tanggal_pernikahan" {{ request('sort_by') == 'tanggal_pernikahan' ? 'selected' : '' }}>Tanggal Pernikahan</option>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label for="sort_order" class="form-label">Arah Urutan</label>
                    <select name="sort_order" class="form-select">
                        <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>A-Z / Terendah</option>
                        <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Z-A / Tertinggi</option>
                    </select>
                </div>
                
                <div class="col-md-12">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                        <a href="{{ route('kartu-keluarga.index') }}" class="btn btn-secondary">
                            <i class="fas fa-sync-alt me-1"></i> Reset
                        </a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="50">#</th>
                            <th>No KK</th>
                            <th>Kepala Keluarga</th>
                            <th>Rayon</th>
                            <th class="text-center">Anggota</th>
                            <th>Tanggal Pernikahan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kartuKeluargas as $kk)
                            <tr>
                                <td>{{ $loop->iteration + ($kartuKeluargas->currentPage() - 1) * $kartuKeluargas->perPage() }}</td>
                                <td>{{ $kk->no_kk }}</td>
                                <td>{{ $kk->kepala_keluarga }}</td>
                                <td>{{ $kk->rayon->nama }}</td>
                                <td class="text-center">
                                    <span class="badge bg-primary">{{ $kk->jemaats_count }}</span>
                                </td>
                                <td>
                                    @if($kk->tanggal_pernikahan)
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fas fa-ring text-danger"></i>
                                            <div>
                                                {{ \Carbon\Carbon::parse($kk->tanggal_pernikahan)->translatedFormat('d F Y') }}
                                                <br>
                                                <small class="text-muted">
                                                    ({{ \Carbon\Carbon::parse($kk->tanggal_pernikahan)->diffInYears() }} tahun)
                                                </small>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('kartu-keluarga.show', $kk->id) }}" 
                                           class="btn btn-sm btn-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('kartu-keluarga.edit', $kk->id) }}" 
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('kartu-keluarga.destroy', $kk->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    title="Hapus" onclick="return confirm('Hapus data ini?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-address-card fa-2x text-muted mb-3"></i>
                                    <p>Tidak ada data Kartu Keluarga</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $kartuKeluargas->links() }}
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .table-responsive {
        -webkit-overflow-scrolling: touch;
    }
    .badge {
        min-width: 30px;
    }
</style>
@endpush