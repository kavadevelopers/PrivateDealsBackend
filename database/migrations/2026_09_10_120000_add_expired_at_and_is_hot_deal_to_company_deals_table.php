<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('company_deals', function (Blueprint $table) {
            $table->timestamp('expired_at')->nullable()->after('status');
            $table->boolean('is_hot_deal')->default(false)->after('expired_at');
            $table->index('expired_at');
            $table->index('is_hot_deal');
        });
    }

    public function down(): void
    {
        Schema::table('company_deals', function (Blueprint $table) {
            $table->dropIndex(['expired_at']);
            $table->dropIndex(['is_hot_deal']);
            $table->dropColumn(['expired_at', 'is_hot_deal']);
        });
    }
};
