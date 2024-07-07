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
                        <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="nav-icon fas fa-folder-plus"></i>&nbsp; Tambah Data Jadwal</button>
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
                        @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-dismissible show fade">
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
                                            <th>Action</th>
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
                                            <td>
                                                <div class="d-flex">

                                                <a href="{{ route('sidang_proposal.edit', Crypt::encrypt($jadwal->id)) }}" class="btn btn-success btn-sm"><i class="nav-icon fas fa-edit"></i> &nbsp; Edit</a>
                                                <form method="POST" action="{{ route('sidang_proposal.destroy', $jadwal->id) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm show_confirm" data-toggle="tooltip" title='Delete' style="margin-left: 8px"><i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Jadwal</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('sidang_proposal.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible show fade">
                                            <div class="alert-body">
                                                <button class="close" data-dismiss="alert">
                                                    <span>&times;</span>
                                                </button>
                                                @foreach ($errors->all() as $error )
                                                {{ $error }}
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                        <div class="form-group">
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="proposal_ta_id">Proposal</label>
                                            <select name="proposal_ta_id" id="proposal_ta_id" class="form-control">
                                                <option value="" disabled selected>Pilih Proposal</option>
                                                @foreach($proposal_ta as $proposal)
                                                    @php
                                                        $pem1_name = $proposal->pem1 ? $proposal->pem1->dosen->nama : 'N/A';
                                                        $pem2_name = $proposal->pem2 ? $proposal->pem2->dosen->nama : 'N/A';
                                                    @endphp
                                                    <option value="{{ $proposal->id }}" data-pem1-name="{{ $pem1_name }}" data-pem2-name="{{ $pem2_name }}">
                                                        {{ $proposal->mahasiswa->nama }} - {{ $proposal->judul }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                            <div class="form-group">
                                                <label for="tanggal">Tanggal</label>
                                                <input type="date" name="tanggal" id="tanggal" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="ruangan">Ruangan</label>
                                                <select name="ruangan" id="ruangan" class="form-control">
                                                    <option value="" disabled selected>Pilih Ruangan</option>
                                                    @foreach($ruangans as $ruangan)
                                                        <option value="{{ $ruangan->id }}">{{ $ruangan->nama_ruangan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="sesi">Sesi</label>
                                                <select name="sesi" id="sesi" class="form-control">
                                                    <option value="" disabled selected>Pilih Sesi</option>
                                                    @foreach($sesis as $sesi)
                                                        <option value="{{ $sesi->id }}">{{ $sesi->id }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="pem1">Pembimbing 1</label>
                                                <input type="text" name="pem1" id="pem1" class="form-control" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="pem2">Pembimbing 2</label>
                                                <input type="text" name="pem2" id="pem2" class="form-control" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="penguji">Penguji</label>
                                                <select name="penguji" id="penguji" class="form-control">
                                                    <option value="" disabled selected>Pilih Penguji</option>
                                                    @foreach($dosens as $dosen)
                                                        <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endsection


@push('script')
<script>
    document.getElementById('proposal_ta_id').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var pem1Name = selectedOption.getAttribute('data-pem1-name');
        var pem2Name = selectedOption.getAttribute('data-pem2-name');
        document.getElementById('pem1').value = pem1Name;
        document.getElementById('pem2').value = pem2Name;
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script type="text/javascript">
    $('.show_confirm').click(function(event) {
        var form = $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();
        swal({
                title: `Yakin ingin menghapus data ini?`
                , text: "Data akan terhapus secara permanen!"
                , icon: "warning"
                , buttons: true
                , dangerMode: true
            , })
            .then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
    });

</script>

@endpush
