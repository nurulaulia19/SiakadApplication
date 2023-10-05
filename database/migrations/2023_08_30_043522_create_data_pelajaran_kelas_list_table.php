<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_pelajaran_kelas_list', function (Blueprint $table) {
            $table->increments('id_pkl');
            $table->integer('id_pk');
            $table->integer('id_sekolah');
            $table->integer('id_pelajaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pelajaran_kelas_list');
    }
};
