@extends('layouts.main')

@section('title', 'Edit Kaprodi')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        @foreach ($errors->all() as $error )
                        {{ $error }}
                        @endforeach
                    </div>
                </div>
                @endif
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Edit Kaprodi {{ $kaprodi->nama }}</h4>
                        <a href="{{ route('kaprodi.index') }}" class="btn btn-primary">Kembali</a>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('kaprodi.update', $kaprodi->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="nama">Nama Kaprodi</label>
                                <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="{{ __('Nama Kaprodi') }}" value="{{ $kaprodi->nama }}">
                            </div>
                            <div class="d-flex">
                                <div class="form-group">
                                    <label for="nidn">NIDN</label>
                                    <input type="text" id="nidn" name="nidn" class="form-control @error('nidn') is-invalid @enderror" placeholder="{{ __('NIDN Kaprodi') }}" value="{{ $kaprodi->nidn }}">
                                </div>
                                <div class="form-group ml-4">
                                    <label for="no_telp">No. Telp</label>
                                    <input type="text" id="no_telp" name="no_telp" class="form-control @error('no_telp') is-invalid @enderror" placeholder="{{ __('No. TElp Kaprodi') }}" value="{{ $kaprodi->no_telp }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror" placeholder="{{ __('Alamat') }}">{{ $kaprodi->alamat }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="prodi_id">Prodi</label>
                                <select id="prodi_id" name="prodi_id" class="select2bs4 form-control @error('prodi_id') is-invalid @enderror">
                                    <option value="">-- Pilih Prodi --</option>
                                    @foreach ($prodi as $data )
                                    <option value="{{ $data->id }}" @if ($kaprodi->prodi_id == $data->id)
                                        selected
                                        @endif
                                        >{{ $data->nama_prodi }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
