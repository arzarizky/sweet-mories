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
        Schema::table('products_bookings', function (Blueprint $table) {
            $table->uuid('product_id')->nullable()->change();  // Allow null for product_id
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products_bookings', function (Blueprint $table) {
            $table->uuid('product_id')->nullable(false)->change();
        });
    }
};