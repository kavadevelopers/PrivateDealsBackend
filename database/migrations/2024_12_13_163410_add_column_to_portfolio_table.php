<?php

use App\Enums\PrimaryTransactionTypeEnum;
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
        Schema::table('portfolio', function (Blueprint $table) {
            $table->enum('type', array_column(PrimaryTransactionTypeEnum::cases(), 'value'))->default(PrimaryTransactionTypeEnum::captable)->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('portfolio', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
