@extends('layouts.app', ['title' => 'Data Modul'])

@section('content')
@push('styles')
    <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endpush

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data Modul</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Button to Create New Modul -->
                            <a href="{{ route('modul.create') }}" class="btn btn-primary text-white my-3">+ Tambah
                                Modul</a>

                            <!-- Data Table -->
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-modul">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Sampul</th>
                                            <th>Judul Modul</th>
                                            <th>Tema</th>
                                            <th>Deskripsi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datas as $i => $data)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>
                                                    <img class="img img-fluid" width="100"
                                                        src="{{ asset('upload/modul/' . $data->sampul) }}"
                                                        alt="Sampul Modul">
                                                </td>
                                                <td>{{ $data->judul }}</td>
                                                <td>{{ $data->tema->nama ?? 'Tidak ada tema' }}</td>
                                                <td>{!! $data->deskripsi ?? '' !!}</td>
                                                <td>
                                                    <a href="{{ route('modul.edit', $data->id) }}"
                                                        class="btn btn-warning my-2">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button onclick="deleteData({{ $data->id }}, 'modul')"
                                                        class="btn btn-danger">
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
        $(document).ready(function () {
            $('#table-modul').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.1.0/i18n/id.json',
                },
            });
        });

        function deleteData(id, route) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                $.ajax({
                    url: `/${route}/${id}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (response) {
                        location.reload();
                    },
                    error: function (err) {
                        alert('Terjadi kesalahan, coba lagi.');
                    }
                });
            }
        }
    </script>
@endpush
@endsection