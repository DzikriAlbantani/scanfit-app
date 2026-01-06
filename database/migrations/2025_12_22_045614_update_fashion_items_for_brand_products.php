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
        Schema::table('fashion_items', function (Blueprint $table) {
            $table->string('category')->change();
            $table->string('store_name')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fashion_items', function (Blueprint $table) {
            $table->enum('category', ['Casual', 'Streetwear', 'Formal', 'Sporty', 'Vintage', 'Minimalist'])->change();
            $table->enum('store_name', ['Tokopedia', 'Shopee', 'Zalora'])->change();
        });
    }
};
