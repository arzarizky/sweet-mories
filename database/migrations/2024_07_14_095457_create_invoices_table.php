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
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('invoice_id')->unique();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('book_id');
            $table->foreign('book_id')->references('book_id')->on('bookings');
            $table->decimal('amount', 10, 2);
            $table->string('payment_link')->nullable();
            $table->enum('status', ['PENDING', 'PAID', 'CANCELLED', 'EXP'])->default('PENDING');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
