@extends('layouts.main')
@section('title', 'SIdang TA')

@section('content')
    <section class="section custom-section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Pendaftaran Sidang TA</h4>
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
                            @if($dokumen_sidang->isEmpty())
                                <div class="mb-3">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#uploadModal">
                                        <i class="nav-icon fas fa-folder-plus"></i>&nbsp; Upload Proposal
                                    </button>
                                </div>
                            @endif
                            <div class="table-responsive">
                                    <table class="table table-striped" id="table-2">
                                    <thead>
                                        <tr>
                                            <th>Proposal TA</th>
                                            <th>Laporan PKL</th>
                                            <th>Lembar Bimbingan</th>
                                            <th>Laporan TA</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($dokumen_sidang as $file)
                                            <tr>
                                                <td>
                                                    <a href="{{ asset('data_file/' . $file->proposal_ta->file) }}" target="_blank">Download</a>
                                                </td>
                                                <td>
                                                    <a href="{{ asset('data_file/' . $file->laporan_pkl) }}" target="_blank">Download</a>
                                                </td>
                                                <td>
                                                    <a href="{{ asset('data_file/' . $file->lembar_bimbingan) }}" target="_blank">Download</a>
                                                </td>

                                                <td>
                                                    <a href="{{ asset('data_file/' . $file->laporan_ta) }}" target="_blank">Download</a>
                                                </td>
                                                <td>
                                                    <form method="POST" action="{{ route('dokumenSidang.destroy', $file->id) }}">
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
                                <form action="{{ route('dokumenSidang.store') }}" method="POST" enctype="multipart/form-data">
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
                                                <label for="proposal_id">Upload Proposal</label>
                                                <select id="proposal_id" name="proposal_id" class="form-control @error('proposal_id') is-invalid @enderror" required>
                                                    <option value="" disabled selected>Pilih Proposal</option>
                                                    @foreach($proposals as $proposal)
                                                    <option value="{{ $proposal->id }}" data-proposal="{{ $proposal->file_proposal }}">{{ $proposal->judul }}</option>
                                                    @endforeach
                                                </select>
                                                @error('proposal_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="laporan_pkl">Upload Laporan PKL</label>
                                                <input type="file" id="laporan_pkl" name="laporan_pkl" class="form-control @error('laporan_pkl') is-invalid @enderror" required>
                                                @error('laporan_pkl')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="lembar_bimbingan">Upload Lembar Bimbingan</label>
                                                <input type="file" id="lembar_bimbingan" name="lembar_bimbingan" class="form-control @error('lembar_bimbingan') is-invalid @enderror" required>
                                                @error('lembar_bimbingan')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="laporan_ta">Upload Laporan TA</label>
                                                <input type="file" id="laporan_ta" name="laporan_ta" class="form-control @error('laporan_ta') is-invalid @enderror" required>
                                                @error('laporan_ta')
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
    </section>
@endsection

@push('script')
<script>
    document.getElementById('proposal_id').addEventListener('change', function() {
        var selectedProposal = this.options[this.selectedIndex].getAttribute('data-proposal');
        if (selectedProposal) {
            document.getElementById('proposal_ta').setAttribute('value', selectedProposal);
        }
    });
</script>
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
