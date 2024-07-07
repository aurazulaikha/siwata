<?php

namespace App\Http\Controllers;

use App\Models\NilaiKetua;
use Illuminate\Http\Request;
use App\Models\SidangTa;
use App\Models\DokumenSidang;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\SidangProposal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;


class NilaiKetuaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        // Get the logged-in dosen's ID
        $dosen = Dosen::where('user_id', Auth::id())->first();

        // Fetch schedules where the logged-in dosen is either pembimbing 1, pembimbing 2, or penguji
        $jadwals = SidangTa::with(['dokumen_sidang', 'mahasiswa', 'nilaiKetua'])
            ->where('status', 1)
            ->where('ketua_id', $dosen->id)
            ->get();

        return view('pages.dosen.nilaiTa.ketua.index', compact('jadwals'));
    }

    public function nilai($id)
    {
        // Mengambil data sidang TA berdasarkan ID
        $sidangTa = SidangTa::findOrFail($id);

        // Mengambil data nilai ketua yang terkait dengan sidang TA
        $nilaiKetua = NilaiKetua::where('sidang_ta_id', $sidangTa->id)->get();

        return view('pages.dosen.nilaiTa.ketua.nilai', compact('sidangTa', 'nilaiKetua'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($sidang_ta_id)
    {
        // Ambil data sidang_ta untuk ditampilkan di form
        $sidangTa = SidangTa::findOrFail($sidang_ta_id);
        return view('pages.dosen.nilaiTa.ketua.input', compact('sidangTa', 'sidang_ta_id'));
    }



    /**
     * Store a newly created resource in storage.
     */



    public function store(Request $request, $sidang_ta_id)
    {
        // Validasi input
        $request->validate([
            'p1' => 'required',
            'p2' => 'required',
            'p3' => 'required',
            'm1' => 'required',
            'm2' => 'required',
            'm3' => 'required',
            'm4' => 'required',
            'm5' => 'required',
            'm6' => 'required',
            'pro' => 'required',
            'total' => 'required',
            'komentar' => 'nullable',

        ]);

        $nilaiKetua = NilaiKetua::where('sidang_ta_id', $sidang_ta_id)->firstOrFail();

        $nilaiKetua->update([
            'p1' => $request->p1,
            'p2' => $request->p2,
            'p3' => $request->p3,
            'm1' => $request->m1,
            'm2' => $request->m2,
            'm3' => $request->m3,
            'm4' => $request->m4,
            'm5' => $request->m5,
            'm6' => $request->m6,
            'pro' => $request->pro,
            'total' => $request->total,
            'komentar' => $request->komentar,
        ]);

        return redirect()->route('sidangTa.ketua')->with('success', 'Nilai berhasil diinputkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $jadwals = SidangTa::findOrFail($id);
        // Ambil data yang dibutuhkan untuk menampilkan form input nilai
        return view('pages.dosen.nilaiTa.ketua.input', compact('jadwals'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $nilaiKetua = NilaiKetua::findOrFail($id);
        $sidangTa = $nilaiKetua->sidangTa;

        return view('pages.dosen.nilaiTa.ketua.edit', compact('sidangTa', 'nilaiKetua'));
    }
    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'p1' => 'required',
            'p2' => 'required',
            'p3' => 'required',
            'm1' => 'required',
            'm2' => 'required',
            'm3' => 'required',
            'm4' => 'required',
            'm5' => 'required',
            'm6' => 'required',
            'pro' => 'required',
            'total' => 'required',
            'komentar' => 'nullable',

        ]);

        $nilaiKetua = NilaiKetua::findOrFail($id);

        $nilaiKetua->update([
            'p1' => $request->p1,
            'p2' => $request->p2,
            'p3' => $request->p3,
            'm1' => $request->m1,
            'm2' => $request->m2,
            'm3' => $request->m3,
            'm4' => $request->m4,
            'm5' => $request->m5,
            'm6' => $request->m6,
            'pro' => $request->pro,
            'total' => $request->total,
            'komentar' => $request->komentar,
        ]);

        return redirect()->route('sidangTa.ketua')->with('success', 'Nilai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NilaiKetua $nilaiKetua)
    {
        //
    }
}
