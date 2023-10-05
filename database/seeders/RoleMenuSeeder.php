<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('data_role_menu')->insert([
            'role_menu_id' => '1',
            'role_id' => '1',
            'menu_id' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
