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
        Schema::create('data_jawaban_kuisioner', function (Blueprint $table) {
            $table->increments('id_jawaban_kuisioner');
            $table->integer('id_gp');
            $table->integer('id_kuisioner');
            $table->string('nis_siswa');
            $table->enum('jawaban', ['sangatbaik', 'baik', 'cukupbaik', 'kurangbaik']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_jawaban_kuisioner');
    }
};
