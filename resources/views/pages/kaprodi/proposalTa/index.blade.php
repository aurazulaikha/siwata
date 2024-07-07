@extends('layouts.main')
@section('title', 'Verfikasi Proposal TA')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Verifikasi Proposal TA</h4>
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
                                        <th>Judul Proposal</th>
                                        <th>Pembimbing 1</th>
                                        <th>Pembimbing 2</th>
                                        <th>Verifikasi</th>
                                        <th>Komentar</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($proposal_ta as $proposal)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $proposal->mahasiswa->nama }}</td>
                                            <td>{{ $proposal->judul }}</td>
                                            <td>
                                                @if($proposal->pem1)
                                                    {{ $proposal->pem1->status == 1 ? 'Disetujui' : 'Belum disetujui' }}
                                                @else
                                                    Belum ditentukan
                                                @endif
                                            </td>
                                            <td>
                                                @if($proposal->pem2)
                                                    {{ $proposal->pem2->status == 1 ? 'Disetujui' : 'Belum disetujui' }}
                                                @else
                                                    Belum ditentukan
                                                @endif
                                            </td>
                                            <td>
                                                @if($proposal)
                                                    {{ $proposal->verifikasi == 1 ? 'Sudah' : 'Belum' }}
                                                @else
                                                    Belum ditentukan
                                                @endif
                                            </td>
                                            <td>{{ $proposal->komentar }}</td>
                                            <td>
                                                @if($proposal->pem1 && $proposal->pem2 && $proposal->pem1->status == 1 && $proposal->pem2->status == 1)
                                                <div class="mb-2 mt-2">
                                                    <form method="POST" action="{{ route('kaprodi.verifyProposal', $proposal->id) }}">
                                                        @csrf
                                                        <button class="btn btn-success btn-sm" type="submit">Verifikasi</button>
                                                    </form>
                                                </div>
                                                @else
                                                    <button class="btn btn-secondary btn-sm" disabled>Belum bisa diverifikasi</button>
                                                @endif
                                                <form method="POST" action="{{ route('proposalTa.commentKaprodi', $proposal->id) }}">
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
    </div>
</section>
@endsection
