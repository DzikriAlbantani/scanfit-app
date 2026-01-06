<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('fashion_items', 'image_url')) {
            DB::statement('ALTER TABLE fashion_items MODIFY image_url TEXT');
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('fashion_items', 'image_url')) {
            // Revert to VARCHAR(255) if needed
            DB::statement("ALTER TABLE fashion_items MODIFY image_url VARCHAR(255)");
        }
    }
};
