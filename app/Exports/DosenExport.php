<?php

namespace App\Exports;

use App\Models\Dosen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class DosenExport implements FromView
{
   
    public function view(): View
    {
        $data  = Dosen::all();          
        return view('report_excel.exportExcel', [
            'data' => $data
        ]);
    }
}
