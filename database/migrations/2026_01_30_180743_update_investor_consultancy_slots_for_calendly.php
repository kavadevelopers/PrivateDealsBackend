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
        Schema::table('investor_consultancy_slots', function (Blueprint $table) {
            // Remove old fields that are no longer needed
            $table->dropColumn(['booking_date', 'booking_time', 'google_meet_link']);

            // Add Calendly fields
            $table->string('calendly_event_uri')->nullable()->after('investor_id');
            $table->string('calendly_invitee_uri')->nullable()->after('calendly_event_uri');
            $table->string('calendly_meeting_url')->nullable()->after('calendly_invitee_uri');
            $table->datetime('scheduled_start_time')->nullable()->after('calendly_meeting_url');
            $table->datetime('scheduled_end_time')->nullable()->after('scheduled_start_time');
            $table->text('calendly_event_data')->nullable()->after('scheduled_end_time')->comment('JSON data from Calendly webhook');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investor_consultancy_slots', function (Blueprint $table) {
            // Restore old fields
            $table->date('booking_date')->after('investor_id');
            $table->time('booking_time')->after('booking_date');
            $table->string('google_meet_link')->nullable()->after('mobile_country_code');

            // Remove Calendly fields
            $table->dropColumn([
                'calendly_event_uri',
                'calendly_invitee_uri',
                'calendly_meeting_url',
                'scheduled_start_time',
                'scheduled_end_time',
                'calendly_event_data'
            ]);
        });
    }
};
