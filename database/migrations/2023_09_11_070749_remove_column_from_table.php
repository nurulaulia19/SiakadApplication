<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnFromTable extends Migration
{
    public function up()
    {
        Schema::table('data_pelajaran', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        
    }

    // public function down()
    // {
    //     Schema::table('nama_tabel', function (Blueprint $table) {
    //         $table->string('nama_kolom'); // Anda bisa menentukan tipe dan konfigurasi kolom sesuai dengan kebutuhan
    //     });
    // }
}

