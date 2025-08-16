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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('sku')->unique();
            $table->string('slug')->unique();
            $table->float('price')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->json('additional_info')->nullable();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // Foreign key to categories
            $table->foreignId('brand_id')->constrained('terms')->onDelete('cascade'); // Foreign key to categories
            $table->enum('type', ['simple', 'variable'])->default('simple');
            $table->boolean('is_pc_component')->default(false);
            $table->string('compatibility_key')->nullable();
            $table->boolean('configurable')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
