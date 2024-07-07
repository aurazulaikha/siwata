<table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

    <thead>
        <tr>
            <th>NO.</th>
            <th>NOBP</th>
            <th>NAMA</th>
            <th>TELP</th>
            <th>ALAMAT</th>
            <th>PRODI_ID</th>
        </tr>
    </thead>

    <tbody>
        {{ $no=1 }}
        @foreach($data as $row)
            <tr>
                <td style="text-align: center">{{ $no++ }}</td>
                <td style="text-align: center">{{ $row->nobp }}</td>
                <td>{{ $row->nama }}</td>
                <td>{{ $row->telp }}</td>
                <td style="text-align: center">{{ $row->alamat }}</td>
                <td style="text-align: center">{{ $row->prodi_id }}</td>
            </tr>
        @endforeach 

    </tbody>
</table>