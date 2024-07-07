@extends('layouts.main')
@section('title', 'Nilai Ketua')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Nilai Ta</h4>

                    </div>

                    <div class="card-body">
                        <div>
                            <h6>Nilai Pembimbing 1</h6>
                        </div>
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
                                    @if($nilaiPembimbing1)
                                        <tr>
                                            <td>1</td>
                                            <td>BIMBINGAN</td>

                                        </tr>
                                        <tr>
                                            <td rowspan="3"></td>
                                            <td>Sikap dan Penampilan</td>
                                            <td>5</td>
                                            <td>{{ $nilaiPembimbing1->b1 }}</td>
                                        </tr>
                                        <tr>

                                            <td>Komunikasi dan Sistematika</td>
                                            <td>5</td>
                                            <td>{{ $nilaiPembimbing1->b2 }}</td>
                                        </tr>
                                        <tr>

                                            <td>Penguasaan Materi</td>
                                            <td>20</td>
                                            <td>{{ $nilaiPembimbing1->b3 }}</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>MAKALAH</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="6"></td>
                                            <td>Identifikasi Masalah, Tujuan dan Kontribusi Penelitian</td>
                                            <td>5</td>
                                            <td>{{ $nilaiPembimbing1->m1 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Relevansi teori / referensi pustaka dan konsep dengan masalah penelitian</td>
                                            <td>5</td>
                                            <td>{{ $nilaiPembimbing1->m2 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Metoda / Algoritma yang digunakan</td>
                                            <td>10</td>
                                            <td>{{ $nilaiPembimbing1->m3 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Hasil dan Pembahasan</td>
                                            <td>15</td>
                                            <td>{{ $nilaiPembimbing1->m4 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Kesimpulan dan Saran</td>
                                            <td>5</td>
                                            <td>{{ $nilaiPembimbing1->m5 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Penggunaan Bahasa dan Tata tulis</td>
                                            <td>5</td>
                                            <td>{{ $nilaiPembimbing1->m6 }}</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>PRODUK</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="1"></td>
                                            <td>Kesesuaian dan fungsionalitas sistem</td>
                                            <td>25</td>
                                            <td>{{ $nilaiPembimbing1->pro }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Total</td>
                                            <td>{{ $nilaiPembimbing1->total }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Komentar</td>
                                            <td>{{ $nilaiPembimbing1->komentar ?? 'tidak ada' }}</td>
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

                    <div class="card-body">
                        <div>
                            <h6>Nilai Pembimbing 2</h6>
                        </div>
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
                                    @if($nilaiPembimbing2)
                                        <tr>
                                            <td>1</td>
                                            <td>BIMBINGAN</td>

                                        </tr>
                                        <tr>
                                            <td rowspan="3"></td>
                                            <td>Sikap dan Penampilan</td>
                                            <td>5</td>
                                            <td>{{ $nilaiPembimbing2->b1 }}</td>
                                        </tr>
                                        <tr>

                                            <td>Komunikasi dan Sistematika</td>
                                            <td>5</td>
                                            <td>{{ $nilaiPembimbing2->b2 }}</td>
                                        </tr>
                                        <tr>

                                            <td>Penguasaan Materi</td>
                                            <td>20</td>
                                            <td>{{ $nilaiPembimbing2->b3 }}</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>MAKALAH</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="6"></td>
                                            <td>Identifikasi Masalah, Tujuan dan Kontribusi Penelitian</td>
                                            <td>5</td>
                                            <td>{{ $nilaiPembimbing2->m1 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Relevansi teori / referensi pustaka dan konsep dengan masalah penelitian</td>
                                            <td>5</td>
                                            <td>{{ $nilaiPembimbing2->m2 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Metoda / Algoritma yang digunakan</td>
                                            <td>10</td>
                                            <td>{{ $nilaiPembimbing2->m3 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Hasil dan Pembahasan</td>
                                            <td>15</td>
                                            <td>{{ $nilaiPembimbing2->m4 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Kesimpulan dan Saran</td>
                                            <td>5</td>
                                            <td>{{ $nilaiPembimbing2->m5 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Penggunaan Bahasa dan Tata tulis</td>
                                            <td>5</td>
                                            <td>{{ $nilaiPembimbing2->m6 }}</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>PRODUK</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="1"></td>
                                            <td>Kesesuaian dan fungsionalitas sistem</td>
                                            <td>25</td>
                                            <td>{{ $nilaiPembimbing2->pro }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Total</td>
                                            <td>{{ $nilaiPembimbing2->total }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Komentar</td>
                                            <td>{{ $nilaiPembimbing2->komentar ?? 'tidak ada' }}</td>
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

                    <div class="card-body">
                        <div>
                            <h6>Nilai Ketua</h6>
                        </div>
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
                                    @if($nilaiKetua)
                                        <tr>
                                            <td>1</td>
                                            <td>PRESENTASI</td>

                                        </tr>
                                        <tr>
                                            <td rowspan="3"></td>
                                            <td>Sikap dan Penampilan</td>
                                            <td>5</td>
                                            <td>{{ $nilaiKetua->p1 }}</td>
                                        </tr>
                                        <tr>

                                            <td>Komunikasi dan Sistematika</td>
                                            <td>5</td>
                                            <td>{{ $nilaiKetua->p2 }}</td>
                                        </tr>
                                        <tr>

                                            <td>Penguasaan Materi</td>
                                            <td>20</td>
                                            <td>{{ $nilaiKetua->p3 }}</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>MAKALAH</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="6"></td>
                                            <td>Identifikasi Masalah, Tujuan dan Kontribusi Penelitian</td>
                                            <td>5</td>
                                            <td>{{ $nilaiKetua->m1 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Relevansi teori / referensi pustaka dan konsep dengan masalah penelitian</td>
                                            <td>5</td>
                                            <td>{{ $nilaiKetua->m2 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Metoda / Algoritma yang digunakan</td>
                                            <td>10</td>
                                            <td>{{ $nilaiKetua->m3 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Hasil dan Pembahasan</td>
                                            <td>15</td>
                                            <td>{{ $nilaiKetua->m4 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Kesimpulan dan Saran</td>
                                            <td>5</td>
                                            <td>{{ $nilaiKetua->m5 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Penggunaan Bahasa dan Tata tulis</td>
                                            <td>5</td>
                                            <td>{{ $nilaiKetua->m6 }}</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>PRODUK</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="1"></td>
                                            <td>Kesesuaian dan fungsionalitas sistem</td>
                                            <td>25</td>
                                            <td>{{ $nilaiKetua->pro }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Total</td>
                                            <td>{{ $nilaiKetua->total }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Komentar</td>
                                            <td>{{ $nilaiKetua->komentar ?? 'tidak ada' }}</td>
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

                    <div class="card-body">
                        <div>
                            <h6>Nilai Sekretaris</h6>
                        </div>
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
                                    @if($nilaiSekretaris)
                                        <tr>
                                            <td>1</td>
                                            <td>PRESENTASI</td>

                                        </tr>
                                        <tr>
                                            <td rowspan="3"></td>
                                            <td>Sikap dan Penampilan</td>
                                            <td>5</td>
                                            <td>{{ $nilaiSekretaris->p1 }}</td>
                                        </tr>
                                        <tr>

                                            <td>Komunikasi dan Sistematika</td>
                                            <td>5</td>
                                            <td>{{ $nilaiSekretaris->p2 }}</td>
                                        </tr>
                                        <tr>

                                            <td>Penguasaan Materi</td>
                                            <td>20</td>
                                            <td>{{ $nilaiSekretaris->p3 }}</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>MAKALAH</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="6"></td>
                                            <td>Identifikasi Masalah, Tujuan dan Kontribusi Penelitian</td>
                                            <td>5</td>
                                            <td>{{ $nilaiSekretaris->m1 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Relevansi teori / referensi pustaka dan konsep dengan masalah penelitian</td>
                                            <td>5</td>
                                            <td>{{ $nilaiSekretaris->m2 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Metoda / Algoritma yang digunakan</td>
                                            <td>10</td>
                                            <td>{{ $nilaiSekretaris->m3 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Hasil dan Pembahasan</td>
                                            <td>15</td>
                                            <td>{{ $nilaiSekretaris->m4 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Kesimpulan dan Saran</td>
                                            <td>5</td>
                                            <td>{{ $nilaiSekretaris->m5 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Penggunaan Bahasa dan Tata tulis</td>
                                            <td>5</td>
                                            <td>{{ $nilaiSekretaris->m6 }}</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>PRODUK</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="1"></td>
                                            <td>Kesesuaian dan fungsionalitas sistem</td>
                                            <td>25</td>
                                            <td>{{ $nilaiSekretaris->pro }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Total</td>
                                            <td>{{ $nilaiSekretaris->total }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Komentar</td>
                                            <td>{{ $nilaiSekretaris->komentar ?? 'tidak ada' }}</td>
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

                    <div class="card-body">
                        <div>
                            <h6>Nilai Penguji 1</h6>
                        </div>
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
                                    @if($nilaiPenguji1)
                                        <tr>
                                            <td>1</td>
                                            <td>PRESENTASI</td>

                                        </tr>
                                        <tr>
                                            <td rowspan="3"></td>
                                            <td>Sikap dan Penampilan</td>
                                            <td>5</td>
                                            <td>{{ $nilaiPenguji1->p1 }}</td>
                                        </tr>
                                        <tr>

                                            <td>Komunikasi dan Sistematika</td>
                                            <td>5</td>
                                            <td>{{ $nilaiPenguji1->p2 }}</td>
                                        </tr>
                                        <tr>

                                            <td>Penguasaan Materi</td>
                                            <td>20</td>
                                            <td>{{ $nilaiPenguji1->p3 }}</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>MAKALAH</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="6"></td>
                                            <td>Identifikasi Masalah, Tujuan dan Kontribusi Penelitian</td>
                                            <td>5</td>
                                            <td>{{ $nilaiPenguji1->m1 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Relevansi teori / referensi pustaka dan konsep dengan masalah penelitian</td>
                                            <td>5</td>
                                            <td>{{ $nilaiPenguji1->m2 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Metoda / Algoritma yang digunakan</td>
                                            <td>10</td>
                                            <td>{{ $nilaiPenguji1->m3 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Hasil dan Pembahasan</td>
                                            <td>15</td>
                                            <td>{{ $nilaiPenguji1->m4 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Kesimpulan dan Saran</td>
                                            <td>5</td>
                                            <td>{{ $nilaiPenguji1->m5 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Penggunaan Bahasa dan Tata tulis</td>
                                            <td>5</td>
                                            <td>{{ $nilaiPenguji1->m6 }}</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>PRODUK</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="1"></td>
                                            <td>Kesesuaian dan fungsionalitas sistem</td>
                                            <td>25</td>
                                            <td>{{ $nilaiPenguji1->pro }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Total</td>
                                            <td>{{ $nilaiPenguji1->total }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Komentar</td>
                                            <td>{{ $nilaiPenguji1->komentar ?? 'tidak ada' }}</td>
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

                    <div class="card-body">
                        <div>
                            <h6>Nilai Penguji 2</h6>
                        </div>
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
                                    @if($nilaiPenguji2)
                                        <tr>
                                            <td>1</td>
                                            <td>PRESENTASI</td>

                                        </tr>
                                        <tr>
                                            <td rowspan="3"></td>
                                            <td>Sikap dan Penampilan</td>
                                            <td>5</td>
                                            <td>{{ $nilaiPenguji2->p1 }}</td>
                                        </tr>
                                        <tr>

                                            <td>Komunikasi dan Sistematika</td>
                                            <td>5</td>
                                            <td>{{ $nilaiPenguji2->p2 }}</td>
                                        </tr>
                                        <tr>

                                            <td>Penguasaan Materi</td>
                                            <td>20</td>
                                            <td>{{ $nilaiPenguji2->p3 }}</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>MAKALAH</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="6"></td>
                                            <td>Identifikasi Masalah, Tujuan dan Kontribusi Penelitian</td>
                                            <td>5</td>
                                            <td>{{ $nilaiPenguji2->m1 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Relevansi teori / referensi pustaka dan konsep dengan masalah penelitian</td>
                                            <td>5</td>
                                            <td>{{ $nilaiPenguji2->m2 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Metoda / Algoritma yang digunakan</td>
                                            <td>10</td>
                                            <td>{{ $nilaiPenguji2->m3 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Hasil dan Pembahasan</td>
                                            <td>15</td>
                                            <td>{{ $nilaiPenguji2->m4 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Kesimpulan dan Saran</td>
                                            <td>5</td>
                                            <td>{{ $nilaiPenguji2->m5 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Penggunaan Bahasa dan Tata tulis</td>
                                            <td>5</td>
                                            <td>{{ $nilaiPenguji2->m6 }}</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>PRODUK</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="1"></td>
                                            <td>Kesesuaian dan fungsionalitas sistem</td>
                                            <td>25</td>
                                            <td>{{ $nilaiPenguji2->pro }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Total</td>
                                            <td>{{ $nilaiPenguji2->total }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Komentar</td>
                                            <td>{{ $nilaiPenguji2->komentar ?? 'tidak ada' }}</td>
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

                    <div class="card-body">
                        <div>
                            <h6>Total Nilai Keseluruhan</h6>
                        </div>
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
