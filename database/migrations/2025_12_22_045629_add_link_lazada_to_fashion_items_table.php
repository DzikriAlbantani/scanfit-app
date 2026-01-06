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
            $table->string('link_lazada')->nullable()->after('link_tiktok');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fashion_items', function (Blueprint $table) {
            $table->dropColumn('link_lazada');
        });
    }
};
