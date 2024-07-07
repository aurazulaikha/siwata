<?php

namespace App\Http\Controllers;

use App\Models\ProposalTa;
use App\Models\DokumenSidang;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Pembimbing1;
use App\Models\Kaprodi;
use App\Models\Pembimbing2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class DokumenSidangController extends Controller
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
        $proposals = ProposalTa::where('mahasiswa_id', $mahasiswa->id)->get();

        // Retrieve dokumen_sidang, Pembimbing 1, and Pembimbing 2 based on mahasiswa_id
        $dokumen_sidang = DokumenSidang::where('mahasiswa_id', $mahasiswa->id)
            ->orderBy('id', 'asc')
            ->get();
        $pembimbing1 = Pembimbing1::where('mahasiswa_id', $mahasiswa->id)->first();
        $pembimbing2 = Pembimbing2::where('mahasiswa_id', $mahasiswa->id)->first();

        return view('pages.mahasiswa.dokumenSidang.index', compact('dokumen_sidang', 'dosen', 'pembimbing1', 'pembimbing2', 'proposals'));
    }


    public function indexForAdmin()
    {

        $dokumen_sidang = DokumenSidang::with(['mahasiswa', 'pem1', 'pem2'])->get();

        return view('pages.admin.dokumenSidang.index', compact('dokumen_sidang'));
    }


    public function indexForKaprodi()
    {
        $kaprodi = Kaprodi::where('user_id', Auth::id())->first();
        $prodi_id = $kaprodi->prodi_id; // Assuming Kaprodi has a prodi_id attribute

        $dokumen_sidang = DokumenSidang::with(['mahasiswa', 'pem1', 'pem2'])
            ->whereHas('mahasiswa', function ($query) use ($prodi_id) {
                $query->where('prodi_id', $prodi_id);
            })
            ->get();

        return view('pages.kaprodi.dokumenSidang.index', compact('dokumen_sidang'));
    }

    public function verifyProposal($id)
    {
        // Logic to verify the proposal
        $dokumen_sidang = DokumenSidang::find($id);

        if ($dokumen_sidang->pem1->status_dokumen == 1 && $dokumen_sidang->pem2->status_dokumen == 1) {
            // Update the proposal status or perform any necessary actions
            // For example:
            $dokumen_sidang->verifikasi = 1;
            $dokumen_sidang->save();

            return redirect()->route('dokumenSidang.IndexForKaprodi')->with('success', 'Proposal berhasil diverifikasi.');
        } else {
            return redirect()->route('dokumenSidang.IndexForKaprodi')->with('error', 'Proposal belum memenuhi syarat verifikasi.');
        }
    }

    public function commentKaprodi(Request $request, $id)
    {
        $request->validate([
            'komentar' => 'required|string|max:255',
        ]);

        // Temukan proposal berdasarkan ID
        $dokumen_sidang = DokumenSidang::findOrFail($id);
        $dokumen_sidang->komentar = $request->komentar;
        $dokumen_sidang->save();

        return redirect()->back()->with('success', 'Komentar berhasil disimpan.');
    }

    public function indexForDosen1()
    {
        // Get the logged-in user's dosen_id
        $dosen = Dosen::where('user_id', Auth::id())->first();
        $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get();
        // Retrieve proposals where the logged-in user is a pembimbing 1 or pembimbing 2
        $dokumen_sidang = DokumenSidang::whereHas('pem1', function ($query) use ($dosen) {
            $query->where('dosen_id', $dosen->id);
        })->orderBy('id', 'asc')->get();

        return view('pages.dosen.dokumenSidang.pem1', compact('dokumen_sidang', 'mahasiswa', 'dosen'));
    }

    public function statusProposal1($id)
    {
        // Temukan proposal berdasarkan ID
        $dokumen_sidang = DokumenSidang::findOrFail($id);

        // Ambil ID dosen yang sedang login
        $dosen_id = Dosen::where('user_id', Auth::id())->value('id');

        // Cek apakah dosen merupakan pembimbing 1 dari proposal
        $pembimbing1 = Pembimbing1::where('dosen_id', $dosen_id)->where('dokumen_sidang_id', $dokumen_sidang->id)->first();
        if ($pembimbing1) {
            // Ubah status pembimbing 1 menjadi 'verified' dan simpan perubahan
            $pembimbing1->status_dokumen = true;
            $pembimbing1->save();
        }

        // Redirect ke halaman yang sesuai dan sertakan pesan sukses
        return redirect()->route('dokumenSidang.indexForDosen1')->with('success', 'Dokumen sudah diverifikasi');
    }

    public function indexForDosen2()
    {
        // Get the logged-in user's dosen_id
        $dosen = Dosen::where('user_id', Auth::id())->first();
        $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get();
        // Retrieve proposals where the logged-in user is a pembimbing 1 or pembimbing 2
        $dokumen_sidang = DokumenSidang::whereHas('pem2', function ($query) use ($dosen) {
            $query->where('dosen_id', $dosen->id);
        })->orderBy('id', 'asc')->get();

        return view('pages.dosen.dokumenSidang.pem2', compact('dokumen_sidang', 'mahasiswa', 'dosen'));
    }

    public function statusProposal2($id)
    {
        // Temukan proposal berdasarkan ID
        $dokumen_sidang = DokumenSidang::findOrFail($id);

        // Ambil ID dosen yang sedang login
        $dosen_id = Dosen::where('user_id', Auth::id())->value('id');

        // Cek apakah dosen merupakan pembimbing 1 dari proposal
        $pembimbing2 = Pembimbing2::where('dosen_id', $dosen_id)->where('dokumen_sidang_id', $dokumen_sidang->id)->first();
        if ($pembimbing2) {
            // Ubah status pembimbing 1 menjadi 'verified' dan simpan perubahan
            $pembimbing2->status_dokumen = true;
            $pembimbing2->save();
        }

        // Redirect ke halaman yang sesuai dan sertakan pesan sukses
        return redirect()->route('dokumenSidang.indexForDosen2')->with('success', 'Dokumen sudah diverifikasi');
    }

    public function saveComment(Request $request, $id)
    {
        $request->validate([
            'komentar' => 'required|string|max:255',
        ]);

        // Temukan proposal berdasarkan ID
        $dokumen_sidang = DokumenSidang::findOrFail($id);

        // Ambil ID dosen yang sedang login
        $dosen_id = Dosen::where('user_id', Auth::id())->value('id');

        // Cek apakah dosen merupakan pembimbing 1 dari proposal
        $pembimbing1 = Pembimbing1::where('dosen_id', $dosen_id)->where('dokumen_sidang_id', $dokumen_sidang->id)->first();
        if ($pembimbing1) {
            // Ubah komentar pembimbing 1 dan simpan perubahan
            $dokumen_sidang->pem1->komentar_dokumen = $request->komentar;
            $dokumen_sidang->pem1->save();
        }

        // Cek apakah dosen merupakan pembimbing 2 dari proposal
        $pembimbing2 = Pembimbing2::where('dosen_id', $dosen_id)->where('dokumen_sidang_id', $dokumen_sidang->id)->first();
        if ($pembimbing2) {
            // Ubah komentar pembimbing 2 dan simpan perubahan
            $dokumen_sidang->pem2->komentar_dokumen = $request->komentar;
            $dokumen_sidang->pem2->save();
        }

        return redirect()->back()->with('success', 'Komentar berhasil disimpan.');
    }

    public function dokumenStatusMahasiswa()
    {
        // Your logic to get the status of proposals
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->first();

        $dokumen_sidang = DokumenSidang::with(['mahasiswa', 'pem1', 'pem2'])
            ->whereHas('pem1', function ($query) use ($mahasiswa) {
                $query->where('mahasiswa_id', $mahasiswa->id);
            })
            ->orWhereHas('pem2', function ($query) use ($mahasiswa) {
                $query->where('mahasiswa_id', $mahasiswa->id);
            })
            ->get();

        return view('pages.mahasiswa.dokumenSidang.status', compact('dokumen_sidang', 'mahasiswa'));
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
            'laporan_pkl' => 'required|file|mimes:pdf,docx|max:2048',
            'lembar_bimbingan' => 'required|file|mimes:pdf,docx|max:2048',
            'laporan_ta' => 'required|file|mimes:pdf,docx|max:2048',
        ]);

        $mahasiswa = Mahasiswa::where('nobp', Auth::user()->nobp)->first();

        $files = [
            'laporan_pkl' => $request->file('laporan_pkl'),
            'lembar_bimbingan' => $request->file('lembar_bimbingan'),
            'laporan_ta' => $request->file('laporan_ta')
        ];

        $uploaded_files = [];

        foreach ($files as $key => $file) {
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $tujuan_upload = 'public/data_file';

            if (!file_exists(public_path('data_file'))) {
                mkdir(public_path('data_file'), 0777, true);
            }

            $file->move(public_path('data_file'), $nama_file);
            $uploaded_files[$key] = $nama_file;
        }

        // Get proposal_ta_id based on mahasiswa_id
        $proposal_ta_id = ProposalTa::where('mahasiswa_id', $mahasiswa->id)->value('id');

        $dokumen_sidang = DokumenSidang::create([
            'mahasiswa_id' => $mahasiswa->id,
            'nobp' => $mahasiswa->nobp,
            'laporan_pkl' => $uploaded_files['laporan_pkl'],
            'lembar_bimbingan' => $uploaded_files['lembar_bimbingan'],
            'proposal_ta_id' => $proposal_ta_id, // Set proposal_ta_id based on logged-in user
            'laporan_ta' => $uploaded_files['laporan_ta'],
        ]);

        Pembimbing1::updateOrCreate(
            ['mahasiswa_id' => $mahasiswa->id],
            ['dokumen_sidang_id' => $dokumen_sidang->id]
        );

        Pembimbing2::updateOrCreate(
            ['mahasiswa_id' => $mahasiswa->id],
            ['dokumen_sidang_id' => $dokumen_sidang->id]
        );

        return redirect()->route('dokumenSidang.index')->with('success', 'File Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(DokomenSidang $dokomenSidang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DokomenSidang $dokomenSidang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DokomenSidang $dokomenSidang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $dokumen_sidang = DokumenSidang::find($id);

        if ($dokumen_sidang) {
            // Mengatur nilai dokumen_sidang_id menjadi null di tabel Pembimbing1 dan Pembimbing2
            Pembimbing1::where('dokumen_sidang_id', $dokumen_sidang->id)->update(['dokumen_sidang_id' => null]);
            Pembimbing2::where('dokumen_sidang_id', $dokumen_sidang->id)->update(['dokumen_sidang_id' => null]);

            // Menghapus entri di tabel DokumenSidang
            $dokumen_sidang->delete();

            return redirect()->route('dokumenSidang.index')->with('success', 'Data berhasil dihapus');
        } else {
            return redirect()->route('dokumenSidang.index')->with('error', 'Data tidak ditemukan');
        }
    }

}
