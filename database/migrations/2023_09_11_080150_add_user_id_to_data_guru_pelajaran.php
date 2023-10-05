<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('data_guru_pelajaran', function (Blueprint $table) {
            $table->integer('user_id'); // Anda bisa menentukan tipe dan konfigurasi kolom sesuai dengan kebutuhan
        });
    }

    // public function down()
    // {
    //     Schema::table('data_guru_pelajaran', function (Blueprint $table) {
    //         $table->dropColumn('user_id');
    //     });
    // }
};
