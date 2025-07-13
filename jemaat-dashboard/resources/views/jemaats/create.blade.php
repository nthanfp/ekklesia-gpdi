@extends('layouts.layout')

@section('title', 'Tambah Jemaat')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Tambah Jemaat Baru</h5>
                </div>
                <div class="card-body">
                    {{-- ALERT ERROR GLOBAL --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Terjadi kesalahan!</strong>
                            <ul class="mb-0 mt-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('jemaats.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">

                            {{-- 🔹 1. INFORMASI PRIBADI --}}
                            <div class="col-md-6">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" name="nama" value="{{ old('nama') }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="no_anggota" class="form-label">Nomor Anggota</label>
                                <input type="text" class="form-control @error('no_anggota') is-invalid @enderror"
                                    id="no_anggota" name="no_anggota" value="{{ old('no_anggota') }}" required>
                                @error('no_anggota')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik"
                                    name="nik" value="{{ old('nik') }}">
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select class="form-select @error('gender') is-invalid @enderror" id="gender"
                                    name="gender" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                    id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="status_kawin" class="form-label">Status Kawin</label>
                                <select class="form-select @error('status_kawin') is-invalid @enderror" id="status_kawin"
                                    name="status_kawin">
                                    <option value="">Pilih Status</option>
                                    @foreach (\App\Models\Jemaat::STATUS_KAWIN as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ old('status_kawin') == $value ? 'selected' : '' }}>{{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status_kawin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="px-2 mt-3 mb-2">
                                <hr />
                            </div>

                            {{-- 🔹 2. DATA KELUARGA --}}
                            <div class="col-md-6">
                                <label for="kartu_keluarga_id" class="form-label">Kartu Keluarga</label>
                                <select class="form-select @error('kartu_keluarga_id') is-invalid @enderror"
                                    id="kartu_keluarga_id" name="kartu_keluarga_id">
                                    <option value="">Pilih KK</option>
                                    @foreach ($kartuKeluargas as $kk)
                                        <option value="{{ $kk->id }}"
                                            {{ old('kartu_keluarga_id') == $kk->id ? 'selected' : '' }}>
                                            {{ $kk->no_kk }} - {{ $kk->kepala_keluarga }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kartu_keluarga_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="status_kk" class="form-label">Status dalam KK</label>
                                <select class="form-select @error('status_kk') is-invalid @enderror" id="status_kk"
                                    name="status_kk">
                                    <option value="">Pilih Status</option>
                                    @foreach (\App\Models\Jemaat::STATUS_KK as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ old('status_kk') == $value ? 'selected' : '' }}>{{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status_kk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="px-2 mt-3 mb-2">
                                <hr />
                            </div>

                            {{-- 🔹 3. STATUS GEREJAWI --}}
                            <div class="col-md-6">
                                <label for="status_pelayanan" class="form-label">Status Pelayanan</label>
                                <select class="form-select @error('status_pelayanan') is-invalid @enderror"
                                    id="status_pelayanan" name="status_pelayanan" required>
                                    <option value="">Pilih Status</option>
                                    @foreach (\App\Models\Jemaat::STATUS_PELAYANAN as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ old('status_pelayanan') == $value ? 'selected' : '' }}>{{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status_pelayanan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="status_keaktifan" class="form-label">Status Keaktifan</label>
                                <select class="form-select @error('status_keaktifan') is-invalid @enderror"
                                    id="status_keaktifan" name="status_keaktifan" required>
                                    <option value="">Pilih Status</option>
                                    @foreach (\App\Models\Jemaat::STATUS_KEAKTIFAN as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ old('status_keaktifan') == $value ? 'selected' : '' }}>{{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status_keaktifan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="tanggal_gabung" class="form-label">Tanggal Gabung</label>
                                <input type="date" class="form-control @error('tanggal_gabung') is-invalid @enderror"
                                    id="tanggal_gabung" name="tanggal_gabung" value="{{ old('tanggal_gabung') }}">
                                @error('tanggal_gabung')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- 🔹 4. KONTAK & FOTO --}}
                            <div class="col-md-6">
                                <label for="telepon" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control @error('telepon') is-invalid @enderror"
                                    id="telepon" name="telepon" value="{{ old('telepon') }}">
                                @error('telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="foto" class="form-label">Foto</label>
                                <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                    id="foto" name="foto">
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('jemaats.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
