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
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link to users
            $table->string('type')->default('product'); // e.g., 'product', 'pc_build', 'bundle'
            $table->string('name')->nullable(); // e.g., "Gaming PC", "Office Bundle"
            $table->decimal('total_price', 10, 2)->default(0.00);
            $table->json('metadata')->nullable(); // For custom data (e.g., build notes)
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configurations');
    }
};
