<?php

namespace App\Http\Controllers;

use App\Models\ProposalTa;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Pembimbing1;
use App\Models\Kaprodi;
use App\Models\Pembimbing2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class ProposalTaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the logged-in user's mahasiswa_id
        $mahasiswa = Mahasiswa::where('nobp', Auth::user()->nobp)->first();
        $dosen = Dosen::orderBy('nama', 'asc')->get();

        // Retrieve proposals only for the logged-in user
        $proposal_ta = ProposalTa::where('mahasiswa_id', $mahasiswa->id)
            ->orderBy('id', 'asc')
            ->get();

        // Retrieve Pembimbing 1 and Pembimbing 2 based on mahasiswa_id
        $pembimbing1 = Pembimbing1::where('mahasiswa_id', $mahasiswa->id)->first();
        $pembimbing2 = Pembimbing2::where('mahasiswa_id', $mahasiswa->id)->first();

        return view('pages.mahasiswa.proposalTa.index', compact('proposal_ta', 'dosen', 'pembimbing1', 'pembimbing2'));
    }

    // In your ProposalTaController



    public function indexForDosen1()
    {
        // Get the logged-in user's dosen_id
        $dosen = Dosen::where('user_id', Auth::id())->first();
        $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get();
        // Retrieve proposals where the logged-in user is a pembimbing 1 or pembimbing 2
        $proposal_ta = ProposalTa::whereHas('pem1', function ($query) use ($dosen) {
            $query->where('dosen_id', $dosen->id);
        })->orderBy('id', 'asc')->get();

        return view('pages.dosen.proposalTa.pem1', compact('proposal_ta', 'mahasiswa', 'dosen'));
    }



    public function saveComment(Request $request, $id)
    {
        $request->validate([
            'komentar' => 'required|string|max:255',
        ]);

        // Temukan proposal berdasarkan ID
        $proposal = ProposalTa::findOrFail($id);

        // Ambil ID dosen yang sedang login
        $dosen_id = Dosen::where('user_id', Auth::id())->value('id');

        // Cek apakah dosen merupakan pembimbing 1 dari proposal
        $pembimbing1 = Pembimbing1::where('dosen_id', $dosen_id)->where('proposal_ta_id', $proposal->id)->first();
        if ($pembimbing1) {
            // Ubah komentar pembimbing 1 dan simpan perubahan
            $proposal->pem1->komentar = $request->komentar;
            $proposal->pem1->save();
        }

        // Cek apakah dosen merupakan pembimbing 2 dari proposal
        $pembimbing2 = Pembimbing2::where('dosen_id', $dosen_id)->where('proposal_ta_id', $proposal->id)->first();
        if ($pembimbing2) {
            // Ubah komentar pembimbing 2 dan simpan perubahan
            $proposal->pem2->komentar = $request->komentar;
            $proposal->pem2->save();
        }

        return redirect()->back()->with('success', 'Komentar berhasil disimpan.');
    }

    public function commentKaprodi(Request $request, $id)
    {
        $request->validate([
            'komentar' => 'required|string|max:255',
        ]);

        // Temukan proposal berdasarkan ID
        $proposal = ProposalTa::findOrFail($id);
        $proposal->komentar = $request->komentar;
        $proposal->save();

        return redirect()->back()->with('success', 'Komentar berhasil disimpan.');
    }


    public function indexForDosen2()
    {
        // Get the logged-in user's dosen_id
        $dosen = Dosen::where('user_id', Auth::id())->first();
        $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get();
        // Retrieve proposals where the logged-in user is a pembimbing 1 or pembimbing 2
        $proposal_ta = ProposalTa::whereHas('pem2', function ($query) use ($dosen) {
            $query->where('dosen_id', $dosen->id);
        })->orderBy('id', 'asc')->get();


        return view('pages.dosen.proposalTa.pem2', compact('proposal_ta', 'mahasiswa', 'dosen'));
    }


    public function indexForKaprodi()
    {
        $kaprodi = Kaprodi::where('user_id', Auth::id())->first();
        $prodi_id = $kaprodi->prodi_id; // Assuming Kaprodi has a prodi_id attribute

        $proposal_ta = ProposalTA::with(['mahasiswa', 'pem1', 'pem2'])
            ->whereHas('mahasiswa', function ($query) use ($prodi_id) {
                $query->where('prodi_id', $prodi_id);
            })
            ->get();

        return view('pages.kaprodi.proposalTa.index', compact('proposal_ta'));
    }

    public function verifyProposal($id)
    {
        // Logic to verify the proposal
        $proposal = ProposalTa::find($id);

        if ($proposal->pem1->status == 1 && $proposal->pem2->status == 1) {
            // Update the proposal status or perform any necessary actions
            // For example:
            $proposal->verifikasi = 1;
            $proposal->save();

            return redirect()->route('proposalTa.IndexForKaprodi')->with('success', 'Proposal berhasil diverifikasi.');
        } else {
            return redirect()->route('proposalTa.IndexForKaprodi')->with('error', 'Proposal belum memenuhi syarat verifikasi.');
        }
    }

    public function statusProposal1($id)
    {
        // Temukan proposal berdasarkan ID
        $proposal = ProposalTa::findOrFail($id);

        // Ambil ID dosen yang sedang login
        $dosen_id = Dosen::where('user_id', Auth::id())->value('id');

        // Cek apakah dosen merupakan pembimbing 1 dari proposal
        $pembimbing1 = Pembimbing1::where('dosen_id', $dosen_id)->where('proposal_ta_id', $proposal->id)->first();
        if ($pembimbing1) {
            // Ubah status pembimbing 1 menjadi 'verified' dan simpan perubahan
            $pembimbing1->status = true;
            $pembimbing1->save();
        }

        // Redirect ke halaman yang sesuai dan sertakan pesan sukses
        return redirect()->route('proposalTa.indexForDosen1')->with('success', 'Proposal verified successfully');
    }

    public function statusProposal2($id)
    {
        // Temukan proposal berdasarkan ID
        $proposal = ProposalTa::findOrFail($id);

        // Ambil ID dosen yang sedang login
        $dosen_id = Dosen::where('user_id', Auth::id())->value('id');


        // Cek apakah dosen merupakan pembimbing 2 dari proposal
        $pembimbing2 = Pembimbing2::where('dosen_id', $dosen_id)->where('proposal_ta_id', $proposal->id)->first();
        if ($pembimbing2) {
            // Ubah status pembimbing 2 menjadi 'verified' dan simpan perubahan
            $pembimbing2->status = true;
            $pembimbing2->save();
        }

        // Redirect ke halaman yang sesuai dan sertakan pesan sukses
        return redirect()->route('proposalTa.indexForDosen2')->with('success', 'Proposal verified successfully');
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
        $this->validate($request, [
            'file' => 'required|file|mimes:pdf,docx|max:2048',
            'judul' => 'required|string|max:255',
        ]);

        $mahasiswa = Mahasiswa::where('nobp', Auth::user()->nobp)->first();

        // menyimpan data file yang diupload ke variabel $file
        $file = $request->file('file');

        $nama_file = time() . "_" . $file->getClientOriginalName();


        $tujuan_upload = 'public/data_file';

        if (!file_exists(public_path('data_file'))) {
            mkdir(public_path('data_file'), 0777, true);
        }

        $file->move(public_path('data_file'), $nama_file);
        $proposal_ta = ProposalTa::create([
            'mahasiswa_id' => $mahasiswa->id,
            'nobp' => $mahasiswa->nobp,
            'judul' => $request->judul,
            'file' => $nama_file
        ]);

        Pembimbing1::updateOrCreate(
            ['mahasiswa_id' => $mahasiswa->id],
            ['proposal_ta_id' => $proposal_ta->id]
        );

        // Menggunakan updateOrCreate untuk Pembimbing2
        Pembimbing2::updateOrCreate(
            ['mahasiswa_id' => $mahasiswa->id],
            ['proposal_ta_id' => $proposal_ta->id]
        );

        return redirect()->route('proposalTa.index')->with('success', 'File Berhasil ditambahkan');
    }


    public function pem1(Request $request)
    {
        $mahasiswa = Mahasiswa::where('nobp', Auth::user()->nobp)->first();
        $proposal_ta = ProposalTa::where('mahasiswa_id', $mahasiswa->id)->first();

        if (!$proposal_ta) {
            return redirect()->route('proposalTa.index')->with('error', 'Anda harus meng-upload proposal terlebih dahulu.');
        }

        $this->validate($request, [
            'dosen_id' => 'required|exists:dosens,id', // Pastikan dosen_id yang diinput sudah ada dalam tabel dosens
        ]);

        $mahasiswa = Mahasiswa::where('nobp', Auth::user()->nobp)->first();

        $dosen = Dosen::find($request->dosen_id);

        // Cek apakah sudah ada record Pembimbing1 untuk mahasiswa ini
        $pembimbing1 = Pembimbing1::where('mahasiswa_id', $mahasiswa->id)->first();

        if ($pembimbing1) {
            // Jika sudah ada, update dosen_id
            $pembimbing1->update(['dosen_id' => $request->dosen_id,]);
        } else {
            // Jika belum ada, buat record baru dengan dosen_id
            Pembimbing1::create([
                'mahasiswa_id' => $mahasiswa->id,
                'dosen_id' => $request->dosen_id,
            ]);
        }

        return redirect()->back()->with('success', 'Dosen added to Pembimbing 1 successfully.');
    }

    public function pem2(Request $request)
    {
        $mahasiswa = Mahasiswa::where('nobp', Auth::user()->nobp)->first();
        $proposal_ta = ProposalTa::where('mahasiswa_id', $mahasiswa->id)->first();

        if (!$proposal_ta) {
            return redirect()->route('proposalTa.index')->with('error', 'Anda harus meng-upload proposal terlebih dahulu.');
        }

        $this->validate($request, [
            'dosen_id' => 'required|exists:dosens,id', // Pastikan dosen_id yang diinput sudah ada dalam tabel dosens
        ]);


        $mahasiswa = Mahasiswa::where('nobp', Auth::user()->nobp)->first();
        $dosen = Dosen::find($request->dosen_id);

        // Cek apakah sudah ada record Pembimbing1 untuk mahasiswa ini
        $pembimbing2 = Pembimbing2::where('mahasiswa_id', $mahasiswa->id)->first();

        if ($pembimbing2) {
            // Jika sudah ada, update dosen_id
            $pembimbing2->update(['dosen_id' => $request->dosen_id,]);
        } else {
            // Jika belum ada, buat record baru dengan dosen_id
            Pembimbing2::create([
                'mahasiswa_id' => $mahasiswa->id,
                'dosen_id' => $request->dosen_id,
            ]);
        }

        return redirect()->back()->with('success', 'Dosen added to Pembimbing 2 successfully.');
    }



    /**
     * Display the specified resource.
     */
    public function show(ProposalTa $proposalTa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProposalTa $proposalTa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProposalTa $proposalTa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $proposal_ta = ProposalTa::find($id);

        if ($proposal_ta) {
            // Menghapus entri terkait di tabel Pembimbing1
            Pembimbing1::where('proposal_ta_id', $proposal_ta->id)->delete();

            // Menghapus entri terkait di tabel Pembimbing2
            Pembimbing2::where('proposal_ta_id', $proposal_ta->id)->delete();

            // Menghapus entri di tabel DokumenSidang
            $proposal_ta->delete();

            return redirect()->route('proposalTa.index')->with('success', 'Data berhasil dihapus');
        } else {
            return redirect()->route('proposalTa.index')->with('error', 'Data tidak ditemukan');
        }
    }



}

