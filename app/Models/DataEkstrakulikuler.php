<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataEkstrakulikuler extends Model
{
    use HasFactory;
    protected $table = "data_ekstrakulikuler";
    protected $primaryKey = 'id_ekstrakulikuler';
    protected $fillable = [
            'id_ekstrakulikuler',
            'id_sekolah',
            'judul',
            'gambar',
            'deskripsi',
            'status'
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id_sekolah');
    }
}
