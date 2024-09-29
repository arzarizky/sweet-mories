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
        Schema::create('products_display', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->string('product_background_id');
            $table->foreign('product_background_id')->references('id')->on('products_background');
            $table->string('product_additional_id');
            $table->foreign('product_additional_id')->references('id')->on('products_additional');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_display');
    }
};
