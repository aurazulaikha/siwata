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

                                            <th>No</th>
                                            <th>Mahasiswa</th>
                                            <th>TA</th>
                                            <th>Tanggal</th>
                                            <th>Ruangan</th>
                                            <th>Sesi</th>
                                            <th>Ketua</th>
                                            <th>Sekretaris</th>
                                            <th>Penguji 1</th>
                                            <th>Penguji 2</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jadwals as $jadwal)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $jadwal->mahasiswa->nama }}</td>
                                            <td>{{ $jadwal->dokumen_sidang->proposal_ta->judul }}</td>
                                            <td>{{ $jadwal->tanggal }}</td>
                                            <td>{{ $jadwal->ruang->nama_ruangan }}</td>
                                            <td>{{ $jadwal->sesi }}</td>
                                            <td>{{ $jadwal->ketuaNama->nama }}</td>
                                            <td>{{ $jadwal->sekretarisNama->nama }}</td>
                                            <td>{{ $jadwal->penguji1->nama }}</td>
                                            <td>{{ $jadwal->penguji2->nama }}</td>
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
