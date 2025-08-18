@extends('layouts.app', ['title' => 'Tambah Absensi'])
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
        <style>
                    .image-preview {
                        width: 100%;
                        height: 200px;
                        border: 2px dashed #ddd;
                        border-radius: 5px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        overflow: hidden;
                        position: relative;
                        background-color: #f8f9fa;
                        transition: all 0.3s ease;
                    }
                    .image-preview:hover {
                        border-color: #6777ef;
                    }
                    #image-label {
                        cursor: pointer;
                        color: #6777ef;
                        font-weight: 600;
                    }
                    .image-preview img {
                        max-width: 100%;
                        max-height: 100%;
                        display: none;
                    }
                    .form-section {
                        background-color: #fff;
                        border-radius: 8px;
                        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
                        margin-bottom: 30px;
                    }
                    .form-header {
                        border-bottom: 1px solid #f0f0f0;
                        padding: 15px 20px;
                        background-color: #f8f9fa;
                        border-radius: 8px 8px 0 0;
                    }
                    .form-body {
                        padding: 20px;
                    }
                    .required-field::after {
                        content: " *";
                        color: #ff0000;
                    }
                </style>
    @endpush

        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Tambah Data Absensi</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                        <div class="breadcrumb-item"><a href="{{ route('absensi.index') }}">Absensi</a></div>
                        <div class="breadcrumb-item active">Tambah Data</div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="{{ route('absensi.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card form-section">
                                    <div class="form-body">
                                        <!-- Agenda Rapat -->
                                        <div class="form-group row mb-4">
                                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3 required-field">Agenda Rapat</label>
                                            <div class="col-sm-12 col-md-7">
                                                <select name="agenda_id" class="form-control select2" required>
                                                    <option value="">Pilih Agenda Rapat</option>
                                                    @foreach($agendas as $agenda)
                                                        <option value="{{ $agenda->id }}" {{ old('agenda_id') == $agenda->id ? 'selected' : '' }}>
                                                            {{ $agenda->judul }} ({{ \Carbon\Carbon::parse($agenda->tgl_kegiatan)->format('d/m/Y H:i') }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('agenda_id')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Pegawai -->
                                        <div class="form-group row mb-4">
                                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pegawai</label>
                                            <div class="col-sm-12 col-md-7">
                                                <select name="user_id" class="form-control select2">
                                                    <option value="">Pilih Pegawai (Opsional)</option>
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                            {{ $user->name }} (NIP: {{ $user->nip ?? '-' }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <small class="text-muted">Biarkan kosong jika absensi untuk diri sendiri</small>
                                            </div>
                                        </div>

                                        <!-- Status Kehadiran -->
                                        <div class="form-group row mb-4">
                                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3 required-field">Status Kehadiran</label>
                                            <div class="col-sm-12 col-md-7">
                                                <select name="status" class="form-control" required>
                                                    <option value="">Pilih Status Kehadiran</option>
                                                    <option value="hadir" {{ old('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                                    <option value="tidak hadir" {{ old('status') == 'tidak hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                                                    <option value="izin" {{ old('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                                                    <option value="sakit" {{ old('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                                    <option value="terlambat" {{ old('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                                                </select>
                                                @error('status')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Keterangan -->
                                        <div class="form-group row mb-4">
                                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Keterangan</label>
                                            <div class="col-sm-12 col-md-7">
                                                <textarea name="keterangan" class="form-control" rows="3" placeholder="Tambahkan keterangan jika perlu">{{ old('keterangan') }}</textarea>
                                                <small class="text-muted">Wajib diisi jika status Izin/Sakit/Terlambat</small>
                                            </div>
                                        </div>

                                        <!-- Dokumentasi -->
                                        <div class="form-group row mb-4">
                                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3 required-field">Dokumentasi</label>
                                            <div class="col-sm-12 col-md-7">
                                                <div id="image-preview" class="image-preview">
                                                    <label for="image-upload" id="image-label">Pilih Gambar Dokumentasi</label>
                                                    <input type="file" name="dokumentasi" id="image-upload" accept="image/*" required />
                                                    <img id="image-preview-img" src="#" alt="Preview" style="display:none;"/>
                                                </div>
                                                <small class="text-muted">Format: JPG, PNG, JPEG (Maks. 2MB)</small>
                                                @error('dokumentasi')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Laporan -->
                                        <div class="form-group row mb-4">
                                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Laporan (PDF)</label>
                                            <div class="col-sm-12 col-md-7">
                                                <div class="custom-file">
                                                    <input type="file" name="laporan" id="laporan" class="custom-file-input" accept="application/pdf">
                                                    <label class="custom-file-label" for="laporan">Pilih file laporan</label>
                                                </div>
                                                <small class="text-muted">Format: PDF (Maks. 5MB)</small>
                                                @error('laporan')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="form-group row mb-4">
                                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                            <div class="col-sm-12 col-md-7">
                                                <button type="submit" class="btn btn-primary btn-icon icon-left">
                                                    <i class="fas fa-save"></i> Simpan Absensi
                                                </button>
                                                <a href="{{ route('absensi.index') }}" class="btn btn-warning btn-icon icon-left">
                                                    <i class="fas fa-arrow-left"></i> Kembali
                                                </a>
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
            <script src="{{ asset('library/bs-custom-file-input/dist/bs-custom-file-input.min.js') }}"></script>
            <script>
                $(document).ready(function() {
                    // Initialize Select2
                    $('.select2').select2({
                        placeholder: 'Pilih opsi',
                        allowClear: true
                    });

                    // Initialize custom file input
                    bsCustomFileInput.init();

                    // Image preview functionality
                    function readURL(input) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();

                            reader.onload = function(e) {
                                $('#image-preview-img').attr('src', e.target.result);
                                $('#image-preview-img').show();
                                $('#image-label').hide();
                            }

                            reader.readAsDataURL(input.files[0]);
                        }
                    }

                    $("#image-upload").change(function() {
                        readURL(this);
                    });

                    // Show required field indicator
                    $('select[required]').on('change', function() {
                        if ($(this).val()) {
                            $(this).removeClass('is-invalid').addClass('is-valid');
                        } else {
                            $(this).removeClass('is-valid').addClass('is-invalid');
                        }
                    });
                });
            </script>
        @endpush
@endsection