<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SidangProposal extends Model
{
    use HasFactory;

    protected $fillable = ['proposal_ta_id', 'tanggal', 'ruangan', 'sesi', 'mahasiswa_id', 'pem1_id', 'pem2_id', 'penguji_id'];

    public function proposal()
    {
        return $this->belongsTo(ProposalTA::class, 'proposal_ta_id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function pem1()
    {
        return $this->belongsTo(Pembimbing1::class, 'pem1_id');
    }

    public function pem2()
    {
        return $this->belongsTo(Pembimbing2::class, 'pem2_id');
    }


    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function penguji()
    {
        return $this->belongsTo(Dosen::class, 'penguji_id');
    }
    public function pem1Nama()
    {
        return $this->belongsTo(Dosen::class, 'pem1_id');
    }
    public function pem2Nama()
    {
        return $this->belongsTo(Dosen::class, 'pem2_id');
    }

    public function ruang()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan');
    }

    public function sesi()
    {
        return $this->belongsTo(Sesi::class, 'sesi');
    }
}
