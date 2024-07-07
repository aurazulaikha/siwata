<?php

namespace App\Http\Controllers;

use App\Models\NilaiPembimbing2;
use Illuminate\Http\Request;
use App\Models\SidangTa;
use App\Models\DokumenSidang;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\SidangProposal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class NilaiPembimbing2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the logged-in dosen's ID
        $dosen = Dosen::where('user_id', Auth::id())->first();

        // Fetch schedules where the logged-in dosen is either pembimbing 1, pembimbing 2, or penguji
        $jadwals = SidangTa::with(['dokumen_sidang', 'mahasiswa', 'nilaiPembimbing2'])
            ->where('status', 1)
            ->where('pem2_id', $dosen->id)
            ->get();

        return view('pages.dosen.nilaiTa.pembimbing2.index', compact('jadwals'));
    }

    public function nilai($id)
    {
        // Mengambil data sidang TA berdasarkan ID
        $sidangTa = SidangTa::findOrFail($id);

        // Mengambil data nilai ketua yang terkait dengan sidang TA
        $nilaiPembimbing2 = NilaiPembimbing2::where('sidang_ta_id', $sidangTa->id)->get();

        return view('pages.dosen.nilaiTa.pembimbing2.nilai', compact('sidangTa', 'nilaiPembimbing2'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($sidang_ta_id)
    {
        // Ambil data sidang_ta untuk ditampilkan di form
        $sidangTa = SidangTa::findOrFail($sidang_ta_id);
        return view('pages.dosen.nilaiTa.pembimbing2.input', compact('sidangTa', 'sidang_ta_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $sidang_ta_id)
    {
        // Validasi input
        $request->validate([
            'b1' => 'required',
            'b2' => 'required',
            'b3' => 'required',
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

        $nilaiPembimbing2 = NilaiPembimbing2::where('sidang_ta_id', $sidang_ta_id)->firstOrFail();

        $nilaiPembimbing2->update([
            'b1' => $request->b1,
            'b2' => $request->b2,
            'b3' => $request->b3,
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

        return redirect()->route('sidangTa.pembimbing2')->with('success', 'Nilai berhasil diinputkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $jadwals = SidangTa::findOrFail($id);
        // Ambil data yang dibutuhkan untuk menampilkan form input nilai
        return view('pages.dosen.nilaiTa.pembimbing2.input', compact('jadwals'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $nilaiPembimbing2 = NilaiPembimbing2::findOrFail($id);
        $sidangTa = $nilaiPembimbing2->sidangTa;

        return view('pages.dosen.nilaiTa.pembimbing2.edit', compact('sidangTa', 'nilaiPembimbing2'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'b1' => 'required',
            'b2' => 'required',
            'b3' => 'required',
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

        $nilaiPembimbing2 = NilaiPembimbing2::findOrFail($id);

        $nilaiPembimbing2->update([
            'b1' => $request->b1,
            'b2' => $request->b2,
            'b3' => $request->b3,
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

        return redirect()->route('sidangTa.pembimbing2')->with('success', 'Nilai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NilaiPembimbing2 $nilaiPembimbing2)
    {
        //
    }
}
