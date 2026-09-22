<?php

namespace App\Http\Controllers\ThirdParty;

use App\Enums\StartupPrimaryRoundStatusEnum;
use App\Helpers\FileUpDownHelper;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\StartupModel;
use App\Models\StartupRoundModel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class StartupController extends Controller
{
    function item(Request $request): JsonResponse
    {
        if (!$request->has('uuid')) {
            return UtillsHelper::_json(false, ['message' => 'Startup UUID is required'], 400);
        }



        $startup = StartupModel::where('uuid', $request->uuid)
            ->where('registration_step', 6)
            ->where('is_deleted', 0)
            ->whereHas('raising_round')
            ->select('id', 'uuid', 'brand_name', 'sector_id')
            ->with([
                'raising_round:id,startup_id,name,round_type,round_status,share_price,instrument,floor,cap,equity_offered,minimum_investment,minimum_investment_aif,fund_requirement',
                'sector:id,name',
                'legalInfo:id,startup_id,company_name,company_pan,cin,dpiit,incorporation_date',
                'cms:id,startup_id,logo,banner,long_banner,product_video,pitch_video,pitch_deck,financial_projection,dd_report,dpiit_report,shuruup_research_report,valuation_report,one_liner,highlights,website,idea,key_information',
            ])
            ->first();

        if (!$startup) {
            return UtillsHelper::_json(false, ['message' => 'Startup not found'], 404);
        }

        // Hide unwanted fields
        $startup->makeHidden(['id', 'is_favorite', 'investor_count', 'sector_id', 'available_shares', 'share_prices_array', 'minimum_shares']);

        // Format relations
        if ($startup->raising_round) {
            $startup->raising_round->makeHidden(['id', 'startup_id']);
        }

        if ($startup->sector) {
            $startup->sector->makeHidden(['id']);
        }
        if ($startup->legalInfo) {
            $startup->legalInfo->makeHidden(['id', 'startup_id']);
        }

        if ($startup->cms) {
            $startup->cms->makeHidden(['id', 'startup_id']);

            foreach (
                [
                    'logo',
                    'banner',
                    'long_banner',
                    'product_video',
                    'pitch_video',
                    'pitch_deck',
                    'financial_projection',
                    'dd_report',
                    'dpiit_report',
                    'shuruup_research_report',
                    'valuation_report',
                ] as $fileField
            ) {
                if (!empty($startup->cms->$fileField)) {
                    $startup->cms->$fileField = FileUpDownHelper::generateUrl($startup->cms->$fileField);
                }
            }
        }

        return UtillsHelper::_json(true, ['message' => 'Startup Detail', 'data' => $startup], 200);
    }

    function list(): JsonResponse
    {
        $startups =
            StartupModel::select('id', 'uuid', 'brand_name', 'sector_id')
            ->where('registration_step', 6)->where('is_deleted', 0)->whereHas('raising_round')
            // ->with('raising_round', 'cms', 'sector')
            ->with(['raising_round' => function ($query) {
                $query->select('startup_id', 'name', 'round_type', 'round_status', 'share_price', 'instrument', 'floor', 'cap', 'equity_offered', 'minimum_investment', 'minimum_investment_aif', 'fund_requirement');
            }])
            ->with(['sector' => function ($query) {
                $query->select('id', 'name');
            }])
            ->with(['cms' => function ($query) {
                $query->select('startup_id', 'logo', 'banner', 'long_banner', 'product_video', 'pitch_video', 'pitch_deck', 'financial_projection', 'dd_report', 'dpiit_report', 'shuruup_research_report', 'valuation_report', 'one_liner', 'highlights', 'website', 'idea', 'key_information');
            }])
            ->get()
            ->each(function ($startup) {
                if ($startup->raising_round) {
                    $startup->raising_round->makeHidden(['startup_id']);
                }
                if ($startup->cms) {
                    $startup->cms->makeHidden(['startup_id']);
                    $startup->cms->logo = FileUpDownHelper::generateUrl($startup->cms->logo);
                    $startup->cms->long_banner = FileUpDownHelper::generateUrl($startup->cms->long_banner);
                    $startup->cms->banner = FileUpDownHelper::generateUrl($startup->cms->banner);
                    $startup->cms->product_video = FileUpDownHelper::generateUrl($startup->cms->product_video);
                    $startup->cms->pitch_video = FileUpDownHelper::generateUrl($startup->cms->pitch_video);
                    $startup->cms->pitch_deck = FileUpDownHelper::generateUrl($startup->cms->pitch_deck);
                    $startup->cms->financial_projection = FileUpDownHelper::generateUrl($startup->cms->financial_projection);
                    $startup->cms->dd_report = FileUpDownHelper::generateUrl($startup->cms->dd_report);
                    $startup->cms->dpiit_report = FileUpDownHelper::generateUrl($startup->cms->dpiit_report);
                    $startup->cms->shuruup_research_report = FileUpDownHelper::generateUrl($startup->cms->shuruup_research_report);
                    $startup->cms->valuation_report = FileUpDownHelper::generateUrl($startup->cms->valuation_report);
                }
                if ($startup->sector) {
                    $startup->sector->makeHidden(['id']);
                }
            })
            ->makeHidden(
                [
                    'is_favorite',
                    'investor_count',
                    'sector_id',
                    'available_shares',
                    'share_prices_array',
                    'minimum_shares',
                    'id'
                ]
            );

        return UtillsHelper::_json(true, ['message' => 'Startup list', 'data' => $startups], 200);
    }
}
