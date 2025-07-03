@extends('layouts.app', ['title' => 'Data Transaksi Pembayaran'])

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
    @endpush

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Pembayaran</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="mb-0">Daftar Pembayaran</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('payment.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-lg"></i> Tambah Pembayaran
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-pembayaran">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>NISN</th>
                                                <th>Nama Siswa</th>
                                                <th>Semester</th>
                                                <th>Tahun</th>
                                                <th>Jumlah</th>
                                                <th>Tanggal Pembayaran</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($datas as $index => $payment)
                                                <tr>
                                                    <td>{{ $payment->order_id }}</td>
                                                    <td>{{ $payment->siswa->nisn }}</td>
                                                    <td>{{ $payment->siswa->name }}</td>
                                                    <td>{{ $payment->spp->semester }}</td>
                                                    <td>{{ $payment->paid_year }}</td>
                                                    <td>{{ number_format($payment->amount, 0, ',', '.') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($payment->paid_at)->format('d-m-Y') }}</td>
                                                    @if ($payment->status == 'paid')
                                                        <td>
                                                            <button class="btn btn-success">{{ $payment->status }}</button>
                                                        </td>
                                                        <td>
                                                            <form action="{{ route('payment.hapus', $payment->id) }}" method="POST"
                                                                class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm">
                                                                    <i class="fas fa-trash"></i> Hapus
                                                                </button>
                                                            </form>
                                                        </td>
                                                    @elseif ($payment->status == 'pending')
                                                        <td>
                                                            <button class="btn btn-warning">{{ $payment->status }}</button>
                                                        </td>
                                                        <td>
                                                            <form action="{{ route('konfirmasi.pembayaran', $payment->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn btn-primary btn-sm">
                                                                    <i class="fas fa-money-bill-wave"></i> Konfirmasi
                                                                </button>
                                                            </form>
                                                            <form action="{{ route('payment.hapus', $payment->id) }}" method="POST"
                                                                class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm">
                                                                    <i class="fas fa-trash"></i> Hapus
                                                                </button>
                                                            </form>
                                                        </td>
                                                    @elseif ($payment->status == 'unpaid')
                                                        <td>
                                                            <button class="btn btn-danger">{{ $payment->status }}</button>
                                                        </td>
                                                        <td>
                                                            <form action="{{ route('payment.hapus', $payment->id) }}" method="POST"
                                                                class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm">
                                                                    <i class="fas fa-trash"></i> Hapus
                                                                </button>
                                                            </form>
                                                        </td>
                                                    @endif
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
                $('#table-pembayaran').DataTable();

                // SweetAlert for delete confirmation
                $('.delete-btn').click(function (e) {
                    e.preventDefault();
                    var form = $(this).closest('form');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data kelas ini akan dihapus secara permanen!",
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