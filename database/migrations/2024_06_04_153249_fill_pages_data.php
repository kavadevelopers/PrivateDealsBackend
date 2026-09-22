<?php

use App\Models\MasterPagesModel;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $array = [
            ['name'      => 'About Us', 'is_display_banner' => '1', 'is_display_title' => '1'],
            ['name'      => 'Careers', 'is_display_banner' => '1', 'is_display_title' => '1'],
            ['name'      => 'Risk Warnings', 'is_display_banner' => '1', 'is_display_title' => '1'],
            ['name'      => 'Privacy Notice', 'is_display_banner' => '1', 'is_display_title' => '1'],
            ['name'      => 'Terms of Service', 'is_display_banner' => '1', 'is_display_title' => '1'],
            ['name'      => 'How to Invest', 'is_display_banner' => '1', 'is_display_title' => '1'],
        ];

        foreach ($array as $key => $value) {
            MasterPagesModel::create($value);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        MasterPagesModel::truncate();
    }
};
