<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class UserExport implements FromView
{
   
    public function view(): View
    {
        $data  = User::all();          
        return view('report_excel.exportUser', [
            'data' => $data
        ]);
    }
}
