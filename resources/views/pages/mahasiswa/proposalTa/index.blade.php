@extends('layouts.main')
@section('title', 'Proposal TA')

@section('content')
    <section class="section custom-section">
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div>
                        <h4 class="text-center my-4"></h4>
                    </div>
                    <div class="card rounded">
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
                            <div class="mb-3">
                                <button class="btn btn-secondary" data-toggle="modal" data-target="#pembimbing1Modal">
                                    <i class="nav-icon fas fa-user-plus"></i>&nbsp; Add Pembimbing 1
                                </button>
                                <button class="btn btn-secondary" data-toggle="modal" data-target="#pembimbing2Modal">
                                    <i class="nav-icon fas fa-user-plus"></i>&nbsp; Add Pembimbing 2
                                </button>
                            </div>
                             <!-- Informasi Pembimbing -->
                               <div class="mb-3">
                                @if($pembimbing1)
                                    <p><strong>Pembimbing 1:</strong> {{ $pembimbing1->dosen ? $pembimbing1->dosen->nama : 'Belum ditentukan' }}</p>
                                @else
                                    <p><strong>Pembimbing 1:</strong> Belum ditentukan</p>
                                @endif
                                @if($pembimbing2)
                                    <p><strong>Pembimbing 2:</strong> {{ $pembimbing2->dosen ? $pembimbing2->dosen->nama : 'Belum ditentukan' }}</p>
                                @else
                                    <p><strong>Pembimbing 2:</strong> Belum ditentukan</p>
                                @endif
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#uploadModal">
                                    <i class="nav-icon fas fa-folder-plus"></i>&nbsp; Upload Proposal
                                </button>
                            </div>
                            <table class="table table-bordered mt-3">
                                <thead>
                                    <tr>
                                        <th>Judul Proposal</th>
                                        <th>File</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($proposal_ta as $file)
                                        <tr>
                                            <td>{{ $file->judul }}</td>
                                            <td>
                                                <a href="{{ asset('data_file/' . $file->file) }}" target="_blank">{{ $file->file }}</a>
                                            </td>

                                            <td>
                                                <form method="POST" action="{{ route('proposalTa.destroy', $file->id) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm show_confirm" data-toggle="tooltip" title='Delete' style="margin-left: 8px"><i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-muted text-center">Data file belum tersedia</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Upload Proposal Modal -->
                <div class="modal fade" tabindex="-1" role="dialog" id="uploadModal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Upload Dokumen</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('proposalTa.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if ($errors->any())
                                                <div class="alert alert-danger alert-dismissible show fade">
                                                    <div class="alert-body">
                                                        <button class="close" data-dismiss="alert">
                                                            <span>&times;</span>
                                                        </button>
                                                        @foreach ($errors->all() as $error)
                                                            {{ $error }}
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="form-group">
                                                <label for="judul">Judul</label>
                                                <input type="text" id="judul" name="judul" class="form-control @error('judul') is-invalid @enderror" required>
                                                @error('judul')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="file">Upload File</label>
                                                <input type="file" id="file" name="file" class="form-control @error('file') is-invalid @enderror" required>
                                                @error('file')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
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

                <!-- Add Pembimbing 1 Modal -->
                <!-- Add Pembimbing 1 Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="pembimbing1Modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Pembimbing 1</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('proposalTa.pem1') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="dosen_id">Dosen Pembimbing 1</label>
                                <select id="dosen_id" name="dosen_id" class="form-control @error('dosen_id') is-invalid @enderror" required>
                                    @foreach($dosen as $dosens)
                                        <option value="{{ $dosens->id }}">{{ $dosens->nama }}</option>
                                    @endforeach
                                </select>
                                @error('dosen_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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

<!-- Add Pembimbing 2 Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="pembimbing2Modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Pembimbing 2</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('proposalTa.pem2') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="dosen_id">Dosen Pembimbing 2</label>
                                <select id="dosen_id" name="dosen_id" class="form-control @error('dosen_id') is-invalid @enderror" required>
                                    @foreach($dosen as $dosens)
                                        <option value="{{ $dosens->id }}">{{ $dosens->nama }}</option>
                                    @endforeach
                                </select>
                                @error('dosen_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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
                title: `Yakin ingin menghapus data ini?`,
                text: "Data akan terhapus secara permanen!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
    });
</script>
@endpush
