<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSiswa extends Model
{
    use HasFactory;
    protected $table = "data_siswa";
    protected $primaryKey = 'id_siswa';
    protected $fillable = [
            'id_siswa',
            'id_sekolah',
            'nama_siswa',
            'nis_siswa',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'tahun_masuk',
            'password',
            'foto_siswa',
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id_sekolah');
    }

    public function kenaikanKelas()
    {
        return $this->hasMany(KenaikanKelas::class, 'nis_siswa', 'nis_siswa');
    }

    public function guruPelajaran()
    {
        return $this->hasMany(GuruPelajaran::class, 'id_siswa', 'id_siswa');
    }

    public function nilai()
    {
        return $this->hasMany(DataNilai::class, 'id_siswa', 'id_siswa');
    }

}
