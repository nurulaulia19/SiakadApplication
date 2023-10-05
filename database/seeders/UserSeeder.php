<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Jane Doe',
            'username' => 'jane',
            'email' => 'jane@example.com',
            'password' => bcrypt('password'),
        ]);
    }
}

