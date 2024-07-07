<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $fillable = ['nobp', 'nama', 'telp', 'alamat', 'prodi_id', 'user_id'];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

}
