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
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->text('bio')->nullable()->after('main_need');
            $table->integer('height')->nullable()->after('bio');
            $table->integer('weight')->nullable()->after('height');
            $table->integer('scans')->default(0)->after('weight');
            $table->integer('saved')->default(0)->after('scans');
            $table->integer('likes')->default(0)->after('saved');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn(['bio', 'height', 'weight', 'scans', 'saved', 'likes']);
        });
    }
};