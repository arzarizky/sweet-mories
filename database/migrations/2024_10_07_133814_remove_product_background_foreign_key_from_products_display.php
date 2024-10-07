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
        Schema::table('products_display', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['product_background_id']);

            // Drop the column if you also want to remove it
            $table->dropColumn('product_background_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products_display', function (Blueprint $table) {
            // Re-add the column if you want to roll back
            $table->string('product_background_id')->after('product_id'); // Adjust position if needed
            $table->foreign('product_background_id')->references('id')->on('products_background');
        });
    }
};
