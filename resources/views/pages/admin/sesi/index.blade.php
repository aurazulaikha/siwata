@extends('layouts.main')
@section('title', 'List Sesi')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>List Sesi</h4>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="nav-icon fas fa-folder-plus"></i>&nbsp; Tambah Sesi</button>
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
                                <thead>
                                    <tr>
                                        <th>Kode Sesi</th>
                                        <th>Mulai</th>
                                        <th>Selesai</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sesi as $result => $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->dari_jam }}</td>
                                        <td>{{ $data->sampai_jam }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <form method="POST" action="{{ route('sesi.destroy', $data->id) }}">
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
                            <h5 class="modal-title">Tambah Sesi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('sesi.store') }}" method="POST">
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
                                            <label for="dari_jam">Mulai dari jam</label>
                                            <input class="form-control" type="text" name="dari_jam" id="time1" />
                                        </div>
                                        <div class="form-group">
                                            <label for="sampai_jam">Sampai dari jam</label>
                                            <input class="form-control" type="text" name="sampai_jam" id="time2" />
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer br">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
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

<script>
    $('#time1').datetimepicker({
        format: 'HH:mm:ss'
    });

</script>

<script>
    $('#time2').datetimepicker({
        format: 'HH:mm:ss'
    });

</script>
@endpush