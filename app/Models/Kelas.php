<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $table = "data_kelas";
    protected $primaryKey = 'id_kelas';
    protected $fillable = [
            'id_kelas',
            'nama_kelas',
            'id_sekolah',
    ];


    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id_sekolah');
    }

    public function pelajaranKelas()
    {
        return $this->hasMany(PelajaranKelas::class, 'id_kelas', 'id_kelas');
    }

    public function kenaikanKelas()
    {
        return $this->hasMany(PelajaranKelas::class, 'id_kelas', 'id_kelas');
    }

    public function guruMapel()
    {
        return $this->hasMany(GuruPelajaran::class, 'id_kelas', 'id_kelas');
    }
}

