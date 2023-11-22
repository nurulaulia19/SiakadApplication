<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataBrosur extends Model
{
    use HasFactory;
    protected $table = "data_brosur";
    protected $primaryKey = 'id_brosur';
    protected $fillable = [
            'id_brosur',
            'judul',
            'file',
            'status'
    ];
}
