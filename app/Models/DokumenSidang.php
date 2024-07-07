<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenSidang extends Model
{
    use HasFactory;

    protected $fillable = ['mahasiswa_id', 'nobp', 'laporan_pkl', 'lembar_bimbingan', 'proposal_ta_id', 'laporan_ta', 'verifikasi', 'komentar'];

    public function proposal_ta()
    {
        return $this->belongsTo(ProposalTa::class, 'proposal_ta_id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function pem1()
    {
        return $this->hasOne(Pembimbing1::class, 'dokumen_sidang_id');
    }

    public function pem2()
    {
        return $this->hasOne(Pembimbing2::class, 'dokumen_sidang_id');
    }



    public function pembimbing1()
    {
        return $this->hasOneThrough(Dosen::class, Pembimbing1::class, 'dokumen_sidang_id', 'id', 'id', 'dosen_id');
    }

    public function pembimbing2()
    {
        return $this->hasOneThrough(Dosen::class, Pembimbing2::class, 'dokumen_sidang_id', 'id', 'id', 'dosen_id');
    }
}


