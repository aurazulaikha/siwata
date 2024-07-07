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
                                            <th>Mahasiswa</th>
                                            <th>Tanggal</th>
                                            <th>Ruangan</th>
                                            <th>Sesi</th>
                                            <th>Ketua</th>
                                            <th>Sekretaris</th>
                                            <th>Penguji 1</th>
                                            <th>Penguji 2</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jadwals as $jadwal)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $jadwal->mahasiswa->nama }}</td>
                                            <td>{{ $jadwal->tanggal }}</td>
                                            <td>{{ $jadwal->ruang->nama_ruangan }}</td>
                                            <td>{{ $jadwal->sesi }}</td>
                                            <td>{{ $jadwal->ketuaNama->nama }}</td>
                                            <td>{{ $jadwal->sekretarisNama->nama }}</td>
                                            <td>{{ $jadwal->penguji1->nama }}</td>
                                            <td>{{ $jadwal->penguji2->nama }}</td>
                                            <td>
                                                @if ($jadwal->status == 0)
                                                    Terjadwal
                                                @elseif ($jadwal->status == 1)
                                                    Sudah Dilaksanakan
                                                @endif
                                            </td>

                                            <td>
                                                <div class="d-flex">

                                                <a href="{{ route('jadwalTa.editAdmin', Crypt::encrypt($jadwal->id)) }}" class="btn btn-success btn-sm"><i class="nav-icon fas fa-edit"></i> &nbsp; Edit</a>
                                                <form method="POST" action="{{ route('jadwalTa.destroyAdmin', $jadwal->id) }}">
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
                <form action="{{ route('jadwalTa.storeAdmin') }}" method="POST">
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
                                <label for="dokumen_sidang_id">TA</label>
                                <select name="dokumen_sidang_id" id="dokumen_sidang_id" class="form-control">
                                    <option value="" disabled selected>Pilih TA</option>
                                    @foreach($dokumen_sidang as $dokumen)
                                        @php
                                            $pem1_name = $dokumen->pem1 ? $dokumen->pem1->dosen->nama : 'N/A';
                                            $pem2_name = $dokumen->pem2 ? $dokumen->pem2->dosen->nama : 'N/A';
                                        @endphp
                                        <option value="{{ $dokumen->id }}" data-pem1-name="{{ $pem1_name }}" data-pem2-name="{{ $pem2_name }}">
                                            {{ $dokumen->mahasiswa->nama }} - {{ $dokumen->proposal_ta->judul }}
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
                            <div>
                                <h8>Pembimbing 1: <span id="pem1-name">N/A</span></h8>
                            </div>
                            <div>
                                <h8>Pembimbing 2: <span id="pem2-name">N/A</span></h8>
                            </div>

                            <div class="form-group">
                                <label for="ketua">Ketua</label>
                                <select name="ketua" id="ketua" class="form-control">
                                    <option value="" disabled selected>Pilih Ketua</option>
                                    @foreach($dosens as $dosen)
                                        <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="sekretaris">Sekretaris</label>
                                <select name="sekretaris" id="sekretaris" class="form-control">
                                    <option value="" disabled selected>Pilih Sekretaris</option>
                                    @foreach($dosens as $dosen)
                                        <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="penguji1">Penguji 1</label>
                                <select name="penguji1" id="penguji1" class="form-control">
                                    <option value="" disabled selected>Pilih Penguji 1</option>
                                    @foreach($dosens as $dosen)
                                        <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="penguji2">Penguji 2</label>
                                <select name="penguji2" id="penguji2" class="form-control">
                                    <option value="" disabled selected>Pilih Penguji 2</option>
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
    // Handle the change event of the TA dropdown
    document.getElementById('dokumen_sidang_id').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var pem1Name = selectedOption.getAttribute('data-pem1-name');
        var pem2Name = selectedOption.getAttribute('data-pem2-name');

        // Update the names of Pembimbing 1 and Pembimbing 2
        document.getElementById('pem1-name').textContent = pem1Name;
        document.getElementById('pem2-name').textContent = pem2Name;
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
