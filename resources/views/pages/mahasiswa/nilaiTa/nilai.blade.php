@extends('layouts.main')
@section('title', 'Nilai Ta')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Nilai Sidang Ta</h4>

                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jabatan</th>
                                        <th>Nama</th>
                                        <th>Total Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($nilaiPembimbing1 && $nilaiPembimbing2 && $nilaiKetua && $nilaiPenguji1 && $nilaiPenguji2)
                                        <tr>
                                            <td>1</td>
                                            <td>Pembimbing 1</td>
                                            <td>{{ $nilaiPembimbing1->dosen->nama }}</td>
                                            <td>{{ $nilaiPembimbing1->total }}</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Pembimbing 2</td>
                                            <td>{{ $nilaiPembimbing2->dosen->nama }}</td>
                                            <td>{{ $nilaiPembimbing2->total }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">Nilai Rata-rata Pendidikan : {{ $ratapembimbing }} </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Ketua</td>
                                            <td>{{ $nilaiKetua->dosen->nama }}</td>
                                            <td>{{ $nilaiKetua->total }}</td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Sekretaris</td>
                                            <td>{{ $nilaiSekretaris->dosen->nama }}</td>
                                            <td>{{ $nilaiSekretaris->total }}</td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>Penguji 1</td>
                                            <td>{{ $nilaiPenguji1->dosen->nama }}</td>
                                            <td>{{ $nilaiPenguji1->total }}</td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>Penguji 2</td>
                                            <td>{{ $nilaiPenguji2->dosen->nama }}</td>
                                            <td>{{ $nilaiPenguji2->total }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">Nilai Rata-rata Penguji : {{ $ratapenguji }} </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">Nilai Akhir : {{ $totalnilai }}  </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">Hasil Lulus: {{ $statusSidang == '1' ? 'Lulus' : 'Tidak Lulus' }}</td>

                                        </tr>

                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center">Nilai belum diinputkan</td>
                                        </tr>
                                    @endif
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
