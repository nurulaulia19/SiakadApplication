<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    public $table = "data_role";
    protected $fillable = [
            'role_id',
            'role_name',
    ];



    public function roleMenus()
    {
        return $this->hasMany(RoleMenu::class, 'role_id', 'role_id')->with('dataMenu');
    }
}
