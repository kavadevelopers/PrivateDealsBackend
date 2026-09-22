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
        Schema::table('resource_billing', function (Blueprint $table) {
            $table->renameColumn('resourece_type', 'resource_type'); 
            $table->unsignedBigInteger('created_by')->after('updated_at')->nullable();
            $table->unsignedBigInteger('updated_by')->after('created_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resource_billing', function (Blueprint $table) {
            $table->renameColumn('resource_type', 'resourece_type');
            $table->dropColumn(['created_by','updated_by']);
        });
    }
};
