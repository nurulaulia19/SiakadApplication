<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelajaranKelas extends Model
{
    use HasFactory;
    protected $table = "pelajaran_kelas";
    protected $primaryKey = 'id_pk';
    protected $fillable = [
            'id_pk',
            'id_kelas',
            'id_sekolah',
            'tahun_ajaran',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id_sekolah');
    }

    public function mapelList()
    {
        return $this->hasMany(PelajaranKelasList::class, 'id_pk', 'id_pk')->with('sekolah', 'mapel');;
    }

    // public static function boot()
    // {
    //     parent::boot();

    //     static::saving(function ($model) {
    //         $existingEntry = self::where([
    //             'tahun_ajaran' => $model->tahun_ajaran,
    //             'id_kelas' => $model->id_kelas,
    //             'id_sekolah' => $model->id_sekolah,
    //         ])->first();

    //         if ($existingEntry) {
    //             throw new \Exception('Kelas sudah ada.');
    //         }
    //     });
    // }
}
