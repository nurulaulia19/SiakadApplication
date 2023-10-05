<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruPelajaranJadwal extends Model
{
    use HasFactory;
    protected $table = "data_guru_pelajaran_jadwal";
    protected $primaryKey = 'id_gpj';
    protected $fillable = [
            'id_gpj',
            'id_gp',
            'hari',
            'jam_mulai',
            'jam_selesai',
    ];

    public function guruMapel()
    {
        return $this->belongsTo(GuruPelajaran::class, 'id_gp', 'id_gp');
    }
}
