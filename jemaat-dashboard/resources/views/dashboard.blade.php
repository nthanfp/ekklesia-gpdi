@extends('layouts.layout')

@section('title', 'Dashboard')
@section('subtitle', 'Statistik dan analisis jemaat')

@section('content')
    <div class="row g-4">
        <!-- Card 1: Kepala Keluarga -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-primary border-4">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 text-primary">
                            <i class="fas fa-user-tie me-2"></i>Kepala Keluarga
                        </h5>
                        <span class="badge bg-primary-light text-primary">+{{ $growthKK ?? 5 }}%</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-value">{{ number_format($totalKepalaKeluarga ?? 0) }}</div>
                    <div class="card-detail">Total kepala keluarga</div>
                </div>
            </div>
        </div>

        <!-- Card 2: Jumlah Jemaat -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-success border-4">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 text-success">
                            <i class="fas fa-users me-2"></i>Jumlah Jemaat
                        </h5>
                        <span class="badge bg-success-light text-success">+{{ $growthJemaat ?? 12 }}%</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-value">{{ number_format($totalJemaat ?? 0) }}</div>
                    <div class="card-detail">Total anggota jemaat</div>
                </div>
            </div>
        </div>

        <!-- Card 3: Majelis -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-info border-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0 text-info">
                        <i class="fas fa-users-cog me-2"></i>Majelis
                    </h5>
                </div>
                <div class="card-body">
                    <div class="card-value">{{ number_format($totalMajelis ?? 0) }}</div>
                    <div class="card-detail">Anggota majelis aktif</div>
                    @if ($majelisUlangTahunCount ?? 0 > 0)
                        <div class="mt-2 text-info small">
                            <i class="fas fa-birthday-cake"></i>
                            {{ $majelisUlangTahunCount }} ulang tahun bulan ini
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Card 4: Ulang Tahun Lahir -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-warning border-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0 text-warning">
                        <i class="fas fa-birthday-cake me-2"></i>Ulang Tahun
                    </h5>
                </div>
                <div class="card-body">
                    <div class="card-value">{{ number_format($ulangTahunBulanIniCount ?? 0) }}</div>
                    <div class="card-detail">Jemaat berulang tahun bulan ini</div>
                </div>
            </div>
        </div>

        <!-- Card 5: Ulang Tahun Pernikahan -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-danger border-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0 text-danger">
                        <i class="fas fa-ring me-2"></i>Ulang Tahun Pernikahan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="card-value">{{ number_format($ulangTahunPernikahanCount ?? 0) }}</div>
                    <div class="card-detail">Pasangan berulang tahun pernikahan bulan ini</div>
                    @if ($ulangTahunPernikahanCount ?? 0 > 0)
                        <div class="mt-2 text-danger small">
                            <i class="fas fa-glass-cheers"></i>
                            {{ $ulangTahunPernikahanCount }} pasangan merayakan
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Jemaat Terbaru -->
    <div class="card mt-4">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list me-2"></i>Daftar Jemaat Terbaru
                </h5>
                <a href="{{ route('jemaats.index') }}" class="btn btn-sm btn-outline-primary">
                    Lihat Semua
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Rayon</th>
                            <th>Bergabung</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentJemaats as $jemaat)
                            <tr>
                                <td>{{ $jemaat->nama }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $jemaat->status_kk == 'KEPALA_KELUARGA' ? 'primary' : 'secondary' }}">
                                        {{ \App\Models\Jemaat::STATUS_KK[$jemaat->status_kk] ?? '-' }}
                                    </span>
                                </td>
                                <td>{{ $jemaat->kartuKeluarga?->rayon?->nama ?? '-' }}</td>
                                <td>{{ $jemaat->created_at->translatedFormat('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    <i class="fas fa-users-slash fa-2x mb-2"></i><br>
                                    Tidak ada data jemaat
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            /* Warna Card */
            .border-primary-light {
                border-color: #e3f2fd !important;
            }

            .border-success-light {
                border-color: #e8f5e9 !important;
            }

            .border-info-light {
                border-color: #e6f7ff !important;
            }

            .border-warning-light {
                border-color: #fff3cd !important;
            }

            .border-danger-light {
                border-color: #fde8e8 !important;
            }

            .bg-primary-light {
                background-color: #e3f2fd;
            }

            .bg-success-light {
                background-color: #e8f5e9;
            }

            .bg-info-light {
                background-color: #e6f7ff;
            }

            .bg-warning-light {
                background-color: #fff3cd;
            }

            .bg-danger-light {
                background-color: #fde8e8;
            }

            /* Animasi Hover */
            .card {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            }
        </style>
    @endpush

@endsection
