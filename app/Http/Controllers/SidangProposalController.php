<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProposalTA;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Ruangan;
use App\Models\Kaprodi;
use App\Models\Sesi;
use App\Models\SidangProposal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;

class SidangProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kaprodi = Kaprodi::where('user_id', Auth::id())->first();
        $prodi_id = $kaprodi->prodi_id; // Assuming Kaprodi has a prodi_id attribute

        // Fetch verified proposals for the same prodi_id as the Kaprodi, excluding those already scheduled
        $scheduledProposalIds = SidangProposal::pluck('proposal_ta_id')->toArray();
        $proposal_ta = ProposalTA::with(['mahasiswa', 'pem1', 'pem2'])
            ->where('verifikasi', 1) // Only fetch verified proposals
            ->whereNotIn('id', $scheduledProposalIds) // Exclude scheduled proposals
            ->whereHas('mahasiswa', function ($query) use ($prodi_id) {
                $query->where('prodi_id', $prodi_id);
            })
            ->get();

        // Fetch schedules for students with the same prodi_id as the Kaprodi
        $jadwals = SidangProposal::with(['proposal', 'mahasiswa', 'pem1', 'pem2', 'penguji', 'ruang', 'sesi'])
            ->whereHas('mahasiswa', function ($query) use ($prodi_id) {
                $query->where('prodi_id', $prodi_id);
            })
            ->get();

        $mahasiswas = Mahasiswa::all();
        $dosens = Dosen::all();
        $ruangans = Ruangan::all();
        $sesis = Sesi::all();

        return view('pages.kaprodi.sidangProposal.index', compact('jadwals', 'proposal_ta', 'mahasiswas', 'dosens', 'ruangans', 'sesis'));
    }

    public function indexForMahasiswa()
    {
        // Get the logged-in dosen's ID
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->first();

        // Fetch schedules where the logged-in dosen is either pembimbing 1, pembimbing 2, or penguji
        $jadwals = SidangProposal::with(['proposal', 'mahasiswa', 'pem1', 'pem2', 'penguji', 'ruang', 'sesi'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->get();

        return view('pages.mahasiswa.sidangProposal.index', compact('jadwals'));
    }
    public function indexForPem1()
    {
        // Get the logged-in dosen's ID
        $dosen = Dosen::where('user_id', Auth::id())->first();

        // Fetch schedules where the logged-in dosen is either pembimbing 1, pembimbing 2, or penguji
        $jadwals = SidangProposal::with(['proposal', 'mahasiswa', 'pem1', 'pem2', 'penguji', 'ruang', 'sesi'])
            ->where('pem1_id', $dosen->id)
            ->get();

        return view('pages.dosen.sidangProposal.pem1', compact('jadwals'));
    }

    public function indexForPem2()
    {
        // Get the logged-in dosen's ID
        $dosen = Dosen::where('user_id', Auth::id())->first();

        // Fetch schedules where the logged-in dosen is either pembimbing 1, pembimbing 2, or penguji
        $jadwals = SidangProposal::with(['proposal', 'mahasiswa', 'pem1', 'pem2', 'penguji', 'ruang', 'sesi'])
            ->where('pem2_id', $dosen->id)
            ->get();

        return view('pages.dosen.sidangProposal.pem2', compact('jadwals'));
    }

    public function indexForPenguji()
    {
        // Get the logged-in dosen's ID
        $dosen = Dosen::where('user_id', Auth::id())->first();

        // Fetch schedules where the logged-in dosen is either pembimbing 1, pembimbing 2, or penguji
        $jadwals = SidangProposal::with(['proposal', 'mahasiswa', 'pem1', 'pem2', 'penguji', 'ruang', 'sesi'])
            ->where('penguji_id', $dosen->id)
            ->get();

        return view('pages.dosen.sidangProposal.penguji', compact('jadwals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'proposal_ta_id' => 'required',
            'tanggal' => 'required|date',
            'ruangan' => 'required|exists:ruangans,id',
            'sesi' => 'required|exists:sesis,id',
            'penguji' => 'required',
        ]);

        // Check if there is an existing schedule with the same date, room, and session
        $existingSchedule = SidangProposal::where('tanggal', $request->tanggal)
            ->where('ruangan', $request->ruangan)
            ->where('sesi', $request->sesi)
            ->first();

        if ($existingSchedule) {
            return redirect()->route('sidang_proposal.index')->with('error', 'Tidak bisa menambahkan jadwal, karena ada jadwal lain pada tanggal, ruangan, dan sesi yang dipilih.');
        }

        // Ambil pembimbing dari tabel proposal_ta
        $proposal = ProposalTA::findOrFail($request->proposal_ta_id);

        SidangProposal::create([
            'proposal_ta_id' => $request->proposal_ta_id,
            'tanggal' => $request->tanggal,
            'ruangan' => $request->ruangan,
            'sesi' => $request->sesi,
            'mahasiswa_id' => $proposal->mahasiswa_id,
            'pem1_id' => $proposal->pem1->dosen_id,
            'pem2_id' => $proposal->pem2->dosen_id,
            'penguji_id' => $request->penguji,
        ]);

        return redirect()->route('sidang_proposal.index')->with('success', 'Jadwal Sidang Proposal berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SidangProposal $sidangProposal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $jadwal = SidangProposal::findOrFail($id);
        $kaprodi = Kaprodi::where('user_id', Auth::id())->first();
        $prodi_id = $kaprodi->prodi_id; // Assuming Kaprodi has a prodi_id attribute
        $proposal_ta = ProposalTA::with(['mahasiswa', 'pem1', 'pem2'])
            ->whereHas('mahasiswa', function ($query) use ($prodi_id) {
                $query->where('prodi_id', $prodi_id);
            })
            ->get();
        $mahasiswas = Mahasiswa::all();
        $dosens = Dosen::all();
        $ruangans = Ruangan::all();
        $sesis = Sesi::all();

        return view('pages.kaprodi.sidangProposal.edit', compact('jadwal', 'proposal_ta', 'mahasiswas', 'dosens', 'ruangans', 'sesis'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SidangProposal $sidangProposal)
    {


        // Check for existing schedules with the same date, room, and session
        $existingSchedule = SidangProposal::where('tanggal', $request->tanggal)
            ->where('ruangan', $request->ruangan)
            ->where('sesi', $request->sesi)
            ->where('id', '!=', $sidangProposal->id)
            ->first();

        if ($existingSchedule) {
            return redirect()->route('sidang_proposal.index')->with('error', 'Jadwal tidak bisa ditambahkan karena ada jadwal pada waktu yang dipilih.');
        }

        $sidangProposal->proposal_ta_id = $request->proposal_ta_id;
        $sidangProposal->tanggal = $request->tanggal;
        $sidangProposal->ruangan = $request->ruangan;
        $sidangProposal->sesi = $request->sesi;
        $sidangProposal->pem1_id = $request->pem1_id;
        $sidangProposal->pem2_id = $request->pem2_id;
        $sidangProposal->penguji_id = $request->penguji_id;
        $sidangProposal->save();

        return redirect()->route('sidang_proposal.index')->with('success', 'Data jadwal sidang proposal berhasil diubah.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $sidangProposal = SidangProposal::find($id);

        $sidangProposal->delete();
        return redirect()->route('sidang_proposal.index')->with('success', 'Jadwal Berhasil Dihapus');
    }
}
