<?php

namespace App\Http\Controllers;

use App\Models\Kaprodi;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;

class KaprodiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodi = Prodi::orderBy('nama_prodi', 'asc')->get();
        $kaprodi = Kaprodi::orderBy('nama', 'asc')->get();
        return view('pages.admin.kaprodi.index', compact('kaprodi', 'prodi'));
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
            'nidn' => 'required|unique:kaprodis',
            'no_telp' => 'required',
            'alamat' => 'required',
            'prodi_id' => 'required',
        ], [
            'nidn.unique' => 'nidn sudah terdaftar',
        ]);

        $kaprodi = new Kaprodi;
        $kaprodi->nama = $request->nama;
        $kaprodi->nidn = $request->nidn;
        $kaprodi->no_telp = $request->no_telp;
        $kaprodi->alamat = $request->alamat;
        $kaprodi->prodi_id = $request->prodi_id;
        $kaprodi->save();


        return redirect()->route('kaprodi.index')->with('success', 'Data Kaprodi berhasil ditambahkan');
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
        $kaprodi = Kaprodi::findOrFail($id);

        return view('pages.admin.kaprodi.profile', compact('kaprodi'));
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
        $kaprodi = Kaprodi::findOrFail($id);

        return view('pages.admin.kaprodi.edit', compact('kaprodi', 'prodi'));
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
        $kaprodi = Kaprodi::find($id);
        $kaprodi->nama = $request->input('nama');
        $kaprodi->nidn = $request->input('nidn');
        $kaprodi->no_telp = $request->input('no_telp');
        $kaprodi->alamat = $request->input('alamat');
        $kaprodi->prodi_id = $request->input('prodi_id');
        $kaprodi->update();

        return redirect()->route('kaprodi.index')->with('success', 'Data kaprodi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kaprodi = Kaprodi::find($id);
        $kaprodi->delete();

        // Hapus data user
        if ($user = User::where('id', $kaprodi->user_id)->first()) {
            $user->delete();
        }

        return back()->with('success', 'Data prodi berhasil dihapus!');
    }
}
