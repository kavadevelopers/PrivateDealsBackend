<?php

namespace App\Console\Commands;

use App\Models\InvestorConsultancySlotModel;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SyncCalendlyBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calendly:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Calendly bookings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $token = env('CALENDLY_TOKEN');
        $userUri = env('CALENDLY_USER_URI');

        if (!$token || !$userUri) {
            $this->error('Calendly config missing');
            return;
        }

        $response = Http::withToken($token)
            ->get('https://api.calendly.com/scheduled_events', [
                'user' => $userUri,
                'status' => 'active',
                'count' => 100
            ]);

        if (!$response->successful()) {
            $this->error('Failed fetching events');
            return;
        }

        $events = $response->json()['collection'] ?? [];

        foreach ($events as $event) {

            $eventUri = $event['uri'] ?? null;
            if (!$eventUri) {
                continue;
            }

            // extract uuid from uri
            $eventUuid = basename($eventUri);

            $start = isset($event['start_time']) ? Carbon::parse($event['start_time']) : null;
            $end   = isset($event['end_time']) ? Carbon::parse($event['end_time']) : null;

            // fetch invitees
            $inviteeResponse = Http::withToken($token)
                ->get("https://api.calendly.com/scheduled_events/{$eventUuid}/invitees");

            if (!$inviteeResponse->successful()) {
                continue;
            }

            $invitees = $inviteeResponse->json()['collection'] ?? [];

            foreach ($invitees as $invitee) {

                $inviteeUri = $invitee['uri'] ?? null;
                if (!$inviteeUri) {
                    continue;
                }

                // skip duplicates
                if (InvestorConsultancySlotModel::where('calendly_invitee_uri', $inviteeUri)->exists()) {
                    continue;
                }

                $nameParts = explode(' ', $invitee['name'] ?? '', 2);
                $investorId = $invitee['tracking']['utm_campaign'] ?? null;

                InvestorConsultancySlotModel::create([
                    'investor_id'            => $investorId,
                    'calendly_event_uri'     => $eventUri,
                    'calendly_invitee_uri'   => $inviteeUri,
                    'scheduled_start_time'   => $start,
                    'scheduled_end_time'     => $end,
                    'first_name'             => $nameParts[0] ?? '',
                    'last_name'              => $nameParts[1] ?? '',
                    'email'                  => $invitee['email'] ?? '',
                    'status'                 => 'confirmed',
                    'calendly_event_data'    => $invitee
                ]);

                $this->info("Inserted booking: {$inviteeUri}");
            }
        }
    }
}
