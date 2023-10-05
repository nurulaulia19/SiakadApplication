<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelajaranKelasList extends Model
{
    use HasFactory;
    protected $table = "data_pelajaran_kelas_list";
    protected $primaryKey = 'id_pkl';
    protected $fillable = [
            'id_pkl',
            'id_pk',
            'id_pelajaran',
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id_sekolah');
    }

    public function mapel()
    {
        return $this->belongsTo(DataPelajaran::class, 'id_pelajaran', 'id_pelajaran');
    }

    public function mapelKelas()
    {
        return $this->belongsTo(PelajaranKelas::class, 'id_pk', 'id_pk');
    }

    public function guruMapel()
    {
        return $this->hasMany(GuruPelajaran::class, 'id_pkl', 'id_pkl');
    }
}
