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
        Schema::table('seller_master', function (Blueprint $table) {
            $table->string('mobile_country_code', 5)->default('91')->after('branch');
            $table->string('mobile_number', 20)->nullable()->after('mobile_country_code');
            $table->string('email')->nullable()->after('mobile_number');
            $table->string('password')->nullable()->after('email');
            $table->boolean('is_blocked')->default(0)->after('password');
            $table->boolean('ask_password_change')->default(0)->after('is_blocked');
            $table->index('mobile_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seller_master', function (Blueprint $table) {
            $table->dropIndex(['mobile_number']);
            $table->dropColumn([
                'mobile_country_code',
                'mobile_number',
                'email',
                'password',
                'is_blocked',
                'ask_password_change',
            ]);
        });
    }
};
