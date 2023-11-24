<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataGaleri extends Model
{
    use HasFactory;
    protected $table = "data_galeri";
    protected $primaryKey = 'id_galeri';
    protected $fillable = [
            'id_galeri',
            'judul',
            'gambar',
            'status'
    ];
}
