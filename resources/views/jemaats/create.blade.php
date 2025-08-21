@extends('layouts.layout')

@section('title', isset($jemaat) ? 'Edit Jemaat' : 'Tambah Jemaat')

@section('content')
    <div class="row">

        @php
            $lastKk = session('last_kk');
            $kkId = old('kartu_keluarga_id', $lastKk['id'] ?? ($jemaat->kartu_keluarga_id ?? ''));
            $kkDisplay = old(
                'kartu_keluarga_display',
                $lastKk
                    ? $lastKk['no_kk'] . ' - ' . $lastKk['kepala_keluarga']
                    : (isset($jemaat->kartuKeluarga)
                        ? $jemaat->kartuKeluarga->no_kk . ' - ' . $jemaat->kartuKeluarga->kepala_keluarga
                        : ''),
            );
            $defaultNama = old('nama', $jemaat->nama ?? ($lastKk['kepala_keluarga'] ?? ''));
            $defaultStatusKk = old('status_kk', $jemaat->status_kk ?? ($lastKk ? 'KEPALA_KELUARGA' : ''));
        @endphp


        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ isset($jemaat) ? 'Edit Data Jemaat' : 'Tambah Jemaat Baru' }}</h5>
                </div>
                <div class="card-body">
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

                    <form action="{{ isset($jemaat) ? route('jemaats.update', $jemaat->id) : route('jemaats.store') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @if (isset($jemaat))
                            @method('PUT')
                        @endif
                        <div class="row g-3">
                            {{-- 🔹 INFORMASI PRIBADI --}}
                            <div class="col-md-6">
                                <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-list"></i></span>
                                    <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                        id="nik" name="nik" value="{{ old('nik', $jemaat->nik ?? '') }}" required>
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
                                        id="nama" name="nama" value="{{ $defaultNama }}" required>
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
                                        id="tanggal_lahir" name="tanggal_lahir"
                                        value="{{ old('tanggal_lahir', optional($jemaat->tanggal_lahir ?? null)->format('Y-m-d')) }}"
                                        required>
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
                                    <option value="L"
                                        {{ old('gender', $jemaat->gender ?? '') == 'L' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="P"
                                        {{ old('gender', $jemaat->gender ?? '') == 'P' ? 'selected' : '' }}>
                                        Perempuan</option>
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
                                        id="pekerjaan" name="pekerjaan"
                                        value="{{ old('pekerjaan', $jemaat->pekerjaan ?? '') }}">
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
                                            {{ old('status_kawin', $jemaat->status_kawin ?? '') == $value ? 'selected' : '' }}>
                                            {{ $label }}</option>
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
                                                {{ old('pendidikan', $jemaat->pendidikan ?? '') == $value ? 'selected' : '' }}>
                                                {{ $label }}</option>
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
                                        id="gelar" name="gelar" value="{{ old('gelar', $jemaat->gelar ?? '') }}">
                                </div>
                                @error('gelar')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="px-2 mt-3 mb-2">
                                <hr />
                            </div>

                            {{-- 🔹 DATA KELUARGA --}}
                            <div class="col-md-6">
                                {{-- Input yang akan menampilkan nama kepala keluarga yang dipilih --}}
                                <label for="kartu_keluarga" class="form-label">Kartu Keluarga</label>
                                <div class="input-group">
                                    @php
                                        $lastKk = session('last_kk');
                                        $kkId = old('kartu_keluarga_id', $lastKk['id'] ?? '');
                                        $kkDisplay = old(
                                            'kartu_keluarga_display',
                                            $lastKk ? $lastKk['no_kk'] . ' - ' . $lastKk['kepala_keluarga'] : '',
                                        );
                                    @endphp
                                    <input type="text" id="kartu_keluarga_display" class="form-control" readonly
                                        placeholder="Pilih Kartu Keluarga" value="{{ $kkDisplay }}">
                                    <input type="hidden" name="kartu_keluarga_id" id="kartu_keluarga_id"
                                        value="{{ $kkId }}">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#kkModal">Pilih</button>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="status_kk" class="form-label">Status dalam KK <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('status_kk') is-invalid @enderror" id="status_kk"
                                    name="status_kk" required>
                                    <option value="">Pilih Status</option>
                                    @foreach (\App\Models\Jemaat::STATUS_KK as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ $defaultStatusKk === $value ? 'selected' : '' }}
                                            @if ($value === 'ANAK') data-is-anak="true" @endif>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status_kk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <div class="form-check form-switch mb-2" id="married_switch_container">
                                    <input class="form-check-input" type="checkbox" id="is_menikah" name="is_menikah"
                                        {{ old('is_menikah', $jemaat->is_menikah ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_menikah">Sudah Menikah</label>
                                </div>

                                <div id="tanggal_pernikahan_container">
                                    <label for="tanggal_pernikahan" class="form-label">Tanggal Pernikahan</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-heart-fill"></i></span>
                                        <input type="date"
                                            class="form-control @error('tanggal_pernikahan') is-invalid @enderror"
                                            id="tanggal_pernikahan" name="tanggal_pernikahan"
                                            value="{{ old('tanggal_pernikahan', optional($jemaat->tanggal_pernikahan ?? null)->format('Y-m-d')) }}">
                                    </div>
                                    @error('tanggal_pernikahan')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="px-2 mt-3 mb-2">
                                <hr />
                            </div>

                            {{-- 🔹 STATUS GEREJAWI --}}
                            <div class="col-md-6">
                                <label for="status_pelayanan" class="form-label">Status Pelayanan <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('status_pelayanan') is-invalid @enderror"
                                    id="status_pelayanan" name="status_pelayanan" required>
                                    <option value="">Pilih Status</option>
                                    @foreach (\App\Models\Jemaat::STATUS_PELAYANAN as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ old('status_pelayanan', $jemaat->status_pelayanan ?? '') == $value ? 'selected' : '' }}>
                                            {{ $label }}</option>
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
                                        id="tanggal_gabung" name="tanggal_gabung"
                                        value="{{ old('tanggal_gabung', optional($jemaat->tanggal_gabung ?? null)->format('Y-m-d')) }}">
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
                                            {{ old('status_keaktifan', $jemaat->status_keaktifan ?? '') == $value ? 'selected' : '' }}>
                                            {{ $label }}</option>
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
                                        value="{{ old('tanggal_nonaktif', optional($jemaat->tanggal_nonaktif ?? null)->format('Y-m-d')) }}">
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
                                    <option value="1"
                                        {{ old('status_baptis', $jemaat->status_baptis ?? '') == '1' ? 'selected' : '' }}>
                                        Sudah
                                    </option>
                                    <option value="0"
                                        {{ old('status_baptis', $jemaat->status_baptis ?? '') == '0' ? 'selected' : '' }}>
                                        Belum
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
                                        id="tanggal_baptis" name="tanggal_baptis"
                                        value="{{ old('tanggal_baptis', optional($jemaat->tanggal_baptis ?? null)->format('Y-m-d')) }}">
                                </div>
                                @error('tanggal_baptis')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="px-2 mt-3 mb-2">
                                <hr />
                            </div>

                            {{-- 🔹 KONTAK & FOTO --}}
                            <div class="col-md-6">
                                <label for="telepon" class="form-label">Nomor Telepon</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                    <input type="text" class="form-control @error('telepon') is-invalid @enderror"
                                        id="telepon" name="telepon"
                                        value="{{ old('telepon', $jemaat->telepon ?? '') }}">
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
                                @if (isset($jemaat) && $jemaat->foto)
                                    <small class="text-muted d-block mt-1">Foto saat ini: {{ $jemaat->foto }}</small>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('jemaats.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit"
                                class="btn btn-primary">{{ isset($jemaat) ? 'Update' : 'Simpan' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="kkModal" tabindex="-1" aria-labelledby="kkModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="kkModalLabel">Cari Kartu Keluarga</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="searchKK" class="form-control mb-3"
                            placeholder="Cari No. KK atau Kepala Keluarga...">
                        <div id="kk-list">
                            {{-- Data KK akan dimuat di sini menggunakan AJAX --}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Logika untuk status baptis dan keaktifan
            const statusBaptis = document.getElementById('status_baptis');
            const tanggalBaptis = document.getElementById('tanggal_baptis');
            const statusKeaktifan = document.getElementById('status_keaktifan');
            const tanggalNonaktif = document.getElementById('tanggal_nonaktif');

            function toggleTanggalBaptis() {
                tanggalBaptis.disabled = statusBaptis.value !== '1';
                if (tanggalBaptis.disabled) {
                    tanggalBaptis.value = '';
                }
            }

            function toggleTanggalNonaktif() {
                tanggalNonaktif.disabled = statusKeaktifan.value === 'AKTIF';
                if (tanggalNonaktif.disabled) {
                    tanggalNonaktif.value = '';
                }
            }

            statusBaptis.addEventListener('change', toggleTanggalBaptis);
            statusKeaktifan.addEventListener('change', toggleTanggalNonaktif);

            // Inisialisasi saat load
            toggleTanggalBaptis();
            toggleTanggalNonaktif();

            // Logika untuk status pernikahan
            const statusKkSelect = document.getElementById('status_kk');
            const isMenikahCheckbox = document.getElementById('is_menikah');
            const tanggalPernikahanContainer = document.getElementById('tanggal_pernikahan_container');
            const marriedSwitchContainer = document.getElementById('married_switch_container');
            const kartuKeluargaSelect = document.getElementById('kartu_keluarga_id');
            const tanggalPernikahanInput = document.getElementById('tanggal_pernikahan');

            function updateMarriageFields() {
                const statusKkValue = statusKkSelect.value;
                const isMarriedStatus = ['KEPALA_KELUARGA', 'SUAMI', 'ISTRI'].includes(statusKkValue);
                const isUnmarriedStatus = ['ANAK', 'CUCU', 'LAINNYA'].includes(statusKkValue);

                // Reset fields
                isMenikahCheckbox.checked = false;
                tanggalPernikahanInput.value = '';

                if (isMarriedStatus) {
                    // Scenario 1: KEPALA, SUAMI, ISTRI
                    marriedSwitchContainer.style.display = 'block';
                    isMenikahCheckbox.checked = true;
                    tanggalPernikahanContainer.style.display = 'block';

                    // Auto-fill marriage date from family card if selected
                    if (kartuKeluargaSelect) {
                        const selectedKK = kartuKeluargaSelect.options[kartuKeluargaSelect.selectedIndex];
                        const marriageDate = selectedKK.dataset.tanggalPernikahan;
                        if (marriageDate) {
                            tanggalPernikahanInput.value = marriageDate;
                        }
                    }
                } else if (isUnmarriedStatus) {
                    // Scenario 2: ANAK, CUCU, LAINNYA
                    marriedSwitchContainer.style.display = 'block';
                    tanggalPernikahanContainer.style.display = isMenikahCheckbox.checked ? 'block' : 'none';
                } else {
                    // Default case, maybe for a new, unselected status
                    marriedSwitchContainer.style.display = 'block';
                    tanggalPernikahanContainer.style.display = isMenikahCheckbox.checked ? 'block' : 'none';
                }
            }

            function toggleTanggalPernikahanVisibility() {
                tanggalPernikahanContainer.style.display = isMenikahCheckbox.checked ? 'block' : 'none';
                if (!isMenikahCheckbox.checked) {
                    tanggalPernikahanInput.value = '';
                }
            }

            // Initial setup on page load
            updateMarriageFields();

            // Event listeners
            statusKkSelect.addEventListener('change', updateMarriageFields);
            isMenikahCheckbox.addEventListener('change', toggleTanggalPernikahanVisibility);

            // This listener is important for 'KEPALA' and 'ISTRI' status
            if (kartuKeluargaSelect) {
                kartuKeluargaSelect.addEventListener('change', updateMarriageFields);
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchKK');
            const kkList = document.getElementById('kk-list');
            let page = 1;

            function fetchKK(query = '', page = 1) {
                fetch(`/jemaats/search-kk?search=${query}&page=${page}`)
                    .then(response => response.json())
                    .then(data => {
                        kkList.innerHTML = ''; // Kosongkan daftar sebelumnya
                        let tableHtml =
                            '<table class="table table-hover"><thead><tr><th>No. KK</th><th>Kepala Keluarga</th><th>Rayon</th><th>Aksi</th></tr></thead><tbody>';
                        data.data.forEach(kk => {
                            tableHtml += `
                        <tr>
                            <td>${kk.no_kk}</td>
                            <td>${kk.kepala_keluarga}</td>
                            <td>${kk.rayon ? kk.rayon.nama : 'Tanpa Rayon'}</td>
                            <td><button type="button" class="btn btn-sm btn-success btn-select-kk" data-id="${kk.id}" data-no-kk="${kk.no_kk}" data-kepala-keluarga="${kk.kepala_keluarga}">Pilih</button></td>
                        </tr>
                    `;
                        });
                        tableHtml += '</tbody></table>';

                        // Tambahkan paginasi
                        let paginationHtml = '<nav><ul class="pagination">';
                        if (data.prev_page_url) {
                            paginationHtml +=
                                `<li class="page-item"><a class="page-link" href="#" data-page="${page - 1}">Previous</a></li>`;
                        }
                        data.links.forEach(link => {
                            paginationHtml +=
                                `<li class="page-item ${link.active ? 'active' : ''}"><a class="page-link" href="#" data-page="${link.label}">${link.label}</a></li>`;
                        });
                        if (data.next_page_url) {
                            paginationHtml +=
                                `<li class="page-item"><a class="page-link" href="#" data-page="${page + 1}">Next</a></li>`;
                        }
                        paginationHtml += '</ul></nav>';

                        kkList.innerHTML = tableHtml + paginationHtml;

                        // Tambahkan event listener untuk tombol "Pilih"
                        document.querySelectorAll('.btn-select-kk').forEach(button => {
                            button.addEventListener('click', function() {
                                const kkId = this.getAttribute('data-id');
                                const kkText = this.getAttribute('data-no-kk') + ' - ' + this
                                    .getAttribute('data-kepala-keluarga');
                                document.getElementById('kartu_keluarga_id').value = kkId;
                                document.getElementById('kartu_keluarga_display').value =
                                    kkText;
                                const kkModal = bootstrap.Modal.getInstance(document
                                    .getElementById('kkModal'));
                                kkModal.hide();
                            });
                        });

                        // Tambahkan event listener untuk paginasi
                        document.querySelectorAll('#kk-list .page-link').forEach(link => {
                            link.addEventListener('click', function(e) {
                                e.preventDefault();
                                const newPage = this.getAttribute('data-page');
                                if (!isNaN(newPage)) {
                                    page = parseInt(newPage);
                                } else if (newPage === 'Previous' && data.prev_page_url) {
                                    page = data.current_page - 1;
                                } else if (newPage === 'Next' && data.next_page_url) {
                                    page = data.current_page + 1;
                                }
                                fetchKK(searchInput.value, page);
                            });
                        });
                    });
            }

            // Panggil saat modal dibuka
            const kkModalElement = document.getElementById('kkModal');
            kkModalElement.addEventListener('show.bs.modal', function() {
                fetchKK();
            });

            // Panggil saat user mengetik di kotak pencarian
            searchInput.addEventListener('input', function() {
                page = 1; // Reset ke halaman 1 setiap kali pencarian baru
                fetchKK(this.value);
            });
        });
    </script>
@endsection
