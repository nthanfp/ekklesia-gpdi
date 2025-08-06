@extends('layouts.layout')

@section('title', 'Edit Rayon')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('rayons.update', $rayon->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="kode" class="form-label">Kode Rayon</label>
                <input type="text" class="form-control @error('kode') is-invalid @enderror" id="kode" name="kode" value="{{ old('kode', $rayon->kode) }}" required>
                @error('kode')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Rayon</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $rayon->nama) }}" required>
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('rayons.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection