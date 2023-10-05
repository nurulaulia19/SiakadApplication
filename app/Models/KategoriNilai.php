<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriNilai extends Model
{
    use HasFactory;
    protected $table = "data_kategori_nilai";
    protected $primaryKey = 'id_kn';
    protected $fillable = [
            'id_kn',
            'id_sekolah',
            'kategori',
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id_sekolah');
    }

    public function guruMapel()
    {
        return $this->hasMany(GuruPelajaran::class, 'id_kn', 'id_kn');
    }

    public function nilai()
    {
        return $this->hasMany(DataNilai::class, 'kategori', 'kategori');
    }

}

