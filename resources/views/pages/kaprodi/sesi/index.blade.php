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
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-2">
                                <thead>
                                    <tr>
                                        <th>Kode Sesi</th>
                                        <th>Mulai</th>
                                        <th>Selesai</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sesi as $result => $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->dari_jam }}</td>
                                        <td>{{ $data->sampai_jam }}</td>
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
