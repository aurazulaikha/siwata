@extends('layouts.main')
@section('title', 'Report Sidang')

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
                        <h4>Report Hasil Sidang</h4>

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
                        <div>
                            <a href="{{ route('report.nilaiAdmin') }}" class="btn btn-primary me-3">
                                <i class="nav-icon fas fa-folder-plus"></i>&nbsp; Report Nilai Sidang TA
                            </a>
                            <a href="{{ route('report.statusAdmin') }}" class="btn btn-primary me-3">
                                <i class="nav-icon fas fa-folder-plus"></i>&nbsp; Report Status Kelulusan
                            </a>
                            <a href="{{ route('report.pengujiAdmin') }}" class="btn btn-primary me-3">
                                <i class="nav-icon fas fa-folder-plus"></i>&nbsp; Report Penguji Sidang
                            </a>
                        </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
