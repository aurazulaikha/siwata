@extends('layouts.main')
@section('title', 'List Jadwal')

@push('style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
@endpush

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>List Jadwal</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-2">
                                <thead>
                                    <tr>
                                        <tr>
                                            <th>No</th>
                                            <th>Proposal</th>
                                            <th>Mahasiswa</th>
                                            <th>Tanggal</th>
                                            <th>Ruangan</th>
                                            <th>Sesi</th>
                                            <th>Pembimbing 1</th>
                                            <th>Pembimbing 2</th>
                                            <th>Penguji</th>
                                        </tr>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jadwals as $jadwal)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $jadwal->proposal->judul }}</td>
                                            <td>{{ $jadwal->mahasiswa->nama }}</td>
                                            <td>{{ $jadwal->tanggal }}</td>
                                            <td>{{ $jadwal->ruang->nama_ruangan }}</td>
                                            <td>{{ $jadwal->sesi }}</td>
                                            <td>{{ $jadwal->pem1Nama->nama }}</td>
                                            <td>{{ $jadwal->pem2Nama->nama }}</td>
                                            <td>{{ $jadwal->penguji->nama }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
