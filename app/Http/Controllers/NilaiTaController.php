<?php

namespace App\Http\Controllers;

use App\Models\NilaiTa;
use Illuminate\Http\Request;
use App\Models\SidangTa;
use App\Models\NilaiKetua;
use App\Models\NilaiPembimbing1;
use App\Models\NilaiPembimbing2;
use App\Models\NilaiPenguji1;
use App\Models\NilaiPenguji2;
use App\Models\NilaiSekretaris;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Kaprodi;
use PDF;

use Illuminate\Support\Facades\Auth;

class NilaiTaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        // Get the logged-in dosen's ID
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->first();

        // Fetch schedules where the logged-in dosen is either pembimbing 1, pembimbing 2, or penguji
        $jadwals = SidangTa::with(['dokumen_sidang', 'mahasiswa'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->get();

        return view('pages.mahasiswa.nilaiTa.index', compact('jadwals'));
    }

    public function report()
    {
        return view('pages.kaprodi.report.index');
    }
    public function reportNilai()
    {
        // Get the logged-in kaprodi's ID
        $kaprodi = Kaprodi::where('user_id', Auth::id())->first();
        $prodi_id = $kaprodi->prodi_id; // Assuming Kaprodi has a prodi_id attribute

        // Fetch nilai_ta where the mahasiswa's prodi_id matches the kaprodi's prodi_id
        $nilai_ta = NilaiTa::whereHas('mahasiswa', function ($query) use ($prodi_id) {
            $query->where('prodi_id', $prodi_id);
        })->with('mahasiswa')->get();

        // Load the view and generate the PDF
        $pdf = PDF::loadView('report_nilai.nilai_ta', compact('nilai_ta'));
        return $pdf->download('nilai_ta_report.pdf');
    }


    public function reportStatus()
    {
        $kaprodi = Kaprodi::where('user_id', Auth::id())->first();
        $prodi_id = $kaprodi->prodi_id; // Assuming Kaprodi has a prodi_id attribute

        // Fetch nilai_ta where the mahasiswa's prodi_id matches the kaprodi's prodi_id
        $nilai_ta = NilaiTa::whereHas('mahasiswa', function ($query) use ($prodi_id) {
            $query->where('prodi_id', $prodi_id);
        })->with('mahasiswa')->get();

        $pdf = PDF::loadView('report_nilai.status_nilai', compact('nilai_ta'));
        return $pdf->download('status_kelulusan_report.pdf');
    }

    public function reportPenguji()
    {
        // Get the logged-in kaprodi's ID
        $kaprodi = Kaprodi::where('user_id', Auth::id())->first();
        $prodi_id = $kaprodi->prodi_id; // Assuming Kaprodi has a prodi_id attribute

        // Fetch the data from sidangTa with relationships, filtered by prodi_id
        $sidangTa = SidangTa::whereHas('mahasiswa', function ($query) use ($prodi_id) {
            $query->where('prodi_id', $prodi_id);
        })->with(['mahasiswa', 'ketuaNama', 'sekretarisNama', 'penguji1', 'penguji2'])->get();

        // Group data by dosen
        $dosens = [];
        foreach ($sidangTa as $sidang) {
            $dosenRoles = [
                'ketua' => $sidang->ketuaNama,
                'sekretaris' => $sidang->sekretarisNama,
                'penguji1' => $sidang->penguji1,
                'penguji2' => $sidang->penguji2,
            ];
            foreach ($dosenRoles as $role => $dosen) {
                if (!isset($dosens[$dosen->id])) {
                    $dosens[$dosen->id] = [
                        'nama_dosen' => $dosen->nama,
                        'mahasiswa_ketua' => [],
                        'mahasiswa_sekretaris' => [],
                        'mahasiswa_penguji1' => [],
                        'mahasiswa_penguji2' => [],
                    ];
                }
                $dosens[$dosen->id]['mahasiswa_' . $role][] = $sidang->mahasiswa->nama;
            }
        }

        $pdf = PDF::loadView('report_nilai.penguji', compact('dosens'));
        return $pdf->download('dosen_penguji_report.pdf');
    }
    public function reportAdmin()
    {
        return view('pages.admin.report.index');
    }
    public function reportNilaiAdmin()
    {
        $nilai_ta = NilaiTa::with(['mahasiswa'])->get();

        $pdf = PDF::loadView('report_nilai.nilai_ta', compact('nilai_ta'));
        return $pdf->download('nilai_ta_report.pdf');
    }

    public function reportStatusAdmin()
    {
        $nilai_ta = NilaiTa::with(['mahasiswa'])->get();

        $pdf = PDF::loadView('report_nilai.status_nilai', compact('nilai_ta'));
        return $pdf->download('status_kelulusan_report.pdf');
    }

    public function reportPengujiAdmin()
    {
        // Fetch the data from sidangTa with relationships
        $sidangTa = SidangTa::with(['mahasiswa', 'ketuaNama', 'sekretarisNama', 'penguji1', 'penguji2'])->get();

        // Group data by dosen
        $dosens = [];
        foreach ($sidangTa as $sidang) {
            $dosenRoles = [
                'ketua' => $sidang->ketuaNama,
                'sekretaris' => $sidang->sekretarisNama,
                'penguji1' => $sidang->penguji1,
                'penguji2' => $sidang->penguji2,
            ];
            foreach ($dosenRoles as $role => $dosen) {
                if (!isset($dosens[$dosen->id])) {
                    $dosens[$dosen->id] = [
                        'nama_dosen' => $dosen->nama,
                        'mahasiswa_ketua' => [],
                        'mahasiswa_sekretaris' => [],
                        'mahasiswa_penguji1' => [],
                        'mahasiswa_penguji2' => [],
                    ];
                }
                $dosens[$dosen->id]['mahasiswa_' . $role][] = $sidang->mahasiswa->nama;
            }
        }

        $pdf = PDF::loadView('report_nilai.penguji', compact('dosens'));
        return $pdf->download('dosen_penguji_report.pdf');
    }


    public function nilai($id)
    {
        // Mengambil data berdasarkan sidang_ta_id
        $sidangTa = SidangTa::findOrFail($id);

        $nilaiKetua = Nilaiketua::where('sidang_ta_id', $sidangTa->id)->with('dosen')->first();
        $nilaiSekretaris = Nilaisekretaris::where('sidang_ta_id', $sidangTa->id)->with('dosen')->first();
        $nilaiPembimbing1 = NilaiPembimbing1::where('sidang_ta_id', $sidangTa->id)->with('dosen')->first();
        $nilaiPembimbing2 = NilaiPembimbing2::where('sidang_ta_id', $sidangTa->id)->with('dosen')->first();
        $nilaiPenguji1 = NilaiPenguji1::where('sidang_ta_id', $sidangTa->id)->with('dosen')->first();
        $nilaiPenguji2 = NilaiPenguji2::where('sidang_ta_id', $sidangTa->id)->with('dosen')->first();

        $ratapembimbing = ((optional($nilaiPembimbing1)->total ?? 0) + (optional($nilaiPembimbing2)->total ?? 0)) / 2;
        $ratapenguji = ((optional($nilaiKetua)->total ?? 0) + (optional($nilaiSekretaris)->total ?? 0) + (optional($nilaiPenguji1)->total ?? 0) + (optional($nilaiPenguji2)->total ?? 0)) / 4;
        $totalnilai = ((optional($nilaiPembimbing1)->total ?? 0) + (optional($nilaiPembimbing2)->total ?? 0) + (optional($nilaiKetua)->total ?? 0) + (optional($nilaiSekretaris)->total ?? 0) + (optional($nilaiPenguji1)->total ?? 0) + (optional($nilaiPenguji2)->total ?? 0)) / 6;

        $ratapembimbing = number_format($ratapembimbing, 2);
        $ratapenguji = number_format($ratapenguji, 2);
        $totalnilai = number_format($totalnilai, 2);

        $countLulus = 0;
        if (optional($nilaiKetua)->total >= 65)
            $countLulus++;
        if (optional($nilaiSekretaris)->total >= 65)
            $countLulus++;
        if (optional($nilaiPenguji1)->total >= 65)
            $countLulus++;
        if (optional($nilaiPenguji2)->total >= 65)
            $countLulus++;
        $statusSidang = ($countLulus >= 3) ? '1' : '0';

        // Simpan nilai total pembimbing
        NilaiTa::updateOrCreate(
            ['sidang_ta_id' => $sidangTa->id],
            [
                'mahasiswa_id' => $sidangTa->mahasiswa_id,
                'total_pem1' => optional($nilaiPembimbing1)->total,
                'total_pem2' => optional($nilaiPembimbing2)->total,
                'rata_pem' => $ratapembimbing,
                'total_ketua' => optional($nilaiKetua)->total,
                'total_sekretaris' => optional($nilaiSekretaris)->total,
                'total_penguji1' => optional($nilaiPenguji1)->total,
                'total_penguji2' => optional($nilaiPenguji2)->total,
                'rata_penguji' => $ratapenguji,
                'total' => $totalnilai,
                'status' => $statusSidang,
            ]
        );

        // Hitung total nilai

        return view('pages.mahasiswa.nilaiTa.nilai', compact('nilaiKetua', 'nilaiSekretaris', 'nilaiPembimbing1', 'nilaiPembimbing2', 'nilaiPenguji1', 'nilaiPenguji2', 'ratapembimbing', 'ratapenguji', 'totalnilai', 'statusSidang'));
    }

    public function indexForAdmin()
    {
        // Get the logged-in Kaprodi's prodi_id

        $jadwals = SidangTa::with(['dokumen_sidang', 'mahasiswa'])
            ->get();

        return view('pages.admin.nilaiTa.index', compact('jadwals'));
    }

    public function nilaiAdmin($id)
    {
        // Mengambil data sidang TA berdasarkan ID
        $sidangTa = SidangTa::findOrFail($id);

        $nilaiKetua = Nilaiketua::where('sidang_ta_id', $sidangTa->id)->with('dosen')->first();
        $nilaiSekretaris = Nilaisekretaris::where('sidang_ta_id', $sidangTa->id)->with('dosen')->first();
        $nilaiPembimbing1 = NilaiPembimbing1::where('sidang_ta_id', $sidangTa->id)->with('dosen')->first();
        $nilaiPembimbing2 = NilaiPembimbing2::where('sidang_ta_id', $sidangTa->id)->with('dosen')->first();
        $nilaiPenguji1 = NilaiPenguji1::where('sidang_ta_id', $sidangTa->id)->with('dosen')->first();
        $nilaiPenguji2 = NilaiPenguji2::where('sidang_ta_id', $sidangTa->id)->with('dosen')->first();

        $ratapembimbing = ((optional($nilaiPembimbing1)->total ?? 0) + (optional($nilaiPembimbing2)->total ?? 0)) / 2;
        $ratapenguji = ((optional($nilaiKetua)->total ?? 0) + (optional($nilaiSekretaris)->total ?? 0) + (optional($nilaiPenguji1)->total ?? 0) + (optional($nilaiPenguji2)->total ?? 0)) / 4;
        $totalnilai = ((optional($nilaiPembimbing1)->total ?? 0) + (optional($nilaiPembimbing2)->total ?? 0) + (optional($nilaiKetua)->total ?? 0) + (optional($nilaiSekretaris)->total ?? 0) + (optional($nilaiPenguji1)->total ?? 0) + (optional($nilaiPenguji2)->total ?? 0)) / 6;

        $ratapembimbing = number_format($ratapembimbing, 2);
        $ratapenguji = number_format($ratapenguji, 2);
        $totalnilai = number_format($totalnilai, 2);

        $countLulus = 0;
        if (optional($nilaiKetua)->total >= 65)
            $countLulus++;
        if (optional($nilaiSekretaris)->total >= 65)
            $countLulus++;
        if (optional($nilaiPenguji1)->total >= 65)
            $countLulus++;
        if (optional($nilaiPenguji2)->total >= 65)
            $countLulus++;
        $statusSidang = ($countLulus >= 3) ? '1' : '0';

        // Simpan nilai total pembimbing
        NilaiTa::updateOrCreate(
            ['sidang_ta_id' => $sidangTa->id],
            [
                'mahasiswa_id' => $sidangTa->mahasiswa_id,
                'total_pem1' => optional($nilaiPembimbing1)->total,
                'total_pem2' => optional($nilaiPembimbing2)->total,
                'rata_pem' => $ratapembimbing,
                'total_ketua' => optional($nilaiKetua)->total,
                'total_sekretaris' => optional($nilaiSekretaris)->total,
                'total_penguji1' => optional($nilaiPenguji1)->total,
                'total_penguji2' => optional($nilaiPenguji2)->total,
                'rata_penguji' => $ratapenguji,
                'total' => $totalnilai,
                'status' => $statusSidang,
            ]
        );

        return view('pages.admin.nilaiTa.nilai', compact('nilaiKetua', 'nilaiSekretaris', 'nilaiPembimbing1', 'nilaiPembimbing2', 'nilaiPenguji1', 'nilaiPenguji2', 'ratapembimbing', 'ratapenguji', 'totalnilai', 'statusSidang'));
    }


    public function indexForKaprodi()
    {
        // Get the logged-in Kaprodi's prodi_id
        $kaprodi = Kaprodi::where('user_id', Auth::id())->first();
        $prodi_id = $kaprodi->prodi_id; // Assuming Kaprodi has a prodi_id attribute

        $jadwals = SidangTa::with(['dokumen_sidang', 'mahasiswa'])
            ->whereHas('mahasiswa', function ($query) use ($prodi_id) {
                $query->where('prodi_id', $prodi_id);
            })
            ->get();

        return view('pages.kaprodi.nilaiTa.index', compact('jadwals'));
    }

    public function nilaiKaprodi($id)
    {
        // Mengambil data sidang TA berdasarkan ID
        $sidangTa = SidangTa::findOrFail($id);

        $nilaiKetua = Nilaiketua::where('sidang_ta_id', $sidangTa->id)->with('dosen')->first();
        $nilaiSekretaris = Nilaisekretaris::where('sidang_ta_id', $sidangTa->id)->with('dosen')->first();
        $nilaiPembimbing1 = NilaiPembimbing1::where('sidang_ta_id', $sidangTa->id)->with('dosen')->first();
        $nilaiPembimbing2 = NilaiPembimbing2::where('sidang_ta_id', $sidangTa->id)->with('dosen')->first();
        $nilaiPenguji1 = NilaiPenguji1::where('sidang_ta_id', $sidangTa->id)->with('dosen')->first();
        $nilaiPenguji2 = NilaiPenguji2::where('sidang_ta_id', $sidangTa->id)->with('dosen')->first();

        $ratapembimbing = ((optional($nilaiPembimbing1)->total ?? 0) + (optional($nilaiPembimbing2)->total ?? 0)) / 2;
        $ratapenguji = ((optional($nilaiKetua)->total ?? 0) + (optional($nilaiSekretaris)->total ?? 0) + (optional($nilaiPenguji1)->total ?? 0) + (optional($nilaiPenguji2)->total ?? 0)) / 4;
        $totalnilai = ((optional($nilaiPembimbing1)->total ?? 0) + (optional($nilaiPembimbing2)->total ?? 0) + (optional($nilaiKetua)->total ?? 0) + (optional($nilaiSekretaris)->total ?? 0) + (optional($nilaiPenguji1)->total ?? 0) + (optional($nilaiPenguji2)->total ?? 0)) / 6;

        $ratapembimbing = number_format($ratapembimbing, 2);
        $ratapenguji = number_format($ratapenguji, 2);
        $totalnilai = number_format($totalnilai, 2);

        $countLulus = 0;
        if (optional($nilaiKetua)->total >= 65)
            $countLulus++;
        if (optional($nilaiSekretaris)->total >= 65)
            $countLulus++;
        if (optional($nilaiPenguji1)->total >= 65)
            $countLulus++;
        if (optional($nilaiPenguji2)->total >= 65)
            $countLulus++;
        $statusSidang = ($countLulus >= 3) ? '1' : '0';

        // Simpan nilai total pembimbing
        NilaiTa::updateOrCreate(
            ['sidang_ta_id' => $sidangTa->id],
            [
                'mahasiswa_id' => $sidangTa->mahasiswa_id,
                'total_pem1' => optional($nilaiPembimbing1)->total,
                'total_pem2' => optional($nilaiPembimbing2)->total,
                'rata_pem' => $ratapembimbing,
                'total_ketua' => optional($nilaiKetua)->total,
                'total_sekretaris' => optional($nilaiSekretaris)->total,
                'total_penguji1' => optional($nilaiPenguji1)->total,
                'total_penguji2' => optional($nilaiPenguji2)->total,
                'rata_penguji' => $ratapenguji,
                'total' => $totalnilai,
                'status' => $statusSidang,
            ]
        );

        // Hitung total nilai

        return view('pages.kaprodi.nilaiTa.nilai', compact('nilaiKetua', 'nilaiSekretaris', 'nilaiPembimbing1', 'nilaiPembimbing2', 'nilaiPenguji1', 'nilaiPenguji2', 'ratapembimbing', 'ratapenguji', 'totalnilai', 'statusSidang'));
    }

    public function indexForDosen()
    {
        // Get the logged-in dosen's ID
        $dosen = Dosen::where('user_id', Auth::id())->first();

        // Fetch schedules where the logged-in dosen is either ketua, sekretaris, pembimbing 1, pembimbing 2, or penguji
        $jadwals = SidangTa::with(['dokumen_sidang', 'mahasiswa', 'nilaiKetua'])
            ->where('status', 1)
            ->where(function ($query) use ($dosen) {
                $query->where('ketua_id', $dosen->id)
                    ->orWhere('sekretaris_id', $dosen->id)
                    ->orWhere('pem1_id', $dosen->id)
                    ->orWhere('pem2_id', $dosen->id)
                    ->orWhere('penguji1_id', $dosen->id)
                    ->orWhere('penguji2_id', $dosen->id);
            })
            ->get();

        return view('pages.dosen.nilaiTampil.index', compact('jadwals'));
    }

    public function nilaiDosen($id)
    {
        // Mengambil data sidang TA berdasarkan ID
        $sidangTa = SidangTa::findOrFail($id);

        $nilaiKetua = Nilaiketua::where('sidang_ta_id', $sidangTa->id)->with('dosen')->first();
        $nilaiSekretaris = Nilaisekretaris::where('sidang_ta_id', $sidangTa->id)->with('dosen')->first();
        $nilaiPembimbing1 = NilaiPembimbing1::where('sidang_ta_id', $sidangTa->id)->with('dosen')->first();
        $nilaiPembimbing2 = NilaiPembimbing2::where('sidang_ta_id', $sidangTa->id)->with('dosen')->first();
        $nilaiPenguji1 = NilaiPenguji1::where('sidang_ta_id', $sidangTa->id)->with('dosen')->first();
        $nilaiPenguji2 = NilaiPenguji2::where('sidang_ta_id', $sidangTa->id)->with('dosen')->first();

        $ratapembimbing = ((optional($nilaiPembimbing1)->total ?? 0) + (optional($nilaiPembimbing2)->total ?? 0)) / 2;
        $ratapenguji = ((optional($nilaiKetua)->total ?? 0) + (optional($nilaiSekretaris)->total ?? 0) + (optional($nilaiPenguji1)->total ?? 0) + (optional($nilaiPenguji2)->total ?? 0)) / 4;
        $totalnilai = ((optional($nilaiPembimbing1)->total ?? 0) + (optional($nilaiPembimbing2)->total ?? 0) + (optional($nilaiKetua)->total ?? 0) + (optional($nilaiSekretaris)->total ?? 0) + (optional($nilaiPenguji1)->total ?? 0) + (optional($nilaiPenguji2)->total ?? 0)) / 6;

        $ratapembimbing = number_format($ratapembimbing, 2);
        $ratapenguji = number_format($ratapenguji, 2);
        $totalnilai = number_format($totalnilai, 2);

        $countLulus = 0;
        if (optional($nilaiKetua)->total >= 65)
            $countLulus++;
        if (optional($nilaiSekretaris)->total >= 65)
            $countLulus++;
        if (optional($nilaiPenguji1)->total >= 65)
            $countLulus++;
        if (optional($nilaiPenguji2)->total >= 65)
            $countLulus++;
        $statusSidang = ($countLulus >= 3) ? '1' : '0';

        // Simpan nilai total pembimbing
        NilaiTa::updateOrCreate(
            ['sidang_ta_id' => $sidangTa->id],
            [
                'mahasiswa_id' => $sidangTa->mahasiswa_id,
                'total_pem1' => optional($nilaiPembimbing1)->total,
                'total_pem2' => optional($nilaiPembimbing2)->total,
                'rata_pem' => $ratapembimbing,
                'total_ketua' => optional($nilaiKetua)->total,
                'total_sekretaris' => optional($nilaiSekretaris)->total,
                'total_penguji1' => optional($nilaiPenguji1)->total,
                'total_penguji2' => optional($nilaiPenguji2)->total,
                'rata_penguji' => $ratapenguji,
                'total' => $totalnilai,
                'status' => $statusSidang,
            ]
        );

        // Hitung total nilai

        return view('pages.dosen.nilaiTampil.nilai', compact('nilaiKetua', 'nilaiSekretaris', 'nilaiPembimbing1', 'nilaiPembimbing2', 'nilaiPenguji1', 'nilaiPenguji2', 'ratapembimbing', 'ratapenguji', 'totalnilai', 'statusSidang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(NilaiTa $nilaiTa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NilaiTa $nilaiTa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NilaiTa $nilaiTa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NilaiTa $nilaiTa)
    {
        //
    }
}
