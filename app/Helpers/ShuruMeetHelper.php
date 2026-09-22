<?php

namespace App\Helpers;

use Carbon\Carbon;
use Psr\Http\Message\ResponseInterface;

class ShuruMeetHelper
{
    public static function generateMeetLink($meeting): void
    {
        $meetLink = self::createShuruMeet($meeting);
        if ($meetLink) {
            if ($meetLink->getStatusCode() == 200) {
                $response = json_decode($meetLink->getBody()->getContents());
                $meeting->user_url = $response->meeting->guest_url;
                $meeting->host_url = $response->meeting->host_url;
                // $meeting->meet_id = $response->meeting->uuid;
                $meeting->save();
            }
        }
    }

    public static function createShuruMeet($meeting): ResponseInterface|string
    {
        $users = [];
        if ($meeting->startup) {
            array_push($users, [
                "type"      => '1',
                "id"        => $meeting->startup->id,
                "email"     => $meeting->startup->email,
                "mobile"    => $meeting->startup->mobile_number,
                "name"      => $meeting->startup->brand_name,
                "is_host"   => 1
            ]);
        }

        $postJson = [
            "users"     => $users,
            "apitoken"  => "X9ZSYffVwQpPsUkR3Yhqei4RMsqIFJAdcRk42gV1yRt046p2Kvw5EsO06WUyUdZk",
            "uuid" => null,
            "title" => 'Live Pitch Meeting at ' . Carbon::parse($meeting->scheduled_date)->format('d-m-Y h:i A'),
            "agenda" => "The startup pitch will begin with a concise introduction of the team and the problem they aim to solve. The presentation will then cover the innovative solution, including product features, market opportunity, and business model. To conclude, the team will highlight their unique value proposition and financial projections, followed by a brief Q&A session to address any questions from the audience.",
            "description" => "",
            "start_date_time" => Carbon::parse($meeting->scheduled_date)->format('Y-m-d H:i:s'),
            "period" => 60,
            "type" => [
                "uuid" => "video_conference",
                "name" => "Video Conference"
            ],
            "category" => [
                "uuid" => "7875e940-e568-4a41-a870-75809bc3452b",
                "name" => "Sample",
                "description" => "",
                "slug" => "sample",
                "meta" => null,
                "created_at" => "2024-02-14 05:31:40",
                "updated_at" => "2024-02-14 05:31:40"
            ],
            "identifier" => "",
            "max_participant_count" => 1000,
            "accessible_via_link" => true,
            "has_event" => false,
            "should_remind" => false,
            "remind_before" => 5,
            "accessible_to_members" => false,
            "accessible_via_link"  => true,
            "is_pam" => true,
            "is_paid" => false,
            "fee" => 0
        ];
        $client = new \GuzzleHttp\Client(['verify' => false, 'http_errors' => false]);
        try {
            $response = $client->post('https://meet.shuruup.com/api/3rd-party/schedule-meeting', [
                'headers' => [
                    'Content-Type'  => 'application/json',
                    'Accept'        => 'application/json'
                ],
                'json' => $postJson
            ]);
        } catch (\Exception $e) {
            $response = $e->getMessage();
        }
        return $response;
    }
}
