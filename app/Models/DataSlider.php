<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSlider extends Model
{
    use HasFactory;
    protected $table = "data_slider";
    protected $primaryKey = 'id_slider';
    protected $fillable = [
            'id_slider',
            'judul',
            'gambar',
    ];
}
