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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Optional: associate with a user or customer
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Unique order number / invoice
            $table->string('order_number')->unique();

            // Order status: pending, paid, shipped, cancelled, etc.
            $table->string('status')->default('pending');

            // Payment status: unpaid, paid, failed, refunded
            $table->enum('payment_status', ['pending', 'paid', 'refunded', 'failed'])->default('pending');

            // Total amounts
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);

            // Currency
            $table->string('currency', 10)->default('USD');

            // Optional: Payment gateway info
            $table->string('payment_gateway')->nullable(); // e.g., stripe, paypal
            $table->string('transaction_id')->nullable(); // fallback if not using separate payments table

            // Billing/shipping (simple form — can normalize later)
            $table->json('billing_address')->nullable();
            $table->json('shipping_address')->nullable();

            // Order metadata (coupons, IP, notes, etc.)
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
