<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AksesSekolah extends Model
{
    use HasFactory;
    protected $table = "akses_sekolah";
    protected $primaryKey = 'id_as';
    protected $fillable = [
            'id_sekolah',
            'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(DataUser::class, 'user_id', 'user_id');
    }
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id_sekolah');
    }

}
