<?php

namespace App\Traits;

use App\Models\CoreFirebaseDeviceTokenModel;
use App\Models\CoreGoogleFirebaseAuthTokenModel;
use App\Models\FirebaseAuthTokenModel;
use App\Models\NotificationsModel;
use App\Models\ReportErrorLogModel;
use App\Models\ReportNotificationsModel;
use App\Services\FCMService;
use Carbon\Carbon;
use Google\Client as GoogleClient;
use Google\Exception;
use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Support\Facades\Log;

trait FirebaseTrait
{

    use FileUploadTrait;

    function sendPushNow(NotificationsModel $notification)
    {
        if ($notification) {
            $appRedirection = '';
            if ($notification->payload) {
                $appRedirection = $notification->payload['redirect_to'];
                if (isset($notification->payload['reference_id'])) {
                    $appRedirection .= '?id=' . $notification->payload['reference_id'];
                }
            }
            $unreadCounter = NotificationsModel::where('user_id', $notification->user_id)
                ->where('user_type', $notification->user_type)
                ->where('is_readed', '0')
                ->count();
            $user = $notification->user_type::where('id', $notification->user_id)->first();

            if ($user) {

                $tokens = CoreFirebaseDeviceTokenModel::where('user_type', $notification->user_type)
                    ->where('user_id', $notification->user_id)
                    ->whereNotNull('token')
                    ->whereNotIn('token', ['N/A', 'TOKEn'])
                    ->distinct()
                    ->pluck('token');

                foreach ($tokens as $token) {
                    $bearerToken = FCMService::getGoogleAuthToken();
                    if ($bearerToken) {
                        $repoNoti = new ReportNotificationsModel();
                        $repoNoti->user_id = $notification->user_id;
                        $repoNoti->user_type = $notification->user_type;
                        $repoNoti->title = $notification->title;
                        $repoNoti->body = $notification->body ?? '';
                        $repoNoti->image = $notification->image ?? '';
                        $repoNoti->broadcast_id = $notification->broadcast_id;
                        $repoNoti->message_id = $notification->id;
                        $repoNoti->response_code = 406;
                        $repoNoti->save();

                        $payload = [
                            "message" => [
                                "token" => $token,
                                "notification" => [
                                    'title' => $notification->title,
                                    'body' => $notification->body,
                                ],
                                "data" => [
                                    "unread_counter" => (string) $unreadCounter,
                                    "app_redirection" => $appRedirection
                                ],
                                "android" => [
                                    // "priority" => "high",
                                    "notification" => [
                                        "title" => $notification->title,
                                        "body" => $notification->body,
                                        "icon" => "ic_notification",
                                        // "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                                    ]
                                ],
                                "apns" => [
                                    "headers" => [
                                        "apns-priority" => "10",
                                        "apns-push-type" => "alert",
                                    ],
                                    "payload" => [
                                        "aps" => [
                                            "alert" => [
                                                "title" => $notification->title,
                                                "body" => $notification->body
                                            ],
                                            "sound" => "default",
                                            "badge" => $unreadCounter,
                                            "mutable-content" => 1
                                        ]
                                    ],
                                    "fcm_options" => [
                                        "image" => ""
                                    ]
                                ],
                                "webpush" => [
                                    "headers" => [
                                        "Urgency" => "high"
                                    ],
                                    "notification" => [
                                        "title" => $notification->title,
                                        "body" => $notification->body,
                                        "icon" => asset('core/images/logo.png'),
                                        "click_action" => url($notification->url)
                                    ]
                                ]
                            ]
                        ];



                        if ($notification->image) {
                            $imageUrl = $this->fileUrl($notification->image);

                            $payload['message']['notification']['image'] = $imageUrl;
                            $payload['message']['android']['notification']['image'] = $imageUrl;
                            $payload['message']['webpush']['notification']['image'] = $imageUrl;
                            $payload['message']['apns']['fcm_options']['image'] = $imageUrl;
                        }



                        $repoNoti->data = json_encode($payload);
                        $repoNoti->save();
                        // ReportErrorLogModel::create([
                        //     'type'        => 'Firebase Push',
                        //     'subtype'     => 'Sending',
                        //     'description' => json_encode($payload)
                        // ]);
                        $client = new GuzzleHttpClient(['verify' => false, 'http_errors' => false]);
                        $response = $client->post('https://fcm.googleapis.com/v1/projects/shuru-up-cd1c5/messages:send', [
                            'headers' => [
                                'Authorization' => 'Bearer ' . $bearerToken,
                                'Content-Type' => 'application/json',
                            ],
                            'json' => $payload,
                        ]);

                        $responseJson = $response->getBody()->getContents();
                        $repoNoti->response_code = $response->getStatusCode();
                        $repoNoti->response = $responseJson;
                        $repoNoti->save();

                        if ($response->getStatusCode() != 200) {
                            ReportErrorLogModel::create([
                                'type' => 'Firebase Push',
                                'subtype' => 'Sending Error',
                                'description' => $responseJson
                            ]);
                            if ($repoNoti->response_code == 404) {
                                // CoreFirebaseDeviceTokenModel::where('token',  $token)->delete();
                            }
                        }
                    }
                }

                $notification->is_sent = 1;
                $notification->save();
            }
        }
    }


    // function sendNotification()
    // {




    //     // $credential = new PulkitJaib('https://www.googleapis.com/auth/firebase.messaging', json_decode(file_get_contents(asset('core/firebase/pkey.json')), true));
    //     // $token = $credential->fetchAuthToken(HttpHandlerFactory::build());
    //     // Log::alert($this->getGoogleAuthToken());
    // }

    // function getGoogleAuthToken(): string|bool
    // {
    //     $token = CoreGoogleFirebaseAuthTokenModel::latest()->first();
    //     if ($token && $token->expired_at > now()) {
    //         return $token->token;
    //     } else {
    //         $keyFilePath = public_path('core/firebase/pkey.json');
    //         $client = new GoogleClient();
    //         $client->setAuthConfig($keyFilePath);
    //         $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
    //         $guzzleClient = new GuzzleHttpClient();
    //         $client->setHttpClient($guzzleClient);
    //         try {
    //             $token = $client->fetchAccessTokenWithAssertion();
    //         } catch (Exception $e) {
    //             $token = false;
    //             ReportErrorLogModel::create([
    //                 'type'          => 'Firebase Google Auth',
    //                 'subtype'       => 'Token Generation',
    //                 'description'   =>  $e->getMessage()
    //             ]);
    //         }

    //         if ($token) {
    //             CoreGoogleFirebaseAuthTokenModel::create([
    //                 'token' => $token['access_token'],
    //                 'expired_at'    => Carbon::now()->addSeconds($token['expires_in'])
    //             ]);
    //             $token = $token['access_token'];
    //         }
    //         return $token;
    //     }
    // }
}
