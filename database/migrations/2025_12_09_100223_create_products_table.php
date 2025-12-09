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
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('stock')->default(0);
            $table->text('image_url')->nullable();
            $table->boolean('is_affiliate')->default(false);
            $table->text('affiliate_link')->nullable();
            $table->enum('style', ['casual', 'formal', 'sport', 'street', 'vintage', 'minimal'])->nullable();
            $table->enum('fit_type', ['slim', 'regular', 'loose'])->nullable();
            $table->string('dominant_color')->nullable();
            $table->string('category')->nullable();
            $table->enum('gender_target', ['male', 'female', 'unisex'])->nullable();
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
