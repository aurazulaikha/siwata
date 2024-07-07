@extends('layouts.main')
@section('title', 'Status Proposal TA')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card rounded">
                    <div class="card-body">
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Judul Proposal</th>
                                    <th>Pembimbing 1</th>
                                    <th>Pembimbing 2</th>
                                    <th>Kaprodi</th>
                                    <th>Komentar</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($proposal_ta as $proposal)
                                    <tr>
                                        <td>{{ $proposal->mahasiswa->nama }}</td>
                                        <td>{{ $proposal->judul }}</td>
                                        <td>
                                            @if($proposal->pem1)
                                                @if($proposal->pem1->status == 1)
                                                    <span>Disetujui</span>
                                                @else
                                                    <span>Belum disetujui</span>
                                                @endif
                                            @else
                                            Belum disetujui
                                            @endif
                                        </td>
                                        <td>
                                            @if($proposal->pem2)
                                                @if($proposal->pem2->status == 1)
                                                    <span>Disetujui</span>
                                                @else
                                                    <span>Belum disetujui</span>
                                                @endif
                                            @else
                                            Belum disetujui
                                            @endif
                                        </td>
                                        <td>
                                            @if($proposal)
                                                @if($proposal->verifikasi == 1)
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
                                                <span>Pembimbing 1 : {{ $proposal->pem1->komentar ?? 'Tidak ada komentar' }}</span>
                                            </div>
                                            <div style="margin: 5px;">
                                                <span>Pembimbing 2 : {{ $proposal->pem2->komentar ?? 'Tidak ada komentar' }}</span>
                                            </div>
                                            <div style="margin: 5px;">
                                                <span>Kaprodi : {{ $proposal->komentar ?? 'Tidak ada komentar' }}</span>
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
</section>
@endsection
