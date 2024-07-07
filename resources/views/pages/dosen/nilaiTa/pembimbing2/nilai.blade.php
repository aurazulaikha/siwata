@extends('layouts.main')
@section('title', 'Nilai Pembimbing 2')

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
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                        <th>No</th>
                                        <th>Nama Nilai</th>
                                        <th>Bobot (%)</th>
                                        <th>Skor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($nilaiPembimbing2 as $nilai)
                                        <tr>
                                            <td>1</td>
                                            <td>BIMBINGAN</td>

                                        </tr>
                                        <tr>
                                            <td rowspan="3"></td>
                                            <td>Sikap dan Penampilan</td>
                                            <td>5</td>
                                            <td>{{ $nilai->b1 }}</td>
                                        </tr>
                                        <tr>

                                            <td>Komunikasi dan Sistematika</td>
                                            <td>5</td>
                                            <td>{{ $nilai->b2 }}</td>
                                        </tr>
                                        <tr>

                                            <td>Penguasaan Materi</td>
                                            <td>20</td>
                                            <td>{{ $nilai->b3 }}</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>MAKALAH</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="6"></td>
                                            <td>Identifikasi Masalah, Tujuan dan Kontribusi Penelitian</td>
                                            <td>5</td>
                                            <td>{{ $nilai->m1 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Relevansi teori / referensi pustaka dan konsep dengan masalah penelitian</td>
                                            <td>5</td>
                                            <td>{{ $nilai->m2 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Metoda / Algoritma yang digunakan</td>
                                            <td>10</td>
                                            <td>{{ $nilai->m3 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Hasil dan Pembahasan</td>
                                            <td>15</td>
                                            <td>{{ $nilai->m4 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Kesimpulan dan Saran</td>
                                            <td>5</td>
                                            <td>{{ $nilai->m5 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Penggunaan Bahasa dan Tata tulis</td>
                                            <td>5</td>
                                            <td>{{ $nilai->m6 }}</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>PRODUK</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="1"></td>
                                            <td>Kesesuaian dan fungsionalitas sistem</td>
                                            <td>25</td>
                                            <td>{{ $nilai->pro }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Total</td>
                                            <td>{{ $nilai->total }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Komentar</td>
                                            <td>{{ $nilai->komentar ?? 'tidak ada' }}</td>
                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Aksi</td>
                                            <td>
                                                <a href="{{ route('nilaiPembimbing2.edit', $nilai->id) }}" class="btn btn-primary">Edit</a>
                                            </td>
                                        </tr>

                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Nilai belum diinputkan</td>
                                        </tr>
                                    @endforelse
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
