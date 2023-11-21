<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataBerita extends Model
{
    use HasFactory;
    protected $table = "data_berita";
    protected $primaryKey = 'id_berita';
    protected $fillable = [
            'id_berita',
            'judul',
            'gambar',
            'deskripsi',
            'status'
    ];
}
