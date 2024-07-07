@extends('layouts.main')
@section('title', 'List User')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>List User</h4>
                        <div>
                            <button class="btn btn-primary me-3" data-toggle="modal" data-target="#importModal">
                                <i class="nav-icon fas fa-folder-plus"></i>&nbsp; Impor
                            </button>
                            <a href="{{ route('export_user') }}" class="btn btn-primary me-3">
                                <i class="nav-icon fas fa-folder-plus"></i>&nbsp; Ekspor
                            </a>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                <i class="nav-icon fas fa-folder-plus"></i>&nbsp; Tambah Data User
                            </button>
                        </div>
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
                                        <th>No</th>
                                        <th>Nama User</th>
                                        <th>Roles</th>
                                        <th>Permissions</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user as $result => $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->roles }}</td>
                                        <td>{{ $data->permissions }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <form method="POST" action="{{ route('users.destroy', $data->id) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm show_confirm" data-toggle="tooltip" title='Delete' style="margin-left: 8px"><i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus</button>
                                                    <a href="{{ route('users.edit',($data->id)) }}" class="btn btn-success btn-sm"><i class="nav-icon fas fa-edit"></i> &nbsp; Edit</a>
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
                            <h5 class="modal-title">Tambah User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('userAdmin.store') }}" method="POST">
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
                                            <label for="email">Email</label>
                                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('Email User') }}" value="{{ old('email') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('Name User') }}" value="{{ old('name') }}">
                                        </div>
                                        <input name="password" type="password" value="password123" hidden>
                                        <div class="form-group">
                                            <label for="roles">Roles</label>
                                            <select id="roles" name="roles" class="select2 form-control @error('roles') is-invalid @enderror">
                                                <option value="">-- Pilih Roles --</option>
                                                <option value="admin">Admin</option>
                                                <option value="dosen">Dosen</option>
                                                <option value="mahasiswa">Mahasiswa</option>
                                                <option value="kaprodi">Kaprodi</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="noId"></div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="importModalLabel">Impor Data User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('import_user') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="file">Pilih file Excel</label>
                                    <input type="file" name="file" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Impor</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('script')
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
<script>
    $(document).ready(function() {
        $('#roles').change(function() {
            var role = $('#roles option:selected').val();
            if (role == "dosen") {
                $("#noId").html('<label for="nidn">NIDN Dosen</label><input id="nidn" type="text" onkeypress="return inputAngka(event)" placeholder="NIDN Dosen" class="form-control" name="nidn" autocomplete="off">');
            } else if (role == "mahasiswa") {
                $("#noId").html('<label for="nobp">NoBP</label><input id="nobp" type="text" placeholder="NOBP Siswa" class="form-control" name="nobp" autocomplete="off">');
            } else if (role == "admin") {
                $("#noId").html('<label for="nip">NIP Admin</label><input id="nip" type="text" placeholder="NIP Admin" class="form-control" name="nip" autocomplete="off">');
            } else if (role == "kaprodi") {
                $("#noId").html('<label for="nidn">NIDN Kaprodi</label><input id="nidn" type="text" placeholder="NIDN Kaprodi" class="form-control" name="nidn" autocomplete="off">');
            } else {
                $("#noId").html("")
            }
        });
    });

</script>
@endpush
