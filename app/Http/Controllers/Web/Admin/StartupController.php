<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\StartupModel;
use App\Models\MasterCityModel;
use App\Models\StartupRoundModel;
use App\Models\StartupFundRaiseModel;
use App\Models\StartupKeyMetricsModel;
use App\Models\StartupFinancialDetailModel;
use App\Models\StartupOtherDetailModel;
use App\Models\MasterSocialmediaLinkModel;
use App\Models\StartupSocialMediaModel;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Helpers\UtillsHelper;
use App\Helpers\AdminHelper;
use App\Helpers\CommonHelper;
use App\Helpers\DateTimeHelper;
use App\Helpers\FileUpDownHelper;
use App\Models\StartupCmsModel;
use App\Models\StartupDetailsModel;
use App\Models\StartupFaqsModel;
use App\Models\StartupLegalModel;
use App\Models\StartupSharePriceModel;
use App\Models\StartupTeamModel;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\JsonResponse;

class StartupController extends Controller
{
    function create(): View
    {
        addVendor('tinymce');
        setPageTitle('Create Startup');
        return view('admin.pages.startup.manage.create');
    }

    public function edit(string $uuid): View|RedirectResponse
    {
        addVendor('tinymce');
        $item = StartupModel::where('is_deleted', '0')->where('uuid', $uuid)->first();

        if ($item) {
            setPageTitle('Edit Startup');
            $data['socialLinks'] = $item->socialMediaLinks->pluck('link', 'master_socialmedia_link_id')->toArray();
            $data['startup'] = $item;
            return view('admin.pages.startup.manage.edit', $data);
        }
        return redirect()->back()->with('error', 'Startup not found');
    }

    public function editet(string $uuid): View|RedirectResponse
    {
        addVendor('tinymce');
        // Retrieve the startup item by UUID
        $item = StartupModel::where('is_deleted', '0')->where('uuid', $uuid)->first();

        // Retrieve necessary data for the form
        $data['cities'] = MasterCityModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
        $data['socialMediaLinks'] = MasterSocialmediaLinkModel::where('is_deleted', '0')->orderby('id', 'desc')->get();

        if ($item) {
            setPageTitle('Edit Startup');
            $data['item'] = $item;

            // Retrieve financial details for the startup
            $data['list'] = StartupRoundModel::where('is_deleted', '0')
                ->with([
                    'startup.StartupFundRaiseOne',
                    'startup.StartupKeyMetricsOne',
                    'startup.rounds',
                    'startup.StartupFinance',
                    'startup.StartupOtherOne',
                    'startup.StartupDocumentOne',
                    'startup.faqs',
                    'startup.teamMembers',
                    'startup.legalInfo',
                    'startup.details',
                    'startup.socialMediaLinks'
                ])
                ->whereHas('startup', function ($query) use ($uuid) {
                    $query->where('uuid', $uuid);
                })
                ->first();
            if ($data['list']) {
                // Prepare financial details
                $startupFinance = $data['list']->startup->StartupFinance;

                $data['financialDetails'] = [
                    'previous' => $startupFinance->filter(function ($finance) {
                        return !($finance->revenue_expected || $finance->current_fy_closing_ebitda || $finance->current_fy_closing_pat || $finance->next_fy_revenue || $finance->next_fy_expense || $finance->next_fy_ebitda || $finance->next_fy_pat);
                    })->map(function ($finance) {
                        return [
                            'year' => $finance->year,
                            'net_revenue' => $finance->net_revenue,
                            'ebitda' => $finance->ebitda,
                            'pat' => $finance->pat,
                        ];
                    })->toArray(),

                    'post' => $startupFinance->filter(function ($finance) {
                        return $finance->revenue_expected || $finance->current_fy_closing_ebitda || $finance->current_fy_closing_pat || $finance->next_fy_revenue || $finance->next_fy_expense || $finance->next_fy_ebitda || $finance->next_fy_pat;
                    })->map(function ($finance) {
                        return [
                            'year' => $finance->year,
                            'revenue_expected' => $finance->revenue_expected,
                            'current_fy_closing_ebitda' => $finance->current_fy_closing_ebitda,
                            'current_fy_closing_pat' => $finance->current_fy_closing_pat,
                            'next_fy_revenue' => $finance->next_fy_revenue,
                            'next_fy_expense' => $finance->next_fy_expense,
                            'next_fy_ebitda' => $finance->next_fy_ebitda,
                            'next_fy_pat' => $finance->next_fy_pat,
                        ];
                    })->toArray(),
                ];
                $data['shortDescription'] = ltrim($data['list']->startup->details->short_description);
                // dd($data['shortDescription']);
                // Return the view with data
                return view('admin.pages.manageStartup.edit')->with($data);
            }

            // Redirect if the financial details are not found
            return redirect()->route('admin.startup.manage.pending')->with('error', 'Financial details not found for this startup');
        }
        // Redirect if the startup is not found
        return redirect()->route('admin.startup.manage.pending')->with('error', 'Startup not found');
    }

