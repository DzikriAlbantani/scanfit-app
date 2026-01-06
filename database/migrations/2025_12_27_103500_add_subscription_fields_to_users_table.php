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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'subscription_plan')) {
                $table->string('subscription_plan')->default('basic')->after('is_premium');
            }
            if (!Schema::hasColumn('users', 'scan_count_monthly')) {
                $table->unsignedInteger('scan_count_monthly')->default(0)->after('subscription_plan');
            }
            if (!Schema::hasColumn('users', 'last_scan_reset')) {
                $table->date('last_scan_reset')->nullable()->after('scan_count_monthly');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'subscription_plan')) {
                $table->dropColumn('subscription_plan');
            }
            if (Schema::hasColumn('users', 'scan_count_monthly')) {
                $table->dropColumn('scan_count_monthly');
            }
            if (Schema::hasColumn('users', 'last_scan_reset')) {
                $table->dropColumn('last_scan_reset');
            }
        });
    }
};
