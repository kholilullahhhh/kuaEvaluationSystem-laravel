@extends('layouts.app', ['title' => 'Absensi Rapat Saya'])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Absensi Rapat Saya</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Kehadiran Rapat</h4>
                                @if (session('role') == 'user' || session('role') == 'penghulu')
                                <div class="card-header-action">
                                    <a href="{{ route('user.absensi.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Isi Absensi
                                    </a>
                                </div>
                                @endif
                            </div> 
                            
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Agenda Rapat</th>
                                                <th>Status Kehadiran</th>
                                                <th>Keterangan</th>
                                                <th>Laporan</th>
                                                <th>Dokumentasi</th>
                                                <th>Tanggal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($datas as $index => $absensi)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $absensi->agenda->judul ?? '' }}</td>
                                                    <td>
                                                        @switch($absensi->status)
                                                            @case('hadir')
                                                                <span class="badge badge-success">Hadir</span>
                                                                @break
                                                            @case('tidak hadir')
                                                                <span class="badge badge-danger">Tidak Hadir</span>
                                                                @break
                                                            @case('izin')
                                                                <span class="badge badge-warning">Izin</span>
                                                                @break
                                                            @case('sakit')
                                                                <span class="badge badge-info">Sakit</span>
                                                                @break
                                                            @case('terlambat')
                                                                <span class="badge badge-secondary">Terlambat</span>
                                                                @break
                                                            @default
                                                                <span class="badge badge-light">Unknown</span>
                                                        @endswitch
                                                    </td>
                                                    <td>{{ $absensi->keterangan ?? '-' }}</td>
                                                    <td>{{ $absensi->created_at->format('d M Y H:i') }}</td>
                                                    <td>
                                                        @if($absensi->laporan)
                                                            <a href="{{ asset('upload/laporan/' . $absensi->laporan) }}" 
                                                               target="_blank" 
                                                               class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-download"></i> Unduh
                                                            </a>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($absensi->dokumentasi)
                                                            <img class="img img-fluid" width="100"
                                                                 src="{{ asset('upload/dokumentasi/' . $absensi->dokumentasi) }}"
                                                                 alt="Dokumentasi">
                                                        @else
                                                            -
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
@endsection