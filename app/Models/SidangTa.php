<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SidangTa extends Model
{
    use HasFactory;

    protected $fillable = ['dokumen_sidang_id', 'tanggal', 'ruangan', 'sesi', 'mahasiswa_id', 'pem1_id', 'pem2_id', 'ketua_id', 'sekretaris_id', 'penguji1_id', 'penguji2_id', 'status'];

    public function dokumen_sidang()
    {
        return $this->belongsTo(DokumenSidang::class, 'dokumen_sidang_id');
    }


    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function ketua()
    {
        return $this->belongsTo(Pembimbing1::class, 'ketua_id');
    }

    public function sekretaris()
    {
        return $this->belongsTo(Pembimbing2::class, 'sekretaris_id');
    }


    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function penguji1()
    {
        return $this->belongsTo(Dosen::class, 'penguji1_id');
    }

    public function pembimbing1()
    {
        return $this->belongsTo(Dosen::class, 'pem1_id');
    }

    public function pembimbing2()
    {
        return $this->belongsTo(Dosen::class, 'pem2_id');
    }

    public function penguji2()
    {
        return $this->belongsTo(Dosen::class, 'penguji2_id');
    }



    public function ketuaNama()
    {
        return $this->belongsTo(Dosen::class, 'ketua_id');
    }

    public function sekretarisNama()
    {
        return $this->belongsTo(Dosen::class, 'sekretaris_id');
    }

    public function ruang()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan');
    }

    public function sesi()
    {
        return $this->belongsTo(Sesi::class, 'sesi');
    }

    public function nilaiKetuaEdit()
    {
        return $this->hasOne(NilaiKetua::class, 'sidang_ta_id');
    }

    public function nilaiSekretarisEdit()
    {
        return $this->hasOne(NilaiSekretaris::class, 'sidang_ta_id');
    }

    public function nilaiPenguji1Edit()
    {
        return $this->hasOne(NilaiPenguji1::class, 'sidang_ta_id');
    }

    public function nilaiPenguji2Edit()
    {
        return $this->hasOne(NilaiPenguji2::class, 'sidang_ta_id');
    }

    public function nilaiKetua()
    {
        return $this->hasMany(NilaiKetua::class, 'sidang_ta_id');
    }

    public function nilaiSekretaris()
    {
        return $this->hasMany(NilaiSekretaris::class, 'sidang_ta_id');
    }

    public function nilaiPembimbing1()
    {
        return $this->hasMany(NilaiPembimbing1::class, 'sidang_ta_id');
    }

    public function nilaiPembimbing2()
    {
        return $this->hasMany(NilaiPembimbing2::class, 'sidang_ta_id');
    }

    public function nilaiPenguji1()
    {
        return $this->hasMany(NilaiPenguji1::class, 'sidang_ta_id');
    }
    public function nilaiPenguji2()
    {
        return $this->hasMany(NilaiPenguji2::class, 'sidang_ta_id');
    }

    public function nilaiTa()
    {
        return $this->hasMany(NilaiTa::class, 'sidang_ta_id');
    }

    public function pem1Email()
    {
        return $this->belongsTo(User::class, 'pem1_id');
    }

    public function pem2Email()
    {
        return $this->belongsTo(User::class, 'pem2_id');
    }

    public function ketuaEmail()
    {
        return $this->belongsTo(User::class, 'ketua_id');
    }

    public function sekretarisEmail()
    {
        return $this->belongsTo(User::class, 'sekretaris_id');
    }

    public function penguji1Email()
    {
        return $this->belongsTo(User::class, 'penguji1_id');
    }

    public function penguji2Email()
    {
        return $this->belongsTo(User::class, 'penguji2_id');
    }

}
