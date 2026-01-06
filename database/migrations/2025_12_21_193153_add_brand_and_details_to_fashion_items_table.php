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
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('cascade')->after('id');
            $table->string('link_shopee')->nullable()->after('image_url');
            $table->string('link_tokopedia')->nullable()->after('link_shopee');
            $table->string('link_tiktok')->nullable()->after('link_tokopedia');
            $table->json('sizes')->nullable()->after('link_tiktok');
            $table->json('colors')->nullable()->after('sizes');
            $table->text('description')->nullable()->after('colors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fashion_items', function (Blueprint $table) {
            $table->dropForeign(['brand_id']);
            $table->dropColumn(['brand_id', 'link_shopee', 'link_tokopedia', 'link_tiktok', 'sizes', 'colors', 'description']);
        });
    }
};
