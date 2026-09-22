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
        Schema::table('report_notifications', function (Blueprint $table) {
            $table->string('image')->nullable()->after('body');
            $table->unsignedBigInteger('broadcast_id')->after('id')->nullable();
            $table->unsignedBigInteger('message_id')->after('broadcast_id')->nullable();
            $table->boolean('is_sent')->default(false)->after('image');
            $table->string('response_code')->nullable()->after('is_sent');
            $table->text('response')->nullable()->after('response_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_notifications', function (Blueprint $table) {
            $table->dropColumn('message_id');
            $table->dropColumn('is_sent');
            $table->dropColumn('response_code');
            $table->dropColumn('response');
            $table->dropColumn('broadcast_id');
            $table->dropColumn('image');
        });
    }
};
