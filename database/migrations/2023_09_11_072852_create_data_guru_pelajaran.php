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
        Schema::create('data_guru_pelajaran', function (Blueprint $table) {
            $table->increments('id_gp');
            $table->integer('id_pkl');
            $table->integer('id_kelas');
            $table->integer('id_sekolah');
            $table->year('tahun_ajaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_guru_pelajaran');
    }
};
