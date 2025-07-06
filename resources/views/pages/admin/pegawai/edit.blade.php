@extends('layouts.app', ['title' => 'Edit Data Pegawai'])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Pegawai</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('pegawai.index') }}">Data Pegawai</a></div>
                    <div class="breadcrumb-item active">Edit Pegawai</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-12 col-lg-8 offset-lg-2">
                        <div class="card">
                            <div class="card-header">
                                <h4>Formulir Edit Pegawai</h4>
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

                                <form action="{{ route('pegawai.update', $data->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" value="{{ $data->id }}">

                                    <div class="row">
                                        <!-- Left Column -->
                                        <div class="col-md-12">
                                            <!-- Personal Information -->
                                            <div class="form-group">
                                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                                <input type="text" name="name" class="form-control"
                                                    value="{{ old('name', $data->name) }}" required>
                                            </div>

                                            <div class="form-group">
                                                <label>Username <span class="text-danger">*</span></label>
                                                <input type="text" name="username" class="form-control"
                                                    value="{{ old('username', $data->username) }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>NIP</label>
                                                <input type="text" name="nip" class="form-control"
                                                    value="{{ old('nip', $data->nip) }}">
                                            </div>

                                            <div class="form-group">
                                                <input type="hidden" name="role" class="form-control"
                                                    value="{{ old('role', $data->role) }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group text-center mt-4">
                                        <button type="submit" class="btn btn-primary btn-lg px-5">
                                            <i class="fas fa-save mr-2"></i> Simpan Perubahan
                                        </button>
                                        <a href="{{ route('pegawai.index') }}" class="btn btn-secondary btn-lg px-5 ml-2">
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
        // Format NIP input
        new Cleave('input[name="nip"]', {
            numericOnly: true,
            blocks: [18],
            delimiter: ' '
        });
    </script>
@endpush