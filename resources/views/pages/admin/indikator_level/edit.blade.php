@extends('layouts.app', ['title' => 'Edit Data Indikator Level'])

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    @endpush

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Data Indikator Level</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('indikator_level.index') }}">Indikator Level</a></div>
                    <div class="breadcrumb-item">Edit Data</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-12 col-lg-8 offset-lg-2">
                        <form action="{{ route('indikator_level.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input required type="hidden" name="id" value="{{ $data->id }}" class="form-control">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Form Edit Level Indikator</h4>
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

                                    <div class="form-group">
                                        <label>Indikator</label>
                                        <select name="indicator_id" class="form-control select2 @error('indicator_id') is-invalid @enderror" required>
                                            <option value="">-- Pilih Indikator --</option>
                                            @foreach($indicators as $indicator)
                                                <option value="{{ $indicator->id }}" 
                                                    {{ old('indicator_id', $data->indicator_id) == $indicator->id ? 'selected' : '' }}>
                                                    {{ $indicator->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('indicator_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Level (1-4)</label>
                                        <select name="score" class="form-control @error('score') is-invalid @enderror" required>
                                            <option value="">-- Pilih Level --</option>
                                            @for($i = 1; $i <= 4; $i++)
                                                <option value="{{ $i }}" 
                                                    {{ old('score', $data->score) == $i ? 'selected' : '' }}>
                                                    Level {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                        @error('score')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Deskripsi Perilaku</label>
                                        <textarea name="behavior_description" class="form-control @error('behavior_description') is-invalid @enderror" 
                                            rows="4" required>{{ old('behavior_description', $data->behavior_description) }}</textarea>
                                        @error('behavior_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    <a href="{{ route('indikator_level.index') }}" class="btn btn-secondary ml-2">Kembali</a>
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
        <script>
            $(document).ready(function() {
                $('.select2').select2();
            });
        </script>
    @endpush
@endsection