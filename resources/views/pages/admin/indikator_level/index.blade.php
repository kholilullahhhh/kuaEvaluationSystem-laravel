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
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
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
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($userData as $data)
                                                <tr>
                                                    <td>{{ $data['user']->name }}</td>
                                                    <td>{{ $data['user']->first()->name }}</td>
                                                    <td>{{ $data['total_kehadiran'] }}</td>

                                                    <!-- Kehadiran -->
                                                    <td>
                                                        <span class="score-indicator score-{{ $data['kehadiran_score'] }}">
                                                            {{ $data['kehadiran_score'] }}
                                                            ({{ $data['kehadiran_score'] == 4 ? 'Hadir' : 'Izin/Sakit' }})
                                                        </span>
                                                    </td>

                                                    <!-- Ketepatan Waktu -->
                                                    <td>
                                                        <span
                                                            class="score-indicator score-{{ $data['ketepatan_waktu_score'] }}">
                                                            {{ number_format($data['ketepatan_waktu_score'], 1) }}
                                                        </span>
                                                    </td>

                                                    <!-- Laporan Kegiatan -->
                                                    <td>
                                                        <span
                                                            class="score-indicator score-{{ $data['laporan_kegiatan_score'] }}">
                                                            {{ $data['laporan_kegiatan_score'] }}
                                                            ({{ $data['total_laporan'] }}/{{ $data['total_kehadiran'] }})
                                                        </span>
                                                    </td>

                                                    <!-- Kelengkapan Laporan -->
                                                    <td>
                                                        <span
                                                            class="score-indicator score-{{ $data['kelengkapan_laporan_score'] }}">
                                                            {{ $data['kelengkapan_laporan_score'] }}
                                                            ({{ $data['total_laporan_lengkap'] }}/{{ $data['total_laporan'] }})
                                                        </span>
                                                    </td>

                                                    <!-- Total Skor -->
                                                    <td>{{ $data['total_skor'] }}</td>

                                                    <!-- Persentase -->
                                                    <td>
                                                        @php
                                                            $persentase = ($data['total_skor'] / 16) * 100;
                                                        @endphp
                                                        {{ number_format($persentase, 2) }}%
                                                    </td>

                                                    <!-- Keterangan -->
                                                    <td>
                                                        @php
                                                            if ($persentase >= 87.5) {
                                                                $keterangan = 'Sempurna';
                                                                $class = 'badge badge-success';
                                                            } elseif ($persentase >= 62.5) {
                                                                $keterangan = 'Baik';
                                                                $class = 'badge badge-primary';
                                                            } elseif ($persentase >= 37.5) {
                                                                $keterangan = 'Cukup';
                                                                $class = 'badge badge-warning';
                                                            } else {
                                                                $keterangan = 'Kurang';
                                                                $class = 'badge badge-danger';
                                                            }
                                                        @endphp
                                                        <span class="{{ $class }}">{{ $keterangan }}</span>
                                                    </td>

                                                    <!-- Actions -->
                                                    <td>
                                                        <button class="btn btn-sm btn-primary"
                                                            onclick="saveScore({{ $data['user']->id }})">
                                                            <i class="fas fa-save"></i> Simpan
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @push('scripts')
        <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
        <script>
            function calculateAllScores() {
                // In a real implementation, this would recalculate scores via AJAX
                swal('Berhasil', 'Semua skor telah dihitung ulang!', 'success');
            }

            function saveScore(userId) {
                swal({
                    title: 'Konfirmasi',
                    text: 'Simpan penilaian kinerja untuk pegawai ini?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willSave) => {
                        if (willSave) {
                            // In a real implementation, this would submit via AJAX
                            swal('Berhasil', 'Data penilaian telah disimpan!', 'success');
                        }
                    });
            }
        </script>
    @endpush
@endsection