<?php

namespace App\Http\Controllers\Api;

use App\Enums\Utills\CodeVerificationTypeEnum;
use App\Helpers\BseCalendarHelper;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\BseHolidayModel;
use App\Models\CmsFaqsModel;
use App\Models\MasterAvtarModel;
use App\Models\MasterBankModel;
use App\Models\MasterBlogModel;
use App\Models\MasterCityModel;
use App\Models\MasterCountryModel;
use App\Models\MasterFamilyRelationsModel;
use App\Models\MasterFindCmlModel;
use App\Models\MasterSectorsModel;
use App\Models\MasterStateModel;
use App\Models\MasterSupportedCountriesModel;
use App\Models\StartupPitchModel;
use App\Repositories\CommonRepository;
use Carbon\Carbon;
use Google\Service\AnalyticsData\OrderBy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class MasterController extends Controller
{

    private $commonRepo;

    function __construct(CommonRepository $commonRepository)
    {
        $this->commonRepo = $commonRepository;
    }

    function verifyMobileNumber(): JsonResponse
    {
        $request = request();
        $validation = Validator::make(
            $request->all(),
            [
                'mobile_number'         => 'required|max:10',
            ]
        );
        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }

        $code = UtillsHelper::sendVerificationCode('', '', $request->mobile_number, CodeVerificationTypeEnum::register);
        return UtillsHelper::json(1, ['message' => 'Verification code sent to : ' . $request->mobile_number, 'data' => $code]);
    }

    function getSectors(): JsonResponse
    {
        $request = request();

        $type = 'startups';

        $sectors = MasterSectorsModel::where('is_deleted', 0)
            ->whereHas($type, function ($query) {
                $query->where('is_deleted', 0); // Filter sectors that have non-deleted startups
            })
            ->withCount([$type => function ($query) {
                $query->where('is_deleted', 0); // Count only non-deleted startups
            }])
            ->orderBy('name', 'asc')
            ->get();

        return UtillsHelper::json(1, [
            'message' => 'Sectors with ' . $type . ' count',
            'data' => $sectors
        ]);
    }

    function getSupportedCountries(): JsonResponse
    {
        $supportedCountry = MasterSupportedCountriesModel::where('is_deleted', '0')->orderByRaw('CASE WHEN id = 1 THEN 0 ELSE 1 END')->orderby('name', 'asc')->get();
        return UtillsHelper::json(1, ['message' => 'Supported Country List', 'data' => $supportedCountry]);
    }

    // public function getBseHolidays(Request $request): JsonResponse
    // {
    //     $date = $request->input('date')
    //         ? Carbon::parse($request->input('date'))->toDateString()
    //         : now()->toDateString();

    //     $holiday = BseHolidayModel::active()
    //         ->whereDate('holiday_date', $date)
    //         ->first(['id', 'holiday_name', 'holiday_img', 'notes']);


    //     return UtillsHelper::json($holiday ? 1 : 0, [
    //         'data' => [
    //             'holiday_name' => $holiday->holiday_name,
    //             'holiday_img'  => $holiday->holiday_img,
    //             'notes'        => $holiday->notes,
    //         ]
    //     ]);
    // }

    public function getBseHolidays(Request $request): JsonResponse
    {
        $date = $request->input('date')
            ? Carbon::parse($request->input('date'))->toDateString()
            : now()->toDateString();

        $nextWorkingDate = BseCalendarHelper::getNextTradingDay(Carbon::parse($date));
        $tomorrow = Carbon::parse($date)->addDay()->toDateString();

        // --- Scenario 1: The requested date itself is a holiday ---
        $holiday = BseHolidayModel::active()
            ->whereDate('holiday_date', $date)
            ->first(['id', 'title', 'holiday_name', 'holiday_img', 'notes', 'holiday_date']);

        if ($holiday) {
            return UtillsHelper::json(1, [
                'data' => [
                    // 'holiday_name' => $holiday->holiday_name,
                    'title' => $holiday->title ?? $holiday->holiday_name,
                    'holiday_img'  => $holiday->holiday_img,
                    'notes' => $holiday->notes
                        ?? "Please note, {$holiday->holiday_date->format('jS F')} is a holiday. Orders placed today will be processed on the next working day ({$nextWorkingDate->format('jS F')}).",

                    'message_type' => 'today',
                ]
            ]);
        }

        // --- Scenario 2: Tomorrow (relative to requested date) is a holiday ---
        $tomorrowHoliday = BseHolidayModel::active()
            ->whereDate('holiday_date', $tomorrow)
            ->first(['id', 'title', 'holiday_name', 'holiday_img', 'notes', 'holiday_date']);

        if ($tomorrowHoliday) {
            return UtillsHelper::json(1, [
                'data' => [
                    // 'holiday_name' => $tomorrowHoliday->holiday_name,
                    'title' => $tomorrowHoliday->title ?? $tomorrowHoliday->holiday_name,
                    'holiday_img'  => $tomorrowHoliday->holiday_img,
                    'notes' => $tomorrowHoliday->notes
                        ?? "Please note, {$tomorrowHoliday->holiday_date->format('jS F')} is a holiday. Orders placed tomorrow will be processed on the next working day ({$nextWorkingDate->format('jS F')}).",
                    'message_type' => 'tomorrow',
                ]
            ]);
        }

        // --- No holiday ---
        return UtillsHelper::json(0, ['data' => null]);
    }

    public function getFindCmlList(): JsonResponse
    {
        $records = MasterFindCmlModel::where('is_deleted', 0)
            ->orderBy('id', 'asc')
            ->get();

        return UtillsHelper::json(1, [
            'message' => 'Find CML list fetched successfully',
            'data' => $records
        ]);
    }



    function getCountry(): JsonResponse
    {
        $country = MasterCountryModel::where('is_deleted', '0')->orderby('name', 'asc')->get();
        return UtillsHelper::json(1, ['message' => 'Country List', 'data' => $country]);
    }

    function getState(Request $request): JsonResponse
    {

        $state = MasterStateModel::where('is_deleted', '0')->orderby('name', 'asc');
        if ($request->country_id) {
            $state->where('country_id', $request->country_id);
        }
        if ($request->skip) {
            $state->skip($request->skip);
        }
        if ($request->take) {
            $state->take($request->take);
        }
        return UtillsHelper::json(1, ['message' => 'State List', 'data' => $state->get()]);
    }

    function getCity(Request $request): JsonResponse
    {
        $city = MasterCityModel::where('is_deleted', '0')->orderby('name', 'asc');
        if ($request->country_id) {
            $city->where('country_id', $request->country_id);
        }
        if ($request->state_id) {
            $city->where('state_id', $request->state_id);
        }
        if ($request->skip) {
            $city->skip($request->skip);
        }
        if ($request->take) {
            $city->take($request->take);
        }
        return UtillsHelper::json(1, ['message' => 'City List', 'data' => $city->get()]);
    }

    function getBlog(Request $request): JsonResponse
    {
        if ($request->blog_id || $request->filled('url_slug')) {
            $blog = MasterBlogModel::query();

            if ($request->blog_id) {
                $blog->where('id', $request->blog_id);
            } else {
                $blog->where('url_slug', $request->url_slug);
            }

            $blog = $blog->first();

            return UtillsHelper::json(1, ['message' => 'Blog Details', 'data' => $blog]);
        } else {
            $blogs = MasterBlogModel::where('is_deleted', '0')->orderby('id', 'desc')->get();

            $blogcolumn = ['id', 'type', 'banner', 'title', 'url_slug', 'short_description', 'created_at'];
            $thirdparty = ['id', 'type', 'banner', 'title', 'url_slug', 'short_description', 'long_description', 'created_at'];

            $bloglist = $blogs->map(function ($blog) use ($blogcolumn, $thirdparty) {
                if ($blog->type == 1) {
                    return $blog->only($blogcolumn);
                } elseif ($blog->type == 2) {
                    return $blog->only($thirdparty);
                }
                return $blog;
            });

            return UtillsHelper::json(1, ['message' => 'Blog List', 'data' => $bloglist]);
        }
    }

    function getAvtar(Request $request): JsonResponse
    {
        $avtars = MasterAvtarModel::where('is_deleted', 0)->get()->makeHidden(['uuid', 'display_order', 'is_deleted']);;
        return UtillsHelper::json(1, [
            'message' => 'Avtars',
            'data' => $avtars
        ]);
    }

    function getBank(): JsonResponse
    {
        $banks = MasterBankModel::where('is_deleted', 0)->get()->makeHidden(['is_deleted']);
        return UtillsHelper::json(1, [
            'message' => 'Banks',
            'data' => $banks
        ]);
    }


    function getFaqs(Request $request): JsonResponse
    {
        $faqs = CmsFaqsModel::where('is_deleted', 0)->get()->makeHidden(['uuid', 'is_deleted']);;
        return UtillsHelper::json(1, [
            'message' => 'FAQs',
            'data' => $faqs
        ]);
    }
    function getFamilyRelation(): JsonResponse
    {
        $relation = MasterFamilyRelationsModel::where('is_deleted', '0')->orderby('name', 'asc')->get();
        return UtillsHelper::json(1, ['message' => 'Family Relation List', 'data' => $relation]);
    }

    function cityToData(): JsonResponse
    {
        $request = request();
        $validation = Validator::make($request->all(), [
            'city_name' => 'required|string|max:255',
        ]);

        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }

        $city = MasterCityModel::with(['MasterState', 'MasterCountry'])
            ->where('name', $request->city_name)
            ->where('is_deleted', '0')
            ->first();

        if (!$city) {
            return UtillsHelper::json(0, ['message' => 'City not found']);
        }

        return UtillsHelper::json(1, [
            'message' => 'City Details',
            'data' => [
                'city' => $city->only(['id', 'name', 'country_id', 'state_id', 'created_at', 'updated_at']),
                'state' => $city->MasterState,
                'country' => $city->MasterCountry,
            ],
        ]);
    }

    function contactFromApp(): JsonResponse
    {
        return $this->commonRepo->contactUs();
    }

    public function upcoming(Request $request)
    {
        $now = Carbon::now();

        $query = StartupPitchModel::with(['startup.cms'])
            ->where('scheduled_date', '>', $now)
            ->where('is_deleted', 0);

        if ($request->filled('startup_id')) {
            $query->where('startup_id', $request->input('startup_id'));
        }

        $pitches = $query->get()->map(function ($pitch) {
            return [
                'id' => $pitch->id,
                'startup_id' => $pitch->startup_id,
                'title' => $pitch->title,
                'description' => $pitch->description,
                'scheduled_date' => $pitch->scheduled_date,
                'meeting_url' => $pitch->host_url,
                'video_url' => $pitch->video_url,
                'startup_brand_name' => optional($pitch->startup)->brand_name,
                'startup_logo' => optional(optional($pitch->startup)->cms)->logo,
                'startup_banner' => optional(optional($pitch->startup)->cms)->banner,
            ];
        });

        return UtillsHelper::json(1, [
            'message' => 'Upcoming Live Pitches',
            'data' => $pitches
        ]);
    }

    public function completed(Request $request)
    {
        $now = Carbon::now()->subMinutes(150);

        $query = StartupPitchModel::with(['startup.cms'])
            ->where('scheduled_date', '<', $now)
            ->where('is_deleted', 0);

        if ($request->filled('startup_id')) {
            $query->where('startup_id', $request->input('startup_id'));
        }

        $pitches = $query->get()->map(function ($pitch) {
            return [
                'id' => $pitch->id,
                'startup_id' => $pitch->startup_id,
                'title' => $pitch->title,
                'description' => $pitch->description,
                'scheduled_date' => $pitch->scheduled_date,
                'meeting_url' => $pitch->host_url,
                'video_url' => $pitch->video_url,
                'startup_brand_name' => optional($pitch->startup)->brand_name,
                'startup_logo' => optional(optional($pitch->startup)->cms)->logo,
                'startup_banner' => optional(optional($pitch->startup)->cms)->banner,
            ];
        });

        return UtillsHelper::json(1, [
            'message' => 'Completed Live Pitches',
            'data' => $pitches
        ]);
    }

    public function livePitchItem(Request $request)
    {
        $request = request();

        $validator = Validator::make($request->all(), [
            'livepitch_id'             => 'required',
        ]);

        if ($validator->fails()) {
            return UtillsHelper::json(0, ['message' => $validator->errors()->first()]);
        }

        $pitch = StartupPitchModel::with(['startup.cms'])->find($request->input('livepitch_id'));

        if (!$pitch) {
            return UtillsHelper::json(0, ['message' => 'Live Pitch not found']);
        }

        return UtillsHelper::json(1, [
            'message' => 'Live Pitch fetched successfully.',
            'data' => [
                'id' => $pitch->id,
                'startup_id' => $pitch->startup_id,
                'title' => $pitch->title,
                'description' => $pitch->description,
                'scheduled_date' => $pitch->scheduled_date,
                'host_url' => $pitch->host_url,
                'user_url' => $pitch->user_url,
                'video_url' => $pitch->video_url,
                'startup_brand_name' => optional($pitch->startup)->brand_name,
                'startup_logo' => optional(optional($pitch->startup)->cms)->logo,
                'startup_banner' => optional(optional($pitch->startup)->cms)->banner,
            ]
        ]);
    }
}
