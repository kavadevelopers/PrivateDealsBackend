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
        Schema::table('documents', function (Blueprint $table) {
            $table->string('api_id')->nullable()->change();
            $table->enum('type', array_column(DocumentTypeEnum::cases(), 'value'))->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->string('api_id')->change();
            $table->enum('type', array_column(DocumentTypeEnum::cases(), 'value'))->change();
        });
    }
};
