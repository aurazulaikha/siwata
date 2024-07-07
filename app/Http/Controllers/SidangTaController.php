<?php

namespace App\Http\Controllers;

use App\Mail\ScheduleNotification;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\SidangTa;
use App\Models\NilaiPembimbing1;
use App\Models\NilaiPembimbing2;
use App\Models\NilaiKetua;
use App\Models\NilaiSekretaris;
use App\Models\NilaiPenguji1;
use App\Models\NilaiPenguji2;
use App\Models\DokumenSidang;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Ruangan;
use App\Models\Kaprodi;
use App\Models\Sesi;
use App\Models\Pembimbing1;
use App\Models\Pembimbing2;
use App\Models\SidangProposal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class SidangTaController extends Controller
{
    /**
     * Display a listing of the resource.
     */



    public function index()
    {
        $kaprodi = Kaprodi::where('user_id', Auth::id())->first();
        $prodi_id = $kaprodi->prodi_id; // Assuming Kaprodi has a prodi_id attribute

        // Fetch verified proposals for the same prodi_id as the Kaprodi, excluding those already scheduled
        $scheduledDokumenIds = SidangTa::pluck('dokumen_sidang_id')->toArray();
        $dokumen_sidang = DokumenSidang::with(['mahasiswa', 'pem1', 'pem2'])
            ->where('verifikasi', 1) // Only fetch verified proposals
            ->whereNotIn('id', $scheduledDokumenIds) // Exclude scheduled proposals
            ->whereHas('mahasiswa', function ($query) use ($prodi_id) {
                $query->where('prodi_id', $prodi_id);
            })
            ->get();

        // Fetch schedules for students with the same prodi_id as the Kaprodi
        $jadwals = SidangTa::with(['dokumen_sidang', 'mahasiswa', 'ketua', 'sekretaris', 'penguji1', 'penguji2', 'ruang', 'sesi'])
            ->whereHas('mahasiswa', function ($query) use ($prodi_id) {
                $query->where('prodi_id', $prodi_id);
            })
            ->get()
            ->each(function ($jadwal) {
                $currentDate = Carbon::now();
                $jadwalDate = Carbon::parse($jadwal->tanggal);
                $newStatus = $currentDate->greaterThanOrEqualTo($jadwalDate) ? '1' : '0';

                if ($jadwal->status !== $newStatus) {
                    $jadwal->status = $newStatus;
                    $jadwal->save();
                }
            });

        $mahasiswas = Mahasiswa::all();
        $dosens = Dosen::all();
        $ruangans = Ruangan::all();
        $sesis = Sesi::all();

        return view('pages.kaprodi.sidangTa.index', compact('jadwals', 'dokumen_sidang', 'mahasiswas', 'dosens', 'ruangans', 'sesis'));
    }

    public function indexForAdmin()
    {

        // Fetch verified proposals for the same prodi_id as the Kaprodi, excluding those already scheduled
        $scheduledDokumenIds = SidangTa::pluck('dokumen_sidang_id')->toArray();
        $dokumen_sidang = DokumenSidang::with(['mahasiswa', 'pem1', 'pem2'])
            ->where('verifikasi', 1) // Only fetch verified proposals
            ->whereNotIn('id', $scheduledDokumenIds) // Exclude scheduled proposals
            ->get();

        // Fetch schedules for students with the same prodi_id as the Kaprodi
        $jadwals = SidangTa::with(['dokumen_sidang', 'mahasiswa', 'ketua', 'sekretaris', 'penguji1', 'penguji2', 'ruang', 'sesi'])
            ->get()
            ->each(function ($jadwal) {
                $currentDate = Carbon::now();
                $jadwalDate = Carbon::parse($jadwal->tanggal);
                $newStatus = $currentDate->greaterThanOrEqualTo($jadwalDate) ? '1' : '0';

                if ($jadwal->status !== $newStatus) {
                    $jadwal->status = $newStatus;
                    $jadwal->save();
                }
            });

        $mahasiswas = Mahasiswa::all();
        $dosens = Dosen::all();
        $ruangans = Ruangan::all();
        $sesis = Sesi::all();

        return view('pages.admin.sidangTa.index', compact('jadwals', 'dokumen_sidang', 'mahasiswas', 'dosens', 'ruangans', 'sesis'));
    }


    public function indexForMahasiswa()
    {
        // Get the logged-in dosen's ID
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->first();

        // Fetch schedules where the logged-in dosen is either pembimbing 1, pembimbing 2, or penguji
        $jadwals = SidangTa::with(['dokumen_sidang', 'mahasiswa', 'ketua', 'sekretaris', 'penguji1', 'penguji2', 'ruang', 'sesi'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->get();

        return view('pages.mahasiswa.sidangTa.index', compact('jadwals'));
    }

    public function indexForKetua()
    {
        // Get the logged-in dosen's ID
        $dosen = Dosen::where('user_id', Auth::id())->first();

        // Fetch schedules where the logged-in dosen is either pembimbing 1, pembimbing 2, or penguji
        $jadwals = SidangTa::with(['dokumen_sidang', 'mahasiswa', 'ketua', 'sekretaris', 'penguji1', 'penguji2', 'ruang', 'sesi'])
            ->where('ketua_id', $dosen->id)
            ->get();

        return view('pages.dosen.sidangTa.ketua', compact('jadwals'));
    }

    public function indexForSekretaris()
    {
        // Get the logged-in dosen's ID
        $dosen = Dosen::where('user_id', Auth::id())->first();

        // Fetch schedules where the logged-in dosen is either pembimbing 1, pembimbing 2, or penguji
        $jadwals = SidangTa::with(['dokumen_sidang', 'mahasiswa', 'ketua', 'sekretaris', 'penguji1', 'penguji2', 'ruang', 'sesi'])
            ->where('sekretaris_id', $dosen->id)
            ->get();

        return view('pages.dosen.sidangTa.sekretaris', compact('jadwals'));
    }

    public function indexForPenguji1()
    {
        // Get the logged-in dosen's ID
        $dosen = Dosen::where('user_id', Auth::id())->first();

        // Fetch schedules where the logged-in dosen is either pembimbing 1, pembimbing 2, or penguji
        $jadwals = SidangTa::with(['dokumen_sidang', 'mahasiswa', 'ketua', 'sekretaris', 'penguji1', 'penguji2', 'ruang', 'sesi'])
            ->where('penguji1_id', $dosen->id)
            ->get();

        return view('pages.dosen.sidangTa.penguji1', compact('jadwals'));
    }

    public function indexForPenguji2()
    {
        // Get the logged-in dosen's ID
        $dosen = Dosen::where('user_id', Auth::id())->first();

        // Fetch schedules where the logged-in dosen is either pembimbing 1, pembimbing 2, or penguji
        $jadwals = SidangTa::with(['dokumen_sidang', 'mahasiswa', 'ketua', 'sekretaris', 'penguji1', 'penguji2', 'ruang', 'sesi'])
            ->where('penguji2_id', $dosen->id)
            ->get();

        return view('pages.dosen.sidangTa.penguji2', compact('jadwals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dokumen_sidang_id' => 'required',
            'tanggal' => 'required|date',
            'ruangan' => 'required|exists:ruangans,id',
            'sesi' => 'required|exists:sesis,id',
            'ketua' => 'required',
            'sekretaris' => 'required',
            'penguji1' => 'required',
            'penguji2' => 'required'
        ]);

        // Check if there is an existing schedule with the same date, room, and session
        $existingSchedule = SidangTa::where('tanggal', $request->tanggal)
            ->where('ruangan', $request->ruangan)
            ->where('sesi', $request->sesi)
            ->first();

        if ($existingSchedule) {
            return redirect()->route('sidang_ta.index')->with('error', 'Tidak bisa menambahkan jadwal, karena ada jadwal lain pada tanggal, ruangan, dan sesi yang dipilih.');
        }

        // Check if there is an existing schedule with the same date, session, ketua, sekretaris, penguji 1, and penguji 2
        $ketuaExists = SidangTa::where('tanggal', $request->tanggal)
            ->where('sesi', $request->sesi)
            ->where(function ($query) use ($request) {
                $query->where('ketua_id', $request->ketua)
                    ->orWhere('sekretaris_id', $request->ketua)
                    ->orWhere('penguji1_id', $request->ketua)
                    ->orWhere('penguji2_id', $request->ketua);
            })
            ->exists();

        if ($ketuaExists) {
            return redirect()->route('sidang_ta.index')->with('error', 'Tidak bisa menambahkan jadwal, karena terdapat jadwal dengan ketua atau salah satu penguji yang sama dengan jadwal yang sudah ada.');
        }

        $sekretarisExists = SidangTa::where('tanggal', $request->tanggal)
            ->where('sesi', $request->sesi)
            ->where(function ($query) use ($request) {
                $query->where('ketua_id', $request->sekretaris)
                    ->orWhere('sekretaris_id', $request->sekretaris)
                    ->orWhere('penguji1_id', $request->sekretaris)
                    ->orWhere('penguji2_id', $request->sekretaris);
            })
            ->exists();

        if ($sekretarisExists) {
            return redirect()->route('sidang_ta.index')->with('error', 'Tidak bisa menambahkan jadwal, karena terdapat jadwal dengan sekretaris atau salah satu penguji yang sama dengan jadwal yang sudah ada.');
        }

        $penguji1Exists = SidangTa::where('tanggal', $request->tanggal)
            ->where('sesi', $request->sesi)
            ->where(function ($query) use ($request) {
                $query->where('ketua_id', $request->penguji1)
                    ->orWhere('sekretaris_id', $request->penguji1)
                    ->orWhere('penguji1_id', $request->penguji1)
                    ->orWhere('penguji2_id', $request->penguji1);
            })
            ->exists();

        if ($penguji1Exists) {
            return redirect()->route('sidang_ta.index')->with('error', 'Tidak bisa menambahkan jadwal, karena terdapat jadwal dengan penguji 1 yang sama dengan jadwal yang sudah ada.');
        }

        $penguji2Exists = SidangTa::where('tanggal', $request->tanggal)
            ->where('sesi', $request->sesi)
            ->where(function ($query) use ($request) {
                $query->where('ketua_id', $request->penguji2)
                    ->orWhere('sekretaris_id', $request->penguji2)
                    ->orWhere('penguji1_id', $request->penguji2)
                    ->orWhere('penguji2_id', $request->penguji2);
            })
            ->exists();

        if ($penguji2Exists) {
            return redirect()->route('sidang_ta.index')->with('error', 'Tidak bisa menambahkan jadwal, karena terdapat jadwal dengan penguji 2 yang sama dengan jadwal yang sudah ada.');
        }

        // Ambil pembimbing dari tabel dokumen_sidang
        $dokumen_sidang = DokumenSidang::findOrFail($request->dokumen_sidang_id);

        // Create a new SidangTa entry
        $sidang_ta = SidangTa::create([
            'dokumen_sidang_id' => $request->dokumen_sidang_id,
            'tanggal' => $request->tanggal,
            'ruangan' => $request->ruangan,
            'sesi' => $request->sesi,
            'mahasiswa_id' => $dokumen_sidang->mahasiswa_id,
            'pem1_id' => $dokumen_sidang->pem1->dosen_id,
            'pem2_id' => $dokumen_sidang->pem2->dosen_id,
            'ketua_id' => $request->ketua,
            'sekretaris_id' => $request->sekretaris,
            'penguji1_id' => $request->penguji1,
            'penguji2_id' => $request->penguji2
        ]);


        NilaiPembimbing1::create([
            'sidang_ta_id' => $sidang_ta->id,
            'dosen_id' => $dokumen_sidang->pem1->dosen_id,
            'mahasiswa_id' => $dokumen_sidang->mahasiswa_id,
            'dokumen_sidang_id' => $request->dokumen_sidang_id,
        ]);

        NilaiPembimbing2::create([
            'sidang_ta_id' => $sidang_ta->id,
            'dosen_id' => $dokumen_sidang->pem2->dosen_id,
            'mahasiswa_id' => $dokumen_sidang->mahasiswa_id,
            'dokumen_sidang_id' => $request->dokumen_sidang_id,
        ]);

        NilaiKetua::create([
            'sidang_ta_id' => $sidang_ta->id,
            'dosen_id' => $sidang_ta->ketua_id,
            'mahasiswa_id' => $dokumen_sidang->mahasiswa_id,
            'dokumen_sidang_id' => $request->dokumen_sidang_id,
        ]);

        NilaiSekretaris::create([
            'sidang_ta_id' => $sidang_ta->id,
            'dosen_id' => $sidang_ta->sekretaris_id,
            'mahasiswa_id' => $dokumen_sidang->mahasiswa_id,
            'dokumen_sidang_id' => $request->dokumen_sidang_id,
        ]);

        NilaiPenguji1::create([
            'sidang_ta_id' => $sidang_ta->id,
            'dosen_id' => $sidang_ta->penguji1_id,
            'mahasiswa_id' => $dokumen_sidang->mahasiswa_id,
            'dokumen_sidang_id' => $request->dokumen_sidang_id,
        ]);

        NilaiPenguji2::create([
            'sidang_ta_id' => $sidang_ta->id,
            'dosen_id' => $sidang_ta->penguji2_id,
            'mahasiswa_id' => $dokumen_sidang->mahasiswa_id,
            'dokumen_sidang_id' => $request->dokumen_sidang_id,
        ]);

        $emails = [
            User::find($sidang_ta->ketuaNama->user_id),    // Fetch user for ketua_id
            User::find($sidang_ta->sekretarisNama->user_id), // Fetch user for sekretaris_id
            User::find($sidang_ta->penguji1->user_id), // Fetch user for penguji1_id
            User::find($sidang_ta->penguji2->user_id)  // Fetch user for penguji2_id
        ];

        // Send email notifications to each user if they exist
        foreach ($emails as $user) {
            if ($user) { // Check if the user object is not null
                Mail::to($user->email)->send(new ScheduleNotification($sidang_ta));
            }
        }



        return redirect()->route('sidang_ta.index')->with('success', 'Jadwal Sidang Proposal berhasil dibuat.');
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'dokumen_sidang_id' => 'required',
            'tanggal' => 'required|date',
            'ruangan' => 'required|exists:ruangans,id',
            'sesi' => 'required|exists:sesis,id',
            'ketua' => 'required',
            'sekretaris' => 'required',
            'penguji1' => 'required',
            'penguji2' => 'required'
        ]);

        // Check if there is an existing schedule with the same date, room, and session
        $existingSchedule = SidangTa::where('tanggal', $request->tanggal)
            ->where('ruangan', $request->ruangan)
            ->where('sesi', $request->sesi)
            ->first();

        if ($existingSchedule) {
            return redirect()->route('jadwalTa.IndexForAdmin')->with('error', 'Tidak bisa menambahkan jadwal, karena ada jadwal lain pada tanggal, ruangan, dan sesi yang dipilih.');
        }

        // Check if there is an existing schedule with the same date, session, ketua, sekretaris, penguji 1, and penguji 2
        $ketuaExists = SidangTa::where('tanggal', $request->tanggal)
            ->where('sesi', $request->sesi)
            ->where(function ($query) use ($request) {
                $query->where('ketua_id', $request->ketua)
                    ->orWhere('sekretaris_id', $request->ketua)
                    ->orWhere('penguji1_id', $request->ketua)
                    ->orWhere('penguji2_id', $request->ketua);
            })
            ->exists();

        if ($ketuaExists) {
            return redirect()->route('jadwalTa.IndexForAdmin')->with('error', 'Tidak bisa menambahkan jadwal, karena terdapat jadwal dengan ketua atau salah satu penguji yang sama dengan jadwal yang sudah ada.');
        }

        $sekretarisExists = SidangTa::where('tanggal', $request->tanggal)
            ->where('sesi', $request->sesi)
            ->where(function ($query) use ($request) {
                $query->where('ketua_id', $request->sekretaris)
                    ->orWhere('sekretaris_id', $request->sekretaris)
                    ->orWhere('penguji1_id', $request->sekretaris)
                    ->orWhere('penguji2_id', $request->sekretaris);
            })
            ->exists();

        if ($sekretarisExists) {
            return redirect()->route('jadwalTa.IndexForAdmin')->with('error', 'Tidak bisa menambahkan jadwal, karena terdapat jadwal dengan sekretaris atau salah satu penguji yang sama dengan jadwal yang sudah ada.');
        }

        $penguji1Exists = SidangTa::where('tanggal', $request->tanggal)
            ->where('sesi', $request->sesi)
            ->where(function ($query) use ($request) {
                $query->where('ketua_id', $request->penguji1)
                    ->orWhere('sekretaris_id', $request->penguji1)
                    ->orWhere('penguji1_id', $request->penguji1)
                    ->orWhere('penguji2_id', $request->penguji1);
            })
            ->exists();

        if ($penguji1Exists) {
            return redirect()->route('jadwalTa.IndexForAdmin')->with('error', 'Tidak bisa menambahkan jadwal, karena terdapat jadwal dengan penguji 1 yang sama dengan jadwal yang sudah ada.');
        }

        $penguji2Exists = SidangTa::where('tanggal', $request->tanggal)
            ->where('sesi', $request->sesi)
            ->where(function ($query) use ($request) {
                $query->where('ketua_id', $request->penguji2)
                    ->orWhere('sekretaris_id', $request->penguji2)
                    ->orWhere('penguji1_id', $request->penguji2)
                    ->orWhere('penguji2_id', $request->penguji2);
            })
            ->exists();

        if ($penguji2Exists) {
            return redirect()->route('jadwalTa.IndexForAdmin')->with('error', 'Tidak bisa menambahkan jadwal, karena terdapat jadwal dengan penguji 2 yang sama dengan jadwal yang sudah ada.');
        }
        // Ambil pembimbing dari tabel dokumen_sidang
        $dokumen_sidang = DokumenSidang::findOrFail($request->dokumen_sidang_id);

        // Create a new SidangTa entry
        $sidang_ta = SidangTa::create([
            'dokumen_sidang_id' => $request->dokumen_sidang_id,
            'tanggal' => $request->tanggal,
            'ruangan' => $request->ruangan,
            'sesi' => $request->sesi,
            'mahasiswa_id' => $dokumen_sidang->mahasiswa_id,
            'pem1_id' => $dokumen_sidang->pem1->dosen_id,
            'pem2_id' => $dokumen_sidang->pem2->dosen_id,
            'ketua_id' => $request->ketua,
            'sekretaris_id' => $request->sekretaris,
            'penguji1_id' => $request->penguji1,
            'penguji2_id' => $request->penguji2
        ]);


        NilaiPembimbing1::create([
            'sidang_ta_id' => $sidang_ta->id,
            'dosen_id' => $dokumen_sidang->pem1->dosen_id,
            'mahasiswa_id' => $dokumen_sidang->mahasiswa_id,
            'dokumen_sidang_id' => $request->dokumen_sidang_id,
        ]);

        NilaiPembimbing2::create([
            'sidang_ta_id' => $sidang_ta->id,
            'dosen_id' => $dokumen_sidang->pem2->dosen_id,
            'mahasiswa_id' => $dokumen_sidang->mahasiswa_id,
            'dokumen_sidang_id' => $request->dokumen_sidang_id,
        ]);

        NilaiKetua::create([
            'sidang_ta_id' => $sidang_ta->id,
            'dosen_id' => $sidang_ta->ketua_id,
            'mahasiswa_id' => $dokumen_sidang->mahasiswa_id,
            'dokumen_sidang_id' => $request->dokumen_sidang_id,
        ]);

        NilaiSekretaris::create([
            'sidang_ta_id' => $sidang_ta->id,
            'dosen_id' => $sidang_ta->sekretaris_id,
            'mahasiswa_id' => $dokumen_sidang->mahasiswa_id,
            'dokumen_sidang_id' => $request->dokumen_sidang_id,
        ]);

        NilaiPenguji1::create([
            'sidang_ta_id' => $sidang_ta->id,
            'dosen_id' => $sidang_ta->penguji1_id,
            'mahasiswa_id' => $dokumen_sidang->mahasiswa_id,
            'dokumen_sidang_id' => $request->dokumen_sidang_id,
        ]);

        NilaiPenguji2::create([
            'sidang_ta_id' => $sidang_ta->id,
            'dosen_id' => $sidang_ta->penguji2_id,
            'mahasiswa_id' => $dokumen_sidang->mahasiswa_id,
            'dokumen_sidang_id' => $request->dokumen_sidang_id,
        ]);

        $emails = [
            User::find($sidang_ta->ketuaNama->user_id),    // Fetch user for ketua_id
            User::find($sidang_ta->sekretarisNama->user_id), // Fetch user for sekretaris_id
            User::find($sidang_ta->penguji1->user_id), // Fetch user for penguji1_id
            User::find($sidang_ta->penguji2->user_id)  // Fetch user for penguji2_id
        ];

        // Send email notifications to each user if they exist
        foreach ($emails as $user) {
            if ($user) { // Check if the user object is not null
                Mail::to($user->email)->send(new ScheduleNotification($sidang_ta));
            }
        }



        return redirect()->route('jadwalTa.IndexForAdmin')->with('success', 'Jadwal Sidang Proposal berhasil dibuat.');
    }


    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function show(SidangTa $sidangTa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $jadwal = SidangTa::findOrFail($id);
        $kaprodi = Kaprodi::where('user_id', Auth::id())->first();
        $prodi_id = $kaprodi->prodi_id; // Assuming Kaprodi has a prodi_id attribute
        $dokumen_sidang = DokumenSidang::with(['mahasiswa', 'pem1', 'pem2'])
            ->whereHas('mahasiswa', function ($query) use ($prodi_id) {
                $query->where('prodi_id', $prodi_id);
            })
            ->get();
        $mahasiswas = Mahasiswa::all();
        $dosens = Dosen::all();
        $ruangans = Ruangan::all();
        $sesis = Sesi::all();

        return view('pages.kaprodi.sidangTa.edit', compact('jadwal', 'dokumen_sidang', 'mahasiswas', 'dosens', 'ruangans', 'sesis'));

    }

    public function editAdmin($id)
    {
        $id = Crypt::decrypt($id);
        $jadwal = SidangTa::findOrFail($id);

        $dokumen_sidang = DokumenSidang::with(['mahasiswa', 'pem1', 'pem2'])
            ->get();
        $mahasiswas = Mahasiswa::all();
        $dosens = Dosen::all();
        $ruangans = Ruangan::all();
        $sesis = Sesi::all();

        return view('pages.admin.sidangTa.edit', compact('jadwal', 'dokumen_sidang', 'mahasiswas', 'dosens', 'ruangans', 'sesis'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'dokumen_sidang_id' => 'required',
            'tanggal' => 'required|date',
            'ruangan' => 'required',
            'sesi' => 'required',
            'ketua_id' => 'required',
            'sekretaris_id' => 'required',
            'penguji1_id' => 'required',
            'penguji2_id' => 'required',
        ]);

        // Mengupdate jadwal berdasarkan ID yang diterima dari route
        $sidang_ta = SidangTa::findOrFail($id);

        // Check for schedule conflicts
        $conflict = SidangTa::where('tanggal', $validatedData['tanggal'])
            ->where('ruangan', $validatedData['ruangan'])
            ->where('sesi', $validatedData['sesi'])
            ->where('id', '!=', $id) // Exclude the current schedule from the check
            ->exists();

        if ($conflict) {
            return redirect()->back()->withErrors(['error' => 'Jadwal sudah ada untuk tanggal, ruangan, dan sesi yang dipilih.'])->withInput();
        }

        $ketuaExists = SidangTa::where('tanggal', $validatedData['tanggal'])
            ->where('sesi', $validatedData['sesi'])
            ->where(function ($query) use ($validatedData) {
                $query->where('ketua_id', $validatedData['ketua_id'])
                    ->orWhere('sekretaris_id', $validatedData['ketua_id'])
                    ->orWhere('penguji1_id', $validatedData['ketua_id'])
                    ->orWhere('penguji2_id', $validatedData['ketua_id']);
            })
            ->where('id', '!=', $id)
            ->exists();

        if ($ketuaExists) {
            return redirect()->back()->withErrors(['error' => 'Ketua atau  penguji yang dipilih sudah ada jadwal pada tanggal, dan sesi yang dipilih.'])->withInput();
        }

        $sekretarisExists = SidangTa::where('tanggal', $validatedData['tanggal'])
            ->where('sesi', $validatedData['sesi'])
            ->where(function ($query) use ($validatedData) {
                $query->where('ketua_id', $validatedData['sekretaris_id'])
                    ->orWhere('sekretaris_id', $validatedData['sekretaris_id'])
                    ->orWhere('penguji1_id', $validatedData['sekretaris_id'])
                    ->orWhere('penguji2_id', $validatedData['sekretaris_id']);
            })
            ->where('id', '!=', $id)
            ->exists();

        if ($sekretarisExists) {
            return redirect()->back()->withErrors(['error' => 'Sekretaris atau  penguji sudah ada jadwal pada tanggal, dan sesi yang dipilih.'])->withInput();
        }

        $penguji1Exists = SidangTa::where('tanggal', $validatedData['tanggal'])
            ->where('sesi', $validatedData['sesi'])
            ->where(function ($query) use ($validatedData) {
                $query->where('ketua_id', $validatedData['penguji1_id'])
                    ->orWhere('sekretaris_id', $validatedData['penguji1_id'])
                    ->orWhere('penguji1_id', $validatedData['penguji1_id'])
                    ->orWhere('penguji2_id', $validatedData['penguji1_id']);
            })
            ->where('id', '!=', $id)
            ->exists();

        if ($penguji1Exists) {
            return redirect()->back()->withErrors(['error' => 'Penguji 1  sudah ada jadwal pada tanggal, dan sesi yang dipilih.'])->withInput();
        }

        $penguji2Exists = SidangTa::where('tanggal', $validatedData['tanggal'])
            ->where('sesi', $validatedData['sesi'])
            ->where(function ($query) use ($validatedData) {
                $query->where('ketua_id', $validatedData['penguji2_id'])
                    ->orWhere('sekretaris_id', $validatedData['penguji2_id'])
                    ->orWhere('penguji1_id', $validatedData['penguji2_id'])
                    ->orWhere('penguji2_id', $validatedData['penguji2_id']);
            })
            ->where('id', '!=', $id)
            ->exists();

        if ($penguji2Exists) {
            return redirect()->back()->withErrors(['error' => 'Penguji 2 sudah ada jadwal pada tanggal, dan sesi yang dipilih.'])->withInput();
        }

        $sidang_ta->update($validatedData);

        // Check if 'penguji1_id' has changed and update 'nilaiPenguji1' accordingly
        if ($sidang_ta->wasChanged('penguji1_id')) {
            $nilaiPenguji1 = $sidang_ta->nilaiPenguji1Edit;
            if ($nilaiPenguji1) {
                $nilaiPenguji1->dosen_id = $sidang_ta->penguji1_id;
                $nilaiPenguji1->save();
            }
        }

        if ($sidang_ta->wasChanged('penguji2_id')) {
            $nilaiPenguji2 = $sidang_ta->nilaiPenguji2Edit;
            if ($nilaiPenguji2) {
                $nilaiPenguji2->dosen_id = $sidang_ta->penguji2_id;
                $nilaiPenguji2->save();
            }
        }

        // Check if 'ketua_id' has changed and update 'nilaiKetua' accordingly
        if ($sidang_ta->wasChanged('ketua_id')) {
            $nilaiKetua = $sidang_ta->nilaiKetuaEdit;
            if ($nilaiKetua) {
                $nilaiKetua->dosen_id = $sidang_ta->ketua_id;
                $nilaiKetua->save();
            }
        }

        // Check if 'sekretaris_id' has changed and update 'nilaiSekretaris' accordingly
        if ($sidang_ta->wasChanged('sekretaris_id')) {
            $nilaiSekretaris = $sidang_ta->nilaiSekretarisEdit;
            if ($nilaiSekretaris) {
                $nilaiSekretaris->dosen_id = $sidang_ta->sekretaris_id;
                $nilaiSekretaris->save();
            }
        }

        // Redirect ke halaman yang dituju setelah berhasil mengupdate jadwal
        return redirect()->route('sidang_ta.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function updateAdmin(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'dokumen_sidang_id' => 'required',
            'tanggal' => 'required|date',
            'ruangan' => 'required',
            'sesi' => 'required',
            'ketua_id' => 'required',
            'sekretaris_id' => 'required',
            'penguji1_id' => 'required',
            'penguji2_id' => 'required',
        ]);

        // Mengupdate jadwal berdasarkan ID yang diterima dari route
        $sidang_ta = SidangTa::findOrFail($id);

        // Check for schedule conflicts
        $conflict = SidangTa::where('tanggal', $validatedData['tanggal'])
            ->where('ruangan', $validatedData['ruangan'])
            ->where('sesi', $validatedData['sesi'])
            ->where('id', '!=', $id) // Exclude the current schedule from the check
            ->exists();

        if ($conflict) {
            return redirect()->back()->withErrors(['error' => 'Jadwal sudah ada untuk tanggal, ruangan, dan sesi yang dipilih.'])->withInput();
        }

        $ketuaExists = SidangTa::where('tanggal', $validatedData['tanggal'])
            ->where('sesi', $validatedData['sesi'])
            ->where(function ($query) use ($validatedData) {
                $query->where('ketua_id', $validatedData['ketua_id'])
                    ->orWhere('sekretaris_id', $validatedData['ketua_id'])
                    ->orWhere('penguji1_id', $validatedData['ketua_id'])
                    ->orWhere('penguji2_id', $validatedData['ketua_id']);
            })
            ->where('id', '!=', $id)
            ->exists();

        if ($ketuaExists) {
            return redirect()->back()->withErrors(['error' => 'Ketua atau  penguji yang dipilih sudah ada jadwal pada tanggal, dan sesi yang dipilih.'])->withInput();
        }

        $sekretarisExists = SidangTa::where('tanggal', $validatedData['tanggal'])
            ->where('sesi', $validatedData['sesi'])
            ->where(function ($query) use ($validatedData) {
                $query->where('ketua_id', $validatedData['sekretaris_id'])
                    ->orWhere('sekretaris_id', $validatedData['sekretaris_id'])
                    ->orWhere('penguji1_id', $validatedData['sekretaris_id'])
                    ->orWhere('penguji2_id', $validatedData['sekretaris_id']);
            })
            ->where('id', '!=', $id)
            ->exists();

        if ($sekretarisExists) {
            return redirect()->back()->withErrors(['error' => 'Sekretaris atau  penguji sudah ada jadwal pada tanggal, dan sesi yang dipilih.'])->withInput();
        }

        $penguji1Exists = SidangTa::where('tanggal', $validatedData['tanggal'])
            ->where('sesi', $validatedData['sesi'])
            ->where(function ($query) use ($validatedData) {
                $query->where('ketua_id', $validatedData['penguji1_id'])
                    ->orWhere('sekretaris_id', $validatedData['penguji1_id'])
                    ->orWhere('penguji1_id', $validatedData['penguji1_id'])
                    ->orWhere('penguji2_id', $validatedData['penguji1_id']);
            })
            ->where('id', '!=', $id)
            ->exists();

        if ($penguji1Exists) {
            return redirect()->back()->withErrors(['error' => 'Penguji 1  sudah ada jadwal pada tanggal, dan sesi yang dipilih.'])->withInput();
        }

        $penguji2Exists = SidangTa::where('tanggal', $validatedData['tanggal'])
            ->where('sesi', $validatedData['sesi'])
            ->where(function ($query) use ($validatedData) {
                $query->where('ketua_id', $validatedData['penguji2_id'])
                    ->orWhere('sekretaris_id', $validatedData['penguji2_id'])
                    ->orWhere('penguji1_id', $validatedData['penguji2_id'])
                    ->orWhere('penguji2_id', $validatedData['penguji2_id']);
            })
            ->where('id', '!=', $id)
            ->exists();

        if ($penguji2Exists) {
            return redirect()->back()->withErrors(['error' => 'Penguji 2 sudah ada jadwal pada tanggal, dan sesi yang dipilih.'])->withInput();
        }

        $sidang_ta->update($validatedData);

        // Check if 'penguji1_id' has changed and update 'nilaiPenguji1' accordingly
        if ($sidang_ta->wasChanged('penguji1_id')) {
            $nilaiPenguji1 = $sidang_ta->nilaiPenguji1Edit;
            if ($nilaiPenguji1) {
                $nilaiPenguji1->dosen_id = $sidang_ta->penguji1_id;
                $nilaiPenguji1->save();
            }
        }

        if ($sidang_ta->wasChanged('penguji2_id')) {
            $nilaiPenguji2 = $sidang_ta->nilaiPenguji2Edit;
            if ($nilaiPenguji2) {
                $nilaiPenguji2->dosen_id = $sidang_ta->penguji2_id;
                $nilaiPenguji2->save();
            }
        }

        // Check if 'ketua_id' has changed and update 'nilaiKetua' accordingly
        if ($sidang_ta->wasChanged('ketua_id')) {
            $nilaiKetua = $sidang_ta->nilaiKetuaEdit;
            if ($nilaiKetua) {
                $nilaiKetua->dosen_id = $sidang_ta->ketua_id;
                $nilaiKetua->save();
            }
        }

        // Check if 'sekretaris_id' has changed and update 'nilaiSekretaris' accordingly
        if ($sidang_ta->wasChanged('sekretaris_id')) {
            $nilaiSekretaris = $sidang_ta->nilaiSekretarisEdit;
            if ($nilaiSekretaris) {
                $nilaiSekretaris->dosen_id = $sidang_ta->sekretaris_id;
                $nilaiSekretaris->save();
            }
        }

        // Redirect ke halaman yang dituju setelah berhasil mengupdate jadwal
        return redirect()->route('jadwalTa.IndexForAdmin')->with('success', 'Jadwal berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $sidang_ta = SidangTa::findOrFail($id);

        // Delete related nilai_ta entries
        $sidang_ta->nilaiKetua()->delete();

        $sidang_ta->nilaiSekretaris()->delete();

        $sidang_ta->nilaiPembimbing1()->delete();

        $sidang_ta->nilaiPembimbing2()->delete();

        $sidang_ta->nilaiPenguji1()->delete();

        $sidang_ta->nilaiPenguji2()->delete();

        $sidang_ta->nilaiTa()->delete();

        // Delete sidang_ta entry
        $sidang_ta->delete();

        return redirect()->route('sidang_ta.index')->with('success', 'Jadwal Berhasil Dihapus');
    }

    public function destroyAdmin($id)
    {
        $sidang_ta = SidangTa::findOrFail($id);

        // Delete related nilai_ta entries
        $sidang_ta->nilaiKetua()->delete();

        $sidang_ta->nilaiSekretaris()->delete();

        $sidang_ta->nilaiPembimbing1()->delete();

        $sidang_ta->nilaiPembimbing2()->delete();

        $sidang_ta->nilaiPenguji1()->delete();

        $sidang_ta->nilaiPenguji2()->delete();

        $sidang_ta->nilaiTa()->delete();

        // Delete sidang_ta entry
        $sidang_ta->delete();

        return redirect()->route('jadwalTa.IndexForAdmin')->with('success', 'Jadwal Berhasil Dihapus');
    }

}