    public function update(Request $request): RedirectResponse
    {
        $startup = StartupModel::where('id', $request->startup_id)->first();
        $uuid = $startup->uuid;
        $validation = Validator::make($request->all(), [
            'brand_name' => 'required|string|max:255',
            'mobile_number' => [
                'required',
                'numeric',
                'digits:10',
                Rule::unique((new StartupModel())->getTable())->where(function ($query) use ($uuid) {
                    return $uuid
                        ? $query->where('is_deleted', '0')->where('uuid', '!=', $uuid)
                        : $query->where('is_deleted', '0');
                }),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique((new StartupModel)->getTable())->where(function ($query) use ($uuid) {
                    return $uuid
                        ? $query->where('is_deleted', '0')->where('uuid', '!=', $uuid)
                        : $query->where('is_deleted', '0');
                }),
            ],
            'industry_id' => 'required',
            'sector_id' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'address' => 'required|string|max:255',
            'pincode' => 'required|numeric|digits:6',
            'company_name' => 'required|string|max:255',
            'cin_number' => 'required|string|size:21',
            'pan_number' => 'required|string|size:10',
            'incorporation_date' => 'required|date_format:d-m-Y',
            'one_liner' => 'required|string|max:255',
            'website' => 'required|url',
            'highlights' => 'required|string',
            'idea' => 'required|string',
            'key_information' => 'required|string',
            'social_media_link' => 'array',
            'social_media_link.*' => 'nullable|url|max:255',
            'indicative_valuation' => 'required|numeric',
            'bg_color_code'   => 'nullable|string',
        ], [], [
            'country_id' => 'Country',
            'state_id' => 'State',
            'city_id' => 'City',
            'industry_id' => 'Industry',
            'sector_id' => 'Sector',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withInput()->withErrors($validation)
                ->with('error', 'Please check form errors.');
        }


        $startup->brand_name = $request->brand_name;
        $startup->sector_id = $request->sector_id;
        $startup->industry_segment = $request->industry_id;
        $startup->mobile_number = $request->mobile_number;
        $startup->email = $request->email;
        $startup->country_id = $request->country_id;
        $startup->state_id = $request->state_id;
        $startup->city_id = $request->city_id;
        $startup->address = $request->address;
        $startup->pincode = $request->pincode;
        $startup->registration_step = 6;
        $startup->indicative_valuation = $request->indicative_valuation;
        $startup->bg_color_code = $request->bg_color_code;
        $startup->save();

        $startupLegal = StartupLegalModel::where('startup_id', $startup->id)->first();
        if (!$startupLegal) {
            $startupLegal = new StartupLegalModel;
            $startupLegal->startup_id = $startup->id;
        }
        $startupLegal->company_name = strtoupper($request->company_name);
        $startupLegal->company_pan = strtoupper($request->pan_number);
        $startupLegal->cin = strtoupper($request->cin_number);
        $startupLegal->incorporation_date = DateTimeHelper::formatDateTime($request->incorporation_date, 'Y-m-d');
        $startupLegal->save();


        $cms = StartupCmsModel::where('startup_id', $startup->id)->first();
        if (!$cms) {
            $cms = new StartupCmsModel;
            $cms->startup_id = $startup->id;
        }

        $cms->startup_id = $startup->id;
        $cms->one_liner = $request->one_liner;
        $cms->website = $request->website;
        $cms->highlights = $request->highlights;
        $cms->idea = $request->idea;
        $cms->key_information = $request->key_information;
        $cms->save();

        if ($request->has('social_media_link')) {
            foreach ($request->social_media_link as $mediaId => $link) {
                if (!empty($link)) {
                    StartupSocialMediaModel::updateOrCreate(
                        [
                            'startup_id' => $startup->id,
                            'master_socialmedia_link_id' => $mediaId,
                        ],
                        [
                            'link' => $link,
                        ]
                    );
                } else {
                    StartupSocialMediaModel::where('startup_id', $startup->id)
                        ->where('master_socialmedia_link_id', $mediaId)
                        ->delete();
                }
            }
        }

        // Save FAQs
        StartupFaqsModel::where('startup_id', $startup->id)->delete();
        foreach ($request->input('question', []) as $index => $question) {
            if ($question) {
                StartupFaqsModel::create([
                    'startup_id' => $startup->id,
                    'question' => $question,
                    'answer' => $request->answer[$index] ?? ''
                ]);
            }
        }

        return redirect()->route('admin.startup.view', ['uuid' => $startup->uuid])
            ->with('success', 'Startup Updated.');
    }

    function store(Request $request): RedirectResponse
    {
        $uuid = false;
        $validation = Validator::make($request->all(), [
            'brand_name' => 'required|string|max:255',
            'mobile_number' => [
                'required',
                'numeric',
                'digits:10',
                Rule::unique((new StartupModel())->getTable())->where(function ($query) use ($uuid) {
                    return $uuid
                        ? $query->where('is_deleted', '0')->where('uuid', '!=', $uuid)
                        : $query->where('is_deleted', '0');
                }),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique((new StartupModel)->getTable())->where(function ($query) use ($uuid) {
                    return $uuid
                        ? $query->where('is_deleted', '0')->where('uuid', '!=', $uuid)
                        : $query->where('is_deleted', '0');
                }),
            ],
            'industry_id' => 'required',
            'sector_id' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'address' => 'required|string|max:255',
            'pincode' => 'required|numeric|digits:6',
            'indicative_valuation' => 'required|numeric',
            'bg_color_code'   => 'nullable|string',
            'company_name' => 'required|string|max:255',
            'cin_number' => 'required|string|size:21',
            'pan_number' => 'required|string|size:10',
            'incorporation_date' => 'required|date_format:d-m-Y',
            'one_liner' => 'required|string|max:255',
            'website' => 'required|url',
            'highlights' => 'required|string',
            'idea' => 'required|string',
            'key_information' => 'required|string',
            'social_media_link' => 'array',
            'social_media_link.*' => 'nullable|url|max:255',
        ], [], [
            'country_id' => 'Country',
            'state_id' => 'State',
            'city_id' => 'City',
            'industry_id' => 'Industry',
            'sector_id' => 'Sector',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withInput()->withErrors($validation)
                ->with('error', 'Please check form errors.');
        }
        try {
            DB::beginTransaction();
            $startup = new StartupModel;
            $startup->brand_name = $request->brand_name;
            $startup->sector_id = $request->sector_id;
            $startup->industry_segment = $request->industry_id;
            $startup->mobile_number = $request->mobile_number;
            $startup->email = $request->email;
            $startup->country_id = $request->country_id;
            $startup->state_id = $request->state_id;
            $startup->city_id = $request->city_id;
            $startup->address = $request->address;
            $startup->pincode = $request->pincode;
            $startup->registration_step = 6;
            $startup->indicative_valuation = $request->indicative_valuation;
            $startup->bg_color_code = $request->bg_color_code;
            $startup->save();

            $startupLegal = new StartupLegalModel;
            $startupLegal->startup_id = $startup->id;
            $startupLegal->company_name = strtoupper($request->company_name);
            $startupLegal->company_pan = strtoupper($request->pan_number);
            $startupLegal->cin = strtoupper($request->cin_number);
            $startupLegal->incorporation_date = DateTimeHelper::formatDateTime($request->incorporation_date, 'Y-m-d');
            $startupLegal->save();


            $cms = new StartupCmsModel;
            $cms->startup_id = $startup->id;
            $cms->one_liner = $request->one_liner;
            $cms->website = $request->website;
            $cms->highlights = $request->highlights;
            $cms->idea = $request->idea;
            $cms->key_information = $request->key_information;
            $cms->save();

            if ($request->has('social_media_link')) {
                foreach ($request->social_media_link as $mediaId => $link) {
                    if (!empty($link)) {
                        StartupSocialMediaModel::create([
                            'startup_id' => $startup->id,
                            'master_socialmedia_link_id' => $mediaId,
                            'link' => $link,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.startup.view', ['uuid' => $startup->uuid])
                ->with('success', 'Startup Created.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create startup. Please try again.']);
        }
    }

    public function view(string $uuid): View|RedirectResponse
    {
        $startup = StartupModel::where('uuid', $uuid)->first();
        if ($startup) {
            setPageTitle($startup->brand_name . ' - View');
            $data['startup'] = $startup;
            return view('admin.pages.startup.manage.view', $data);
        }
        return redirect()->back()->with('error', 'Startup not found');
    }

    public function viewOld(string $uuid): View|RedirectResponse
    {
        $startup = StartupModel::where('uuid', $uuid)->first();
        if ($startup) {
            setPageTitle($startup->brand_name . ' - View');
            $data['startup'] = $startup;
            return view('admin.pages.manageStartup.view', $data);
        }
        return redirect()->back()->with('error', 'Startup not found');
    }

    public function list(Request $request): View
    {
        // $query = StartupModel::where('is_deleted', '0');
        // if ($request->routeIs('admin.startup.manage.pending')) {
        //     setPageTitle('Pending Startup');
        //     $query = StartupModel::whereHas('rounds', function ($query) {
        //         $query->where('round_status', 'Pending');
        //     })
        //         ->with(['rounds'])->where('is_active', '0')->where('is_deleted', '0')->orderby('id', 'desc');
        // }
        // if ($request->routeIs('admin.startup.manage.coming_soon')) {
        //     setPageTitle('Coming Soon Startup');
        //     $query = StartupModel::whereHas('rounds', function ($query) {
        //         $query->where('round_status', 'Coming Soon');
        //     })
        //         ->with(['rounds'])->where('is_active', '0')->where('is_deleted', '0')->orderby('id', 'desc');
        // }
        // if ($request->routeIs('admin.startup.manage.raising_now')) {
        //     setPageTitle('Raising Now Startup');
        //     $query = StartupModel::whereHas('rounds', function ($query) {
        //         $query->where('round_status', 'Raising Now');
        //     })
        //         ->with(['rounds'])->where('is_active', '0')->where('is_deleted', '0')->orderby('id', 'desc');
        // }
        // if ($request->routeIs('admin.startup.manage.completed')) {
        //     setPageTitle('Completed Startup');
        //     $query = StartupModel::whereHas('rounds', function ($query) {
        //         $query->where('round_status', 'Completed');
        //     })
        //         ->with(['rounds'])->where('is_active', '0')->where('is_deleted', '0')->orderby('id', 'desc');
        // }
        setPageTitle('Start Up List');
        $data['list'] = StartupModel::where('is_deleted', '0')
            ->where('registration_step', '6')
            ->with(['rounds' => function ($query) {
                $query->select('startup_id', 'round_status')->distinct();
            }])
            ->get()
            ->map(function ($startup) {
                // Convert the distinct round_status values into a comma-separated string
                $startup->round_statuses = $startup->rounds->pluck('round_status')->unique()->join(', ');
                return $startup;
            });
        addVendor('datatables');
        return view('admin.pages.startup.manage.list')->with($data);
    }

    function sharePrice($uuid): View|RedirectResponse
    {
        $item = StartupModel::where('is_deleted', '0')->where('uuid', $uuid)->first();
        if ($item) {
            setPageTitle($item->brand_name . ' - Share Price');
            $data['item']   = $item;
            return view('admin.pages.startup.common.share-price', $data);
        }
        return redirect()->back()->with('error', 'Startup not found');
    }

    function sharePriceDelete($id): RedirectResponse
    {
        $item = StartupSharePriceModel::where('id', $id)->first();
        if ($item) {
            AdminHelper::logPut('Share Price delete ' . $item->price, StartupModel::class, $item->startup_id);
            $item->delete();
            return redirect()->back()->with('success', 'Share Price Deleted');
        }
        return redirect()->back()->with('error', 'Item not found');
    }

    function sharePriceSave(Request $request): View|RedirectResponse
    {
        $validation = Validator::make($request->all(), [
            'share_price' => [
                'required',
                'numeric'
            ],
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withInput()
                ->with('error', $validation->errors()->first());
        }

        StartupSharePriceModel::create([
            'startup_id'    => $request->startup_id,
            'price'         => $request->share_price
        ]);
        AdminHelper::logPut('Share Price Update to ' . $request->share_price, StartupModel::class, $request->startup_id);
        return redirect()->back()
            ->with('success', 'Share price updated.');
    }







    public function updatess(Request $request, string $uuid): RedirectResponse
    {

        // dd($request->all());

        $startup = StartupModel::where('is_deleted', '0')->where('uuid', $uuid)->first();

        if ($startup) {
            $startupRound = StartupRoundModel::where('startup_id', $startup->id)->first();
            if ($startupRound) {
                $startupRound->update([
                    'round_status' => $request->input('primary_round_status'),
                    'share_price' => $request->input('share_price'),
                    'instrument' => $request->input('instrument')

                ]);
            } else {
                // Handle the case where $startupRound is not found
                return redirect()->back()->with('error', 'Startup round not found.');
            }
            // dd($request->input('primary_round_status'));
            // Update the startup details
            $startup->update([
                'url_slug' => AdminHelper::startupSlug($request->input('brand_name')),
                'brand_name' => $request->input('brand_name'),
                'city_id' => $request->input('city_id'),
                'state_id' => $request->input('state_id'),
                'country_id' => $request->input('country_id'),
                'email' => $request->input('founder_email_id'),
                'mobile_number' => $request->input('founder_contact_number'),
                'company_name' => $request->input('company_name'),
                'email' => $request->input('email'),
                'brief_information' => $request->input('brief_description'),
                'address' => $request->input('registered_address'),
                'sector_id' => $request->input('sector_id'),
                'industry_segment' => $request->input('industry_segment')
            ]);
            $fundRaise = StartupFundRaiseModel::where('startup_id', $startup->id)->first();
            $input = $request->input('committed_investors'); // Get the input from the request
            $committedInvestors = explode(',', $input); // Split the input string by commas into an array
            $fundRaise->update([
                'valuation_of_previous_round' => $request->input('valuation_of_previous_round'),
                'fund_requirement' => $request->input('fund_requirement'),
                'committed_investors' => $committedInvestors,
                'fund_utilisation_details' => $request->input('fund_utilisation_details'),
                'current_fund_raise' => $request->input('current_fund_raise'),
                'funds_required_from_shuru' => $request->input('funds_required_from_shuru'),
                'min_ticket_size' => $request->input('min_ticket_size'),
                'pre_money_valuation_basis' => $request->input('pre_money_valuation_basis'),
                'instrument_and_conversion_condition' => $request->input('instrument_and_conversion_condition'),
                'pre_money_valuation' => $request->input('pre_money_valuation'),
            ]);
            $keyMetric = StartupKeyMetricsModel::where('startup_id', $startup->id)->first();
            $keyMetric->update([
                'founder_capital_contribution' => $request->input('founder_capital_contribution'),
                'monthly_revenue_run_rate' => $request->input('monthly_revenue_run_rate'),
                'annualized_revenue_run_rate' => $request->input('annualized_revenue_run_rate'),
                'traction_metrics' => $request->input('traction_metrics'),
                'current_monthly_burn' => $request->input('current_monthly_burn'),
                'current_cash_balance' => $request->input('current_cash_balance'),
                'runway_months' => $request->input('runway_months'),
                'competitors' => $request->input('competitors'),
                'key_usp_differentiator_entry_barrier' => $request->input('key_usp_differentiator_entry_barrier'),
            ]);
            if ($request->previous_raised_year) {
                foreach ($request->previous_raised_year as $index => $year) {
                    $financialDetail = StartupFinancialDetailModel::where('startup_id', $startup->id)
                        ->where('year', $year)
                        ->first();

                    if (!$financialDetail) {
                        $financialDetail = new StartupFinancialDetailModel();
                        $financialDetail->startup_id = $startup->id;
                        $financialDetail->round_id = $startup->lastRounds ? $startup->lastRounds->id : NULL;
                    }
                    // dd($financialDetail);
                    $financialDetail->year = $year;
                    $financialDetail->net_revenue = $request->net_revenue[$index];
                    $financialDetail->ebitda = $request->ebitda[$index];
                    $financialDetail->pat = $request->pat[$index];
                    $financialDetail->save();
                }
            }

            if ($request->post_raised_year) {
                // Handle Post Fund Raise Details
                foreach ($request->post_raised_year as $index => $postYear) {
                    $postFundRaise = StartupFinancialDetailModel::where('startup_id', $startup->id)
                        ->where('year', $postYear)
                        ->first();

                    if (!$postFundRaise) {
                        $postFundRaise = new StartupFinancialDetailModel();
                        $postFundRaise->startup_id = $startup->id;
                        $postFundRaise->round_id = $startup->lastRounds ? $startup->lastRounds->id : NULL;
                    }

                    $postFundRaise->year = $postYear;
                    $postFundRaise->revenue_expected = $request->revenue_expected[$index] ?? null;
                    $postFundRaise->current_fy_closing_ebitda = $request->current_fy_closing_ebitda[$index] ?? null;
                    $postFundRaise->current_fy_closing_pat = $request->current_fy_closing_pat[$index] ?? null;
                    $postFundRaise->next_fy_revenue = $request->next_fy_revenue[$index] ?? null;
                    $postFundRaise->next_fy_expense = $request->next_fy_expense[$index] ?? null;
                    $postFundRaise->next_fy_ebitda = $request->next_fy_ebitda[$index] ?? null;
                    $postFundRaise->next_fy_pat = $request->next_fy_pat[$index] ?? null;
                    $postFundRaise->save();
                }
            }


            $legalDetails = StartupLegalModel::where('startup_id', $startup->id)->first();
            if (!$legalDetails) {
                $legalDetails = new StartupLegalModel();
                $legalDetails->startup_id = $startup->id;
                $legalDetails->incorporation_date = $request->incorporation_date;
                $legalDetails->cin = $request->cin;
            }
            $legalDetails->incorporation_date = $request->incorporation_date;
            $legalDetails->cin = $request->cin;
            $legalDetails->save();

            $otherDetails = StartupOtherDetailModel::where('startup_id', $startup->id)->first();
            if (!$otherDetails) {
                $otherDetails = new StartupOtherDetailModel();
                $otherDetails->startup_id = $startup->id;
                $otherDetails->round_id = $startup->lastRounds ? $startup->lastRounds->id : null;
            }

            // Update the other details
            $otherDetails->number_of_founders = $request->number_of_founders;
            $otherDetails->name_of_founder = $request->name_of_founder;
            $otherDetails->age = $request->age;
            $otherDetails->education_qualification = $request->education_qualification;
            $otherDetails->work_exp = $request->work_exps;
            $otherDetails->startup_failures_successful_exits = $request->startup_failures_successful_exits;
            $otherDetails->highlights = $request->highlights;
            $otherDetails->idea = $request->idea;
            $otherDetails->key_information = $request->key_information;
            $otherDetails->pitchdeck = $request->pitchdeck;
            $otherDetails->financial_model = $request->financial_model;
            $otherDetails->founder_email_id = $request->founder_email_id;
            $otherDetails->founder_contact_number = $request->founder_contact_number;
            $otherDetails->ssa_id = $request->ssa_id;
            $otherDetails->ssa_sign_coordinates = $request->ssa_sign_coordinates;
            $otherDetails->offer_id = $request->offer_id;
            $otherDetails->offer_sign_coordinates = $request->offer_sign_coordinates;
            $otherDetails->equity_offered = $request->equity_offered;
            $otherDetails->floor = $request->floor;
            $otherDetails->cap = $request->cap;
            $otherDetails->save();

            $faq = StartupFaqsModel::where('startup_id', $startup->id)->delete();
            foreach ($request->input('question', []) as $index => $question) {
                if ($question) {
                    StartupFaqsModel::create([
                        'startup_id' => $startup->id,
                        'question' => $question,
                        'answer' => $request->answer[$index]
                    ]);
                }
            }

            $startupMIS = StartupDetailsModel::where('startup_id', $startup->id)->first();
            if (!$startupMIS) {
                $startupMIS = new StartupDetailsModel;
                $startupMIS->startup_id = $startup->id;
            }
            // Handle file uploads using FileUpDownHelper
            if ($request->hasFile('pitch_deck_file')) {
                $startupMIS->pitch_deck_file = FileUpDownHelper::startup_pitch_deck_upload($request->file('pitch_deck_file'));
            }
            if ($request->hasFile('fina_projection')) {
                $startupMIS->financial_projection = FileUpDownHelper::startup_financial_projection_upload($request->file('fina_projection'));
            }
            if ($request->hasFile('dd_report')) {
                $startupMIS->dd_report = FileUpDownHelper::startup_dd_report_upload($request->file('dd_report'));
            }
            if ($request->hasFile('valuation_report')) {
                $startupMIS->valuation_report = FileUpDownHelper::startup_valuation_report_upload($request->file('valuation_report'));
            }
            if ($request->hasFile('dpiit_file')) {
                $startupMIS->dpiit_certificate = FileUpDownHelper::startup_dpiit_certificate_upload($request->file('dpiit_file'));
            }
            if ($request->hasFile('shuruup_research_report')) {
                $startupMIS->shuruup_research_report = FileUpDownHelper::startup_shuruup_research_report_upload($request->file('shuruup_research_report'));
            }
            if ($request->hasFile('long_banner')) {
                $startupMIS->long_banner = FileUpDownHelper::startup_long_banner_upload($request->file('long_banner'));
            }
            if ($request->hasFile('banner')) {
                $startupMIS->banner = FileUpDownHelper::startup_short_banner_upload($request->file('banner'));
            }
            if ($request->hasFile('logo')) {
                $startupMIS->logo = FileUpDownHelper::startup_logo_upload($request->file('logo'));
            }
            if ($request->hasFile('product_video')) {
                $startupMIS->product_video = FileUpDownHelper::startup_product_video_upload($request->file('product_video'));
            }
            if ($request->hasFile('pitch_video')) {
                $startupMIS->pitch_video = FileUpDownHelper::startup_pitch_video_upload($request->file('pitch_video'));
            }
            $startupMIS->short_description = trim($request->short_description);
            $startupMIS->website_url = $request->website_url;
            $startupMIS->save();

            if ($request->has('_token')) {
                StartupSocialMediaModel::where('startup_id', $startup->id)->delete();

                foreach ($request->all() as $key => $link) {
                    if (preg_match('/(\d+)_url$/', $key, $matches)) {
                        $socialMediaId = $matches[1];
                        if (!empty($link)) {
                            StartupSocialMediaModel::create([
                                'startup_id' => $startup->id,
                                'master_socialmedia_link_id' => $socialMediaId,
                                'link' => $link,
                            ]);
                        }
                    }
                }
            }

            return redirect()->route('admin.startup.view', ['uuid' => $uuid])
                ->with('success', 'Startup updated successfully.');
        }
        // Redirect with an error message if startup is not found
        return redirect()->route('admin.startup.manage.pending')->with('error', 'Startup not found.');
    }

    public function delete(string $id): RedirectResponse
    {
        $item = StartupModel::where('is_deleted', '0')->find($id);
        if ($item) {
            $item->is_deleted = '1';
            $item->update();
            AdminHelper::logPut('Deleted Investor', InvestorController::class, $item->id);
            return redirect()->back()->with('success', 'Startup Deleted');
        }
        return redirect()->route('admin.startup.manage.pending')->with('error', 'Item not found');
    }

    function editTeam($uuid): View|RedirectResponse
    {
        $item = StartupModel::where('is_deleted', '0')->where('uuid', $uuid)->first();

        if ($item) {
            setPageTitle($item->brand_name . ' - Team Update');
            $data['item'] = $item;
            $data['uuid'] = $uuid;
            $data['key'] = 0;
            return view('admin.pages.startup.common.team', $data);
        }
        return redirect()->back();
    }

    function updateTeam(Request $request)
    {
        // dd($request->all());
        $item = StartupModel::where('is_deleted', '0')->where('uuid', $request->uuid)->first();
        if ($item) {

            if ($request->delete) {
                StartupTeamModel::whereIn('id', explode(',', $request->delete))->delete();
            }
            if ($request->input) {
                foreach ($request->input as $key => $value) {
                    if ($value['old_id'] != "") {
                        $team = StartupTeamModel::find($value['old_id']);
                    } else {
                        $team = new StartupTeamModel();
                        $team->startup_id                   = $item->id;
                    }
                    $team->name                         = $value['name'];
                    $team->designation                  = $value['designation'];
                    $team->experience                  = $value['experience'];
                    $team->linkedin_url                 = $value['linkedin'];
                    $team->brief_information            = $value['berif'];
                    if (isset($request->file('input')[$key]['photo'])) {
                        $team->profile_photo = FileUpDownHelper::startup_team_profile_photo_upload($request->file('input')[$key]['photo']);
                    }
                    $team->save();
                }
            }
            return redirect()->back()->with('success', 'Team Updated');
        }
        return redirect()->back();
    }

    function editRoundDetails($round_id)
    {
        $round = StartupRoundModel::find($round_id);
        if ($round) {
            $round->formatted_created_at = Carbon::parse($round->created_at)->format('d-m-Y');
        }
        return UtillsHelper::json(1, ['round' => $round], 200);
    }

    function updateRoundDetails(Request $request): RedirectResponse|JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'round_name' => 'required',
            'round_type' => 'required',
            'round_status' => 'required',
            'share_price' => 'required|numeric',
            'shuru_commission' => 'required|numeric',
            'instrument' => 'required',
            'floor' => 'required|numeric',
            'cap' => 'required|numeric',
            'minimum_investment' => 'required|numeric',
            'minimum_investment_aif' => 'required|numeric',
            'total_fund_requirement' => 'required|numeric',
            'fund_requirement' => 'required|numeric',
            'date'              => 'required|date_format:d-m-Y',
        ]);
        if ($validation->fails()) {
            return UtillsHelper::json(0, ['errors' => $validation->errors()], 422);
        }
        $formattedDate = Carbon::createFromFormat('d-m-Y', $request->date)->startOfDay();
        $round = StartupRoundModel::find($request->input('round_id'));

        if (!$round) {
            $round = new StartupRoundModel();
            $round->startup_id = $request->startup_id;
        }

        $round->name = $request->round_name;
        $round->round_type = $request->round_type;
        $round->round_status = $request->round_status;
        $round->share_price = $request->share_price;
        $round->shuru_commission = $request->shuru_commission;
        $round->instrument = $request->instrument;
        $round->floor = $request->floor;
        $round->cap = $request->cap;
        $round->equity_offered = $request->equity_offered;
        $round->minimum_investment = $request->minimum_investment;
        $round->minimum_investment_aif = $request->minimum_investment_aif;
        $round->total_fund_requirement = $request->total_fund_requirement;
        $round->fund_requirement = $request->fund_requirement;
        $round->created_at = $formattedDate;
        $round->save();


        // Update SharePrice
        if ($request->share_price > 0) {
            $sharePrice = StartupSharePriceModel::where('startup_id', $round->startup_id)
                ->where('price', $request->share_price)
                ->where('created_at', $round->created_at)->first();
            if (!$sharePrice) {
                $sPrice = new StartupSharePriceModel;
                $sPrice->startup_id = $round->startup_id;
                $sPrice->price = $request->share_price;
                $sPrice->created_at = $round->created_at;
                $sPrice->save();
            }
        }

        $rounds = StartupRoundModel::where('startup_id', $round->startup_id)->where('is_deleted', 0)->get();

        if ($request->has('round_id')) {
            return UtillsHelper::json(1, ['message' => 'Round updated successfully', 'table' => view('admin.pages.startup.child.child.round-table', ['rounds' => $rounds])->render()], 200);
        } else {
            return UtillsHelper::json(1, ['message' => 'Round created successfully', 'table' => view('admin.pages.startup.child.child.round-table', ['rounds' => $rounds])->render()], 200);
        }

        // return UtillsHelper::json(0, ['errors' => 'Cannot create or update record'], 422);
    }

    function updateCMS(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'startup_id'    => 'required',
            'logo' => 'nullable|image|mimes:' . CommonHelper::appSettings('file_image_extensions_allowed') . '|max:' . UtillsHelper::maxFileImageSizeInKB(),
            'banner' => 'nullable|image|mimes:' . CommonHelper::appSettings('file_image_extensions_allowed') . '|max:' . UtillsHelper::maxFileImageSizeInKB(),
            'long_banner' => 'nullable|image|mimes:' . CommonHelper::appSettings('file_image_extensions_allowed') . '|max:' . UtillsHelper::maxFileImageSizeInKB(),
            'product_video' => 'nullable|mimes:' . CommonHelper::appSettings('file_video_extensions_allowed') . '|max:' . UtillsHelper::maxFileVideoSizeInKB(),
            'pitch_video' => 'nullable|mimes:' . CommonHelper::appSettings('file_video_extensions_allowed') . '|max:' . UtillsHelper::maxFileVideoSizeInKB(),
            'pitch_deck' => 'nullable|mimes:' . CommonHelper::appSettings('file_document_extensions_allowed') . '|max:' . UtillsHelper::maxFileDocumentSizeInKB(),
            'financial_projection' => 'nullable|mimes:' . CommonHelper::appSettings('file_document_extensions_allowed') . '|max:' . UtillsHelper::maxFileDocumentSizeInKB(),
            'dd_report' => 'nullable|mimes:' . CommonHelper::appSettings('file_document_extensions_allowed') . '|max:' . UtillsHelper::maxFileDocumentSizeInKB(),
            'dpiit_report' => 'nullable|mimes:' . CommonHelper::appSettings('file_document_extensions_allowed') . '|max:' . UtillsHelper::maxFileDocumentSizeInKB(),
            'shuruup_research_report' => 'nullable|mimes:' . CommonHelper::appSettings('file_document_extensions_allowed') . '|max:' . UtillsHelper::maxFileDocumentSizeInKB(),
            'valuation_report' => 'nullable|mimes:' . CommonHelper::appSettings('file_document_extensions_allowed') . '|max:' . UtillsHelper::maxFileDocumentSizeInKB(),
        ]);
        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }

        $cms = StartupCmsModel::where('startup_id', $request->startup_id)->first();
        if (!$cms) {
            $cms = new StartupCmsModel;
            $cms->startup_id = $request->startup_id;
        }
        if ($request->hasFile('logo')) {
            $cms->logo = FileUpDownHelper::startup_logo_upload($request->file('logo'));
        }
        if ($request->hasFile('banner')) {
            $cms->banner = FileUpDownHelper::startup_short_banner_upload($request->file('banner'));
        }
        if ($request->hasFile('long_banner')) {
            $cms->long_banner = FileUpDownHelper::startup_long_banner_upload($request->file('long_banner'));
        }

        if ($request->hasFile('product_video')) {
            $cms->product_video = FileUpDownHelper::startup_product_video_upload($request->file('product_video'));
        }
        if ($request->hasFile('pitch_video')) {
            $cms->pitch_video = FileUpDownHelper::startup_pitch_video_upload($request->file('pitch_video'));
        }

        if ($request->hasFile('pitch_deck')) {
            $cms->pitch_deck = FileUpDownHelper::startup_document_upload($request->file('pitch_deck'));
        }
        if ($request->hasFile('financial_projection')) {
            $cms->financial_projection = FileUpDownHelper::startup_document_upload($request->file('financial_projection'));
        }
        if ($request->hasFile('dd_report')) {
            $cms->dd_report = FileUpDownHelper::startup_dd_report_upload($request->file('dd_report'));
        }
        if ($request->hasFile('dpiit_report')) {
            $cms->dpiit_report = FileUpDownHelper::startup_dd_report_upload($request->file('dpiit_report'));
        }
        if ($request->hasFile('shuruup_research_report')) {
            $cms->shuruup_research_report = FileUpDownHelper::startup_dd_report_upload($request->file('shuruup_research_report'));
        }
        if ($request->hasFile('valuation_report')) {
            $cms->valuation_report = FileUpDownHelper::startup_dd_report_upload($request->file('valuation_report'));
        }

        $cms->save();

        $startup = StartupModel::where('id', $request->startup_id)->first();

        return UtillsHelper::json(1, [
            'message' => 'ok',
            'document' => view(
                'admin.pages.startup.child.child.files.documents',
                ['startup' => $startup]
            )->render(),
            'banner' => view(
                'admin.pages.startup.child.child.files.banners',
                ['startup' => $startup]
            )->render()
        ]);
    }
}
