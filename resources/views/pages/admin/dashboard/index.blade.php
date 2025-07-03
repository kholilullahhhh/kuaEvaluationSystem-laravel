@extends('layouts.app', ['title' => 'SPP Payment Dashboard'])

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
                background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
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

            .floating-card {
                position: absolute;
                right: 20px;
                top: 20px;
                z-index: 10;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(5px);
                border-radius: 12px;
                padding: 0.75rem 1.25rem;
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
                border: 1px solid rgba(0,0,0,0.05);
            }

            .status-badge {
                padding: 0.35rem 0.75rem;
                border-radius: 50rem;
                font-size: 0.75rem;
                font-weight: 600;
                letter-spacing: 0.5px;
            }

            .bg-paid {
                background-color: rgba(40, 167, 69, 0.1);
                color: var(--success);
            }

            .bg-pending {
                background-color: rgba(255, 193, 7, 0.1);
                color: var(--warning);
            }

            .bg-overdue {
                background-color: rgba(220, 53, 69, 0.1);
                color: var(--danger);
            }

            .recent-payments::-webkit-scrollbar {
                width: 6px;
            }

            .recent-payments::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 10px;
            }

            .recent-payments::-webkit-scrollbar-thumb {
                background: #c1c1c1;
                border-radius: 10px;
            }

            .recent-payments::-webkit-scrollbar-thumb:hover {
                background: #a8a8a8;
            }

            .progress-thin {
                height: 8px;
                border-radius: 4px;
            }

            .payment-item {
                transition: all 0.3s ease;
                border-left: 4px solid transparent;
            }

            .payment-item:hover {
                transform: translateX(5px);
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.05);
            }

            .payment-item.bg-paid {
                border-left-color: var(--success);
            }

            .payment-item.bg-pending {
                border-left-color: var(--warning);
            }

            .payment-item.bg-overdue {
                border-left-color: var(--danger);
            }

            .section-header {
                padding: 20px 0;
                border-bottom: 1px solid rgba(0,0,0,0.05);
                margin-bottom: 30px;
            }

            .breadcrumb-item.active {
                color: var(--primary);
            }

            .dropdown-toggle::after {
                display: none;
            }

            .card-header {
                border-bottom: 1px solid rgba(0,0,0,0.05);
                background-color: transparent;
            }
        </style>
    @endpush

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">SPP Payment Dashboard</h1>
                        <p class="mb-0 text-muted">Ringkasan dan analisis pembayaran SPP</p>
                    </div>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><i class="bi bi-house-door"></i> Dashboard</div>
                    </div>
                </div>
            </div>

            @if (session('role') == 'admin')
                <!-- Summary Cards Row -->
                <div class="row mb-4">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="dashboard-card card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="card-icon">
                                        <i class="bi bi-cash-stack"></i>
                                    </div>
                                    <div>
                                        <div class="card-label">Total Pembayaran Bulan Ini</div>
                                        <div class="card-value">Rp {{ number_format($currentMonthPayments, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                                <div class="mt-3 text-right">
                                    <span class="text-success small"><i class="bi bi-arrow-up"></i> 12% dari bulan lalu</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="dashboard-card card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="card-icon" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                                        <i class="bi bi-check-circle"></i>
                                    </div>
                                    <div>
                                        <div class="card-label">Pembayaran Lunas</div>
                                        <div class="card-value">{{ $paidPayments }}</div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="progress progress-thin">


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="dashboard-card card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="card-icon" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
                                        <i class="bi bi-exclamation-triangle"></i>
                                    </div>
                                    <div>
                                        <div class="card-label">Pembayaran Tertunda</div>
                                        <div class="card-value">{{ $pendingPayments }}</div>
                                    </div>
                                </div>
                                <div class="mt-3 text-right">
                                    <a href="{{ route('payment.index') }}?status=pending" class="btn btn-sm btn-warning">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="dashboard-card card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="card-icon" style="background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);">
                                        <i class="bi bi-exclamation-octagon"></i>
                                    </div>
                                    <div>
                                        <div class="card-label">Pembayaran Belum Lunas</div>
                                        <div class="card-value">{{ $unpaidngPayments }}</div>
                                    </div>
                                </div>
                                <div class="mt-3 text-right">
                                    <a href="{{ route('payment.index') }}?status=unpaid" class="btn btn-sm btn-danger">Kirim Pengingat</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="row mb-4">
                    <!-- Payment Statistics Chart -->
                    <div class="col-lg-8 mb-4">
                        <div class="dashboard-card card h-100">
                            <div class="card-header d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Statistik Pembayaran SPP</h6>
                                <div class="d-flex">
                                    <select id="yearSelect" class="form-control form-control-sm mr-2">
                                        @foreach(range(date('Y') - 2, date('Y')) as $year)
                                            <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-sm btn-outline-primary" id="exportChartBtn">
                                        <i class="bi bi-download"></i> Export
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <div id="paymentChart"></div>
                                    <div class="floating-card">
                                        <div class="text-center">
                                            <div class="text-xs text-muted">Total Tahun Ini</div>
                                            <div class="h5 font-weight-bold">Rp {{ number_format($currentYearPayment, 0, ',', '.') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Status Pie Chart -->
                    <div class="col-lg-4 mb-4">
                        <div class="dashboard-card card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="m-0 font-weight-bold text-primary">Status Pembayaran</h6>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="statusFilter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Bulan Ini
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="statusFilter">
                                        <a class="dropdown-item" href="#" data-period="month">Bulan Ini</a>
                                        <a class="dropdown-item" href="#" data-period="year">Tahun Ini</a>
                                        <a class="dropdown-item" href="#" data-period="all">Semua</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="paymentStatusChart"></div>
                                <div class="mt-4 text-center small">
                                    <span class="mr-2">
                                        <i class="fas fa-circle text-success"></i> Lunas ({{ $paidPayments }}%)
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-circle text-warning"></i> Tertunda ({{ $pendingPayments }}%)
                                    </span>
                                    <span>
                                        <i class="fas fa-circle text-danger"></i> Belum Bayar ({{ $unpaidngPayments }}%)
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Tables Row -->
                <div class="row">
                    <!-- Recent Payments -->
                    <div class="col-lg-6 mb-4">
                        <div class="dashboard-card card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="m-0 font-weight-bold text-primary">Pembayaran Terbaru</h6>
                                <div>
                                    <a href="{{ route('payment.index') }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-list-ul"></i> Lihat Semua
                                    </a>
                                </div>
                            </div>
                            <div class="card-body recent-payments" style="max-height: 350px; overflow-y: auto;">
                                @forelse($recentPayments as $payment)
                                    <div class="payment-item mb-3 p-3 rounded bg-{{ $payment->status }}">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="d-flex align-items-center mb-1">
                                                    <div class="avatar-sm mr-2">
                                                        <span class="avatar-title rounded-circle bg-light text-dark">
                                                            {{ substr($payment->siswa->name, 0, 1) }}
                                                        </span>
                                                    </div>
                                                    <h6 class="font-weight-bold mb-0">{{ $payment->siswa->name }}</h6>
                                                </div>
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar"></i> {{ $payment->paid_month }} {{ $payment->paid_year }} • 
                                                    <i class="bi bi-cash"></i> Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                                </small>
                                            </div>
                                            <div class="text-right">
                                                <span class="status-badge bg-{{ $payment->status }}">
                                                    {{ ucfirst($payment->status) }}
                                                </span>
                                                <div class="text-muted small mt-1">
                                                    <i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($payment->paid_at)->format('d M Y') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-4">
                                        <i class="bi bi-receipt text-muted" style="font-size: 3rem;"></i>
                                        <p class="mt-2">Belum ada data pembayaran</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Class Payment Progress -->
                    <div class="col-lg-6 mb-4">
                        <div class="dashboard-card card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="m-0 font-weight-bold text-primary">Progress Pembayaran per Kelas</h6>
                                <button class="btn btn-sm btn-outline-primary" id="refreshProgress">
                                    <i class="bi bi-arrow-clockwise"></i> Refresh
                                </button>
                            </div>
                            <div class="card-body">
                                
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </section>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.28.3/dist/apexcharts.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            // Initialize charts with current data
            var paymentChart = new ApexCharts(document.querySelector("#paymentChart"), {
                series: [{
                    name: 'Pembayaran',
                    data: @json(array_values($monthlyPayments))
                }],
                chart: {
                    type: 'bar',
                    height: '100%',
                    toolbar: {
                        show: false
                    },
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800
                    }
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                colors: ['#4361ee'],
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                },
                yaxis: {
                    labels: {
                        formatter: function (value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function (value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            });
            paymentChart.render();

            var paymentStatusChart = new ApexCharts(document.querySelector("#paymentStatusChart"), {
                series: [{{ $paidPayments }}, {{ $pendingPayments }}, {{ $unpaidngPayments }}],
                chart: {
                    type: 'donut',
                    height: 350
                },
                labels: ['Lunas', 'Tertunda', 'Belum Bayar'],
                colors: ['#28a745', '#ffc107', '#dc3545'],
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
            paymentStatusChart.render();

            // Handle year selection change
            $('#yearSelect').change(function () {
                const year = $(this).val();
                window.location.href = "{{ route('dashboard') }}?year=" + year;
            });

            // Export chart button
            $('#exportChartBtn').click(function() {
                paymentChart.dataURI().then(({ imgURI, blob }) => {
                    const link = document.createElement('a');
                    link.href = imgURI;
                    link.download = 'statistik-pembayaran-spp-' + new Date().toISOString().slice(0,10) + '.png';
                    link.click();
                });
            });

            // Refresh progress button
            $('#refreshProgress').click(function() {
                $(this).html('<i class="bi bi-arrow-clockwise spin"></i> Memuat...');
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            });

            // Status filter dropdown
            $('[data-period]').click(function(e) {
                e.preventDefault();
                const period = $(this).data('period');
                $('#statusFilter').text($(this).text());
                // Here you would typically make an AJAX call to filter data
                // For now we'll just show a toast
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'info',
                    title: 'Memfilter data untuk periode: ' + $(this).text(),
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        </script>
    @endpush
@endsection