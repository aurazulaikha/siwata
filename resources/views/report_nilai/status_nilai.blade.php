<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Status Kelulusan Sidang TA</title>
    <style>
        table tr td,
		table tr th{
			font-size: 9pt;
		}
    </style>
</head>
<body>
    <center>
    <h4>Status Kelulusan Sidang TA</h4>
    </center>
    <table class='table table-bordered'>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Nama</th>
                <th>NoBP</th>
                <th>Nilai Akhir</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach($nilai_ta as $nilai)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $nilai->mahasiswa->nama }}</td>
                    <td>{{ $nilai->mahasiswa->nobp }}</td>
                    <td>{{ $nilai->total }}</td>
                    <td>
                        @if($nilai->status == 1)
                            Lulus
                        @else
                            Tidak Lulus
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
