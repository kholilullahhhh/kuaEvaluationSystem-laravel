@extends('layouts.app', ['title' => 'Edit Absensi'])
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    @endpush

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Data Absensi</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <form action="{{ route('absensi.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input required type="hidden" name="id" value="{{ $data->id }}" class="form-control">
                            
                            <div class="card">
                                <div class="card-header">
                                    <h4>Form Edit Absensi</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Agenda Rapat</label>
                                        <div class="col-sm-12 col-md-7">
                                            <select name="agenda_id" class="form-control select2" required>
                                                @foreach($agendas as $agenda)
                                                    <option value="{{ $agenda->id }}" {{ $data->agenda_id == $agenda->id ? 'selected' : '' }}>
                                                        {{ $agenda->judul }} ({{ $agenda->tgl_kegiatan }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pegawai</label>
                                        <div class="col-sm-12 col-md-7">
                                            <select name="user_id" class="form-control select2">
                                                <option value="">Pilih Pegawai (Opsional)</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}" {{ $data->user_id == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status Kehadiran</label>
                                        <div class="col-sm-12 col-md-7">
                                            <select name="status" class="form-control" required>
                                                <option value="hadir" {{ $data->status == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                                <option value="tidak hadir" {{ $data->status == 'tidak hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                                                <option value="izin" {{ $data->status == 'izin' ? 'selected' : '' }}>Izin</option>
                                                <option value="sakit" {{ $data->status == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                                <option value="terlambat" {{ $data->status == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Keterangan</label>
                                        <div class="col-sm-12 col-md-7">
                                            <textarea name="keterangan" class="form-control" placeholder="Tambahkan keterangan jika perlu">{{ $data->keterangan }}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                        <div class="col-sm-12 col-md-7">
                                            <button type="submit" class="btn btn-primary">Update Absensi</button>
                                            <a href="{{ route('absensi.index') }}" class="btn btn-warning">Kembali</a>
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
        <script>
            $(document).ready(function() {
                $('.select2').select2();
            });
        </script>
    @endpush
@endsection