<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MahasiswaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
      
        return new Mahasiswa([
            'nobp'      => $row['nobp'],
            'nama'      => $row['nama'],
            'telp'  => $row['telp'],
            'alamat'   => $row['alamat'],
            'prodi_id'    => $row['prodi_id']
        ]);
    }
}
