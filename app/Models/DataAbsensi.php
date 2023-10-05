<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAbsensi extends Model
{
    use HasFactory;
    protected $table = "data_absensi";
    protected $primaryKey = 'id_absensi';
    protected $fillable = [
            'id_absensi',
            'id_gp',
            'tanggal',
    ];

    public function guruPelajaran()
    {
        return $this->belongsTo(GuruPelajaran::class, 'id_gp', 'id_gp');
    }

    public function absensiDetail()
    {
        return $this->hasMany(AbsensiDetail::class, 'id_absensi', 'id_absensi');
    }
}
