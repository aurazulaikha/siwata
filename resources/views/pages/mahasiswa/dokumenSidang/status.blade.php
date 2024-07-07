@extends('layouts.main')
@section('title', 'Status Proposal TA')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Status Dokumen</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                                <table class="table table-striped" id="table-2">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Judul TA</th>
                                        <th>Pembimbing 1</th>
                                        <th>Pembimbing 2</th>
                                        <th>Kaprodi</th>
                                        <th>Komentar</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($dokumen_sidang as $dokumen)
                                        <tr>
                                            <td>{{ $dokumen->mahasiswa->nama }}</td>
                                            <td>{{ $dokumen->proposal_ta->judul }}</td>
                                            <td>
                                                @if($dokumen->pem1)
                                                    @if($dokumen->pem1->status_dokumen == 1)
                                                        <span>Disetujui</span>
                                                    @else
                                                        <span>Belum disetujui</span>
                                                    @endif
                                                @else
                                                Belum disetujui
                                                @endif
                                            </td>
                                            <td>
                                                @if($dokumen->pem2)
                                                    @if($dokumen->pem2->status_dokumen == 1)
                                                        <span>Disetujui</span>
                                                    @else
                                                        <span>Belum disetujui</span>
                                                    @endif
                                                @else
                                                Belum disetujui
                                                @endif
                                            </td>
                                            <td>
                                                @if($dokumen)
                                                    @if($dokumen->verifikasi == 1)
                                                        <span>Sudah Diverifikasi</span>
                                                    @else
                                                        <span>Belum Diverifikasi</span>
                                                    @endif
                                                @else
                                                Belum Diverifikasi
                                                @endif
                                            </td>
                                            <td>
                                                <div style="margin: 5px ">
                                                    <span><strong>Pembimbing 1 : </strong> {{ $dokumen->pem1->komentar_dokumen ?? 'Tidak ada komentar' }}</span>
                                                </div>
                                                <div style="margin: 5px;">
                                                    <span><strong>Pembimbing 2 : </strong> {{ $dokumen->pem2->komentar_dokumen ?? 'Tidak ada komentar' }}</span>
                                                </div>
                                                <div style="margin: 5px;">
                                                    <span><strong>Kaprodi : </strong> {{ $dokumen->komentar ?? 'Tidak ada komentar' }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-muted text-center">Data proposal belum tersedia</td>
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
