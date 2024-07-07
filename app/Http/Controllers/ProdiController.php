<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodi = Prodi::OrderBy('nama_prodi', 'asc')->get();
        return view('pages.admin.prodi.index', compact('prodi'));
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
            'nama_prodi' => 'required|unique:prodis',
        ], [
            'nama_prodi.unique' => 'Nama prodi sudah ada',
        ]);

        Prodi::create([
            'id' => $request->prodi_id,
            'nama_prodi' => $request->nama_prodi,
        ]);

        return back()->with('success', 'Data prodi berhasil dibuat!');
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
        $prodi = Prodi::findOrFail($id);
        return view('pages.admin.prodi.edit', compact('prodi'));
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
        $this->validate($request, [
            'nama_prodi' => 'unique:prodis',
        ], [
            'nama_prodi.unique' => 'Nama prodi sudah ada',
        ]);

        $data = $request->all();

        $prodi = Prodi::findOrFail($id);
        $prodi->update($data);

        return redirect()->route('prodi.index')->with('success', 'Data prodi berhasil diperbaharui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $prodi = Prodi::findOrFail($id);
        $prodi->delete();

        return back()->with('success', 'Data prodi berhasil dihapus!');
    }
}
