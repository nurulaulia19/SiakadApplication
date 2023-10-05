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
            $table->integer('id_pelajaran')->after('id_gp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_guru_pelajaran', function (Blueprint $table) {
            //
        });
    }
};
