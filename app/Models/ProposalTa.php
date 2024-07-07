<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalTa extends Model
{
    use HasFactory;

    protected $fillable = ['proposal_ta_id', 'mahasiswa_id', 'nobp', 'judul', 'file', 'verifikasi', 'komentar'];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    public function pem1()
    {
        return $this->hasOne(Pembimbing1::class, 'proposal_ta_id');
    }

    public function pem2()
    {
        return $this->hasOne(Pembimbing2::class, 'proposal_ta_id');
    }



}


