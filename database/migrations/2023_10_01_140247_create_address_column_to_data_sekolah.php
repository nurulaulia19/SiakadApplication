<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressColumnToDataSekolah extends Migration
{
    public function up()
    {
        Schema::table('data_sekolah', function (Blueprint $table) {
            $table->string('alamat'); // Menambah kolom alamat
        });
    }

    // public function down()
    // {
    //     Schema::table('sekolah', function (Blueprint $table) {
    //         $table->dropColumn('alamat'); // Menghapus kolom alamat jika diperlukan
    //     });
    // }
}
