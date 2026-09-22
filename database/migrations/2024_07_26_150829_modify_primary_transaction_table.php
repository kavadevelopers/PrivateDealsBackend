<?php

use App\Enums\DocumentTypeEnum;
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
        Schema::table('primary_transaction', function (Blueprint $table) {
            $table->integer('status')->default(0)->comment('0-Commitment Pending,1-Committed,2-SSA Sent,3-SSA Signed,4-MGT-14 Completed,5-Offer Letter Sent,6-Offer Letter Signed,7-Payment Received,8-PAS-3 Uploaded,9-SHA Sent,10-Completed')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('primary_transaction', function (Blueprint $table) {
            $table->integer('status')->change();
        });
    }
};
