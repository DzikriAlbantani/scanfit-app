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
        Schema::table('closet_items', function (Blueprint $table) {
            // Only add if column doesn't exist
            if (!Schema::hasColumn('closet_items', 'outfit_album_id')) {
                $table->unsignedBigInteger('outfit_album_id')->nullable()->after('fashion_item_id');
                $table->foreign('outfit_album_id')->references('id')->on('outfit_albums')->onDelete('set null');
                $table->index('outfit_album_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('closet_items', function (Blueprint $table) {
            $table->dropForeign(['outfit_album_id']);
            $table->dropColumn('outfit_album_id');
        });
    }
};
