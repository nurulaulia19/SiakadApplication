<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKuisioner extends Model
{
    use HasFactory;
    protected $table = "data_kuisioner";
    protected $primaryKey = 'id_kuisioner';
    protected $fillable = [
            'id_kuisioner',
            'id_kategori_kuisioner',
            'id_sekolah',
            'pertanyaan',
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id_sekolah');
    }

    public function kategoriKuisioner()
    {
        return $this->belongsTo(KategoriKuisioner::class, 'id_kategori_kuisioner', 'id_kategori_kuisioner');
    }
}
