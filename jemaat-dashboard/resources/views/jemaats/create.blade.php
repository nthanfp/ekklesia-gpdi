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
                            <div class="col-md-12">
                                <label for="no_anggota" class="form-label">Nomor Anggota <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-hash"></i></span>
                                    <input type="text" class="form-control @error('no_anggota') is-invalid @enderror"
                                        id="no_anggota" name="no_anggota" value="{{ old('no_anggota') }}" required>
                                </div>
                                @error('no_anggota')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-list"></i></span>
                                    <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                        id="nik" name="nik" value="{{ old('nik') }}" required>
                                </div>
                                @error('nik')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="nama" class="form-label">Nama Lengkap <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        id="nama" name="nama" value="{{ old('nama') }}" required>
                                </div>
                                @error('nama')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                        id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                                </div>
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="gender" class="form-label">Jenis Kelamin <span
                                        class="text-danger">*</span></label>
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
                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-briefcase-fill"></i></span>
                                    <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror"
                                        id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}">
                                </div>
                                @error('pekerjaan')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="status_kawin" class="form-label">Status Kawin</label>
                                <select class="form-select @error('status_kawin') is-invalid @enderror" id="status_kawin"
                                    name="status_kawin" required>
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

                            <div class="col-md-6">
                                <label for="pendidikan" class="form-label">Pendidikan Terakhir</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-mortarboard-fill"></i></span>
                                    <select class="form-select @error('pendidikan') is-invalid @enderror" id="pendidikan"
                                        name="pendidikan">
                                        <option value="">Pilih Pendidikan</option>
                                        @foreach (\App\Models\Jemaat::PENDIDIKAN as $value => $label)
                                            <option value="{{ $value }}"
                                                {{ old('pendidikan') == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('pendidikan')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="gelar" class="form-label">Gelar</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-award-fill"></i></span>
                                    <input type="text" class="form-control @error('gelar') is-invalid @enderror"
                                        id="gelar" name="gelar" value="{{ old('gelar') }}">
                                </div>
                                @error('gelar')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
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
                                    <option value="">Pilih Kartu Keluarga</option>

                                    @php
                                        $grouped = $kartuKeluargas->groupBy(
                                            fn($item) => $item->rayon->nama ?? 'Tanpa Rayon',
                                        );
                                    @endphp

                                    @foreach ($grouped as $rayon => $items)
                                        <optgroup label="{{ $rayon }}">
                                            @foreach ($items as $kk)
                                                <option value="{{ $kk->id }}"
                                                    {{ old('kartu_keluarga_id') == $kk->id ? 'selected' : '' }}>
                                                    {{ $kk->no_kk }} - {{ $kk->kepala_keluarga }}
                                                </option>
                                            @endforeach
                                        </optgroup>
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
                                <label for="status_pelayanan" class="form-label">Status Pelayanan <span
                                        class="text-danger">*</span></label>
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
                                <label for="tanggal_gabung" class="form-label">Tanggal Gabung</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-check-fill"></i></span>
                                    <input type="date"
                                        class="form-control @error('tanggal_gabung') is-invalid @enderror"
                                        id="tanggal_gabung" name="tanggal_gabung" value="{{ old('tanggal_gabung') }}">
                                </div>
                                @error('tanggal_gabung')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="status_keaktifan" class="form-label">Status Keaktifan <span
                                        class="text-danger">*</span></label>
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
                                <label for="tanggal_nonaktif" class="form-label">Tanggal Nonaktif</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-x-fill"></i></span>
                                    <input type="date"
                                        class="form-control @error('tanggal_nonaktif') is-invalid @enderror"
                                        id="tanggal_nonaktif" name="tanggal_nonaktif"
                                        value="{{ old('tanggal_nonaktif') }}">
                                </div>
                                @error('tanggal_nonaktif')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="status_baptis" class="form-label">Status Baptis <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('status_baptis') is-invalid @enderror"
                                    id="status_baptis" name="status_baptis" required>
                                    <option value="">Pilih Status</option>
                                    <option value="1" {{ old('status_baptis') == '1' ? 'selected' : '' }}>Sudah
                                    </option>
                                    <option value="0" {{ old('status_baptis') === '0' ? 'selected' : '' }}>Belum
                                    </option>
                                </select>
                                @error('status_baptis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="tanggal_baptis" class="form-label">Tanggal Baptis</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-droplet-fill"></i></span>
                                    <input type="date"
                                        class="form-control @error('tanggal_baptis') is-invalid @enderror"
                                        id="tanggal_baptis" name="tanggal_baptis" value="{{ old('tanggal_baptis') }}">
                                </div>
                                @error('tanggal_baptis')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- 🔹 5. KONTAK & FOTO --}}
                            <div class="col-md-6">
                                <label for="telepon" class="form-label">Nomor Telepon</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                    <input type="text" class="form-control @error('telepon') is-invalid @enderror"
                                        id="telepon" name="telepon" value="{{ old('telepon') }}">
                                </div>
                                @error('telepon')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
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

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusBaptis = document.getElementById('status_baptis');
            const tanggalBaptis = document.getElementById('tanggal_baptis');
            const statusKeaktifan = document.getElementById('status_keaktifan');
            const tanggalNonaktif = document.getElementById('tanggal_nonaktif');

            function toggleTanggalBaptis() {
                tanggalBaptis.disabled = statusBaptis.value != '1';
            }

            function toggleTanggalNonaktif() {
                tanggalNonaktif.disabled = statusKeaktifan.value === 'AKTIF';
            }

            statusBaptis.addEventListener('change', toggleTanggalBaptis);
            statusKeaktifan.addEventListener('change', toggleTanggalNonaktif);

            // Inisialisasi saat load
            toggleTanggalBaptis();
            toggleTanggalNonaktif();
        });
    </script>
@endsection
