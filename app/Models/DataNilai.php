<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataNilai extends Model
{
    use HasFactory;
    protected $table = "data_nilai";
    protected $primaryKey = 'id_nilai';
    protected $fillable = [
            'id_nilai',
            'id_gp',
            'kategori',
            'nis_siswa',
            'nilai',
    ];

    public function guruPelajaran()
    {
        return $this->belongsTo(GuruPelajaran::class, 'id_gp', 'id_gp');
    }

    public function kategoriNilai()
    {
        return $this->belongsTo(KategoriNilai::class, 'kategori','id_kn');
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id_sekolah');
    }

    
    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class, 'nis_siswa', 'nis_siswa');
    }

    public function mapel()
    {
        return $this->belongsTo(DataPelajaran::class, 'id_pelajaran', 'id_pelajaran');
    }
}
