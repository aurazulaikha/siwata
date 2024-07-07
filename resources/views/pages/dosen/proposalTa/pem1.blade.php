@extends('layouts.main')
@section('title', 'Proposal TA Dosen')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Verifikasi Proposal</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-2">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Judul Proposal</th>
                                    <th>File</th>
                                    <th>Status</th>
                                    <th>Komentar</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($proposal_ta as $proposal)
                                    <tr>
                                        <td>{{ $proposal->mahasiswa->nama }}</td>
                                        <td>{{ $proposal->judul }}</td>
                                        <td>
                                            <a href="{{ asset('data_file/' . $proposal->file) }}" target="_blank">{{ $proposal->file }}</a>
                                        </td>
                                        <td>
                                            @if($proposal->pem1 && $proposal->pem1->dosen_id == $dosen->id && $proposal->pem1->status)
                                                @if($proposal->pem1->status == 1)
                                                    <span>Disetujui</span>
                                                @else
                                                    <span>Belum Disetujui</span>
                                                @endif
                                            @else
                                                <span>Belum Disetujui</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $proposal->pem1->komentar }}</>
                                        </td>
                                        <td>
                                            @if($proposal->pem1 && $proposal->pem1->dosen_id == $dosen->id && $proposal->pem1->status)
                                            <div class="mb-2 mt-2">
                                            <span class="badge badge-success">Disetujui</span>
                                            </div>
                                            @else
                                            <div class="mb-2">
                                                <form method="POST" action="{{ route('proposalTa.status1', $proposal->id) }}" class="mb-2 mt-2">
                                                    @csrf
                                                    <button class="btn btn-danger btn-sm" type="submit">Setujui</button>
                                                </form>
                                            </div>
                                            @endif
                                            <form method="POST" action="{{ route('proposalTa.comment', $proposal->id) }}">
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
