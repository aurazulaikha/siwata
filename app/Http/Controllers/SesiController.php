<?php

namespace App\Http\Controllers;

use App\Models\Sesi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SesiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sesi = Sesi::OrderBy('id', 'asc')->get();
        return view('pages.admin.sesi.index', compact('sesi'));
    }

    public function indexKaprodi()
    {
        $sesi = Sesi::OrderBy('id', 'asc')->get();
        return view('pages.kaprodi.sesi.index', compact('sesi'));
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
        Sesi::create($request->all());
        return back()->with('success', 'Data Sesi berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sesi $sesi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sesi $sesi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sesi $sesi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sesi $sesi)
    {
        $sesi->delete();
        return back()->with('success', 'Data Sesi berhasil dihapus!');
    }
}
