<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Foundation\Auth\User as Authenticatable;


class DataSiswa extends Model implements Authenticatable
{
    use HasFactory;
    protected $table = "data_siswa";
    protected $primaryKey = 'id_siswa';
    protected $fillable = [
            'id_siswa',
            'id_sekolah',
            'nama_siswa',
            'nis_siswa',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'tahun_masuk',
            'password',
            'foto_siswa',
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id_sekolah');
    }

    public function kenaikanKelas()
    {
        return $this->hasMany(KenaikanKelas::class, 'nis_siswa', 'nis_siswa');
    }

    public function guruPelajaran()
    {
        return $this->hasMany(GuruPelajaran::class, 'id_siswa', 'id_siswa');
    }

    public function nilai()
    {
        return $this->hasMany(DataNilai::class, 'id_siswa', 'id_siswa');
    }

    public function absensiDetail()
    {
        return $this->hasMany(DataNilai::class, 'nis_siswa', 'nis_siswa');
    }
   
    public function getAuthIdentifierName() {
        return 'nis_siswa';
    }
    
    public function getAuthIdentifier() {
        return $this->nis_siswa; // Mengembalikan nilai dari atribut 'nis_siswa'
    }    

    public function getAuthPassword() {
        return $this->password; // Sesuaikan dengan nama kolom password
    }

    public function getRememberToken() {
        return null; // Jika tidak menggunakan fitur "Remember Me"
    }

    public function setRememberToken($value) {
        // Jika tidak menggunakan fitur "Remember Me"
    }

    public function getRememberTokenName() {
        // Jika tidak menggunakan fitur "Remember Me"
    }
    
}
