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
            $table->enum('style', ['casual', 'formal', 'sport', 'street', 'vintage', 'minimal'])->nullable()->after('description');
            $table->enum('fit_type', ['slim', 'regular', 'loose'])->nullable()->after('style');
            $table->string('dominant_color')->nullable()->after('fit_type');
            $table->enum('gender_target', ['male', 'female', 'unisex'])->nullable()->after('dominant_color');
            $table->integer('stock')->default(0)->after('gender_target');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fashion_items', function (Blueprint $table) {
            $table->dropColumn(['style', 'fit_type', 'dominant_color', 'gender_target', 'stock']);
        });
    }
};
