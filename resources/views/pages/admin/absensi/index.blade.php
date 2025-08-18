@extends('layouts.app', ['title' => 'Data Absensi'])

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
        <style>
            .badge {
                font-size: 0.85em;
                font-weight: 500;
                padding: 0.35em 0.65em;
            }
            .img-thumbnail {
                max-width: 100px;
                height: auto;
                border: 1px solid #dee2e6;
                border-radius: 4px;
            }
            .action-buttons {
                white-space: nowrap;
            }
            .action-buttons .btn {
                margin-right: 5px;
            }
            .action-buttons .btn:last-child {
                margin-right: 0;
            }
        </style>
    @endpush

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Absensi Rapat</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Absensi</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Absensi</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('absensi.create') }}" class="btn btn-primary btn-icon icon-left">
                                        <i class="fas fa-plus"></i> Tambah Absensi
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="table-absensi">
                                        <thead class="text-white">
                                            <tr>
                                                <th class="text-center" width="5%">No</th>
                                                <th width="15%">Nama Agenda</th>
                                                <th width="12%">Nama Pegawai</th>
                                                <th width="10%">NIP</th>
                                                <th width="10%">Status</th>
                                                <th width="10%">Keterangan</th>
                                                <th width="12%">Tanggal</th>
                                                <th width="10%">Laporan</th>
                                                <th width="10%">Dokumentasi</th>
                                                <th width="8%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($datas as $i => $data)
                                                <tr>
                                                    <td class="text-center">{{ ++$i }}</td>
                                                    <td>{{ $data->agenda->judul ?? 'N/A' }}</td>
                                                    <td>{{ $data->user->name ?? 'N/A' }}</td>
                                                    <td>{{ $data->user->nip ?? 'N/A' }}</td>
                                                    <td>
                                                        @switch($data->status)
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
                                                    <td>{{ $data->keterangan ?: '-' }}</td>
                                                    <td>{{ $data->created_at->format('d/m/Y H:i') }}</td>
                                                    <td>
                                                        @if($data->laporan)
                                                            <a href="{{ asset('upload/laporan/' . $data->laporan) }}" 
                                                               target="_blank" 
                                                               class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-download"></i> Unduh
                                                            </a>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($data->dokumentasi)
                                                            <a href="{{ asset('upload/dokumentasi/' . $data->dokumentasi) }}" 
                                                               target="_blank">
                                                                <img class="img-thumbnail" 
                                                                     src="{{ asset('upload/dokumentasi/' . $data->dokumentasi) }}" 
                                                                     alt="Dokumentasi">
                                                            </a>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td class="action-buttons">
                                                        <a href="{{ route('absensi.edit', $data->id) }}"
                                                            class="btn btn-sm btn-warning" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button onclick="deleteData({{ $data->id }}, 'absensi')" 
                                                                class="btn btn-sm btn-danger" title="Hapus">
                                                            <i class="fas fa-trash-alt"></i>
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
        <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('library/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('js/page/modules-datatables.js') }}"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#table-absensi').DataTable({
                    responsive: true,
                    paging: true,
                    searching: true,
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/2.1.0/i18n/id.json',
                    },
                    columnDefs: [
                        { orderable: false, targets: [6,7,8,9] }, // Disable sorting for image and action columns
                        { searchable: false, targets: [0,6,7,8,9] }, // Disable searching for # and action columns
                        { className: "text-center", targets: [0,4,9] } // Center align certain columns
                    ],
                    dom: '<"top"f>rt<"bottom"lip><"clear">',
                    initComplete: function() {
                        $('.dataTables_filter input').addClass('form-control').attr('placeholder', 'Cari...');
                        $('.dataTables_length select').addClass('form-control');
                    }
                });
            });
        </script>
    @endpush
@endsection