@extends('layouts.app', ['title' => 'Isi Absensi Rapat'])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Isi Absensi Rapat</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('user.absensi.index') }}">Absensi</a></div>
                    <div class="breadcrumb-item">Isi Absensi</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Form Absensi Rapat</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('user.absensi.store') }}" method="POST">
                                    @csrf

                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Agenda
                                            Rapat</label>
                                        <div class="col-sm-12 col-md-7">
                                            <select name="agenda_id"
                                                class="form-control select2 @error('agenda_id') is-invalid @enderror"
                                                required>
                                                <option value="">Pilih Agenda</option>
                                                @foreach($agendas as $agenda)
                                                    <option value="{{ $agenda->id }}" {{ old('agenda_id') == $agenda->id ? 'selected' : '' }}>
                                                        {{ $agenda->judul }} ({{ $agenda->tgl_kegiatan }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('agenda_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status
                                            Kehadiran</label>
                                        <div class="col-sm-12 col-md-7">
                                            <select name="status" class="form-control @error('status') is-invalid @enderror"
                                                required>
                                                <option value="">Pilih Status</option>
                                                <option value="hadir" {{ old('status') == 'hadir' ? 'selected' : '' }}>Hadir
                                                </option>
                                                <option value="tidak hadir" {{ old('status') == 'tidak hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                                                <option value="izin" {{ old('status') == 'izin' ? 'selected' : '' }}>Izin
                                                </option>
                                                <option value="sakit" {{ old('status') == 'sakit' ? 'selected' : '' }}>Sakit
                                                </option>
                                                <option value="terlambat" {{ old('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label
                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Keterangan</label>
                                        <div class="col-sm-12 col-md-7">
                                            <textarea class="form-control @error('keterangan') is-invalid @enderror"
                                                name="keterangan" rows="3"
                                                placeholder="Isi keterangan jika diperlukan">{{ old('keterangan') }}</textarea>
                                            @error('keterangan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                        <div class="col-sm-12 col-md-7">
                                            <button type="submit" class="btn btn-primary">Simpan Absensi</button>
                                            <a href="{{ route('user.absensi.index') }}"
                                                class="btn btn-secondary ml-2">Batal</a>
                                        </div>
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

@push('css')
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@push('js')
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
@endpush