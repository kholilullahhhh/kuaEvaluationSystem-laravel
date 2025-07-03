@extends('layouts.app', ['title' => 'Tambah Data Pembayaran'])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Pembayaran</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('payment.index') }}">Pembayaran</a></div>
                    <div class="breadcrumb-item active">Tambah</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4 class="text-dark">Form Pembayaran</h4>
                            </div>
                            <div class="card-body">
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                <form action="{{ route('payment.store') }}" method="POST" class="needs-validation" novalidate>
                                    @csrf
                                    
                                    <div class="form-row">
                                        <!-- Student Info -->
                                        <div class="form-group col-md-6">
                                            <label for="nisn-select">Pilih Siswa</label>
                                            <select class="form-control select2" name="siswa_id" id="nisn-select" required>
                                                <option value="">Cari berdasarkan NISN</option>
                                                @foreach ($siswa as $student)
                                                    <option value="{{ $student->id }}" 
                                                        data-nama="{{ $student->name }}"
                                                        {{ old('siswa_id') == $student->id ? 'selected' : '' }}>
                                                        {{ $student->nisn }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="mt-2">
                                                <label>Nama Siswa</label>
                                                <input type="text" id="nama-siswa" class="form-control bg-light" readonly>
                                            </div>
                                        </div>

                                        <!-- Payment Info -->
                                        <div class="form-group col-md-6">
                                            <label for="spp-select">Pilih SPP</label>
                                            <select class="form-control select2" name="spp_id" id="spp-select" required>
                                                <option value="">Pilih Paket SPP</option>
                                                @foreach ($spp as $plan)
                                                    <option value="{{ $plan->id }}"
                                                        data-nominal="{{ $plan->nominal }}"
                                                        data-year="{{ $plan->year }}"
                                                        data-semester="{{ $plan->semester }}"
                                                        {{ old('spp_id') == $plan->id ? 'selected' : '' }}>
                                                        {{ $plan->name }} (Rp{{ number_format($plan->nominal, 0, ',', '.') }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="row mt-2">
                                                <div class="col-md-6">
                                                    <label>Jumlah</label>
                                                    <input type="text" name="amount" id="amount-input" class="form-control bg-light" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Tahun</label>
                                                    <input type="text" name="paid_year" id="year-input" class="form-control bg-light" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row mt-3">
                                        <div class="form-group col-md-4">
                                            <label>Bulan Pembayaran</label>
                                            <select name="paid_month" class="form-control" required>
                                                <option value="">Pilih Bulan</option>
                                                @foreach(['January'=>'Januari', 'February'=>'Februari', 'March'=>'Maret', 
                                                        'April'=>'April', 'May'=>'Mei', 'June'=>'Juni',
                                                        'July'=>'Juli', 'August'=>'Agustus', 'September'=>'September',
                                                        'October'=>'Oktober', 'November'=>'November', 'December'=>'Desember'] as $value => $label)
                                                    <option value="{{ $value }}" {{ old('paid_month') == $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>Semester</label>
                                            <input type="text" id="semester-input" class="form-control bg-light" readonly>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>Status</label>
                                            <select name="status" class="form-control" required>
                                                <option value="unpaid" {{ old('status') == 'unpaid' ? 'selected' : '' }}>
                                                    Belum Dibayar
                                                </option>
                                                <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>
                                                    Sudah Dibayar
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <input type="hidden" name="paid_at" id="paid_at">

                                    <div class="form-group text-center mt-4">
                                        <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm">
                                            <i class="fas fa-save mr-2"></i> Simpan
                                        </button>
                                        <a href="{{ route('payment.index') }}" class="btn btn-light btn-lg px-5 ml-2">
                                            <i class="fas fa-arrow-left mr-2"></i> Batal
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <style>
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }
        .card-header {
            background: #f8f9fa;
            border-bottom: 1px solid #eaeff1;
        }
        .form-control {
            border-radius: 5px;
        }
        .select2-container--default .select2-selection--single {
            height: calc(2.25rem + 2px);
            border-radius: 5px;
            padding: 0.375rem 0.75rem;
        }
        .bg-light {
            background-color: #f8f9fa !important;
        }
        .btn-primary {
            background-color: #4361ee;
            border-color: #4361ee;
        }
        .btn-lg {
            padding: 0.5rem 1.5rem;
            font-size: 1.1rem;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize select2
            $('.select2').select2({
                width: '100%',
                placeholder: $(this).data('placeholder')
            });

            // Set payment date
            $('#paid_at').val(new Date().toISOString().split('T')[0]);

            // Auto-fill student name
            $('#nisn-select').change(function() {
                $('#nama-siswa').val($(this).find('option:selected').data('nama'));
            });

            // Auto-fill payment details
            $('#spp-select').change(function() {
                var option = $(this).find('option:selected');
                $('#amount-input').val(option.data('nominal'));
                $('#year-input').val(option.data('year'));
                $('#semester-input').val(option.data('semester'));
            });

            // Trigger changes if old values exist
            @if(old('siswa_id')) $('#nisn-select').trigger('change'); @endif
            @if(old('spp_id')) $('#spp-select').trigger('change'); @endif
        });
    </script>
@endpush