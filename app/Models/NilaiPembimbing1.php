<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiPembimbing1 extends Model
{
    use HasFactory;

    protected $fillable = ['sidang_ta_id', 'dosen_id', 'mahasiswa_id', 'dokumen_sidang_id', 'b1', 'b2', 'b3', 'm1', 'm2', 'm3', 'm4', 'm5', 'm6', 'pro', 'total', 'komentar'];

    public function SidangTa()
    {
        return $this->belongsTo(SidangTa::class, 'sidang_ta_id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }
}