<?php

namespace App\Traits;

use App\Enums\MessagesStatusEnum;
use App\Enums\NotificationTypeEnum;
use App\Helpers\CommonHelper;
use App\Models\ReportErrorLogModel;
use App\Models\ReportMessagesSMSModel;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;

trait SMSSendTrait
{
    static function sendSms(NotificationTypeEnum $type, string $destination_mobile, string $body, array $message_data         = []): void
    {
        $sms = new ReportMessagesSMSModel;
        $sms->trycount               = '0';
        $sms->type                   = $type;
        $sms->status                 = MessagesStatusEnum::pending;
        $sms->destination_mobile_no  = $destination_mobile;
        $sms->message_data           = json_encode($message_data);
        $sms->body                   = $body;
        $sms->save();

        self::sendSMSNow($sms);
    }

    static private function sendSMSNow(ReportMessagesSMSModel $message): void
    {
        $responseCode = 599;
        $status = MessagesStatusEnum::pending;
        $response = 'Pending Response';


        $post["apikey"] = CommonHelper::appSettings('third_party_magicsms_apikey');
        $post["senderid"] = CommonHelper::appSettings('third_party_magicsms_senderid');
        $post['message']            = $message->body;
        $post['number']             = $message->destination_mobile_no;
        if (CommonHelper::appSettings('test_mobile') != '') {
            $post['number']    = CommonHelper::appSettings('test_mobile');
        }

        if (true) {
            $request = "";
            foreach ($post as $key => $val) {
                $request .= $key . "=" . urlencode($val);
                $request .= "&";
            }
            $request = substr($request, 0, strlen($request) - 1);

            $url = "http://sms5.magicsms.co.in/V2/http-api.php?" . $request;
            $message->url = $url;
            $client = new Client(['verify' => false, 'http_errors' => false]);

            try {
                $request = $client->get($message->url, [
                    'headers' => [
                        'Content-Type'  => 'application/json',
                        'Accept'        => 'application/json'
                    ]
                ]);

                $responseCode = $request->getStatusCode();
                if ($responseCode != 200) {
                    $status         = MessagesStatusEnum::failed;
                    $responseCode   = $responseCode;
                    $response       = $request->getBody()->getContents();
                } else {
                    $status         = MessagesStatusEnum::sent;
                    $responseCode   = $responseCode;
                    $response       = $request->getBody()->getContents();
                    if (json_decode($response)->status != 'OK') {
                        $status         = MessagesStatusEnum::failed;
                        $responseCode   = 400;
                    }
                }
            } catch (ConnectException $e) {
                $status         = MessagesStatusEnum::failed;
                $responseCode   = 500;
                $response       = $e->getMessage();
                // Handle timeout or connection error
                // echo "Connection timed out: " . $e->getMessage();
            } catch (RequestException $e) {
                // Handle other Guzzle request exceptions
                // echo "Request failed: " . $e->getMessage();
                $status         = MessagesStatusEnum::failed;
                $responseCode   = 500;
                $response       = $e->getMessage();
            }

            $message->trycount              = $message->trycount + 1;
            $message->status                = $status;
            $message->response              = $response;
            $message->response_code         = $responseCode;
            $message->save();
            if ($responseCode != 200) {
                ReportErrorLogModel::create([
                    'type'          => 'Megic SMS',
                    'subtype'       => 'Send',
                    'description'   => $response
                ]);
            }
        }
    }
}
