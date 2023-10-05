<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Data_MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('data_menu')->insert([
            'menu_id' => '1',
            'menu_name' => 'Home',
            'menu_link' => 'admin/home',
            'menu_category' => 'master menu',
            'menu_sub' => null,
            'menu_position' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
