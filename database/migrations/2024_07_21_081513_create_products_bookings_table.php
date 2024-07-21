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
        Schema::create('products_bookings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('book_id');
            $table->foreign('book_id')->references('book_id')->on('bookings');
            $table->uuid('products_id');
            $table->foreign('products_id')->references('id')->on('products');
            $table->integer('quantity_product');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_bookings');
    }
};