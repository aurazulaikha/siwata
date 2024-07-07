<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Report Nilai Sidang TA</title>
    <style>
        table tr td,
		table tr th{
			font-size: 9pt;
		}
    </style>
</head>
<body>
    <center>
    <h4>Report Nilai Sidang TA</h4>
    </center>
    <table class='table table-bordered'>
        <thead>
            <tr>
                <th class="text-center align-middle">No</th>
                <th class="text-center align-middle">Nama</th>
                <th class="text-center align-middle">NoBP</th>
                <th class="text-center align-middle">Pembimbing 1</th>
                <th class="text-center align-middle">Pembimbing 2</th>
                <th class="text-center align-middle">Ketua</th>
                <th class="text-center align-middle">Sekretaris</th>
                <th class="text-center align-middle">Penguji 1</th>
                <th class="text-center align-middle">Penguji 2</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach($nilai_ta as $nilai)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $nilai->mahasiswa->nama }}</td>
                    <td>{{ $nilai->mahasiswa->nobp }}</td>
                    <td>{{ $nilai->total_pem1 }}</td>
                    <td>{{ $nilai->total_pem2 }}</td>
                    <td>{{ $nilai->total_ketua }}</td>
                    <td>{{ $nilai->total_sekretaris}}</td>
                    <td>{{ $nilai->total_penguji1 }}</td>
                    <td>{{ $nilai->total_penguji2 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
