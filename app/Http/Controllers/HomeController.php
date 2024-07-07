<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\Ruangan;
use App\Models\Prodi;
use App\Models\Kaprodi;

use App\Models\Mahasiswa;
use App\Models\SidangTa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function admin()
    {
        $mahasiswa = Mahasiswa::count();
        $dosen = Dosen::count();
        $ruangan = Ruangan::count();
        $prodi = Prodi::count();

        $sidangTerjadwal = SidangTa::with(['dokumen_sidang', 'mahasiswa', 'ketua', 'sekretaris', 'penguji1', 'penguji2', 'ruang', 'sesi'])
            ->where('status', 0)
            ->count();

        $sidangSelesai = SidangTa::with(['dokumen_sidang', 'mahasiswa', 'ketua', 'sekretaris', 'penguji1', 'penguji2', 'ruang', 'sesi'])
            ->where('status', 1)
            ->count();

        return view('pages.admin.dashboard', compact('mahasiswa', 'dosen', 'ruangan', 'sidangTerjadwal', 'sidangSelesai', 'prodi'));
    }

    public function landing()
    {
        $sidangTerjadwal = SidangTa::with(['dokumen_sidang', 'mahasiswa', 'ketua', 'sekretaris', 'penguji1', 'penguji2', 'ruang', 'sesi'])
            ->where('status', 0)
            ->get();

        return view('welcome', compact('sidangTerjadwal'));
    }

    public function kaprodi()
    {

        $dosen = Dosen::count();
        $ruangan = Ruangan::count();

        $kaprodi = Kaprodi::where('user_id', Auth::id())->first();
        $prodi_id = $kaprodi->prodi_id; // Assuming Kaprodi has a prodi_id attribute
        $mahasiswa = Mahasiswa::where('prodi_id', $prodi_id)->count();

        $sidangTerjadwal = SidangTa::with(['dokumen_sidang', 'mahasiswa', 'ketua', 'sekretaris', 'penguji1', 'penguji2', 'ruang', 'sesi'])
            ->where('status', 0)
            ->where(function ($query) use ($prodi_id) {
                $query->whereHas('mahasiswa', function ($query) use ($prodi_id) {
                    $query->where('prodi_id', $prodi_id);
                });
            })
            ->count();

        $sidangSelesai = SidangTa::with(['dokumen_sidang', 'mahasiswa', 'ketua', 'sekretaris', 'penguji1', 'penguji2', 'ruang', 'sesi'])
            ->where('status', 1)
            ->where(function ($query) use ($prodi_id) {
                $query->whereHas('mahasiswa', function ($query) use ($prodi_id) {
                    $query->where('prodi_id', $prodi_id);
                });
            })
            ->count();

        $hari = Carbon::now()->locale('id')->isoFormat('dddd');

        return view('pages.kaprodi.dashboard', compact('mahasiswa', 'hari', 'sidangTerjadwal', 'sidangSelesai', 'dosen', 'ruangan'));
    }

    public function dosen()
    {
        $dosen = Dosen::where('user_id', Auth::id())->first();

        // Fetch schedules where the logged-in dosen is either ketua, sekretaris, pembimbing 1, pembimbing 2, penguji 1, or penguji 2
        // and the status is 1
        $sidangTerjadwal = SidangTa::with(['dokumen_sidang', 'mahasiswa', 'ketua', 'sekretaris', 'penguji1', 'penguji2', 'ruang', 'sesi'])
            ->where('status', 0)
            ->where(function ($query) use ($dosen) {
                $query->where('ketua_id', $dosen->id)
                    ->orWhere('sekretaris_id', $dosen->id)
                    ->orWhere('pem1_id', $dosen->id)
                    ->orWhere('pem2_id', $dosen->id)
                    ->orWhere('penguji1_id', $dosen->id)
                    ->orWhere('penguji2_id', $dosen->id);
            })
            ->count();

        $sidangSelesai = SidangTa::with(['dokumen_sidang', 'mahasiswa', 'ketua', 'sekretaris', 'penguji1', 'penguji2', 'ruang', 'sesi'])
            ->where('status', 1)
            ->where(function ($query) use ($dosen) {
                $query->where('ketua_id', $dosen->id)
                    ->orWhere('sekretaris_id', $dosen->id)
                    ->orWhere('pem1_id', $dosen->id)
                    ->orWhere('pem2_id', $dosen->id)
                    ->orWhere('penguji1_id', $dosen->id)
                    ->orWhere('penguji2_id', $dosen->id);
            })
            ->count();
        return view('pages.dosen.dashboard', compact('sidangTerjadwal', 'sidangSelesai'));
    }

    public function mahasiswa()
    {
        $mahasiswa = Mahasiswa::where('nobp', Auth::user()->nobp)->first();
        $hari = Carbon::now()->locale('id')->isoFormat('dddd');

        return view('pages.mahasiswa.dashboard', compact('mahasiswa', 'hari'));

    }

}
