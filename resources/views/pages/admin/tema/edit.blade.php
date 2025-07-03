@extends('layouts.app', ['title' => 'Ubah Tema'])
@section('content')
@push('styles')
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Ubah Tema</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <form action="{{ route('tema.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input required type="hidden" name="id" value="{{ $data->id }}" class="form-control">
                        <div class="card">
                            <div class="card-header">
                                <h4>Form Ubah Tema</h4>
                            </div>
                            <div class="card-body">

                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Modul</label>
                                    <div class="col-sm-12 col-md-7">
                                        <select name="modul_id" class="form-control select2" >
                                            <option value="" disabled>Pilih Modul</option>
                                            @foreach($modul as $md)
                                                <option value="{{ $md->id }}" {{ $md->id == $md->modul_id ? 'selected' : '' }}>{{ $md->judul }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Tema</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" name="nama" class="form-control" value="{{ $data->nama }}" required>
                                    </div>
                                </div>

                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Deskripsi</label>
                                    <div class="col-sm-12 col-md-7">
                                        <textarea name="deskripsi" class="summernote">{!! $data->deskripsi !!}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Gambar</label>
                                    <div class="col-sm-6 col-md-4">
                                        <input type="file" name="gambar" class="form-control-file">
                                        <input type="hidden" name="gambar_old" value="{{ $data->gambar }}">
                                    </div>
                                    <div class="col-sm-6 col-md-4 mt-3">
                                        @if($data->gambar)
                                            <img src="{{ asset('upload/tema/' . $data->gambar) }}" class="img-fluid" width="250">
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status</label>
                                        <div class="col-sm-6 col-md-4">
                                            <select class="form-control selectric" name="status" required>
                                                <option {{ $data->status == 'publish' ? 'selected' : '' }}
                                                    value="publish">Publish</option>
                                                <option {{ $data->status == 'pending' ? 'selected' : '' }}
                                                    value="pending">Pending</option>
                                            </select>
                                        </div>
                                    </div>

                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                    <div class="col-sm-12 col-md-7">
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        <a href="{{ route('tema.index') }}" class="btn btn-warning">Kembali</a>
                                    </div>
                                </div>
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
    <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
@endpush
@endsection
