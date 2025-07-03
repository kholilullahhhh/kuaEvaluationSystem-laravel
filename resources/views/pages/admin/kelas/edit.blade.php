@extends('layouts.app', ['title' => 'Edit Data Kelas'])

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    @endpush

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Data Kelas</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('kelas.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input required type="hidden" name="id" value="{{ $data->id }}" class="form-control">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="col-form-label col-md-3">Nama</label>
                                        <div class="col-md-7">
                                            <input required type="text" name="name" class="form-control"
                                                value="{{ old('name', $data->name) }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label col-md-3">Nama</label>
                                        <div class="col-md-7">
                                            <input required type="text" name="jurusan" class="form-control"
                                                value="{{ old('jurusan', $data->jurusan) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    <a href="{{ route('kelas.index') }}" class="btn btn-secondary">Kembali</a>
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