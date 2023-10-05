<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataUser extends Authenticatable
{
    use HasFactory;
    protected $table = "data_user";
    protected $primaryKey = 'user_id';
    protected $fillable = [
            'user_id',
            'user_name',
            'user_email',
            'user_password',
            'user_gender',
            'user_photo',
            'role_id',
            'user_token'
    ];


    protected $user_name = 'user_name';
    protected $user_password = 'user_password';

    public function role(){
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'user_id', 'user_id');
    }

    public function aksesCabang()
    {
        return $this->hasMany(AksesCabang::class, 'user_id', 'user_id');
    }

    public function updateProfile(array $data)
    {
        return $this->update($data);
    }

    public function guruMapel()
    {
        return $this->hasMany(GuruPelajaran::class, 'user_id', 'user_id');
    }
}
