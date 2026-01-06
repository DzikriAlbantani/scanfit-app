<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brand_banners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('banner_image_url');
            $table->string('link_url')->nullable();
            $table->string('cta_text')->default('Lihat Sekarang');
            $table->enum('status', ['pending', 'approved', 'rejected', 'active', 'inactive'])->default('pending');
            $table->dateTime('started_at')->nullable();
            $table->dateTime('ended_at')->nullable();
            $table->integer('clicks')->default(0);
            $table->integer('impressions')->default(0);
            $table->decimal('budget', 10, 2)->nullable();
            $table->string('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brand_banners');
    }
};
