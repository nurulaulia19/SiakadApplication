<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KenaikanKelas extends Model
{
    use HasFactory;
    protected $table = "data_kenaikan_kelas";
    protected $primaryKey = 'id_kk';
    protected $fillable = [
            'id_kk',
            'id_sekolah',
            'id_kelas',
            'tahun_ajaran',
            'nis_siswa',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id_sekolah');
    }

    
    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class, 'nis_siswa', 'nis_siswa');
    }
    
    public function guruPelajaran()
    {
        return $this->belongsTo(GuruPelajaran::class, 'id_gp', 'id_gp');
    }

    
    // public function nilai()
    // {
    //     return $this->hasMany(DataNilai::class, 'id_kk', 'id_kk');
    // }
}
