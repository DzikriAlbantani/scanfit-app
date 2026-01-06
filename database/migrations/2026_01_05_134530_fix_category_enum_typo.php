<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Fix the category column by:
     * 1. Converting from ENUM to VARCHAR temporarily
     * 2. Fixing the typo "Outwear" -> "Outerwear" 
     * 3. Converting back to ENUM with all valid values
     */
    public function up(): void
    {
        // Step 1: Change from ENUM to VARCHAR to allow any value temporarily
        DB::statement('ALTER TABLE fashion_items MODIFY category VARCHAR(255)');
        
        // Step 2: Fix the typo
        DB::statement("UPDATE fashion_items SET category = 'Outerwear' WHERE category = 'Outwear'");
        
        // Step 3: Convert back to ENUM with all valid values
        Schema::table('fashion_items', function (Blueprint $table) {
            $table->enum('category', [
                'Atasan',        // Tops (Indonesian)
                'Bawahan',       // Bottoms (Indonesian)
                'Aksesoris',     // Accessories (Indonesian)
                'Outerwear',     // Outerwear (fixed typo)
                'Dress',         // Dress
                'Shoes',         // Shoes
            ])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to VARCHAR first
        DB::statement('ALTER TABLE fashion_items MODIFY category VARCHAR(255)');
        
        // Revert the typo fix
        DB::statement("UPDATE fashion_items SET category = 'Outwear' WHERE category = 'Outerwear'");
        
        // Change back to original ENUM
        Schema::table('fashion_items', function (Blueprint $table) {
            $table->enum('category', ['Atasan', 'Bawahan', 'Aksesoris', 'Outwear', 'Dress', 'Shoes'])->change();
        });
    }
};
