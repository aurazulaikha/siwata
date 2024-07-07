@extends('layouts.main')
@section('title', 'Edit Nilai Penguji 2')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Edit Nilai Penguji 2</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('nilaiPenguji2.update', $nilaiPenguji2->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Nilai</th>
                                            <th>Bobot (%)</th>
                                            <th>Skor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>PRESENTASI</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="3"></td>
                                            <td>Sikap dan Penampilan</td>
                                            <td>5</td>
                                            <td>
                                                <input type="number" name="p1" class="form-control score-input" value="{{ $nilaiPenguji2->p1 }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Komunikasi dan Sistematika</td>
                                            <td>5</td>
                                            <td>
                                                <input type="number" name="p2" class="form-control score-input" value="{{ $nilaiPenguji2->p2 }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Penguasaan Materi</td>
                                            <td>20</td>
                                            <td>
                                                <input type="number" name="p3" class="form-control score-input" value="{{ $nilaiPenguji2->p3 }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>MAKALAH</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="6"></td>
                                            <td>Identifikasi Masalah, Tujuan dan Kontribusi Penelitian</td>
                                            <td>5</td>
                                            <td>
                                                <input type="number" name="m1" class="form-control score-input" value="{{ $nilaiPenguji2->m1 }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Relevansi teori / referensi pustaka dan konsep dengan masalah penelitian</td>
                                            <td>5</td>
                                            <td>
                                                <input type="number" name="m2" class="form-control score-input" value="{{ $nilaiPenguji2->m2 }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Metoda / Algoritma yang digunakan</td>
                                            <td>10</td>
                                            <td>
                                                <input type="number" name="m3" class="form-control score-input" value="{{ $nilaiPenguji2->m3 }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Hasil dan Pembahasan</td>
                                            <td>15</td>
                                            <td>
                                                <input type="number" name="m4" class="form-control score-input" value="{{ $nilaiPenguji2->m4 }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Kesimpulan dan Saran</td>
                                            <td>5</td>
                                            <td>
                                                <input type="number" name="m5" class="form-control score-input" value="{{ $nilaiPenguji2->m5 }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Penggunaan Bahasa dan Tata tulis</td>
                                            <td>5</td>
                                            <td>
                                                <input type="number" name="m6" class="form-control score-input" value="{{ $nilaiPenguji2->m6 }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>PRODUK</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="1"></td>
                                            <td>Kesesuaian dan fungsionalitas sistem</td>
                                            <td>25</td>
                                            <td>
                                                <input type="number" name="pro" class="form-control score-input" value="{{ $nilaiPenguji2->pro }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Total</td>
                                            <td>
                                                <input type="number" name="total" id="total" class="form-control" value="{{ $nilaiPenguji2->average }}" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Komentar</td>
                                            <td>
                                                <textarea name="komentar" class="form-control">{{ $nilaiPenguji2->komentar }}</textarea>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-right mt-3">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function calculateAverage() {
    var scores = document.getElementsByClassName('score-input');
    var total = 0;
    var totalWeight = 0;

    var weights = {
        'p1': 5,
        'p2': 5,
        'p3': 20,
        'm1': 5,
        'm2': 5,
        'm3': 10,
        'm4': 15,
        'm5': 5,
        'm6': 5,
        'pro': 25
    };

    Array.prototype.forEach.call(scores, function(score) {
        var scoreName = score.getAttribute('name');
        var weight = weights[scoreName];
        total += parseFloat(score.value) * (weight / 100);
        totalWeight += weight;
    });

    var average = total / (totalWeight / 100);
    document.getElementById('total').value = average.toFixed(2);
}

document.querySelectorAll('.score-input').forEach(function(input) {
    input.addEventListener('input', calculateAverage);
});

window.addEventListener('load', calculateAverage);
</script>
@endsection
