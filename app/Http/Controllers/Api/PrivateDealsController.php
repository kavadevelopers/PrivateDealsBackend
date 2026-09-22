<?php

namespace App\Http\Controllers\Api;

use App\Enums\NotificationTypeEnum;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Traits\PMailerTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class PrivateDealsController extends Controller
{
    use PMailerTrait;

    private const RECIPIENT = 'privatedeals.in@gmail.com';

    public function submitData(Request $request): JsonResponse|Response
    {
        if ($request->isMethod('OPTIONS')) {
            return $this->corsResponse(response('', HttpResponse::HTTP_NO_CONTENT));
        }

        $payload = $request->except(['_token', '_method']);

        if (empty($payload)) {
            return $this->corsResponse(UtillsHelper::json(0, ['message' => 'No form data received']));
        }

        $rows = '';
        foreach ($payload as $key => $value) {
            $label = e((string) $key);
            $display = is_scalar($value)
                ? e((string) $value)
                : e(json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            $rows .= "<tr><td style=\"padding:8px;border:1px solid #ddd;font-weight:600;\">{$label}</td>"
                . "<td style=\"padding:8px;border:1px solid #ddd;\">{$display}</td></tr>";
        }

        $body = '<p>New form submission from <strong>privatedeals.in</strong>.</p>'
            . '<table style="border-collapse:collapse;width:100%;max-width:640px;">'
            . '<thead><tr>'
            . '<th style="padding:8px;border:1px solid #ddd;text-align:left;background:#f5f5f5;">Field</th>'
            . '<th style="padding:8px;border:1px solid #ddd;text-align:left;background:#f5f5f5;">Value</th>'
            . '</tr></thead><tbody>'
            . $rows
            . '</tbody></table>';

        try {
            $this->sendMail(
                NotificationTypeEnum::regular,
                self::RECIPIENT,
                'privatedeals.in — form submission',
                $body
            );
        } catch (\Throwable $e) {
            return $this->corsResponse(UtillsHelper::json(0, ['message' => 'Unable to send email']));
        }

        return $this->corsResponse(UtillsHelper::json(1, ['message' => 'Submitted']));
    }

    private function corsResponse(JsonResponse|Response $response): JsonResponse|Response
    {
        return $response
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'POST, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Origin')
            ->header('Access-Control-Max-Age', '86400');
    }
}
