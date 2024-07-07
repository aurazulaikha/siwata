<table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

            <thead>
                <tr>
                    <th>NO.</th>
                    <th>NAMA</th>
                    <th>NIDN</th>
                    <th>PROGRAM STUDI</th>
                    <th>NO TELP</th>
                    <th>ALAMAT</th>
                </tr>
            </thead>

            <tbody>
                {{ $no=1 }}
                @foreach($data as $row)
                    <tr>
                        <td style="text-align: center">{{ $no++ }}</td>
                        <td style="text-align: center">{{ $row->nama }}</td>
                        <td>{{ $row->nidn }}</td>
                        <td>{{ $row->prodi_id }}</td>
                        <td style="text-align: center">{{ $row->no_telp }}</td>
                        <td style="text-align: center">{{ $row->alamat }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
