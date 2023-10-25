<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriKuisioner extends Model
{
    use HasFactory;
    protected $table = "data_kategori_kuisioner";
    protected $primaryKey = 'id_kategori_kuisioner';
    protected $fillable = [
            'id_kategori_kuisioner',
            'id_sekolah',
            'nama_kategori',
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id_sekolah');
    }

    public function Kuisioner()
    {
        return $this->hasMany(DataKuisioner::class, 'id_kuisioner', 'id_kuisioner');
    }
}
