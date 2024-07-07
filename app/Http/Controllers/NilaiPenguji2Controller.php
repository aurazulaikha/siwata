<?php

namespace App\Http\Controllers;

use App\Models\NilaiPenguji2;
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


class NilaiPenguji2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        // Get the logged-in dosen's ID
        $dosen = Dosen::where('user_id', Auth::id())->first();

        // Fetch schedules where the logged-in dosen is either pembimbing 1, pembimbing 2, or penguji
        $jadwals = SidangTa::with(['dokumen_sidang', 'mahasiswa', 'nilaiPenguji2'])
            ->where('status', 1)
            ->where('penguji2_id', $dosen->id)
            ->get();

        return view('pages.dosen.nilaiTa.penguji2.index', compact('jadwals'));
    }

    public function nilai($id)
    {
        // Mengambil data sidang TA berdasarkan ID
        $sidangTa = SidangTa::findOrFail($id);

        // Mengambil data nilai penguji2 yang terkait dengan sidang TA
        $nilaiPenguji2 = NilaiPenguji2::where('sidang_ta_id', $sidangTa->id)->get();

        return view('pages.dosen.nilaiTa.penguji2.nilai', compact('sidangTa', 'nilaiPenguji2'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($sidang_ta_id)
    {
        // Ambil data sidang_ta untuk ditampilkan di form
        $sidangTa = SidangTa::findOrFail($sidang_ta_id);
        return view('pages.dosen.nilaiTa.penguji2.input', compact('sidangTa', 'sidang_ta_id'));
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

        $nilaiPenguji2 = NilaiPenguji2::where('sidang_ta_id', $sidang_ta_id)->firstOrFail();

        $nilaiPenguji2->update([
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

        return redirect()->route('sidangTa.penguji2')->with('success', 'Nilai berhasil diinputkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $jadwals = SidangTa::findOrFail($id);
        // Ambil data yang dibutuhkan untuk menampilkan form input nilai
        return view('pages.dosen.nilaiTa.penguji2.input', compact('jadwals'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $nilaiPenguji2 = NilaiPenguji2::findOrFail($id);
        $sidangTa = $nilaiPenguji2->sidangTa;

        return view('pages.dosen.nilaiTa.penguji2.edit', compact('sidangTa', 'nilaiPenguji2'));
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

        $nilaiPenguji2 = NilaiPenguji2::findOrFail($id);

        $nilaiPenguji2->update([
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

        return redirect()->route('sidangTa.penguji2')->with('success', 'Nilai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NilaiPenguji2 $nilaiPenguji2)
    {
        //
    }
}
