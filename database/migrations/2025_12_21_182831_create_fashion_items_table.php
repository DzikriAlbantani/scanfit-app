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
        Schema::create('fashion_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('category', ['Casual', 'Streetwear', 'Formal', 'Sporty', 'Vintage', 'Minimalist']);
            $table->decimal('price', 10, 2);
            $table->decimal('original_price', 10, 2)->nullable();
            $table->decimal('rating', 2, 1)->default(4.0); // 1-5 scale
            $table->integer('review_count')->default(0);
            $table->enum('store_name', ['Tokopedia', 'Shopee', 'Zalora']);
            $table->string('image_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fashion_items');
    }
};
