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
            // First, drop the existing column
            $table->dropColumn('product_additional_id');
        });

        Schema::table('products_display', function (Blueprint $table) {
            // Then, add it back as a JSON type
            $table->json('product_additional_id')->nullable();
        });

        Schema::table('products_display', function (Blueprint $table) {
            // Create the generated column and index it
            $table->string('product_additional_first')->virtualAs('json_unquote(json_extract(product_additional_id, "$[0]"))');
            $table->index('product_additional_first');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products_display', function (Blueprint $table) {
            // Drop the generated column and index first
            $table->dropIndex(['product_additional_first']);
            $table->dropColumn('product_additional_first');

            // Then, drop the JSON column
            $table->dropColumn('product_additional_id');

            // Finally, add it back as a string (if you want to revert)
            $table->string('product_additional_id')->nullable();
        });
    }
};
