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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('text')->nullable();
            $table->string('href')->nullable();
            $table->string('target')->nullable();
            $table->text('slug');
            $table->integer('parent_id')->default(0); // default no parent
            $table->tinyInteger('status')->default(true);
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->integer('position')->default(0);
            $table->string('type')->default('header');
            // $table->text('language')->nullable(); // {"en": "", "bn": ""}
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
