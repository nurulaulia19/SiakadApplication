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
        Schema::create('data_pelajaran', function (Blueprint $table) {
            $table->increments('id_pelajaran');
            $table->string('kode_pelajaran');
            $table->integer('user_id');
            $table->integer('id_sekolah');
            $table->string('nama_pelajaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pelajaran');
    }
};
