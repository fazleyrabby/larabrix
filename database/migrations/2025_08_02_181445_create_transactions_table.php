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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // payer/payee
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete(); // if linked to an order
            // Type of transaction
            $table->string('type'); // e.g. payment, refund, payout, credit, fee
            $table->string('gateway')->nullable(); // 'stripe', 'paypal', etc.
            $table->string('transaction_id')->nullable(); // gateway transaction ID
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->string('status')->default('pending'); // success, failed, refunded, etc.
            $table->json('meta')->nullable(); // store any gateway response, fees, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
