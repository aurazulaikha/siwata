<table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

            <thead>
                <tr>
                    <th>NO.</th>
                    <th>NAMA</th>
                    <th>EMAIL</th>
                    <th>ROLES</th>
                    <th>NOBP</th>
                    <th>NIDN</th>
                    <th>NIP</th>
                </tr>
            </thead>

            <tbody>
                {{ $no=1 }}
                @foreach($data as $row)
                    <tr>
                        <td style="text-align: center">{{ $no++ }}</td>
                        <td style="text-align: center">{{ $row->name }}</td>
                        <td>{{ $row->email }}</td>
                        <td>{{ $row->roles }}</td>
                        <td style="text-align: center">{{ $row->nobp }}</td>
                        <td style="text-align: center">{{ $row->nidn }}</td>
                        <td style="text-align: center">{{ $row->nip }}</td>
                    </tr>
                @endforeach 

            </tbody>
        </table>