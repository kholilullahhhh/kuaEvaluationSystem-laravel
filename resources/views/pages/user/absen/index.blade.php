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
                                <div class="card-header-action">
                                    <a href="{{ route('user.absensi.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Isi Absensi
                                    </a>
                                </div>
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