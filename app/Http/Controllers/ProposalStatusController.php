<?php

namespace App\Http\Controllers;

use App\Models\ProposalTa;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Pembimbing1;
use App\Models\Pembimbing2;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProposalStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Your logic to get the status of proposals
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->first();

        $proposal_ta = ProposalTa::with(['mahasiswa', 'pem1', 'pem2'])
            ->whereHas('pem1', function ($query) use ($mahasiswa) {
                $query->where('mahasiswa_id', $mahasiswa->id);
            })
            ->orWhereHas('pem2', function ($query) use ($mahasiswa) {
                $query->where('mahasiswa_id', $mahasiswa->id);
            })
            ->get();

        return view('pages.mahasiswa.proposalTa.status', compact('proposal_ta', 'mahasiswa'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
