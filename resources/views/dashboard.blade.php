@extends('layouts.layout')

@section('title', 'Dashboard')
@section('subtitle', 'Statistik dan analisis jemaat')

@section('content')
    <div class="row g-4">
        <!-- Cards -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-primary border-4">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 small text-primary">
                            <i class="fas fa-user-tie me-2"></i>Kepala Keluarga
                        </h5>
                        <span class="badge bg-primary-light text-primary">+{{ $growthKK ?? 5 }}%</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-value">{{ number_format($totalKepalaKeluarga ?? 0) }}</div>
                    <div class="card-detail small">Total Kepala Keluarga</div>
                </div>
            </div>
        </div>

        <!-- Card Jumlah Jemaat -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-success border-4">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 small text-success">
                            <i class="fas fa-users me-2"></i>Jumlah Jemaat
                        </h5>
                        <span class="badge bg-success-light text-success">+{{ $growthJemaat ?? 12 }}%</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-value">{{ number_format($totalJemaat) }}</div>
                    <div class="card-detail small">Total Anggota Jemaat</div>
                </div>
            </div>
        </div>

        <!-- Card Majelis -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-info border-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0 small text-info">
                        <i class="fas fa-users-cog me-2"></i>Majelis
                    </h5>
                </div>
                <div class="card-body">
                    <div class="card-value">{{ number_format($totalMajelis ?? 0) }}</div>
                    <div class="card-detail small">Anggota Majelis Aktif</div>
                    @if ($majelisUlangTahunCount ?? 0 > 0)
                        <div class="mt-2 text-info small">
                            <i class="fas fa-birthday-cake"></i>
                            {{ $majelisUlangTahunCount }} ulang tahun bulan ini
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Card Ulang Tahun Pernikahan -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-danger border-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0 small text-danger">
                        <i class="fas fa-ring me-2"></i>Ulang Tahun Pernikahan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="card-value">{{ number_format($ulangTahunPernikahanBulanIniCount ?? 0) }}</div>
                    <div class="card-detail small">Bulan {{ \Carbon\Carbon::now()->translatedFormat('F') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Ulang Tahun Pribadi -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start border-danger border-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0 small text-danger">
                    <i class="fas fa-birthday-cake"></i> Ulang Tahun Pribadi
                </h5>
            </div>
            <div class="card-body">
                <div class="card-value">{{ number_format($ulangTahunBulanIni ?? 0) }}</div>
                <div class="card-detail small">
                    <div class="card-detail small">
                        Bulan {{ \Carbon\Carbon::now()->translatedFormat('F') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Recent Members Table -->
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
                                        class="badge bg-{{ $jemaat->status_kk === 'KEPALA_KELUARGA' ? 'primary' : 'secondary' }}">
                                        {{ $jemaat->status_kk_label }}
                                    </span>
                                </td>
                                <td>{{ $jemaat->kartuKeluarga->rayon->nama ?? '-' }}</td>
                                <td>{{ $jemaat->tanggal_gabung ? $jemaat->tanggal_gabung->translatedFormat('d M Y') : '-' }}</td>
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
            .border-primary-light {
                border-color: #e3f2fd !important;
            }

            .border-success-light {
                border-color: #e8f5e9 !important;
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

            .bg-danger-light {
                background-color: #fde8e8;
            }

            .card-value {
                font-size: 1.75rem;
                font-weight: 600;
                line-height: 1.2;
            }

            .card-detail {
                color: #6c757d;
                font-size: 0.875rem;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            //Masih pengembangan dan bisa digunakan apabila perlu
            // document.addEventListener('DOMContentLoaded', function() {
            //     // Growth Chart
            //     const growthCtx = document.getElementById('growthChart').getContext('2d');
            //     new Chart(growthCtx, {
            //         type: 'line',
            //         data: {
            //             labels: @json($monthLabels ?? 0),
            //             datasets: [{
            //                 label: 'Jumlah Jemaat',
            //                 data: @json($jemaatGrowthData ?? 0),
            //                 borderColor: 'rgba(78, 84, 200, 1)',
            //                 backgroundColor: 'rgba(78, 84, 200, 0.1)',
            //                 borderWidth: 2,
            //                 tension: 0.4,
            //                 fill: true
            //             }]
            //         },
            //         options: {
            //             responsive: true,
            //             maintainAspectRatio: false,
            //             plugins: {
            //                 legend: {
            //                     display: false
            //                 },
            //                 tooltip: {
            //                     callbacks: {
            //                         label: function(context) {
            //                             return `Jemaat: ${context.raw}`;
            //                         }
            //                     }
            //                 }
            //             },
            //             scales: {
            //                 y: {
            //                     beginAtZero: true,
            //                     ticks: {
            //                         precision: 0
            //                     }
            //                 }
            //             }
            //         }
            //     });

            // Rayon Chart
            const rayonCtx = document.getElementById('rayonChart').getContext('2d');
            new Chart(rayonCtx, {
            type: 'doughnut',
            data: {
                labels: @json($rayonLabels ?? 0),
                datasets: [{
                    data: @json($rayonData ?? 0),
                    backgroundColor: [
                        'rgba(78, 84, 200, 0.8)',
                        'rgba(143, 148, 251, 0.8)',
                        'rgba(246, 201, 14, 0.8)',
                        'rgba(40, 167, 69, 0.8)',
                        'rgba(220, 53, 69, 0.8)',
                        'rgba(253, 126, 20, 0.8)'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
            });
            });
        </script>
    @endpush
@endsection
