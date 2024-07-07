<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DosenExport;
use App\Imports\DosenImport;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodi = Prodi::orderBy('nama_prodi', 'asc')->get();
        $dosen = Dosen::orderBy('nama', 'asc')->get();
        return view('pages.admin.dosen.index', compact('dosen', 'prodi'));
    }

    public function indexKaprodi()
    {
        $prodi = Prodi::orderBy('nama_prodi', 'asc')->get();
        $dosen = Dosen::orderBy('nama', 'asc')->get();
        return view('pages.kaprodi.dosen.index', compact('dosen', 'prodi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'nama' => 'required',
            'nidn' => 'required|unique:dosens',
            'no_telp' => 'required',
            'alamat' => 'required',
            'prodi_id' => 'required',
        ], [
            'nidn.unique' => 'nidn sudah terdaftar',
        ]);

        $dosen = new Dosen;
        $dosen->nama = $request->nama;
        $dosen->nidn = $request->nidn;
        $dosen->no_telp = $request->no_telp;
        $dosen->alamat = $request->alamat;
        $dosen->prodi_id = $request->prodi_id;
        $dosen->save();


        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $dosen = Dosen::findOrFail($id);

        return view('pages.admin.dosen.profile', compact('dosen'));
    }

    public function showKaprodi($id)
    {
        $id = Crypt::decrypt($id);
        $dosen = Dosen::findOrFail($id);

        return view('pages.kaprodi.dosen.profile', compact('dosen'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $prodi = Prodi::all();
        $dosen = Dosen::findOrFail($id);

        return view('pages.admin.dosen.edit', compact('dosen', 'prodi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dosen = Dosen::find($id);
        $dosen->nama = $request->input('nama');
        $dosen->nidn = $request->input('nidn');
        $dosen->no_telp = $request->input('no_telp');
        $dosen->alamat = $request->input('alamat');
        $dosen->prodi_id = $request->input('prodi_id');
        $dosen->update();

        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dosen = Dosen::find($id);
        $dosen->delete();

        // Hapus data user
        if ($user = User::where('id', $dosen->user_id)->first()) {
            $user->delete();
        }

        return back()->with('success', 'Data prodi berhasil dihapus!');
    }

    public function export_dosen()
    {
        try {
            return Excel::download(new DosenExport, 'dosen.xlsx');
        } catch (\Throwable $th) {
            return back()->with('error', 'Gagal mengekspor data: ' . $th->getMessage());
        }
    }

    public function import_dosen(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'file' => 'required|max:2048',
        ]);

        Excel::import(new DosenImport, $request->file('file'));

        return back()->with('success', 'Import data dosen berhasil !');
    }
}

