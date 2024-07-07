<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembimbing1 extends Model
{
    use HasFactory;

    protected $fillable = ['proposal_ta_id', 'dosen_id', 'nama_dosen', 'komentar', 'mahasiswa_id', 'dokumen_sidang_id', 'status_dokumen', 'komentar_dokumen'];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }
    public function proposal_ta()
    {
        return $this->belongsTo(ProposalTa::class, 'proposal_ta_id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    public function dokumenSidang()
    {
        return $this->belongsTo(DokumenSidang::class, 'dokumen_sidang_id');
    }
}
