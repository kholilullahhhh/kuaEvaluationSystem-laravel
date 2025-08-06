@extends('layouts.app', ['title' => 'Data Indikator Level'])

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
    @endpush

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Indikator Level</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Indikator Level</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Level Indikator</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('indikator_level.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Tambah Level Indikator
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-indikator-level">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Indikator</th>
                                                <th>Level</th>
                                                <th>Deskripsi Perilaku</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($datas as $index => $level)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $level->indicator->name }}</td>
                                                    <td>Level {{ $level->score }}</td>
                                                    <td>{{ $level->behavior_description }}</td>
                                                    <td>
                                                        <div class="action-buttons">
                                                            <a href="{{ route('indikator_level.edit', $level->id) }}"
                                                                class="btn btn-warning btn-action">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </a>
                                                            <form action="{{ route('indikator_level.hapus', $level->id) }}" method="POST"
                                                                class="d-inline delete-form">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button"
                                                                    class="btn btn-danger btn-action delete-btn">
                                                                    <i class="fas fa-trash"></i> Hapus
                                                                </button>
                                                            </form>
                                                        </div>
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
        <!-- SweetAlert2 from CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.18/dist/sweetalert2.all.min.js"></script>

        <!-- Other scripts -->
        <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('library/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>

        <script>
            $(document).ready(function () {
                $('#table-indikator-level').DataTable();

                // SweetAlert for delete confirmation
                $('.delete-btn').click(function (e) {
                    e.preventDefault();
                    var form = $(this).closest('form');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data level indikator ini akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });

                // Show success message if exists
                @if(session('message'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: '{{ session('message') }}',
                        timer: 3000,
                        showConfirmButton: true
                    });
                @endif

                // Show error message if exists
                @if(session('error'))
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: '{{ session('error') }}',
                    });
                @endif
            });
        </script>
    @endpush
@endsection