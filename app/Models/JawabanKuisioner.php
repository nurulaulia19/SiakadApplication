<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanKuisioner extends Model
{
    use HasFactory;
    protected $table = "data_jawaban_kuisioner";
    protected $primaryKey = 'id_jawaban_kuisioner';
    protected $fillable = [
            'id_jawaban_kuisioner',
            'id_gp',
            'id_kuisioner',
            'nis_siswa',
            'jawaban',
    ];
}
