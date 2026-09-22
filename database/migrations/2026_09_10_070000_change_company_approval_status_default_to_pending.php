<?php

use App\Enums\CompanyApprovalStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Column default should be pending for new inserts; existing rows stay approved.
     * (Follow-up for DBs that already ran the original approval migration.)
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE company MODIFY approval_status VARCHAR(20) NOT NULL DEFAULT 'pending'");

        DB::table('company')
            ->whereNull('submitted_by_seller_id')
            ->where('approval_status', '!=', CompanyApprovalStatusEnum::approved->value)
            ->update([
                'approval_status' => CompanyApprovalStatusEnum::approved->value,
            ]);
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE company MODIFY approval_status VARCHAR(20) NOT NULL DEFAULT 'approved'");
    }
};
