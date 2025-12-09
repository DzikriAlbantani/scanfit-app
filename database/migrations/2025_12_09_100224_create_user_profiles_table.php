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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->enum('style_preference', ['casual', 'formal', 'sport', 'street', 'vintage', 'minimal'])->nullable();
            $table->enum('skin_tone', ['light', 'medium', 'tan', 'dark'])->nullable();
            $table->enum('body_size', ['XS', 'S', 'M', 'L', 'XL', 'XXL'])->nullable();
            $table->string('favorite_color')->nullable();
            $table->string('main_need')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
