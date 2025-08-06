@extends('layouts.app', ['title' => 'Tambah Data Indikator Level'])

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    @endpush

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Data Indikator Level</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('indikator_level.index') }}">Indikator Level</a></div>
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
                                    <h4>Form Tambah Indikator Level</h4>
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
                                        <select name="indicator_id" class="form-control select2" required>
                                            <option value="">-- Pilih Indikator --</option>
                                            @foreach($indicators as $indicator)
                                                <option value="{{ $indicator->id }}" {{ old('indicator_id') == $indicator->id ? 'selected' : '' }}>
                                                    {{ $indicator->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Score (1-4)</label>
                                        <select name="score" class="form-control selectric" required>
                                            <option value="">-- Pilih Score --</option>
                                            @for($i = 1; $i <= 4; $i++)
                                                <option value="{{ $i }}" {{ old('score') == $i ? 'selected' : '' }}>
                                                    Level {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Deskripsi Perilaku</label>
                                        <textarea name="behavior_description" class="form-control" rows="4" required
                                            placeholder="Masukkan deskripsi perilaku untuk level ini">{{ old('behavior_description') }}</textarea>
                                    </div>
                                </div>

                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('indikator_level.index') }}" class="btn btn-warning ml-2">Kembali</a>
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
                $('.select2').select2();
                $('.selectric').selectric();
            });
        </script>
    @endpush
@endsection