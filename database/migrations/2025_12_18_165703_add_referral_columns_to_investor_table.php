<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('investor', function (Blueprint $table) {
            $table->string('referral_code', 50)->nullable()->after('uuid');
            $table->unsignedBigInteger('referred_by_investor_id')->nullable()->after('partner_id');
            $table->timestamp('referral_used_at')->nullable()->after('referred_by_investor_id');
        });
    }

    public function down(): void
    {
        Schema::table('investor', function (Blueprint $table) {
            $table->dropColumn(['referral_code', 'referred_by_investor_id', 'referral_used_at']);
        });
    }
};
