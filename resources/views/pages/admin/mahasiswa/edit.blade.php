@extends('layouts.main')
@section('title', 'Edit Mahasiswa')

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
                            <h4>Edit Mahasiswa {{ $mahasiswa->nama }}</h4>
                            <a href="{{ route('mahasiswa.index') }}" class="btn btn-primary">Kembali</a>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('mahasiswa.update', $mahasiswa->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="nama">Nama mahasiswa</label>
                                    <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="{{ __('Nama Mahasiswa') }}" value="{{ $mahasiswa->nama }}">
                                </div>
                                <div class="d-flex">
                                    <div class="form-group">
                                        <label for="nobp">NOBP</label>
                                        <input type="text" id="nobp" name="nobp" class="form-control @error('nobp') is-invalid @enderror" placeholder="{{ __('NOBP Mahasiswa') }}" value="{{ $mahasiswa->nobp }}">
                                    </div>
                                    <div class="form-group ml-4">
                                        <label for="telp">No. Telp</label>
                                        <input type="text" id="telp" name="telp" class="form-control @error('telp') is-invalid @enderror" placeholder="{{ __('No. TElp Mahasiswa') }}" value="{{ $mahasiswa->telp }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="prodi_id">Prodi</label>
                                    <select id="prodi_id" name="prodi_id" class="select2 form-control @error('prodi_id') is-invalid @enderror">
                                        <option value="">-- Pilih Prodi --</option>
                                        @foreach ($prodi as $data )
                                        <option value="{{ $data->id }}" @if ($mahasiswa->prodi_id == $data->id)
                                            selected
                                            @endif
                                            >{{ $data->nama_prodi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror" placeholder="{{ __('Alamat') }}">{{ $mahasiswa->alamat }}</textarea>
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
