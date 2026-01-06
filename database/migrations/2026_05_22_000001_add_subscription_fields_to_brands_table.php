<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            if (!Schema::hasColumn('brands', 'subscription_plan')) {
                $table->string('subscription_plan')->default('basic')->after('status');
                $table->index('subscription_plan');
            }
            if (!Schema::hasColumn('brands', 'is_premium')) {
                $table->boolean('is_premium')->default(false)->after('subscription_plan');
                $table->index('is_premium');
            }
            if (!Schema::hasColumn('brands', 'subscription_expires_at')) {
                $table->timestamp('subscription_expires_at')->nullable()->after('is_premium');
            }
        });
    }

    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            if (Schema::hasColumn('brands', 'subscription_plan')) {
                $table->dropIndex(['subscription_plan']);
                $table->dropColumn('subscription_plan');
            }
            if (Schema::hasColumn('brands', 'is_premium')) {
                $table->dropIndex(['is_premium']);
                $table->dropColumn('is_premium');
            }
            if (Schema::hasColumn('brands', 'subscription_expires_at')) {
                $table->dropColumn('subscription_expires_at');
            }
        });
    }
};
