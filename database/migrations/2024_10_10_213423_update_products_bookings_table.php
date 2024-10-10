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

            $table->uuid('additional_product_id')->nullable()->after('product_id');
            $table->foreign('additional_product_id')->references('id')->on('products_additional');

            $table->uuid('background_product_id')->nullable()->after('product_id');
            $table->foreign('background_product_id')->references('id')->on('products_background');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products_bookings', function (Blueprint $table) {
            $table->dropForeign(['additional_product_id']);
            $table->dropColumn('additional_product_id');

            $table->dropForeign(['background_product_id']);
            $table->dropColumn('background_product_id');
        });
    }
};
