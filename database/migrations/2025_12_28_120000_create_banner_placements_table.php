<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('banner_placements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('banner_id')->constrained('brand_banners')->cascadeOnDelete();
            $table->foreignId('brand_id')->constrained()->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedInteger('days');
            $table->unsignedInteger('daily_fee');
            $table->unsignedBigInteger('total_amount');
            $table->string('status')->default('pending'); // pending, paid, active, expired, canceled
            $table->foreignId('payment_id')->nullable()->constrained('payments')->nullOnDelete();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banner_placements');
    }
};
