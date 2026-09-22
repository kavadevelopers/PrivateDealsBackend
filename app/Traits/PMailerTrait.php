<?php

namespace App\Traits;

use App\Enums\MessagesStatusEnum;
use App\Enums\NotificationTypeEnum;
use App\Helpers\CommonHelper;
use App\Models\ReportErrorLogModel;
use App\Models\ReportMessagesEmailModel;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

trait PMailerTrait
{
    function sendMail(NotificationTypeEnum $type, $to, $subject, $body, array $attachments = []): void
    {
        $email = new ReportMessagesEmailModel;
        $email->trycount                = '0';
        $email->type                    = $type;
        $email->status                  = MessagesStatusEnum::pending;
        $email->subject                 = $subject;
        $email->destination_emails      = $to;
        $email->body                    = $body;
        $email->attachments             = json_encode($attachments);
        $email->save();

        $this->sendNowEmail($email);
    }

    private function sendNowEmail(ReportMessagesEmailModel $email): void
    {
        $responseCode = 599;
        $status = MessagesStatusEnum::failed;
        $response = 'Pending Response';

        try {
            $mail               = new PHPMailer();
            $mail->isSMTP();
            $mail->IsHTML(true);
            $mail->SMTPDebug    = 0;
            $mail->SMTPAuth     = true;
            $mail->SMTPSecure   = 'ssl';
            $mail->CharSet      = "utf-8";
            $mail->Host         = CommonHelper::appSettings('smtp_mail_host');
            $mail->Port         = CommonHelper::appSettings('smtp_mail_port');
            $mail->Username     = CommonHelper::appSettings('smtp_mail_user');
            $mail->Password     = CommonHelper::appSettings('smtp_mail_password');
            $mail->SetFrom(CommonHelper::appSettings('smtp_mail_send_from'), CommonHelper::appSettings('smtp_mail_send_from_name'));
            $mail->Subject      = $email->subject;
            $mail->Body         = $email->body;

            if (CommonHelper::appSettings('test_email') == '') {
                foreach (explode(',', $email->destination_emails) as $key => $value) {
                    $mail->AddAddress($value);
                }
            } else {
                foreach (explode(',', CommonHelper::appSettings('test_email')) as $key => $value) {
                    $mail->AddAddress($value);
                }
            }

            // if ($email->attachments != NULL && is_array($email->attachments) && count($email->attachments) > 0) {
            //     foreach ($email->attachments as $key => $value) {
            //         $mail->addStringAttachment(file_get_contents($value['url']), $value['name']);
            //     }
            // }
            // In the sendNowEmail method, replace the attachments handling with:
            if ($email->attachments != NULL) {
                $attachmentsArray = json_decode($email->attachments, true);
                if (is_array($attachmentsArray) && count($attachmentsArray) > 0) {
                    foreach ($attachmentsArray as $key => $value) {
                        $mail->addStringAttachment(file_get_contents($value['url']), $value['name']);
                    }
                }
            }

            if ($mail->Send()) {
                $responseCode = 200;
                $status = MessagesStatusEnum::sent;
                $response = 'Mail sent';
            } else {
                $responseCode = 500;
                $response = $mail->ErrorInfo;
                ReportErrorLogModel::create([
                    'type'          => 'Email PhpMailer',
                    'subtype'       => 'Send',
                    'description'   => $mail->ErrorInfo
                ]);
            }
        } catch (Exception $e) {
            ReportErrorLogModel::create([
                'type'          => 'Email PhpMailer',
                'subtype'       => 'Send',
                'description'   => $e->getMessage()
            ]);
            $responseCode = 500;
            $response = $e->getMessage();
        }

        $email->trycount              = $email->trycount + 1;
        $email->status                = $status;
        $email->response              = $response;
        $email->response_code         = $responseCode;
        $email->save();
    }
}
