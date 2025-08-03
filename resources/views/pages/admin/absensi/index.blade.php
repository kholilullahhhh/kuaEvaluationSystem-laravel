@extends('layouts.app', ['title' => 'Data Absensi'])

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
    @endpush

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Absensi Rapat</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- Navigation Buttons -->
                                <a href="{{ route('absensi.create') }}" class="btn btn-primary text-white my-3">
                                    <i class="fas fa-plus"></i> Tambah Absensi
                                </a>

                                <!-- Tables Section -->
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-absensi">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Nama Agenda</th>
                                                <th>Nama Pegawai</th>
                                                <th>NUPTK</th>
                                                <th>Status Kehadiran</th>
                                                <th>Keterangan</th>
                                                <th>Tanggal Absensi</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($datas as $i => $data)
                                                <tr>
                                                    <td>{{ ++$i }}</td>
                                                    <td>{{ $data->agenda->judul ?? 'N/A' }}</td>
                                                    <td>{{ $data->user->name ?? 'N/A' }}</td>
                                                    <td>{{ $data->user->nuptk ?? 'N/A' }}</td>
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
                                                    <td>{{ $data->keterangan ?? '-' }}</td>
                                                    <td>{{ $data->created_at->format('d F Y H:i') }}</td>
                                                    <td>
                                                        <a href="{{ route('absensi.edit', $data->id) }}"
                                                            class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                                        <button onclick="deleteData({{ $data->id }}, 'absensi')" 
                                                                class="btn btn-danger btn-sm" title="Hapus">
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
                    paging: true,
                    searching: true,
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/2.1.0/i18n/id.json',
                    },
                    columnDefs: [
                        { orderable: false, targets: [6] }, // Disable sorting for action column
                        { searchable: false, targets: [0, 6] } // Disable searching for # and action columns
                    ]
                });
            });
        </script>
    @endpush
@endsection