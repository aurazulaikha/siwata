<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiTa extends Model
{
    use HasFactory;


    protected $fillable = ['sidang_ta_id', 'mahasiswa_id', 'total_pem1', 'total_pem2', 'rata_pem', 'total_ketua', 'total_sekretaris', 'total_penguji1', 'total_penguji2', 'rata_penguji', 'total', 'status'];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

}

