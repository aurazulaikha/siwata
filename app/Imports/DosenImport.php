<?php

namespace App\Imports;

use App\Models\Dosen;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DosenImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
      
        return new Dosen([
            'nama'      => $row['nama'],
            'nidn'      => $row['nidn'],
            'prodi_id'  => $row['prodi_id'],
            'no_telp'   => $row['no_telp'],
            'alamat'    => $row['alamat']
        ]);
    }
}
