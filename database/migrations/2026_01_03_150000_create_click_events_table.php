<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('click_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fashion_item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('source', 50)->nullable();
            $table->string('ip')->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->timestamps();
            $table->index(['fashion_item_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('click_events');
    }
};
