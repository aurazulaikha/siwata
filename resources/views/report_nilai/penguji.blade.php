<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Report Dosen Penguji Sidang TA</title>
    <style>
        table tr td,
        table tr th {
            font-size: 9pt;
        }
    </style>
</head>
<body>
    <center>
        <h4>Report Dosen Penguji Sidang TA</h4>
    </center>
    <table class='table table-bordered'>
        <thead>
            <tr>
                <th class="text-center align-middle" rowspan="2">Dosen</th>
                <th class="text-center" colspan="4">Mahasiswa</th>
            </tr>
            <tr>
                <th class="text-center align-middle">Sebagai Ketua</th>
                <th class="text-center">Sebagai Sekretaris</th>
                <th class="text-center">Sebagai Penguji 1</th>
                <th class="text-center">Sebagai Penguji 2</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dosens as $dosen)
                <tr>
                    <td>{{ $dosen['nama_dosen'] }}</td>
                    <td>
                        @foreach($dosen['mahasiswa_ketua'] as $mahasiswa)
                            {{ $mahasiswa }}<br>
                        @endforeach
                    </td>
                    <td>
                        @foreach($dosen['mahasiswa_sekretaris'] as $mahasiswa)
                            {{ $mahasiswa }}<br>
                        @endforeach
                    </td>
                    <td>
                        @foreach($dosen['mahasiswa_penguji1'] as $mahasiswa)
                            {{ $mahasiswa }}<br>
                        @endforeach
                    </td>
                    <td>
                        @foreach($dosen['mahasiswa_penguji2'] as $mahasiswa)
                            {{ $mahasiswa }}<br>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
