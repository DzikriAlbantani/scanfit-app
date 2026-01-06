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
        Schema::create('closet_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('fashion_item_id')->nullable()->constrained()->onDelete('set null');
            $table->string('image_url');
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('category', ['Casual', 'Streetwear', 'Formal', 'Sporty', 'Vintage', 'Minimalist']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('closet_items');
    }
};
