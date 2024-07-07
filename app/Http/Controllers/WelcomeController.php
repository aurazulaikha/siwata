<?php

namespace App\Http\Controllers;

use App\Models\SidangTa;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $sidangTerjadwal = SidangTa::with(['dokumen_sidang', 'mahasiswa', 'ketua', 'sekretaris', 'penguji1', 'penguji2', 'ruang', 'sesi'])
            ->where('status', 0)
            ->get();

        $sidangSelesai = SidangTa::with(['dokumen_sidang', 'mahasiswa', 'ketua', 'sekretaris', 'penguji1', 'penguji2', 'ruang', 'sesi'])
            ->where('status', 1)
            ->get();

        $totalSidangTa = SidangTa::count();

        $mahasiswa = Mahasiswa::count();
        $dosen = Dosen::count();


        $kuotaSidang = 50 - $totalSidangTa;

        return view('welcome', compact('sidangTerjadwal', 'sidangSelesai', 'kuotaSidang', 'mahasiswa', 'dosen'));
    }
}

