<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class RuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruangan = Ruangan::orderBy('nama_ruangan', 'asc')->get();
        return view('pages.admin.ruangan.index', compact('ruangan'));
    }

    public function indexKaprodi()
    {
        $ruangan = Ruangan::orderBy('nama_ruangan', 'asc')->get();
        return view('pages.kaprodi.ruangan.index', compact('ruangan'));
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
            'nama_ruangan' => 'required|unique:ruangans',
        ], [
            'nama_ruangan.unique' => 'Nama ruangan sudah ada',
        ]);

        Ruangan::create($request->all());

        return redirect()->route('ruangan.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        $ruangan = Ruangan::findOrFail($id);
        return view('pages.admin.ruangan.edit', compact('ruangan'));
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
        $data = $request->all();
        $ruangan = Ruangan::findOrFail($id);
        $ruangan->update($data);

        return redirect()->route('ruangan.index')->with('success', 'Data ruangan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Ruangan::find($id)->delete();
        return back()->with('success', 'Data Ruangan berhasil dihapus!');
    }
}
