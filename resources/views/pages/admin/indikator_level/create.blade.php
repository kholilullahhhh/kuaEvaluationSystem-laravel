@extends('layouts.app', ['title' => 'Tambah Skor Kinerja'])

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
    @endpush

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Skor Kinerja</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('indikator_level.index') }}">Skor Kinerja</a></div>
                    <div class="breadcrumb-item">Tambah Data</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-12 col-lg-8 offset-lg-2">
                        <form action="{{ route('indikator_level.store') }}" method="POST">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h4>Form Tambah Skor Kinerja</h4>
                                </div>
                                <div class="card-body">
                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible show fade">
                                            <div class="alert-body">
                                                <button class="close" data-dismiss="alert">
                                                    <span>&times;</span>
                                                </button>
                                                <strong>Whoops!</strong> Terdapat kesalahan dalam input data.<br><br>
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="form-group">
                                        <label for="user_id">Pengguna</label>
                                        <select name="user_id" id="user_id" class="form-control select2 @error('user_id') is-invalid @enderror">
                                            <option value="">-- Pilih Pengguna (Opsional) --</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }} ({{ $user->email }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="indicator_id">Indikator <span class="text-danger">*</span></label>
                                        <select name="indicator_id" id="indicator_id" class="form-control select2 @error('indicator_id') is-invalid @enderror" required>
                                            <option value="">-- Pilih Indikator --</option>
                                            @foreach($indicators as $indicator)
                                                <option value="{{ $indicator->id }}" {{ old('indicator_id') == $indicator->id ? 'selected' : '' }}>
                                                    {{ $indicator->name }} (Skor: {{ $indicator->score }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('indicator_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="total_skor">Total Skor <span class="text-danger">*</span></label>
                                        <input type="number" name="total_skor" id="total_skor" class="form-control @error('total_skor') is-invalid @enderror" 
                                            value="{{ old('total_skor') }}" required min="1" max="100">
                                        @error('total_skor')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="persentase">Persentase <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="number" step="0.01" name="persentase" id="persentase" 
                                                class="form-control @error('persentase') is-invalid @enderror" 
                                                value="{{ old('persentase') }}" required min="0" max="100">
                                            <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                        @error('persentase')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="keterangan">Keterangan <span class="text-danger">*</span></label>
                                        <select name="keterangan" id="keterangan" class="form-control select2 @error('keterangan') is-invalid @enderror" required>
                                            <option value="">-- Pilih Keterangan --</option>
                                            <option value="Sempurna" {{ old('keterangan') == 'Sempurna' ? 'selected' : '' }}>Sempurna</option>
                                            <option value="Baik" {{ old('keterangan') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                            <option value="Cukup" {{ old('keterangan') == 'Cukup' ? 'selected' : '' }}>Cukup</option>
                                            <option value="Kurang" {{ old('keterangan') == 'Kurang' ? 'selected' : '' }}>Kurang</option>
                                        </select>
                                        @error('keterangan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Simpan
                                    </button>
                                    <a href="{{ route('indikator_level.index') }}" class="btn btn-warning ml-2">
                                        <i class="fas fa-arrow-left"></i> Kembali
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @push('scripts')
        <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                // Initialize select2
                $('.select2').select2({
                    width: '100%'
                });

                // Auto-calculate percentage when total score changes
                $('#total_skor').on('change', function() {
                    const totalScore = $(this).val();
                    if (totalScore) {
                        const percentage = (totalScore / 4) * 100;
                        $('#persentase').val(percentage.toFixed(2));
                        
                        // Auto-set keterangan based on score
                        if (totalScore >= 3.5) {
                            $('#keterangan').val('Sempurna').trigger('change');
                        } else if (totalScore >= 2.5) {
                            $('#keterangan').val('Baik').trigger('change');
                        } else if (totalScore >= 1.5) {
                            $('#keterangan').val('Cukup').trigger('change');
                        } else {
                            $('#keterangan').val('Kurang').trigger('change');
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection