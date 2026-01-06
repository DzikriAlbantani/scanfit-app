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
            $table->text('link_shopee')->nullable()->change();
            $table->text('link_tokopedia')->nullable()->change();
            $table->text('link_tiktok')->nullable()->change();
            $table->text('link_lazada')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fashion_items', function (Blueprint $table) {
            $table->string('link_shopee')->nullable()->change();
            $table->string('link_tokopedia')->nullable()->change();
            $table->string('link_tiktok')->nullable()->change();
            $table->string('link_lazada')->nullable()->change();
        });
    }
};
