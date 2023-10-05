<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data_Menu extends Model
{
    use HasFactory;
    public $table = "data_menu";
    protected $fillable = [
            'menu_id',
            'menu_name',
            'menu_link',
            'menu_category',
            'menu_sub',
            'menu_position'
    ];


    // public function rolemenu(){
    //     return $this->hasMany('App\Models\DataRoleMenu');
    // }

    public function roleMenus()
    {
        return $this->hasMany(RoleMenu::class, 'menu_id', 'menu_id');
    }
}
