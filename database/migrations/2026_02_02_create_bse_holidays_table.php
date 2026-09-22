<?php

use App\Enums\HolidayTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bse_holidays', function (Blueprint $table) {
            $table->id();
            $table->uuid()->nullable();
            $table->date('holiday_date')->unique();
            $table->string('holiday_name')->comment('Name of the holiday');
            $table->enum('holiday_type', array_column(HolidayTypeEnum::cases(), 'value'))->default(HolidayTypeEnum::national->value);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_deleted')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();

            // Index for faster queries
            $table->index('holiday_date');
            $table->index('is_active');
            $table->index('is_deleted');
        });

        // Seed initial 2026 holidays
        $holidays = [
            ['holiday_date' => '2026-01-26', 'holiday_name' => 'Republic Day', 'holiday_type' => HolidayTypeEnum::national->value],
            ['holiday_date' => '2026-03-25', 'holiday_name' => 'Holi', 'holiday_type' => HolidayTypeEnum::national->value],
            ['holiday_date' => '2026-04-02', 'holiday_name' => 'Good Friday', 'holiday_type' => HolidayTypeEnum::national->value],
            ['holiday_date' => '2026-04-10', 'holiday_name' => 'Eid ul-Fitr', 'holiday_type' => HolidayTypeEnum::national->value],
            ['holiday_date' => '2026-05-01', 'holiday_name' => 'May Day', 'holiday_type' => HolidayTypeEnum::national->value],
            ['holiday_date' => '2026-08-15', 'holiday_name' => 'Independence Day', 'holiday_type' => HolidayTypeEnum::national->value],
            ['holiday_date' => '2026-09-02', 'holiday_name' => 'Janmashtami', 'holiday_type' => HolidayTypeEnum::national->value],
            ['holiday_date' => '2026-10-02', 'holiday_name' => 'Gandhi Jayanti', 'holiday_type' => HolidayTypeEnum::national->value],
            ['holiday_date' => '2026-10-23', 'holiday_name' => 'Diwali (Bhai Dooj)', 'holiday_type' => HolidayTypeEnum::national->value],
            ['holiday_date' => '2026-11-14', 'holiday_name' => 'Guru Nanak Jayanti', 'holiday_type' => HolidayTypeEnum::national->value],
            ['holiday_date' => '2026-12-25', 'holiday_name' => 'Christmas', 'holiday_type' => HolidayTypeEnum::national->value],
        ];

        foreach ($holidays as $holiday) {
            DB::table('bse_holidays')->insert(array_merge($holiday, [
                'uuid' => (string) Str::uuid(),
                'is_deleted' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bse_holidays');
    }
};
