@extends('layouts.main')
@section('title', 'Verifikasi Proposal')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Pendaftaran TA</h4>
                    </div>
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible show fade">
                            <div class="alert-body">
                                <button class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                                {{ $message }}
                            </div>
                        </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Laporan PKL</th>
                                    <th>Lembar Bimbingan</th>
                                    <th>Proposal TA</th>
                                    <th>Laporan TA</th>
                                    <th>Pembimbing 1</th>
                                    <th>Pembimbing 2</th>
                                    <th>Verifikasi</th>
                                    <th>Komentar</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dokumen_sidang as $dokumen)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $dokumen->mahasiswa->nama }}</td>
                                        <td>
                                            <a href="{{ asset('data_file/' . $dokumen->laporan_pkl) }}" target="_blank">download</a>
                                        </td>
                                        <td>
                                            <a href="{{ asset('data_file/' . $dokumen->lembar_bimbingan) }}" target="_blank">download</a>
                                        </td>
                                        <td>
                                            <a href="{{ asset('data_file/' . $dokumen->proposal_ta->file) }}" target="_blank">download</a>
                                        </td>
                                        <td>
                                            <a href="{{ asset('data_file/' . $dokumen->laporan_ta) }}" target="_blank">download</a>
                                        </td>
                                        <td>
                                            @if($dokumen->pem1)
                                                {{ $dokumen->pem1->status_dokumen == 1 ? 'Disetujui' : 'Belum disetujui' }}
                                            @else
                                                Belum ditentukan
                                            @endif
                                        </td>
                                        <td>
                                            @if($dokumen->pem2)
                                                {{ $dokumen->pem2->status_dokumen == 1 ? 'Disetujui' : 'Belum disetujui' }}
                                            @else
                                                Belum ditentukan
                                            @endif
                                        </td>
                                        <td>
                                            @if($dokumen)
                                                {{ $dokumen->verifikasi == 1 ? 'Sudah' : 'Belum' }}
                                            @else
                                                Belum ditentukan
                                            @endif
                                        </td>
                                        <td>{{ $dokumen->komentar }}</td>
                                        <td>
                                            @if($dokumen->pem1 && $dokumen->pem2 && $dokumen->pem1->status_dokumen == 1 && $dokumen->pem2->status_dokumen == 1)
                                            <div class="mb-2 mt-2">
                                                <form method="POST" action="{{ route('kaprodi.verifyDokumen', $dokumen->id) }}">
                                                    @csrf
                                                    <button class="btn btn-success btn-sm" type="submit">Verifikasi</button>
                                                </form>
                                            </div>
                                            @else
                                                <button class="btn btn-secondary btn-sm" disabled>Belum bisa diverifikasi</button>
                                            @endif
                                            <form method="POST" action="{{ route('dokumenSidang.commentKaprodi', $dokumen->id) }}">
                                                @csrf
                                                <div class="input-group mb-2">
                                                    <input type="text" name="komentar" class="form-control" value="Isi komentar" onfocus="if(this.value=='Isi komentar') this.value='';">
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-muted text-center">Data proposal belum tersedia</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
