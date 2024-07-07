<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $fillable = ['nidn', 'nama', 'prodi_id', 'no_telp', 'alamat', 'user_id'];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
