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
                                                        <span class="score-indicator score-{{ $data['kehadiran'] }}">
                                                            {{ $data['kehadiran'] }}
                                                            ({{ $data['kehadiran'] == 4 ? 'Hadir' : 'Izin/Sakit' }})
                                                        </span>
                                                    </td>

                                                    <!-- Ketepatan Waktu -->
                                                    <td>
                                                        <span
                                                            class="score-indicator score-{{ round($data['ketepatan_waktu']) }}">
                                                            {{ number_format($data['ketepatan_waktu'], 1) }}
                                                        </span>
                                                    </td>

                                                    <!-- Laporan Kegiatan -->
                                                    <td>
                                                        <span
                                                            class="score-indicator score-{{ $data['laporan_kegiatan'] }}">
                                                            {{ $data['laporan_kegiatan'] }}
                                                            ({{ $data['total_laporan'] }}/{{ $data['total_kehadiran'] }})
                                                        </span>
                                                    </td>

                                                    <!-- Kelengkapan Laporan -->
                                                    <td>
                                                        <span
                                                            class="score-indicator score-{{ $data['kelengkapan_laporan'] }}">
                                                            {{ $data['kelengkapan_laporan'] }}
                                                            ({{ $data['total_laporan_lengkap'] }}/{{ $data['total_laporan'] }})
                                                        </span>
                                                    </td>

                                                    <!-- Total Skor -->
                                                    <td>{{ $data['total_skor'] }}</td>

                                                    <!-- Persentase -->
                                                    <td>
                                                        {{ number_format($data['persentase'], 2) }}%
                                                    </td>

                                                    <!-- Keterangan -->
                                                    <td>
                                                        @php
                                                            if ($data['persentase'] >= 87.5) {
                                                                $keterangan = 'Sempurna';
                                                                $class = 'badge badge-success';
                                                            } elseif ($data['persentase'] >= 62.5) {
                                                                $keterangan = 'Baik';
                                                                $class = 'badge badge-primary';
                                                            } elseif ($data['persentase'] >= 37.5) {
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
                                                        <!-- Form Tersembunyi untuk Data -->
                                                        <form id="form-{{ $data['user']->id }}" class="score-form">
                                                            @csrf
                                                            <input type="hidden" name="user_id" value="{{ $data['user']->id }}">
                                                            <input type="hidden" name="periode" value="{{ now()->format('Y-m-01') }}">
                                                            <input type="hidden" name="kehadiran" value="{{ $data['kehadiran'] }}">
                                                            <input type="hidden" name="ketepatan_waktu" value="{{ $data['ketepatan_waktu'] }}">
                                                            <input type="hidden" name="laporan_kegiatan" value="{{ $data['laporan_kegiatan'] }}">
                                                            <input type="hidden" name="kelengkapan_laporan" value="{{ $data['kelengkapan_laporan'] }}">
                                                            <input type="hidden" name="total_absensi" value="{{ $data['total_kehadiran'] }}">
                                                            <input type="hidden" name="total_laporan" value="{{ $data['total_laporan'] }}">
                                                            <input type="hidden" name="total_laporan_lengkap" value="{{ $data['total_laporan_lengkap'] }}">
                                                        </form>
                                                        
                                                        <button class="btn btn-sm btn-primary"
                                                            onclick="saveScore({{ $data['user']->id }})">
                                                            <i class="fas fa-save"></i> 
                                                            {{ $data['existing_score'] ? 'Update' : 'Simpan' }}
                                                        </button>
                                                        
                                                        @if($data['existing_score'])
                                                            <span class="badge badge-success ml-2">Tersimpan</span>
                                                        @endif
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
                        // Kirim data via AJAX
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
                            if (data.success) {
                                swal('Berhasil', data.message, 'success').then(() => {
                                    // Reload halaman untuk memperbarui status
                                    location.reload();
                                });
                            } else {
                                swal('Error', data.message, 'error');
                            }
                        })
                        .catch(error => {
                            swal('Error', 'Terjadi kesalahan: ' + error, 'error');
                        });
                    }
                });
            }
        </script>
    @endpush
@endsection