@extends('layouts.app', ['title' => 'Edit Data SPP'])

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    @endpush

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Data SPP</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('spp.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input required type="hidden" name="id" value="{{ $data->id }}" class="form-control">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="tahun">Tahun</label>
                                        <input type="number" name="year" id="year"
                                            value="{{ old('tahun', $data->tahun) }}"
                                            class="form-control @error('year') is-invalid @enderror">
                                        @error('year')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="semester">Semester</label>
                                        <select name="semester" id="semester"
                                            class="form-control @error('semester') is-invalid @enderror">
                                            <option value="">-- Pilih Semester --</option>
                                            <option value="ganjil" {{ old('semester', $data->semester) == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                                            <option value="genap" {{ old('semester', $data->semester) == 'genap' ? 'selected' : '' }}>Genap</option>
                                        </select>
                                        @error('semester')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="nominal">Nominal</label>
                                        <input type="number" name="nominal" id="nominal"
                                            value="{{ old('nominal', $data->nominal) }}"
                                            class="form-control @error('nominal') is-invalid @enderror">
                                        @error('nominal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    <a href="{{ route('spp.index') }}" class="btn btn-secondary">Kembali</a>
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
            $(document).ready(function () {
                $('.select2').select2();
            });
        </script>
    @endpush
@endsection