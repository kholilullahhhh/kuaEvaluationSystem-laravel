@extends('layouts.app', ['title' => 'Admin Dashboard'])

@section('content')
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.28.3/dist/apexcharts.min.css">
        <style>
            :root {
                --primary: #4361ee;
                --primary-light: #eef2ff;
                --secondary: #3f37c9;
                --success: #28a745;
                --warning: #ffc107;
                --danger: #dc3545;
                --info: #17a2b8;
                --dark: #343a40;
                --light: #f8f9fa;
            }

            .dashboard-card {
                border: none;
                border-radius: 0.75rem;
                box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.05);
                transition: all 0.3s ease;
                overflow: hidden;
                background-color: white;
            }

            .dashboard-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
            }

            .card-icon {
                width: 60px;
                height: 60px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.75rem;
                color: white;
                margin-right: 1rem;
            }

            .card-value {
                font-size: 1.75rem;
                font-weight: 700;
                line-height: 1.2;
                color: var(--dark);
            }

            .card-label {
                font-size: 0.875rem;
                color: #6c757d;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .chart-container {
                position: relative;
                height: 300px;
            }

            .status-badge {
                padding: 0.35rem 0.75rem;
                border-radius: 50rem;
                font-size: 0.75rem;
                font-weight: 600;
                letter-spacing: 0.5px;
            }

            .bg-hadir {
                background-color: rgba(40, 167, 69, 0.1);
                color: var(--success);
            }

            .bg-tidak_hadir {
                background-color: rgba(220, 53, 69, 0.1);
                color: var(--danger);
            }

            .bg-izin {
                background-color: rgba(23, 162, 184, 0.1);
                color: var(--info);
            }

            .bg-sakit {
                background-color: rgba(108, 117, 125, 0.1);
                color: #6c757d;
            }

            .bg-terlambat {
                background-color: rgba(255, 193, 7, 0.1);
                color: var(--warning);
            }

            .recent-list {
                max-height: 350px;
                overflow-y: auto;
            }

            .recent-list::-webkit-scrollbar {
                width: 6px;
            }

            .recent-list::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 10px;
            }

            .recent-list::-webkit-scrollbar-thumb {
                background: #c1c1c1;
                border-radius: 10px;
            }

            .recent-list::-webkit-scrollbar-thumb:hover {
                background: #a8a8a8;
            }

            .recent-item {
                transition: all 0.3s ease;
                border-left: 4px solid transparent;
            }

            .recent-item:hover {
                transform: translateX(5px);
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.05);
            }

            .section-header {
                padding: 20px 0;
                border-bottom: 1px solid rgba(0, 0, 0, 0.05);
                margin-bottom: 30px;
            }

            .avatar-sm {
                width: 36px;
                height: 36px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                background-color: #e9ecef;
                color: #495057;
                font-weight: 600;
            }

            .progress-thin {
                height: 8px;
                border-radius: 4px;
            }
        </style>
    @endpush

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>
                        <p class="mb-0 text-muted">Ringkasan aktivitas sistem</p>
                    </div>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><i class="bi bi-house-door"></i> Dashboard</div>
                    </div>
                </div>
            </div>

            <!-- Summary Cards Row -->

            <div class="row mb-4">
                <!-- User Statistics -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="dashboard-card card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="card-icon"
                                    style="background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div>
                                    <div class="card-label">Total Pengguna</div>
                                    <div class="card-value">{{ $totalUsers }}</div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="d-flex justify-content-between small text-muted mb-1">
                                    <span>Admin</span>
                                    <span>{{ $adminCount }}</span>
                                </div>
                                <div class="d-flex justify-content-between small text-muted mb-1">
                                    <span>Kepala KUA</span>
                                    <span>{{ $kepalaKuaCount }}</span>
                                </div>
                                <div class="d-flex justify-content-between small text-muted">
                                    <span>Pegawai</span>
                                    <span>{{ $pegawaiCount }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Agenda Statistics -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="dashboard-card card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="card-icon"
                                    style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                                    <i class="bi bi-calendar-event"></i>
                                </div>
                                <div>
                                    <div class="card-label">Total Agenda</div>
                                    <div class="card-value">{{ $totalAgendas }}</div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="progress progress-thin mb-2">
                                    <div class="progress-bar bg-success"
                                        style="width: {{ $totalAgendas ? round(($agendasThisMonth / $totalAgendas) * 100) : 0 }}%">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between small text-muted">
                                    <span>Agenda Bulan Ini</span>
                                    <span>{{ $agendasThisMonth }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attendance Statistics -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="dashboard-card card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="card-icon"
                                    style="background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);">
                                    <i class="bi bi-clipboard-check"></i>
                                </div>
                                <div>
                                    <div class="card-label">Total Absensi</div>
                                    <div class="card-value">{{ $totalAttendances }}</div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="d-flex justify-content-between small text-muted mb-1">
                                    <span>Hadir</span>
                                    <span>{{ $hadirCount }}</span>
                                </div>
                                <div class="d-flex justify-content-between small text-muted mb-1">
                                    <span>Tidak Hadir</span>
                                    <span>{{ $tidakHadirCount }}</span>
                                </div>
                                <div class="d-flex justify-content-between small text-muted">
                                    <span>Izin</span>
                                    <span>{{ $izinCount }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Performance Statistics -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="dashboard-card card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="card-icon"
                                    style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
                                    <i class="bi bi-graph-up"></i>
                                </div>
                                <div>
                                    <div class="card-label">Penilaian Kinerja</div>
                                    <div class="card-value">{{ $totalAssessments }}</div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="text-center mb-2">
                                    <span class="h4 font-weight-bold">{{ $averageScore }}</span>
                                    <span class="text-muted small">/ 4.0</span>
                                </div>
                                <div class="progress progress-thin">
                                    <div class="progress-bar bg-warning" style="width: {{ ($averageScore / 4) * 100 }}%"></div>
                                </div>
                                <div class="text-center small text-muted mt-1">Rata-rata Skor</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row mb-4">
                <!-- Monthly Attendance Chart -->
                <div class="col-lg-8 mb-4">
                    <div class="dashboard-card card h-100">
                        <div class="card-header d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Statistik Kehadiran Tahun {{ $selectedYear }}</h6>
                            <div class="d-flex">
                                <select id="yearSelect" class="form-control form-control-sm">
                                    @foreach(range(date('Y') - 2, date('Y')) as $year)
                                        <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <div id="attendanceChart"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attendance Distribution -->
                <div class="col-lg-4 mb-4">
                    <div class="dashboard-card card h-100">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">Distribusi Kehadiran</h6>
                        </div>
                        <div class="card-body">
                            <div id="attendanceDistributionChart"></div>
                            <div class="mt-3 text-center small">
                                <span class="mr-2"><i class="fas fa-circle text-success"></i> Hadir</span>
                                <span class="mr-2"><i class="fas fa-circle text-danger"></i> Tidak Hadir</span>
                                <span class="mr-2"><i class="fas fa-circle text-info"></i> Izin</span>
                                <span class="mr-2"><i class="fas fa-circle text-secondary"></i> Sakit</span>
                                <span><i class="fas fa-circle text-warning"></i> Terlambat</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities Row -->
            <div class="row">
                <!-- Recent Agendas -->
                <div class="col-lg-4 mb-4">
                    <div class="dashboard-card card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Agenda Terbaru</h6>
                            <a href="{{ route('agenda.index') }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-list-ul"></i> Lihat Semua
                            </a>
                        </div>
                        <div class="card-body recent-list">
                            @forelse($recentAgendas as $agenda)
                                <div class="recent-item mb-3 p-3 border rounded">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="font-weight-bold mb-0">{{ $agenda->judul }}</h6>
                                        <small
                                            class="text-muted">{{ \Carbon\Carbon::parse($agenda->tgl_kegiatan)->format('d M') }}</small>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <small class="text-muted"><i class="bi bi-clock"></i> {{ $agenda->jam_mulai }}</small>
                                        <small class="text-muted"><i class="bi bi-geo-alt"></i>
                                            {{ $agenda->tempat_kegiatan }}</small>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                                    <p class="mt-2">Belum ada agenda</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Recent Attendances -->
                <div class="col-lg-4 mb-4">
                    <div class="dashboard-card card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Absensi Terbaru</h6>
                            <a href="{{ route('absensi.index') }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-list-ul"></i> Lihat Semua
                            </a>
                        </div>
                        <div class="card-body recent-list">
                            @forelse($recentAttendances as $attendance)
                                <div
                                    class="recent-item mb-3 p-3 border rounded bg-{{ str_replace(' ', '_', $attendance->status) }}">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="d-flex align-items-center mb-1">
                                                <div class="avatar-sm mr-2">
                                                    {{ substr($attendance->user->name, 0, 1) }}
                                                </div>
                                                <h6 class="font-weight-bold mb-0">{{ $attendance->user->name }}</h6>
                                            </div>
                                            <small class="text-muted">
                                                {{ $attendance->agenda->judul }}
                                            </small>
                                        </div>
                                        <div class="text-right">
                                            <span class="status-badge bg-{{ str_replace(' ', '_', $attendance->status) }}">
                                                {{ ucfirst($attendance->status) }}
                                            </span>
                                            <div class="text-muted small mt-1">
                                                {{ \Carbon\Carbon::parse($attendance->created_at)->format('d M') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <i class="bi bi-clipboard-x text-muted" style="font-size: 3rem;"></i>
                                    <p class="mt-2">Belum ada absensi</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Recent Assessments -->
                <div class="col-lg-4 mb-4">
                    <div class="dashboard-card card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Penilaian Terbaru</h6>
                            <a href="{{ route('indikator_level.index') }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-list-ul"></i> Lihat Semua
                            </a>
                        </div>
                        <div class="card-body recent-list">
                            @forelse($recentAssessments as $assessment)
                                <div class="recent-item mb-3 p-3 border rounded">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge badge-warning">{{ $assessment->skor_akhir }}/4</span>
                                    </div>
                                    <div class="mb-2">
                                        <small class="text-muted">{{ $assessment->indicator->name }}</small>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <small class="text-muted">{{ $assessment->kategori }}</small>
                                        <small
                                            class="text-muted">{{ \Carbon\Carbon::parse($assessment->created_at)->format('d M') }}</small>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <i class="bi bi-clipboard-x text-muted" style="font-size: 3rem;"></i>
                                    <p class="mt-2">Belum ada penilaian</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.28.3/dist/apexcharts.min.js"></script>
        <script>
            // Monthly Attendance Chart
            var attendanceChart = new ApexCharts(document.querySelector("#attendanceChart"), {
                series: [
                    {
                        name: 'Hadir',
                        data: @json(array_column($monthlyAttendance, 'hadir'))
                    },
                    {
                        name: 'Tidak Hadir',
                        data: @json(array_column($monthlyAttendance, 'tidak_hadir'))
                    },
                    {
                        name: 'Izin',
                        data: @json(array_column($monthlyAttendance, 'izin'))
                    }
                ],
                chart: {
                    type: 'bar',
                    height: '100%',
                    stacked: true,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        borderRadius: 4,
                        columnWidth: '55%',
                    },
                },
                colors: ['#28a745', '#dc3545', '#17a2b8'],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                },
                yaxis: {
                    title: {
                        text: 'Jumlah Kehadiran'
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val + " orang"
                        }
                    }
                }
            });
            attendanceChart.render();

            // Attendance Distribution Chart
            var attendanceDistributionChart = new ApexCharts(document.querySelector("#attendanceDistributionChart"), {
                series: [{{ $hadirCount }}, {{ $tidakHadirCount }}, {{ $izinCount }}, {{ $sakitCount }}, {{ $terlambatCount }}],
                chart: {
                    type: 'donut',
                    height: 350
                },
                labels: ['Hadir', 'Tidak Hadir', 'Izin', 'Sakit', 'Terlambat'],
                colors: ['#28a745', '#dc3545', '#17a2b8', '#6c757d', '#ffc107'],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }],
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total',
                                    formatter: function (w) {
                                        return w.globals.seriesTotals.reduce((a, b) => {
                                            return a + b
                                        }, 0)
                                    }
                                }
                            }
                        }
                    }
                }
            });
            attendanceDistributionChart.render();

            // Handle year selection change
            $('#yearSelect').change(function () {
                const year = $(this).val();
                window.location.href = "{{ route('dashboard') }}?year=" + year;
            });
        </script>
    @endpush
@endsection