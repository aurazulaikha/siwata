<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Ruangan;

use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jadwal = Jadwal::orderBy('hari', 'desc')->get();

        $ruangan = Ruangan::orderBy('nama_ruangan', 'desc')->get();
        return view('pages.admin.jadwal.index', compact('jadwal', 'ruangan'));
    }

    public function jadwalKaprodi()
    {
        $jadwal = Jadwal::orderBy('hari', 'desc')->get();

        $ruangan = Ruangan::orderBy('nama_ruangan', 'desc')->get();
        return view('pages.kaprodi.jadwal.index', compact('jadwal', 'ruangan'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $this->validate($request, [
            'ruangan_id' => 'required',
            'hari' => 'required',
            'dari_jam' => 'required',
            'sampai_jam' => 'required',
        ], [
            'ruangan_id.required' => 'Ruangan wajib diisi',
            'hari.required' => 'Hari wajib diisi',
            'dari_jam.required' => 'Jam mulai wajib diisi',
            'sampai_jam.required' => 'Jam selesai wajib diisi',
        ]);

        Jadwal::create([
            'ruangan_id' => $data['ruangan_id'],
            'hari' => $data['hari'],
            'dari_jam' => $data['dari_jam'],
            'sampai_jam' => $data['sampai_jam'],
        ]);

        return redirect()->back()->with('success', 'Jadwal berhasil dibuat');
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
        $jadwal = Jadwal::find($id);

        $ruangan = Ruangan::orderBy('nama_ruangan', 'desc')->get();

        $hari = ['senin', 'selasa', 'rabu', 'kamis', 'jumat'];

        return view('pages.admin.jadwal.edit', compact('jadwal', 'ruangan', 'hari'));
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

        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update($data);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jadwal = Jadwal::find($id);
        $jadwal->delete();

        return redirect()->back()->with('success', 'Jadwal berhasil dihapus');
    }
}
