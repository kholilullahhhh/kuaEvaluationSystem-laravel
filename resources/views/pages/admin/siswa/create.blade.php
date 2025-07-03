@extends('layouts.app', ['title' => 'Tambah Data Siswa'])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Siswa</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('siswa.index') }}">Data Siswa</a></div>
                    <div class="breadcrumb-item active">Tambah Siswa</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Formulir Pendaftaran Siswa</h4>
                            </div>
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible show fade">
                                        <div class="alert-body">
                                            <button class="close" data-dismiss="alert">
                                                <span>&times;</span>
                                            </button>
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif

                                <form action="{{ route('siswa.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="role" value="siswa">
                                    
                                    <div class="row">
                                        <!-- Left Column -->
                                        <div class="col-md-6">
                                            <!-- Personal Information -->
                                            <div class="form-group">
                                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                                <input type="text" name="name" class="form-control" 
                                                    value="{{ old('name') }}" required>
                                            </div>

                                            <div class="form-group">
                                                <label>Username <span class="text-danger">*</span></label>
                                                <input type="text" name="username" class="form-control" 
                                                    value="{{ old('username') }}" required>
                                            </div>

                                            <div class="form-group">
                                                <label>Password <span class="text-danger">*</span></label>
                                                <input type="password" name="password" class="form-control" required>
                                            </div>

                                            <div class="form-group">
                                                <label>Kelas <span class="text-danger">*</span></label>
                                                <select class="form-control" name="class_id" required>
                                                    <option value="">Pilih Kelas</option>
                                                    @foreach ($kelas as $item)
                                                        <option value="{{ $item->id }}" {{ old('class_id') == $item->id ? 'selected' : '' }}>
                                                            {{ $item->name }} - {{ $item->jurusan }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <!-- School Information -->
                                            <div class="form-group">
                                                <label>NISN <span class="text-danger">*</span></label>
                                                <input type="text" name="nisn" class="form-control" 
                                                    value="{{ old('nisn') }}" required>
                                            </div>

                                            <div class="form-group">
                                                <label>NIS <span class="text-danger">*</span></label>
                                                <input type="text" name="nis" class="form-control" 
                                                    value="{{ old('nis') }}" required>
                                            </div>

                                            <div class="form-group">
                                                <label>Nomor HP</label>
                                                <input type="number" name="no_hp" class="form-control" 
                                                    value="{{ old('no_hp') }}">
                                            </div>

                                            <div class="form-group">
                                                <label>Alamat <span class="text-danger">*</span></label>
                                                <textarea name="address" class="form-control" rows="3" required>{{ old('address') }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group text-center mt-4">
                                        <button type="submit" class="btn btn-primary btn-lg px-5">
                                            <i class="fas fa-save mr-2"></i> Simpan Data
                                        </button>
                                        <a href="{{ route('siswa.index') }}" class="btn btn-secondary btn-lg px-5 ml-2">
                                            <i class="fas fa-arrow-left mr-2"></i> Kembali
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

@push('scripts')
    <script src="{{ asset('library/cleave.js/dist/cleave.min.js') }}"></script>
    <script>
        // Format NISN input
        new Cleave('input[name="nisn"]', {
            numericOnly: true,
            blocks: [10],
            delimiter: ' '
        });

        // Format NIS input
        new Cleave('input[name="nis"]', {
            numericOnly: true,
            blocks: [8],
            delimiter: ' '
        });

        // Format phone number input
        new Cleave('input[name="no_hp"]', {
            phone: true,
            phoneRegionCode: 'ID'
        });
    </script>
@endpush