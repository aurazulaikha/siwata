<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class MahasiswaExport implements FromView
{
   
    public function view(): View
    {
        $data  = Mahasiswa::all();          
        return view('report_excel.exportMahasiswa', [
            'data' => $data
        ]);
    }
}
