@extends('layouts.layout')

@section('title', 'Daftar Rayon')

@section('action-buttons')
    <a href="{{ route('rayons.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Tambah Rayon
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Nama Rayon</th>
                        <th>Jumlah KK</th>
                        <th>Jumlah Jemaat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rayons as $rayon)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $rayon->kode }}</td>
                        <td>{{ $rayon->nama }}</td>
                        <td>{{ $rayon->kartuKeluargas_count }}</td>
                        <td>{{ $rayon->jemaat_count }}</td>
                        <td>
                            <a href="{{ route('rayon.edit', $rayon->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('rayon.destroy', $rayon->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus rayon ini?')">
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