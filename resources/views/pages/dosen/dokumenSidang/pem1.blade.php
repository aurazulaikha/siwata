@extends('layouts.main')
@section('title', 'Verifikasi Dokumen')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Verifikasi Dokumen Pendaftaran Sidang TA</h4>
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

                                        <th>Nama</th>
                                        <th>Laporan TA</th>
                                        <th>Laporan PKL</th>
                                        <th>Lembar Bimbingan</th>
                                        <th>Proposal TA</th>
                                        <th>Status</th>
                                        <th>Komentar</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($dokumen_sidang as $dokumen)
                                        <tr>
                                            <td>{{ $dokumen->mahasiswa->nama }}</td>
                                            <td>
                                                <a href="{{ asset('data_file/' . $dokumen->proposal_ta->file) }}" target="_blank">Download</a>
                                            </td>
                                            <td>
                                                <a href="{{ asset('data_file/' . $dokumen->laporan_pkl) }}" target="_blank">Download</a>
                                            </td>
                                            <td>
                                                <a href="{{ asset('data_file/' . $dokumen->lembar_bimbingan) }}" target="_blank">Download</a>
                                            </td>

                                            <td>
                                                <a href="{{ asset('data_file/' . $dokumen->laporan_ta) }}" target="_blank">Download</a>
                                            </td>
                                            <td>
                                                @if($dokumen->pem1 && $dokumen->pem1->dosen_id == $dosen->id && $dokumen->pem1->status_dokumen)
                                                    @if($dokumen->pem1->status_dokumen == 1)
                                                        <span>Disetujui</span>
                                                    @else
                                                        <span>Belum Disetujui</span>
                                                    @endif
                                                @else
                                                    <span>Belum Disetujui</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $dokumen->pem1->komentar_dokumen }}</>
                                            </td>
                                            <td>
                                                @if($dokumen->pem1 && $dokumen->pem1->dosen_id == $dosen->id && $dokumen->pem1->status_dokumen)
                                                <div class="mb-2 mt-2">
                                                <span class="badge badge-success">Disetujui</span>
                                                </div>
                                                @else
                                                <div class="mb-2">
                                                    <form method="POST" action="{{ route('dokumenSidang.status1', $dokumen->id) }}" class="mb-2 mt-2">
                                                        @csrf
                                                        <button class="btn btn-danger btn-sm" type="submit">Setujui</button>
                                                    </form>
                                                </div>
                                                @endif
                                                <form method="POST" action="{{ route('dokumenSidang.comment', $dokumen->id) }}">
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
                                            <td colspan="6" class="text-muted text-center">Data proposal belum tersedia</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
