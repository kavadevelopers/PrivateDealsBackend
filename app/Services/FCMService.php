<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Models\CoreGoogleFirebaseAuthTokenModel;
use App\Models\ReportErrorLogModel;
use Carbon\Carbon;
use Google\Client as GoogleClient;
use Google\Exception;
use GuzzleHttp\Client as GuzzleHttpClient;


class FCMService
{
    public function __construct() {}

    public function sendPushNotification(): void
    {
        $bearerToken = self::getGoogleAuthToken();
        if ($bearerToken) {
            $payload = [
                'message' => [
                    'token' => 'fuYWUBsx6Masc_ZKEyisQN:APA91bF3vy5OAGTiPonLdb6FLgrjma-DlLG45BNKhW-IsmNfpaNk_SIIKO9Bx4EMeoQmVWQB9NQ9SgehhBd2wET1laQeGrTcgaQyemn1A0_Jmy3SQpcly-yvpZQQPtIHAc1rrf2CDh_J',
                    'notification' => [
                        'title' => 'From Code Title',
                        'body' => 'From Code Body',
                        'image' => 'https://shuruup.privatedealroom.in/core/images/logo.png',
                    ],
                    'data' => [
                        'message'   => 'Offer!',
                        'image_url' => 'https://shuruup.privatedealroom.in/core/images/logo.png',
                        'image'     => 'https://shuruup.privatedealroom.in/core/images/logo.png',
                    ],
                    'android' => [
                        'notification' => [
                            'image' => 'https://shuruup.privatedealroom.in/core/images/logo.png',
                        ],
                    ],
                    'apns' => [
                        'payload' => [
                            'aps' => [
                                'mutable-content' => 1,
                            ],
                        ],
                        'fcm_options' => [
                            'image' => 'https://shuruup.privatedealroom.in/core/images/logo.png',
                        ],
                    ],
                    'webpush' => [
                        'fcm_options' => [
                            'link' => 'https://shuruup.privatedealroom.in/',
                        ],
                    ],
                ],
            ];
            $client = new Client();
            $response = $client->post('https://fcm.googleapis.com/v1/projects/shuru-up-cd1c5/messages:send', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $bearerToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => $payload,
            ]);
        }
    }

    static function getGoogleAuthToken(): string|bool
    {
        $token = CoreGoogleFirebaseAuthTokenModel::latest()->first();
        if ($token && $token->expired_at > now()) {
            return $token->token;
        } else {
            $token = false;
            try {
                $keyFilePath = public_path('core/firebase/pkey.json');
                $client = new GoogleClient();
                $client->setAuthConfig($keyFilePath);
                $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
                $guzzleClient = new GuzzleHttpClient(['verify' => false, 'http_errors' => false]);
                $client->setHttpClient($guzzleClient);
                $token = $client->fetchAccessTokenWithAssertion();
            } catch (Exception $e) {
                $token = false;
                ReportErrorLogModel::create([
                    'type'          => 'Firebase Google Auth',
                    'subtype'       => 'Token Generation',
                    'description'   =>  $e->getMessage()
                ]);
            }

            if ($token) {
                CoreGoogleFirebaseAuthTokenModel::create([
                    'token' => $token['access_token'],
                    'expired_at'    => Carbon::now()->addSeconds($token['expires_in'])
                ]);
                $token = $token['access_token'];
            }
            return $token;
        }
    }
}
