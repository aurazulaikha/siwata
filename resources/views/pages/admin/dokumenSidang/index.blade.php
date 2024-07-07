@extends('layouts.main')
@section('title', 'Proposal TA Kaprodi')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Daftar TA</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-2">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NoBP</th>
                                        <th>Judul TA</th>
                                        <th>Proposal TA</th>
                                        <th>Laporan TA</th>
                                        <th>Pembimbing 1</th>
                                        <th>Pembimbing 2</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($dokumen_sidang as $dokumen)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $dokumen->mahasiswa->nama }}</td>
                                            <td>{{ $dokumen->mahasiswa->nobp }}</td>
                                            <td>{{ $dokumen->proposal_ta->judul }}</td>
                                            <td>
                                                <a href="{{ asset('data_file/' . $dokumen->proposal_ta->file) }}" target="_blank">download</a>
                                            </td>
                                            <td>
                                                <a href="{{ asset('data_file/' . $dokumen->laporan_ta) }}" target="_blank">download</a>
                                            </td>
                                            <td>
                                            {{ $dokumen->pembimbing1->nama }}
                                            </td>
                                            <td>
                                                {{ $dokumen->pembimbing2->nama }}
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
