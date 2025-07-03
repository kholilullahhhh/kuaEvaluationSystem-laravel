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
                                            @foreach ($datas as $payment)
                                                <tr>
                                                    <td>{{ $payment->order_id }}</td>
                                                    <td>{{ $payment->siswa->nisn }}</td>
                                                    <td>{{ $payment->siswa->name }}</td>
                                                    <td>{{ $payment->spp->semester }}</td>
                                                    <td>{{ $payment->paid_year }}</td>
                                                    <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                                    <td>
                                                        @if($payment->paid_at)
                                                            {{ \Carbon\Carbon::parse($payment->paid_at)->format('d-m-Y') }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($payment->status == 'paid')
                                                            <span class="badge badge-success">Lunas</span>
                                                        @elseif($payment->status == 'pending')
                                                            <span class="badge badge-warning">Pending</span>
                                                        @else
                                                            <span class="badge badge-danger">Belum Bayar</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($payment->status == 'unpaid')
                                                            <a href="{{ route('midtrans.create', $payment->id) }}"
                                                                class="btn btn-primary btn-sm">
                                                                <i class="fas fa-money-bill-wave"></i> Bayar
                                                            </a>
                                                        @elseif($payment->status == 'pending')
                                                            <button class="btn btn-success btn-sm" disabled>
                                                                <i class="fa fa-spinner"></i> Konfirmasi
                                                                </button>
                                                        @else
                                                                <button class="btn btn-success btn-sm" disabled>
                                                                    <i class="fas fa-check"></i> Sudah Bayar
                                                                </button>
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
        <!-- SweetAlert2 from CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.18/dist/sweetalert2.all.min.js"></script>

        <!-- Other scripts -->
        <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('library/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>

        <script>
            $(document).ready(function () {
                $('#table-pembayaran').DataTable();

                // SweetAlert for notifications
                @if(session('message'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: '{{ session('message') }}',
                        timer: 3000,
                        showConfirmButton: true
                    });
                @endif

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