<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPelajaran extends Model
{
    use HasFactory;
    protected $table = "data_pelajaran";
    protected $primaryKey = 'id_pelajaran';
    protected $fillable = [
            'id_pelajaran',
            'kode_pelajaran',
            'id_sekolah',
            'nama_pelajaran',
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id_sekolah');
    }

    public function mapelList()
    {
        return $this->hasMany(PelajaranKelasList::class, 'id_pelajaran', 'id_pelajaran');
    }

    public function guruMapel()
    {
        return $this->hasMany(GuruPelajaran::class, 'id_pelajaran', 'id_pelajaran');
    }

    public function nilai()
    {
        return $this->hasMany(DataNilai::class, 'id_pelajaran', 'id_pelajaran');
    }
}
