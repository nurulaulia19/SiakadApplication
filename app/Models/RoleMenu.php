<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleMenu extends Model
{
    use HasFactory;
    public $table = "data_role_menu";
    protected $fillable = [
            'role_menu_id',
            'role_id',
            'menu_id',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    public function dataMenu()
    {
        return $this->belongsTo(Data_Menu::class, 'menu_id', 'menu_id');
    }
  
}
