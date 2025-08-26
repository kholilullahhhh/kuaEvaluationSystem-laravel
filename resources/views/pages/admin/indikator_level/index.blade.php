@extends('layouts.app', ['title' => 'Tambah Skor Kinerja'])@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
        <style>
            .score-card {
                border: 1px solid #e3e6f0;
                border-radius: 5px;
                padding: 15px;
                margin-bottom: 20px;
            }

            .score-indicator {
                font-weight: bold;
            }

            .score-4 {
                color: #1cc88a;
            }

            .score-3 {
                color: #36b9cc;
            }

            .score-2 {
                color: #f6c23e;
            }

            .score-1 {
                color: #e74a3b;
            }

            .score-0 {
                color: #858796;
            }

            .table th,
            .table td {
                vertical-align: middle;
                text-align: center;
            }

            .table th:nth-child(1),
            .table td:nth-child(1) {
                text-align: left;
            }

            .badge-status {
                font-size: 0.8rem;
                padding: 0.4em 0.6em;
            }
        /* Progress bar styles */
                    .progress {
                        height: 10px;
                        margin-bottom: 10px;
                    }

                    .progress-bar-score-4 {
                        background-color: #1cc88a;
                    }

                    .progress-bar-score-3 {
                        background-color: #36b9cc;
                    }

                    .progress-bar-score-2 {
                        background-color: #f6c23e;
                    }

                    .progress-bar-score-1 {
                        background-color: #e74a3b;
                    }

                    .progress-bar-score-0 {
                        background-color: #858796;
                    }

                    /* Modal detail styles */
                    .detail-item {
                        margin-bottom: 15px;
                        padding-bottom: 15px;
                        border-bottom: 1px solid #eee;
                    }

                    .detail-item:last-child {
                        border-bottom: none;
                    }

                    .detail-label {
                        font-weight: bold;
                        color: #555;
                    }

                    .score-detail {
                        display: flex;
                        align-items: center;
                        margin-bottom: 5px;
                    }

                    .score-detail-label {
                        width: 200px;
                        font-weight: 500;
                    }

                    .score-detail-value {
                        width: 60px;
                        text-align: center;
                        font-weight: bold;
                    }

                    .score-detail-bar {
                        flex-grow: 1;
                        margin: 0 15px;
                    }
                </style>
    @endpush

        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Penilaian Kinerja Pegawai</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                        <div class="breadcrumb-item">Penilaian Kinerja</div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Periode: {{ now()->format('F Y') }}</h4>
                                    <div class="card-header-action">
                                        <button class="btn btn-primary" onclick="calculateAllScores()">
                                            <i class="fas fa-calculator"></i> Hitung Semua Skor
                                        </button>
                                        <button class="btn btn-success" onclick="saveAllScores()">
                                            <i class="fas fa-save"></i> Simpan Semua
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Nama Pegawai</th>
                                                    <th>Jabatan</th>
                                                    <th>Total Kegiatan</th>
                                                    <th>Kehadiran (Skor)</th>
                                                    <th>Ketepatan Waktu (Skor)</th>
                                                    <th>Laporan Kegiatan (Skor)</th>
                                                    <th>Kelengkapan Laporan (Skor)</th>
                                                    <th>Total Skor</th>
                                                    <th>Persentase</th>
                                                    <th>Keterangan</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($userData as $data)
                                                    <tr>
                                                        <td>{{ $data['user']->name }}</td>
                                                        <td>
                                                            @if($data['user']->role == 'user')
                                                                Penyuluh
                                                            @elseif($data['user']->role == 'penghulu')
                                                                Penghulu
                                                            @elseif($data['user']->role == 'kepala_kua')
                                                                Kepala KUA
                                                            @elseif($data['user']->role == 'admin')
                                                                Admin
                                                            @else
                                                                {{ $data['user']->role }}
                                                            @endif
                                                        </td>
                                                        <td>{{ $data['total_kehadiran'] }}</td>

                                                        <!-- Kehadiran -->
                                                        <td>
                                                            @php
                                                                $kehadiranScore = round($data['kehadiran']);
                                                            @endphp
                                                            <span class="score-indicator score-{{ $kehadiranScore }}">
                                                                {{ number_format($data['kehadiran'], 1) }}
                                                            </span>
                                                            <br>
                                                            <small class="text-muted">
                                                                {{ $data['total_kehadiran'] }} kegiatan
                                                            </small>
                                                        </td>

                                                        <!-- Ketepatan Waktu -->
                                                        <td>
                                                            @php
                                                                $ketepatanScore = round($data['ketepatan_waktu']);
                                                            @endphp
                                                            <span class="score-indicator score-{{ $ketepatanScore }}">
                                                                {{ number_format($data['ketepatan_waktu'], 1) }}
                                                            </span>
                                                        </td>

                                                        <!-- Laporan Kegiatan -->
                                                        <td>
                                                            @php
                                                                $laporanScore = round($data['laporan_kegiatan']);
                                                            @endphp
                                                            <span class="score-indicator score-{{ $laporanScore }}">
                                                                {{ number_format($data['laporan_kegiatan'], 1) }}
                                                            </span>
                                                            <br>
                                                            <small class="text-muted">
                                                                {{ $data['total_laporan'] }}/{{ $data['total_kehadiran'] }} laporan
                                                            </small>
                                                        </td>

                                                        <!-- Kelengkapan Laporan -->
                                                        <td>
                                                            @php
                                                                $kelengkapanScore = round($data['kelengkapan_laporan']);
                                                            @endphp
                                                            <span class="score-indicator score-{{ $kelengkapanScore }}">
                                                                {{ number_format($data['kelengkapan_laporan'], 1) }}
                                                            </span>
                                                            <br>
                                                            <small class="text-muted">
                                                                {{ $data['total_laporan_lengkap'] }}/{{ $data['total_laporan'] }}
                                                                lengkap
                                                            </small>
                                                        </td>

                                                        <!-- Total Skor -->
                                                        <td>
                                                            <strong>{{ number_format($data['total_skor'], 2) }}</strong>
                                                            <br>
                                                            <small class="text-muted">dari 16</small>
                                                        </td>

                                                        <!-- Persentase -->
                                                        <td>
                                                            <strong>{{ number_format($data['persentase'], 2) }}%</strong>
                                                        </td>

                                                        <!-- Keterangan -->
                                                        <td>
                                                            @php
                                                                if ($data['persentase'] >= 87.5) {
                                                                    $keterangan = 'Sempurna';
                                                                    $class = 'badge badge-success badge-status';
                                                                } elseif ($data['persentase'] >= 62.5) {
                                                                    $keterangan = 'Baik';
                                                                    $class = 'badge badge-primary badge-status';
                                                                } elseif ($data['persentase'] >= 37.5) {
                                                                    $keterangan = 'Cukup';
                                                                    $class = 'badge badge-warning badge-status';
                                                                } else {
                                                                    $keterangan = 'Kurang';
                                                                    $class = 'badge badge-danger badge-status';
                                                                }
                                                            @endphp
                                                            <span class="{{ $class }}">{{ $keterangan }}</span>
                                                        </td>

                                                        <!-- Status -->
                                                        <td>
                                                            @if($data['existing_score'])
                                                                <span class="badge badge-success badge-status">
                                                                    <i class="fas fa-check-circle"></i> Tersimpan
                                                                </span>
                                                                <br>
                                                                <small class="text-muted">
                                                                    {{ $data['existing_score']->updated_at->format('d/m/Y H:i') }}
                                                                </small>
                                                            @else
                                                                <span class="badge badge-secondary badge-status">
                                                                    <i class="fas fa-clock"></i> Belum Disimpan
                                                                </span>
                                                            @endif
                                                        </td>

                                                        <!-- Actions -->
                                                        <td>
                                                            <!-- Form Tersembunyi untuk Data -->
                                                            <form id="form-{{ $data['user']->id }}" class="score-form">
                                                                @csrf
                                                                <input type="hidden" name="user_id" value="{{ $data['user']->id }}">
                                                                <input type="hidden" name="periode"
                                                                    value="{{ now()->format('Y-m-01') }}">
                                                                <input type="hidden" name="kehadiran"
                                                                    value="{{ $data['kehadiran'] }}">
                                                                <input type="hidden" name="ketepatan_waktu"
                                                                    value="{{ $data['ketepatan_waktu'] }}">
                                                                <input type="hidden" name="laporan_kegiatan"
                                                                    value="{{ $data['laporan_kegiatan'] }}">
                                                                <input type="hidden" name="kelengkapan_laporan"
                                                                    value="{{ $data['kelengkapan_laporan'] }}">
                                                                <input type="hidden" name="total_absensi"
                                                                    value="{{ $data['total_kehadiran'] }}">
                                                                <input type="hidden" name="total_laporan"
                                                                    value="{{ $data['total_laporan'] }}">
                                                                <input type="hidden" name="total_laporan_lengkap"
                                                                    value="{{ $data['total_laporan_lengkap'] }}">
                                                            </form>

                                                            <div class="btn-group" role="group">
                                                                <button class="btn btn-sm btn-primary"
                                                                    onclick="saveScore({{ $data['user']->id }})"
                                                                    title="Simpan penilaian untuk {{ $data['user']->name }}">
                                                                    <i class="fas fa-save"></i>
                                                                    {{ $data['existing_score'] ? 'Update' : 'Simpan' }}
                                                                </button>

                                                                <button class="btn btn-sm btn-info"
                                                                    onclick="viewDetails({{ $data['user']->id }}, {{ json_encode($data) }})"
                                                                    title="Lihat detail penilaian">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Informasi Legenda Skor -->
                                    <div class="mt-4 p-3 bg-light rounded">
                                        <h6>Legenda Skor:</h6>
                                        <div class="d-flex flex-wrap">
                                            <span class="mr-3"><span class="score-indicator score-4">4</span> = Sangat
                                                Baik</span>
                                            <span class="mr-3"><span class="score-indicator score-3">3</span> = Baik</span>
                                            <span class="mr-3"><span class="score-indicator score-2">2</span> = Cukup</span>
                                            <span class="mr-3"><span class="score-indicator score-1">1</span> = Kurang</span>
                                            <span><span class="score-indicator score-0">0</span> = Tidak Ada</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Modal Detail Penilaian -->
        <div class="modal fade" tabindex="-1" role="dialog" id="detailModal">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Penilaian Kinerja</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <div class="detail-label">Nama Pegawai</div>
                                    <div id="detail-nama"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <div class="detail-label">Jabatan</div>
                                    <div id="detail-jabatan"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <div class="detail-label">Periode</div>
                                    <div>{{ now()->format('F Y') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <div class="detail-label">Status</div>
                                    <div id="detail-status"></div>
                                </div>
                            </div>
                        </div>

                        <h6>Detail Skor Penilaian</h6>
                        <div class="detail-item">
                            <div class="score-detail">
                                <div class="score-detail-label">Kehadiran:</div>
                                <div class="score-detail-value" id="detail-kehadiran-score"></div>
                                <div class="score-detail-bar">
                                    <div class="progress">
                                        <div id="detail-kehadiran-bar" class="progress-bar" role="progressbar" style="width: 0%"></div>
                                    </div>
                                </div>
                                <div id="detail-kehadiran-desc"></div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="score-detail">
                                <div class="score-detail-label">Ketepatan Waktu:</div>
                                <div class="score-detail-value" id="detail-ketepatan-score"></div>
                                <div class="score-detail-bar">
                                    <div class="progress">
                                        <div id="detail-ketepatan-bar" class="progress-bar" role="progressbar" style="width: 0%"></div>
                                    </div>
                                </div>
                                <div id="detail-ketepatan-desc"></div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="score-detail">
                                <div class="score-detail-label">Laporan Kegiatan:</div>
                                <div class="score-detail-value" id="detail-laporan-score"></div>
                                <div class="score-detail-bar">
                                    <div class="progress">
                                        <div id="detail-laporan-bar" class="progress-bar" role="progressbar" style="width: 0%"></div>
                                    </div>
                                </div>
                                <div id="detail-laporan-desc"></div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="score-detail">
                                <div class="score-detail-label">Kelengkapan Laporan:</div>
                                <div class="score-detail-value" id="detail-kelengkapan-score"></div>
                                <div class="score-detail-bar">
                                    <div class="progress">
                                        <div id="detail-kelengkapan-bar" class="progress-bar" role="progressbar" style="width: 0%"></div>
                                    </div>
                                </div>
                                <div id="detail-kelengkapan-desc"></div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <div class="detail-label">Total Skor</div>
                                    <div id="detail-total-skor" class="font-weight-bold" style="font-size: 1.2rem;"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <div class="detail-label">Persentase</div>
                                    <div id="detail-persentase" class="font-weight-bold" style="font-size: 1.2rem;"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="detail-item">
                                    <div class="detail-label">Keterangan</div>
                                    <div id="detail-keterangan"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
            <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
            <script>
                function calculateAllScores() {
                    swal({
                        title: 'Hitung Ulang Semua Skor?',
                        text: 'Proses ini akan menghitung ulang semua skor berdasarkan data terbaru.',
                        icon: 'info',
                        buttons: true,
                        dangerMode: false,
                    })
                        .then((willCalculate) => {
                            if (willCalculate) {
                                // Show loading
                                swal({
                                    title: 'Menghitung...',
                                    text: 'Sedang menghitung semua skor',
                                    icon: 'info',
                                    buttons: false,
                                    closeOnClickOutside: false,
                                    closeOnEsc: false,
                                });

                                // Reload page to recalculate scores
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            }
                        });
                }

                function saveAllScores() {
                    swal({
                        title: 'Simpan Semua Data?',
                        text: 'Proses ini akan menyimpan semua data penilaian yang belum tersimpan.',
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true,
                    })
                        .then((willSaveAll) => {
                            if (willSaveAll) {
                                // Show loading
                                swal({
                                    title: 'Menyimpan...',
                                    text: 'Sedang menyimpan semua data',
                                    icon: 'info',
                                    buttons: false,
                                    closeOnClickOutside: false,
                                    closeOnEsc: false,
                                });

                                // Get all user IDs
                                const userIds = @json(collect($userData)->pluck('user.id'));

                                // Save all scores sequentially
                                let promises = [];
                                userIds.forEach(userId => {
                                    promises.push(saveSingleScore(userId));
                                });

                                // Execute all promises
                                Promise.all(promises)
                                    .then(results => {
                                        const successCount = results.filter(r => r.success).length;
                                        const errorCount = results.filter(r => !r.success).length;

                                        if (errorCount === 0) {
                                            swal('Berhasil!', `Semua ${successCount} data berhasil disimpan.`, 'success')
                                                .then(() => location.reload());
                                        } else {
                                            swal('Sebagian Berhasil',
                                                `${successCount} data berhasil disimpan, ${errorCount} gagal.`,
                                                'warning')
                                                .then(() => location.reload());
                                        }
                                    })
                                    .catch(error => {
                                        swal('Error', 'Terjadi kesalahan: ' + error, 'error');
                                    });
                            }
                        });
                }

                function saveSingleScore(userId) {
                    return new Promise((resolve) => {
                        const formData = new FormData(document.getElementById(`form-${userId}`));

                        fetch('{{ route("indikator_level.store") }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: formData
                        })
                            .then(response => response.json())
                            .then(data => {
                                resolve({ success: data.success, userId: userId, message: data.message });
                            })
                            .catch(error => {
                                resolve({ success: false, userId: userId, message: error.toString() });
                            });
                    });
                }

                function saveScore(userId) {
                    swal({
                        title: 'Konfirmasi',
                        text: `Simpan penilaian kinerja untuk pegawai ini?`,
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true,
                    })
                        .then((willSave) => {
                            if (willSave) {
                                // Show loading
                                swal({
                                    title: 'Menyimpan...',
                                    text: 'Sedang menyimpan data',
                                    icon: 'info',
                                    buttons: false,
                                    closeOnClickOutside: false,
                                    closeOnEsc: false,
                                });

                                // Kirim data via AJAX
                                saveSingleScore(userId)
                                    .then(result => {
                                        if (result.success) {
                                            swal('Berhasil', result.message, 'success')
                                                .then(() => location.reload());
                                        } else {
                                            swal('Error', result.message, 'error');
                                        }
                                    });
                            }
                        });
                }

                function viewDetails(userId, data) {
                    // Set data to modal
                    document.getElementById('detail-nama').textContent = data.user.name;

                    // Set jabatan
                    let jabatan = '';
                    switch(data.user.role) {
                        case 'user':
                            jabatan = 'Penyuluh';
                            break;
                        case 'penghulu':
                            jabatan = 'Penghulu';
                            break;
                        case 'kepala_kua':
                            jabatan = 'Kepala KUA';
                            break;
                        case 'admin':
                            jabatan = 'Admin';
                            break;
                        default:
                            jabatan = data.user.role;
                    }
                    document.getElementById('detail-jabatan').textContent = jabatan;

                    // Set status
                    const statusElement = document.getElementById('detail-status');
                    if (data.existing_score) {
                        statusElement.innerHTML = '<span class="badge badge-success">Tersimpan</span>';
                    } else {
                        statusElement.innerHTML = '<span class="badge badge-secondary">Belum Disimpan</span>';
                    }

                    // Set scores and progress bars
                    setScoreDetail('kehadiran', data.kehadiran, data.total_kehadiran + ' kegiatan');
                    setScoreDetail('ketepatan', data.ketepatan_waktu, '');
                    setScoreDetail('laporan', data.laporan_kegiatan, data.total_laporan + '/' + data.total_kehadiran + ' laporan');
                    setScoreDetail('kelengkapan', data.kelengkapan_laporan, data.total_laporan_lengkap + '/' + data.total_laporan + ' lengkap');

                    // Set total and percentage
                    document.getElementById('detail-total-skor').textContent = data.total_skor.toFixed(2) + ' dari 16';
                    document.getElementById('detail-persentase').textContent = data.persentase.toFixed(2) + '%';

                    // Set keterangan
                    let keterangan = '';
                    let keteranganClass = '';
                    if (data.persentase >= 87.5) {
                        keterangan = 'Sempurna';
                        keteranganClass = 'badge badge-success';
                    } else if (data.persentase >= 62.5) {
                        keterangan = 'Baik';
                        keteranganClass = 'badge badge-primary';
                    } else if (data.persentase >= 37.5) {
                        keterangan = 'Cukup';
                        keteranganClass = 'badge badge-warning';
                    } else {
                        keterangan = 'Kurang';
                        keteranganClass = 'badge badge-danger';
                    }
                    document.getElementById('detail-keterangan').innerHTML = '<span class="' + keteranganClass + '">' + keterangan + '</span>';

                    // Show modal
                    $('#detailModal').modal('show');
                }

                function setScoreDetail(type, score, description) {
                    const scoreElement = document.getElementById('detail-' + type + '-score');
                    const barElement = document.getElementById('detail-' + type + '-bar');
                    const descElement = document.getElementById('detail-' + type + '-desc');

                    // Set score value
                    scoreElement.textContent = score.toFixed(1);
                    scoreElement.className = 'score-detail-value score-indicator score-' + Math.round(score);

                    // Set progress bar
                    const percentage = (score / 4) * 100;
                    barElement.style.width = percentage + '%';

                    // Set bar color based on score
                    const roundedScore = Math.round(score);
                    barElement.className = 'progress-bar progress-bar-score-' + roundedScore;

                    // Set description
                    descElement.textContent = description;
                }
            </script>
        @endpush
@endsection