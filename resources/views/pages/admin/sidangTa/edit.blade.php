@extends('layouts.main')
@section('title', 'Edit Jadwal')

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
                            <h4>Edit Jadwal</h4>
                            <a href="{{ route('jadwalTa.IndexForAdmin') }}" class="btn btn-primary">Kembali</a>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('jadwalTa.updateAdmin', $jadwal->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="dokumen_sidang_id">TA</label>
                                    <select id="dokumen_sidang_id" name="dokumen_sidang_id" class="form-control @error('dokumen_sidang_id') is-invalid @enderror">
                                        <option value="">-- Pilih TA --</option>
                                        @foreach ($dokumen_sidang as $dokumen )

                                        <option value="{{ $dokumen->id }}" @if ($jadwal->dokumen_sidang_id == $dokumen->id)
                                            selected
                                            @endif
                                            >{{ $dokumen->mahasiswa->nama }} - {{ $dokumen->proposal_ta->judul }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" id="tanggal" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ $jadwal->tanggal }}">
                                </div>
                                <div class="form-group">
                                    <label for="ruangan">Ruangan</label>
                                    <select id="ruangan" name="ruangan" class="form-control @error('ruangan') is-invalid @enderror">
                                        <option value="">-- Pilih Ruangan --</option>
                                        @foreach ($ruangans as $data )
                                        <option value="{{ $data->id }}" @if ($jadwal->ruangan == $data->id)
                                            selected
                                            @endif
                                            >{{ $data->nama_ruangan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="sesi">Sesi</label>
                                    <select id="sesi" name="sesi" class="form-control @error('sesi') is-invalid @enderror">
                                        <option value="">-- Pilih Sesi --</option>
                                        @foreach ($sesis as $data )
                                        <option value="{{ $data->id }}" @if ($jadwal->sesi == $data->id)
                                            selected
                                            @endif
                                            >{{ $data->id }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <h8>Pembimbing 1: {{ $dokumen->pem1->dosen->nama }}</span></h8>
                                </div>
                                <div>
                                    <h8>Pembimbing 2: {{ $dokumen->pem2->dosen->nama }}</span></h8>
                                </div>
                                <div class="form-group">
                                    <label for="ketua_id">Ketua</label>
                                    <select id="ketua_id" name="ketua_id" class="form-control @error('ketua') is-invalid @enderror">
                                        <option value="">-- Pilih Ketua --</option>
                                        @foreach ($dosens as $dosen)
                                            <option value="{{ $dosen->id }}" @if ($jadwal->ketua_id == $dosen->id) selected @endif>
                                                {{ $dosen->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="sekretaris_id">Sekretaris</label>
                                    <select id="sekretaris_id" name="sekretaris_id" class="form-control @error('sekretaris') is-invalid @enderror">
                                        <option value="">-- Pilih Sekretaris --</option>
                                        @foreach ($dosens as $dosen)
                                            <option value="{{ $dosen->id }}" @if ($jadwal->sekretaris_id == $dosen->id) selected @endif>
                                                {{ $dosen->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="penguji1_id">Penguji 1</label>
                                    <select id="penguji1_id" name="penguji1_id" class="form-control @error('penguji1') is-invalid @enderror">
                                        <option value="">-- Pilih Penguji 1 --</option>
                                        @foreach ($dosens as $dosen)
                                            <option value="{{ $dosen->id }}" @if ($jadwal->penguji1_id == $dosen->id) selected @endif>
                                                {{ $dosen->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="penguji2_id">Penguji 2</label>
                                    <select id="penguji2_id" name="penguji2_id" class="form-control @error('penguji2') is-invalid @enderror">
                                        <option value="">-- Pilih Penguji 2 --</option>
                                        @foreach ($dosens as $dosen)
                                            <option value="{{ $dosen->id }}" @if ($jadwal->penguji2_id == $dosen->id) selected @endif>
                                                {{ $dosen->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

