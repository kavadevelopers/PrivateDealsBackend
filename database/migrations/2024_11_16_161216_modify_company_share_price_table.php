<?php

use App\Models\CompanySharePriceModel;
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
        Schema::table('company_share_price', function (Blueprint $table) {
            $table->decimal('base_price', 40, 2)->default(0)->after('price');
        });

        $list = CompanySharePriceModel::get();
        if ($list->count() > 0) {
            $list->each(function ($item) {
                $item->base_price = $item->distributer_price;
                $item->save();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_share_price', function (Blueprint $table) {
            $table->dropColumn('base_price');
        });
    }
};
