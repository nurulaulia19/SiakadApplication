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
        Schema::create('data_menu', function (Blueprint $table) {
            $table->increments('menu_id')->primary;
            $table->string('menu_name');
            $table->string('menu_link');
            $table->enum('menu_category', ['master menu', 'sub menu']);
            $table->integer('menu_sub')->nullable();
            $table->integer('menu_position');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_menu');
    }
};
