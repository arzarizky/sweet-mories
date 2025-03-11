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
        Schema::create('outlet_settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');

            // Pisahkan hari dan waktu untuk waktu mulai
            $table->date('start_day'); // Hanya tanggal (YYYY-MM-DD)
            $table->time('start_time'); // Hanya waktu (HH:MM:SS)

            // Pisahkan hari dan waktu untuk waktu selesai
            $table->date('end_day'); // Hanya tanggal (YYYY-MM-DD)
            $table->time('end_time'); // Hanya waktu (HH:MM:SS)

            $table->enum('is_active', ['ENABLE', 'DISABLE'])->default('DISABLE');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outlet_settings');
    }
};
