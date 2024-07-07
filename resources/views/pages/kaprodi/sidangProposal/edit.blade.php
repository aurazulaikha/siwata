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
                            <a href="{{ route('sidang_proposal.index') }}" class="btn btn-primary">Kembali</a>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('sidang_proposal.update', $jadwal->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="proposal_ta_id">Proposal</label>
                                    <select id="proposal_ta_id" name="proposal_ta_id" class="form-control @error('proposal_ta_id') is-invalid @enderror">
                                        <option value="">-- Pilih Proposal --</option>
                                        @foreach ($proposal_ta as $proposal )
                                        <option value="{{ $proposal->id }}" @if ($jadwal->proposal_ta_id == $proposal->id)
                                            selected
                                            @endif
                                            >{{ $proposal->mahasiswa->nama }} - {{ $proposal->judul }}</option>
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
                                <div class="form-group">
                                    <label for="pem1">Pembimbing 1</label>
                                    <input type="text" id="pem1_nama" name="pem1_nama" class="form-control @error('pem1_id') is-invalid @enderror" value="{{ $jadwal->pem1Nama->nama }}">
                                    <input type="hidden" id="pem1_id" name="pem1_id" value="{{ $jadwal->pem1_id }}">
                                </div>
                                <div class="form-group">
                                    <label for="pem2">Pembimbing 2</label>
                                    <input type="text" id="pem2_nama" name="pem2_nama" class="form-control @error('pem2_id') is-invalid @enderror" value="{{ $jadwal->pem2Nama->nama }}">
                                    <input type="hidden" id="pem2_id" name="pem2_id" value="{{ $jadwal->pem2_id }}">
                                </div>
                                <div class="form-group">
                                    <label for="penguji_id">Penguji</label>
                                    <select id="penguji_id" name="penguji_id" class="form-control @error('penguji_id') is-invalid @enderror">
                                        <option value="">-- Pilih Penguji --</option>
                                        @foreach ($dosens as $dosen)
                                            <option value="{{ $dosen->id }}" @if ($jadwal->penguji_id == $dosen->id) selected @endif>
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
