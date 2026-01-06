<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update category values based on current values
        DB::statement("UPDATE fashion_items SET category = 'Atasan' WHERE category IN ('tops', 'Atasan')");
        DB::statement("UPDATE fashion_items SET category = 'Bawahan' WHERE category IN ('bottoms', 'Bawahan')");
        DB::statement("UPDATE fashion_items SET category = 'Aksesoris' WHERE category NOT IN ('Atasan', 'Bawahan')");

        // Then migrate style data from old category
        DB::statement("UPDATE fashion_items SET style = 
            CASE 
                WHEN style IS NULL OR style = '' THEN 'casual'
                ELSE style
            END");

        // Now change the enum
        Schema::table('fashion_items', function (Blueprint $table) {
            $table->enum('category', ['Atasan', 'Bawahan', 'Aksesoris', 'Outwear', 'Dress', 'Shoes'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fashion_items', function (Blueprint $table) {
            // Revert to original enum
            $table->enum('category', ['Casual', 'Streetwear', 'Formal', 'Sporty', 'Vintage', 'Minimalist'])->change();
        });
    }
};
