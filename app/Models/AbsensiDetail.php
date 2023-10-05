<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiDetail extends Model
{
    use HasFactory;
    protected $table = "data_absensi_detail";
    protected $primaryKey = 'id_ad';
    protected $fillable = [
            'id_ad',
            'id_gp',
            'id_absensi',
            'tanggal',
            'nis_siswa',
            'keterangan'
    ];

    public function guruPelajaran()
    {
        return $this->belongsTo(GuruPelajaran::class, 'id_gp', 'id_gp');
    }

    public function absensi()
    {
        return $this->belongsTo(DataAbsensi::class, 'id_absensi', 'id_absensi');
    }
}
