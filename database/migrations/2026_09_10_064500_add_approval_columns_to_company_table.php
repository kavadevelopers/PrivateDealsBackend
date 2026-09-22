<?php

use App\Enums\CompanyApprovalStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('company', function (Blueprint $table) {
            $table->string('approval_status', 20)
                ->default(CompanyApprovalStatusEnum::pending->value)
                ->after('status');
            $table->unsignedBigInteger('submitted_by_seller_id')->nullable()->after('approval_status');
            $table->unsignedBigInteger('approved_by')->nullable()->after('submitted_by_seller_id');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            $table->text('rejection_reason')->nullable()->after('approved_at');
            $table->index('approval_status');
            $table->index('submitted_by_seller_id');
        });

        // Existing live catalog companies must remain visible after go-live.
        DB::table('company')->update([
            'approval_status' => CompanyApprovalStatusEnum::approved->value,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company', function (Blueprint $table) {
            $table->dropIndex(['approval_status']);
            $table->dropIndex(['submitted_by_seller_id']);
            $table->dropColumn([
                'approval_status',
                'submitted_by_seller_id',
                'approved_by',
                'approved_at',
                'rejection_reason',
            ]);
        });
    }
};
