<?php

namespace App\Http\Controllers\ThirdParty;

use App\Enums\TempCompanyStatusEnum;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\TempCompanyModel;
use App\Services\AiAutowork\AiCompanyIngestService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class AiCompanyIngestController extends Controller
{
    public function __construct(private AiCompanyIngestService $ingestService)
    {
    }

    public function schema(): JsonResponse
    {
        return UtillsHelper::_json(true, [
            'message' => 'AI Company Ingest schema',
            'data' => $this->ingestService->schema(),
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $payload = $request->all();
            unset($payload['client']);

            $client = $request->attributes->get('client');
            $result = $this->ingestService->ingest(
                $payload,
                $client->id ?? null
            );

            $temp = $result['temp'];

            return UtillsHelper::_json(true, [
                'message' => 'Company ingest accepted',
                'data' => [
                    'uuid' => $temp->uuid,
                    'status' => $temp->status->value,
                    'intent' => $temp->intent->value,
                    'accepted_keys' => $result['accepted_keys'],
                    'ignored_keys' => $result['ignored_keys'],
                ],
            ], 200);
        } catch (\InvalidArgumentException $e) {
            return UtillsHelper::_json(false, ['message' => $e->getMessage()], 422);
        } catch (\Throwable $e) {
            return UtillsHelper::_json(false, ['message' => 'Ingest failed: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, string $uuid): JsonResponse
    {
        try {
            $temp = TempCompanyModel::where('uuid', $uuid)->first();
            if (!$temp) {
                return UtillsHelper::_json(false, ['message' => 'Temp company not found'], 404);
            }

            $payload = $request->all();
            unset($payload['client']);

            $client = $request->attributes->get('client');
            $result = $this->ingestService->ingest(
                $payload,
                $client->id ?? null,
                $temp
            );

            $temp = $result['temp'];

            return UtillsHelper::_json(true, [
                'message' => 'Company ingest updated',
                'data' => [
                    'uuid' => $temp->uuid,
                    'status' => $temp->status->value,
                    'intent' => $temp->intent->value,
                    'accepted_keys' => $result['accepted_keys'],
                    'ignored_keys' => $result['ignored_keys'],
                ],
            ], 200);
        } catch (\InvalidArgumentException $e) {
            return UtillsHelper::_json(false, ['message' => $e->getMessage()], 422);
        } catch (\Throwable $e) {
            return UtillsHelper::_json(false, ['message' => 'Update failed: ' . $e->getMessage()], 500);
        }
    }

    public function show(string $uuid): JsonResponse
    {
        $temp = TempCompanyModel::where('uuid', $uuid)->first();
        if (!$temp) {
            return UtillsHelper::_json(false, ['message' => 'Temp company not found'], 404);
        }

        return UtillsHelper::_json(true, [
            'message' => 'Temp company status',
            'data' => [
                'uuid' => $temp->uuid,
                'external_ref' => $temp->external_ref,
                'status' => $temp->status instanceof TempCompanyStatusEnum
                    ? $temp->status->value
                    : $temp->status,
                'intent' => $temp->intent->value ?? $temp->intent,
                'cin' => $temp->cin,
                'brand_name' => $temp->brand_name,
                'company_name' => $temp->company_name,
                'admin_notes' => $temp->admin_notes,
                'reviewed_at' => $temp->reviewed_at?->toIso8601String(),
                'sections' => [
                    'fundamentals' => $temp->fundamentals,
                    'promoters' => $temp->promoters,
                    'shareholders' => $temp->shareholders,
                    'events' => $temp->events,
                    'financials' => $temp->financials,
                ],
            ],
        ], 200);
    }
}
