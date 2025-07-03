@extends('layouts.app', ['title' => 'Data Siswa'])

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/sweetalert2/dist/sweetalert2.min.css') }}">
        <style>
            .action-buttons {
                display: flex;
                gap: 0.5rem;
            }

            .btn-action {
                padding: 0.375rem 0.75rem;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .btn-action i {
                margin-right: 0.25rem;
            }
        </style>
    @endpush

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Siswa</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Data Siswa</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Siswa</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('siswa.create') }}" class="btn btn-primary btn-icon icon-left">
                                        <i class="fas fa-plus"></i> Tambah Siswa
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-siswa">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama</th>
                                                <th>Username</th>
                                                <th>Kelas</th>
                                                <th>NISN</th>
                                                <th>NIS</th>
                                                <th>Alamat</th>
                                                <th>No Handphone</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($datas as $index => $siswa)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $siswa->name }}</td>
                                                    <td>{{ $siswa->username }}</td>
                                                    <td>{{ $siswa->class->name ?? '-' }}</td>
                                                    <td>{{ $siswa->nisn }}</td>
                                                    <td>{{ $siswa->nis }}</td>
                                                    <td>{{ $siswa->address ?? '-' }}</td>
                                                    <td>{{ $siswa->no_hp ?? '-' }}</td>
                                                    <td>
                                                        <div class="action-buttons">
                                                            <a href="{{ route('siswa.edit', $siswa->id) }}"
                                                                class="btn btn-warning btn-action">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </a>
                                                            <form action="{{ route('siswa.hapus', $siswa->id) }}" method="POST"
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
                $('#table-siswa').DataTable();

                // SweetAlert for delete confirmation
                $('.delete-btn').click(function (e) {
                    e.preventDefault();
                    var form = $(this).closest('form');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data siswa ini akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();  // Submit the form if confirmed
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