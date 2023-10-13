<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    protected $table = "data_sekolah";
    protected $primaryKey = 'id_sekolah';
    protected $fillable = [
            'id_sekolah',
            'nama_sekolah',
            'nama_kepsek',
            'logo',
            'alamat',
    ];

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'id_sekolah', 'id_sekolah');
    }

    public function mapel()
    {
        return $this->hasMany(DataPelajaran::class, 'id_sekolah', 'id_sekolah');
    }

    public function pelajaranKelas()
    {
        return $this->hasMany(PelajaranKelas::class, 'id_sekolah', 'id_sekolah');
    }

    public function mapelList()
    {
        return $this->hasMany(PelajaranKelasList::class, 'id_sekolah', 'id_sekolah');
    }

    public function siswa()
    {
        return $this->hasMany(DataSiswa::class, 'id_sekolah', 'id_sekolah');
    }

    public function guruMapel()
    {
        return $this->hasMany(GuruPelajaran::class, 'id_sekolah', 'id_sekolah');
    }

    public function kategoriNilai()
    {
        return $this->hasMany(KategoriNilai::class, 'id_sekolah', 'id_sekolah');
    }

    public function nilai()
    {
        return $this->hasMany(DataNilai::class, 'id_sekolah', 'id_sekolah');
    }

    public function aksesSekolah()
    {
        return $this->hasMany(AksesSekolah::class, 'id_sekolah', 'id_sekolah');
    }
}
