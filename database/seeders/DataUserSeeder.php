<?php

namespace Database\Seeders;

use App\Models\Data_Menu;
use App\Models\DataUser;
use App\Models\Role;
use App\Models\RoleMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $curut = Role::create([
            'role_name' => 'admin'
        ]);

        $home = Data_Menu::create([
            'menu_name' => 'Home',
            'menu_link' => 'admin/home*',
            'menu_category' => 'master menu',
            'menu_position' => 1
        ]);
        $ayamgeprek = Data_Menu::create([
            'menu_name' => 'Home',
            'menu_link' => 'admin.home',
            'menu_category' => 'sub menu',
            'menu_sub' => $home->id,
            'menu_position' => 1
        ]);
        RoleMenu::create([
            'role_id' => $curut->id,
            'menu_id' => $ayamgeprek->id,
        ]);
        

        $dataMenu = Data_Menu::create([
            'menu_name' => 'Master Menu',
            'menu_link' => 'admin/menu*',
            'menu_category' => 'master menu',
            'menu_position' => 3
        ]);

        $menu = Data_Menu::create([
            'menu_name' => 'Menu',
            'menu_link' => 'menu.index',
            'menu_category' => 'sub menu',
            'menu_sub' => $dataMenu->id,
            'menu_position' => 1
        ]);

        $masterUser = Data_Menu::create([
            'menu_name' => 'Master User',
            'menu_link' => 'admin/role*,admin/user*',
            'menu_category' => 'master menu',
            'menu_position' => 2
        ]);

        $role = Data_Menu::create([
            'menu_name' => 'Role',
            'menu_link' => 'role.index',
            'menu_category' => 'sub menu',
            'menu_sub' => $masterUser->id,
            'menu_position' => 1
        ]);

        $user = Data_Menu::create([
            'menu_name' => 'User',
            'menu_link' => 'user.index',
            'menu_category' => 'sub menu',
            'menu_sub' => $masterUser->id,
            'menu_position' => 2
        ]);

        RoleMenu::create([
            'role_id' => $curut->id,
            'menu_id' => $menu->id,
        ]);

        DataUser::create([
            'user_id' => 1,
            'user_name' => 'nurulaulia',
            'user_email' => 'nurulauliaseptiani9@gmail.com',
            'user_password' => bcrypt('@Nurulauliaseptiani9@gmail.com'),
            'user_gender' => 'female',
            'user_photo' => 'nurul.jpg',
            'role_id' => $curut->id,
            'user_token' => 123
            
        ]);

        DataUser::create([
            'user_id' => 4,
            'user_name' => 'agat',
            'user_email' => 'agat@gmail.com',
            'user_password' => bcrypt('@Nurulauliaseptiani9@gmail.com'),
            'user_gender' => 'male',
            'user_photo' => 'agat.jpg',
            'role_id' => $curut->id,
            'user_token' => 123
            
        ]);
    }
}
