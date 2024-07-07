@extends('layouts.main')
@section('title', 'Nilai Pembimbing 2')

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
                        <h4>Nilai Pembimbing 2</h4>
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
                                <!-- Table headers -->
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Mahasiswa</th>
                                        <th>NoBP</th>
                                        <th>TA</th>
                                        <th>Action</th> <!-- Add Action column for inputting nilai -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jadwals as $jadwal)
                                        <tr>
                                            <!-- Table data -->
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $jadwal->mahasiswa->nama }}</td>
                                            <td>{{ $jadwal->mahasiswa->nobp }}</td>
                                            <td>{{ $jadwal->dokumen_sidang->proposal_ta->judul }}</td>
                                            <td>
                                                <a href="{{ route('nilaiTa.pembimbing2', $jadwal->id) }}" class="btn btn-success btn-sm">
                                                    <i class="nav-icon fas fa-edit"></i> &nbsp;Lihat Nilai
                                                </a>
                                                @if(
                                                    is_null($jadwal->nilaiPembimbing2) ||
                                                    $jadwal->nilaiPembimbing2->isEmpty() ||
                                                    $jadwal->nilaiPembimbing2->contains(function ($item) {
                                                        return is_null($item->b1) ||
                                                               is_null($item->b2) ||
                                                               is_null($item->b3) ||
                                                               is_null($item->m1) ||
                                                               is_null($item->m2) ||
                                                               is_null($item->m3) ||
                                                               is_null($item->m4) ||
                                                               is_null($item->m5) ||
                                                               is_null($item->m6) ||
                                                               is_null($item->pro) ||
                                                               is_null($item->total);
                                                    })
                                                )
                                                    <a href="{{ route('nilaiPembimbing2.create', $jadwal->id) }}" class="btn btn-success btn-sm">Input Nilai</a>
                                                @endif
                                            </td>
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
</section>
@endsection
