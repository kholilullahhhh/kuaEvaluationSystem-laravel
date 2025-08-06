@extends('layouts.app', ['title' => 'Edit Data Indikator'])

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    @endpush

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Data Indikator</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('indikator.index') }}">Indikator</a></div>
                    <div class="breadcrumb-item">Edit Data</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-12 col-lg-8 offset-lg-2">
                        <form action="{{ route('indikator.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{ $data->id }}">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Form Edit Indikator</h4>
                                </div>
                                <div class="card-body">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="form-group row">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Indikator</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                                value="{{ old('name', $data->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Deskripsi</label>
                                        <div class="col-sm-12 col-md-7">
                                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                                rows="3">{{ old('description', $data->description) }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    <a href="{{ route('indikator.index') }}" class="btn btn-secondary ml-2">Kembali</a>
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
        <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                // Initialize any select2 or selectric if needed
            });
        </script>
    @endpush
@endsection