@extends('layouts.layout')

@section('title', 'Edit Kartu Keluarga')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Edit Kartu Keluarga</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('kartu-keluarga.update', $kartuKeluarga->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">

                    {{-- Rayon --}}
                    <div class="col-md-12 mb-3">
                        <label for="rayon_id" class="form-label">Rayon *</label>
                        <select name="rayon_id" id="rayon_id" class="form-select @error('rayon_id') is-invalid @enderror"
                            required>
                            <option value="">-- Pilih Rayon --</option>
                            @foreach ($rayons as $rayon)
                                <option value="{{ $rayon->id }}"
                                    {{ old('rayon_id', $kartuKeluarga->rayon_id) == $rayon->id ? 'selected' : '' }}>
                                    {{ $rayon->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('rayon_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- No KK --}}
                    <div class="col-md-6 mb-3">
                        <label for="no_kk" class="form-label">Nomor KK *</label>
                        <input type="text" name="no_kk" id="no_kk"
                            class="form-control @error('no_kk') is-invalid @enderror"
                            value="{{ old('no_kk', $kartuKeluarga->no_kk) }}" maxlength="20" required>
                        @error('no_kk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kepala Keluarga --}}
                    <div class="col-md-6 mb-3">
                        <label for="kepala_keluarga" class="form-label">Kepala Keluarga *</label>
                        <input type="text" name="kepala_keluarga" id="kepala_keluarga"
                            class="form-control @error('kepala_keluarga') is-invalid @enderror"
                            value="{{ old('kepala_keluarga', $kartuKeluarga->kepala_keluarga) }}" maxlength="100" required>
                        @error('kepala_keluarga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Provinsi --}}
                    <div class="col-md-6 mb-3">
                        <label for="provinsi_id" class="form-label">Provinsi</label>
                        <select id="provinsi_id" name="provinsi_id"
                            class="form-select @error('provinsi_id') is-invalid @enderror">
                            <option value="">-- Pilih Provinsi --</option>
                            @foreach ($provinces as $prov)
                                <option value="{{ $prov->id }}"
                                    {{ old('provinsi_id', $kartuKeluarga->provinsi_id) == $prov->id ? 'selected' : '' }}>
                                    {{ $prov->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('provinsi_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kabupaten --}}
                    <div class="col-md-6 mb-3">
                        <label for="kota_id" class="form-label">Kabupaten/Kota</label>
                        <select id="kota_id" name="kota_id" class="form-select @error('kota_id') is-invalid @enderror">
                            <option value="">-- Pilih Kabupaten/Kota --</option>
                        </select>
                        @error('kota_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kecamatan --}}
                    <div class="col-md-6 mb-3">
                        <label for="kecamatan_id" class="form-label">Kecamatan</label>
                        <select id="kecamatan_id" name="kecamatan_id"
                            class="form-select @error('kecamatan_id') is-invalid @enderror">
                            <option value="">-- Pilih Kecamatan --</option>
                        </select>
                        @error('kecamatan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kelurahan --}}
                    <div class="col-md-6 mb-3">
                        <label for="kelurahan_id" class="form-label">Kelurahan/Desa</label>
                        <select id="kelurahan_id" name="kelurahan_id"
                            class="form-select @error('kelurahan_id') is-invalid @enderror">
                            <option value="">-- Pilih Kelurahan/Desa --</option>
                        </select>
                        @error('kelurahan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="kodepos_id" class="form-label">Kode POS</label>
                            <input type="number" name="kodepos_id" id="kodepos_id"
                                class="form-control @error('kodepos_id') is-invalid @enderror"
                                value="{{ old('kodepos_id', $kartuKeluarga->kodepos_id) }}">
                            @error('kodepos_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- RT & RW --}}
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="alamat_rt" class="form-label">RT</label>
                            <input type="number" name="alamat_rt" id="alamat_rt"
                                class="form-control @error('alamat_rt') is-invalid @enderror"
                                value="{{ old('alamat_rt', $kartuKeluarga->alamat_rt) }}" min="1" max="9999">
                            @error('alamat_rt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="alamat_rw" class="form-label">RW</label>
                            <input type="number" name="alamat_rw" id="alamat_rw"
                                class="form-control @error('alamat_rw') is-invalid @enderror"
                                value="{{ old('alamat_rw', $kartuKeluarga->alamat_rw) }}" min="1" max="9999">
                            @error('alamat_rw')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        {{-- Alamat Lengkap --}}
                        <div class="mb-3">
                            <label for="alamat_lengkap" class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat_lengkap" id="alamat_lengkap"
                                class="form-control @error('alamat_lengkap') is-invalid @enderror" rows="2">{{ old('alamat_lengkap', $kartuKeluarga->alamat_lengkap) }}</textarea>
                            @error('alamat_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Tanggal Pernikahan --}}
                    {{-- <div class="col-md-6">
                        <label for="tanggal_pernikahan" class="form-label">Tanggal Pernikahan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-ring"></i></span>
                            <input type="date" class="form-control @error('tanggal_pernikahan') is-invalid @enderror"
                                id="tanggal_pernikahan" name="tanggal_pernikahan"
                                value="{{ old('tanggal_pernikahan', $kartuKeluarga->tanggal_pernikahan ? \Carbon\Carbon::parse($kartuKeluarga->tanggal_pernikahan)->format('Y-m-d') : '') }}">
                        </div>
                        @error('tanggal_pernikahan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div> --}}

                    {{-- Buttons --}}
                    <div class="mt-4 d-flex justify-content-between">
                        <a href="{{ route('kartu-keluarga.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Perubahan
                        </button>
                    </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const prov = document.getElementById('provinsi_id'),
                kota = document.getElementById('kota_id'),
                kec = document.getElementById('kecamatan_id'),
                kel = document.getElementById('kelurahan_id');

            const selected = {
                kota_id: '{{ old('kota_id', $kartuKeluarga->kota_id) }}',
                kecamatan_id: '{{ old('kecamatan_id', $kartuKeluarga->kecamatan_id) }}',
                kelurahan_id: '{{ old('kelurahan_id', $kartuKeluarga->kelurahan_id) }}',
            };

            function fetchItems(level, parentId, targetSelect, selectedId = null) {
                fetch(`/api/${level}/${parentId}`)
                    .then(res => res.json())
                    .then(data => {
                        targetSelect.innerHTML =
                            `<option value="">-- Pilih ${targetSelect.previousElementSibling.innerText} --</option>`;
                        data.forEach(item => {
                            const selectedAttr = item.id == selectedId ? 'selected' : '';
                            targetSelect.innerHTML +=
                                `<option value="${item.id}" ${selectedAttr}>${item.name}</option>`;
                        });
                        targetSelect.disabled = false;
                    });
            }

            if (prov.value) {
                fetchItems('regencies', prov.value, kota, selected.kota_id);
            }
            if (selected.kota_id) {
                fetchItems('districts', selected.kota_id, kec, selected.kecamatan_id);
            }
            if (selected.kecamatan_id) {
                fetchItems('villages', selected.kecamatan_id, kel, selected.kelurahan_id);
            }

            prov.addEventListener('change', () => {
                kota.innerHTML = `<option value="">-- Pilih Kabupaten/Kota --</option>`;
                kec.innerHTML = `<option value="">-- Pilih Kecamatan --</option>`;
                kel.innerHTML = `<option value="">-- Pilih Kelurahan/Desa --</option>`;
                kota.disabled = kec.disabled = kel.disabled = true;

                if (prov.value) fetchItems('regencies', prov.value, kota);
            });

            kota.addEventListener('change', () => {
                kec.innerHTML = `<option value="">-- Pilih Kecamatan --</option>`;
                kel.innerHTML = `<option value="">-- Pilih Kelurahan/Desa --</option>`;
                kec.disabled = kel.disabled = true;

                if (kota.value) fetchItems('districts', kota.value, kec);
            });

            kec.addEventListener('change', () => {
                kel.innerHTML = `<option value="">-- Pilih Kelurahan/Desa --</option>`;
                kel.disabled = true;

                if (kec.value) fetchItems('villages', kec.value, kel);
            });
        });
    </script>
@endpush
