<?php

namespace App\Http\Controllers\Web\Admin;

use App\Enums\CouponCompanyScopeEnum;
use App\Helpers\AdminHelper;
use App\Http\Controllers\Controller;
use App\Models\CompanyModel;
use App\Models\MasterCouponModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use App\Enums\CouponTypeEnum;
use App\Enums\InvestorCouponStatusEnum;
use App\Enums\PreIpoCategoryEnum;
use App\Models\AppSettingsModel;
use App\Models\InvestorCouponModel;
use App\Models\InvestorModel;
use Exception;
use Illuminate\Validation\Rules\Enum;

class CouponController extends Controller
{
    public function list(): View
    {
        setPageTitle('Coupon Management');
        $coupons = MasterCouponModel::with(['company', 'companies'])
            ->orderBy('id', 'desc')
            ->get();
        return view('admin.pages.coupon.list', compact('coupons'));
    }

    public function create(): View
    {
        addVendor('tinymce');
        setPageTitle('Create Coupon');
        $companies = CompanyModel::where('is_deleted', 0)->where('is_grab_opportunity_enabled', 1)
            ->where('category', '!=', PreIpoCategoryEnum::listed->value)->orderBy('brand_name', 'asc')->get();
        return view('admin.pages.coupon.create', compact('companies'));
    }

    public function edit(string $uuid): View|RedirectResponse
    {
        addVendor('tinymce');
        $coupon = MasterCouponModel::with('companies')->where('uuid', $uuid)->first();

        if (!$coupon) {
            return redirect()->route('admin.coupon.list')->with('error', 'Coupon not found');
        }

        setPageTitle('Edit Coupon');
        $companies = CompanyModel::where('is_deleted', 0)->where('is_grab_opportunity_enabled', 1)->where('category', '!=', PreIpoCategoryEnum::listed->value)->orderBy('brand_name', 'asc')->get();
        $selectedCompanyIds = $coupon->companies->pluck('id')->toArray();

        return view('admin.pages.coupon.edit', compact('coupon', 'companies', 'selectedCompanyIds'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validation = Validator::make($request->all(), [
            'code' => [
                'required',
                'string',
                'max:100',
                'unique:master_coupon,code',
            ],
            'type' => ['required', new Enum(CouponTypeEnum::class)],
            'description' => ['nullable', 'string'],
            'terms_conditions' => ['nullable', 'string'],
            'discount_value' => ['required', 'numeric', 'min:0'],
            'max_discount_amount' => ['nullable', 'numeric', 'min:0'],
            'applies_on' => ['required', 'in:primary,secondary,pre_ipo,all'],
            'company_scope' => ['required', new Enum(CouponCompanyScopeEnum::class)],
            'company_id'   => ['nullable', 'required_if:company_scope,' . CouponCompanyScopeEnum::single->value, 'exists:company,id'],
            'company_ids'  => ['nullable', 'required_if:company_scope,' . CouponCompanyScopeEnum::multiple->value, 'array'],
            'company_ids.*' => ['exists:company,id'],
            'min_investment_amount' => ['nullable', 'numeric', 'min:0'],
            'usage_limit_per_user' => ['nullable', 'integer', 'min:1'],
            'usage_limit_global' => ['nullable', 'integer', 'min:1'],
            'valid_from' => ['required', 'date'],
            'valid_to' => ['required', 'date', 'after_or_equal:valid_from'],
            'is_active' => ['nullable', 'boolean'],
            'is_private' => ['nullable', 'boolean'],
            'created_via' => ['nullable', 'in:referral,manual,campaign'],
            // 'first_transaction_only' => ['nullable', 'boolean'],
            // 'new_user_only' => ['nullable', 'boolean'],
            // 'is_referral_coupon' => ['nullable', 'boolean'],
            // 'assign_to_referrer' => ['nullable', 'boolean'],
            // 'assign_to_referred' => ['nullable', 'boolean'],
            // 'referrer_reward_value' => [
            //     'nullable',
            //     'numeric',
            //     'min:0',
            //     'required_if:created_via,referral'
            // ],

            // 'referred_reward_value' => [
            //     'nullable',
            //     'numeric',
            //     'min:0',
            //     'required_if:created_via,referral'
            // ],


        ]);

        if ($validation->fails()) {
            return redirect()->back()->withInput()->withErrors($validation)
                ->with('error', 'Please check form errors.');
        }

        DB::beginTransaction();
        try {
            // if ($request->created_via === 'referral') {

            //     $exists = MasterCouponModel::where('is_referral_coupon', 1)
            //         ->where('is_deleted', 0)
            //         ->exists();

            //     if ($exists) {
            //         DB::rollBack();
            //         return redirect()->back()
            //             ->withInput()
            //             ->with('error', 'Referral coupon already exists. Please edit existing one.');
            //     }
            // }
            // $isReferral = $request->created_via === 'referral';

            $coupon = new MasterCouponModel();
            $coupon->uuid = (string) Str::uuid();
            $coupon->code = strtoupper(trim($request->code));
            $coupon->type = CouponTypeEnum::from($request->type)->value;
            $coupon->description = $request->description;
            $coupon->terms_conditions = $request->terms_conditions;
            $coupon->discount_value = $request->discount_value;
            $coupon->max_discount_amount = $request->max_discount_amount;
            $coupon->applies_on = $request->applies_on;
            $coupon->min_investment_amount = $request->min_investment_amount;
            $coupon->usage_limit_per_user = $request->usage_limit_per_user;
            $coupon->usage_limit_global = $request->usage_limit_global;
            $coupon->valid_from = $request->valid_from ? date('Y-m-d H:i:s', strtotime($request->valid_from)) : null;
            $coupon->valid_to = $request->valid_to ? date('Y-m-d H:i:s', strtotime($request->valid_to)) : null;
            $coupon->is_active = $request->has('is_active') ? 1 : 0;
            $coupon->is_private = $request->has('is_private') ? 1 : 0;
            $coupon->created_via           = 'manual';

            // Referral fields — always null, managed via Settings now
            $coupon->is_referral_coupon    = 0;
            $coupon->assign_to_referrer    = 0;
            $coupon->assign_to_referred    = 0;
            $coupon->referrer_reward_value = null;
            $coupon->referred_reward_value = null;
            // $coupon->meta = [
            //     'first_transaction_only' => $request->has('first_transaction_only') ? true : false,
            //     'new_user_only' => $request->has('new_user_only') ? true : false,
            // ];
            $coupon->meta = [];

            // Handle company scope
            if ($request->company_scope === CouponCompanyScopeEnum::single->value) {
                $coupon->company_id = $request->company_id;
            } else {
                $coupon->company_id = null;
            }

            $coupon->save();

            // Sync multiple companies if selected
            if ($request->company_scope === CouponCompanyScopeEnum::multiple->value && $request->has('company_ids')) {
                $coupon->companies()->sync($request->company_ids);
            }

            DB::commit();
            AdminHelper::logPut('Coupon Created', MasterCouponModel::class, $coupon->id);

            return redirect()->route('admin.coupon.list')
                ->with('success', 'Coupon created successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()
                ->with('error', 'Error creating coupon: ' . $e->getMessage());
        }
    }

    public function update(Request $request, string $uuid): RedirectResponse
    {
        $coupon = MasterCouponModel::where('uuid', $uuid)->first();

        if (!$coupon) {
            return redirect()->route('admin.coupon.list')->with('error', 'Coupon not found');
        }

        $validation = Validator::make($request->all(), [
            'code' => [
                'required',
                'string',
                'max:100',
                Rule::unique('master_coupon', 'code')->ignore($coupon->id),
            ],
            'type' => ['required', new Enum(CouponTypeEnum::class)],
            'description' => ['nullable', 'string'],
            'terms_conditions' => ['nullable', 'string'],
            'discount_value' => ['required', 'numeric', 'min:0'],
            'max_discount_amount' => ['nullable', 'numeric', 'min:0'],
            'applies_on' => ['required', 'in:primary,secondary,pre_ipo,all'],
            'company_scope' => ['required', new Enum(CouponCompanyScopeEnum::class)],
            'company_id'   => ['nullable', 'required_if:company_scope,' . CouponCompanyScopeEnum::single->value, 'exists:company,id'],
            'company_ids'  => ['nullable', 'required_if:company_scope,' . CouponCompanyScopeEnum::multiple->value, 'array'],
            'company_ids.*' => ['exists:company,id'],
            'min_investment_amount' => ['nullable', 'numeric', 'min:0'],
            'usage_limit_per_user' => ['nullable', 'integer', 'min:1'],
            'usage_limit_global' => ['nullable', 'integer', 'min:1'],
            'valid_from' => ['nullable', 'date'],
            'valid_to' => ['nullable', 'date', 'after_or_equal:valid_from'],
            'is_active' => ['nullable', 'boolean'],
            'is_private' => ['nullable', 'boolean'],
            // 'created_via' => ['nullable', 'in:referral,manual,campaign'],
            // 'first_transaction_only' => ['nullable', 'boolean'],
            // 'new_user_only' => ['nullable', 'boolean'],
            // 'is_referral_coupon' => ['nullable', 'boolean'],
            // 'assign_to_referrer' => ['nullable', 'boolean'],
            // 'assign_to_referred' => ['nullable', 'boolean'],
            // 'referrer_reward_value' => [
            //     'nullable',
            //     'numeric',
            //     'min:0',
            //     'required_if:created_via,referral'
            // ],

            // 'referred_reward_value' => [
            //     'nullable',
            //     'numeric',
            //     'min:0',
            //     'required_if:created_via,referral'
            // ],


        ]);

        if ($validation->fails()) {
            return redirect()->back()->withInput()->withErrors($validation)
                ->with('error', 'Please check form errors.');
        }

        DB::beginTransaction();
        try {
            // $isReferral = $request->created_via === 'referral';
            // if ($isReferral && !$coupon->is_referral_coupon) {

            //     $exists = MasterCouponModel::where('is_referral_coupon', 1)
            //         ->where('is_deleted', 0)
            //         ->where('id', '!=', $coupon->id)
            //         ->exists();

            //     if ($exists) {
            //         DB::rollBack();
            //         return redirect()->back()
            //             ->withInput()
            //             ->with('error', 'Referral coupon already exists. Please edit existing one.');
            //     }
            // }
            $coupon->code = strtoupper(trim($request->code));
            $coupon->type = CouponTypeEnum::from($request->type)->value;
            $coupon->description = $request->description;
            $coupon->terms_conditions = $request->terms_conditions;
            $coupon->discount_value = $request->discount_value;
            $coupon->max_discount_amount = $request->max_discount_amount;
            $coupon->applies_on = $request->applies_on;
            $coupon->min_investment_amount = $request->min_investment_amount;
            $coupon->usage_limit_per_user = $request->usage_limit_per_user;
            $coupon->usage_limit_global = $request->usage_limit_global;
            $coupon->valid_from = $request->valid_from ? date('Y-m-d H:i:s', strtotime($request->valid_from)) : null;
            $coupon->valid_to = $request->valid_to ? date('Y-m-d H:i:s', strtotime($request->valid_to)) : null;
            $coupon->is_active = $request->has('is_active') ? 1 : 0;
            $coupon->is_private = $request->has('is_private') ? 1 : 0;
            // $meta                          = is_array($coupon->meta) ? $coupon->meta : [];
            // $meta['first_transaction_only'] = $request->has('first_transaction_only');
            // $meta['new_user_only']          = $request->has('new_user_only');
            // $coupon->meta                  = $meta;


            // Handle company scope
            if ($request->company_scope === CouponCompanyScopeEnum::single->value) {
                $coupon->company_id = $request->company_id;
                $coupon->companies()->detach();
            } elseif ($request->company_scope === CouponCompanyScopeEnum::multiple->value) {
                $coupon->company_id = null;
                if ($request->has('company_ids')) {
                    $coupon->companies()->sync($request->company_ids);
                } else {
                    $coupon->companies()->detach();
                }
            } else {
                // All companies
                $coupon->company_id = null;
                $coupon->companies()->detach();
            }

            $coupon->save();

            DB::commit();
            AdminHelper::logPut('Coupon Updated', MasterCouponModel::class, $coupon->id);

            return redirect()->route('admin.coupon.list')
                ->with('success', 'Coupon updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()
                ->with('error', 'Error updating coupon: ' . $e->getMessage());
        }
    }

    public function delete(string $uuid): RedirectResponse
    {
        $coupon = MasterCouponModel::where('uuid', $uuid)->first();

        if (!$coupon) {
            return redirect()->route('admin.coupon.list')->with('error', 'Coupon not found');
        }

        try {
            // Check if coupon is being used
            $usageCount = $coupon->investorCoupons()->where('status', 'redeemed')->count();

            if ($usageCount > 0) {
                return redirect()->route('admin.coupon.list')
                    ->with('error', 'Cannot delete coupon that has been redeemed.');
            }

            $coupon->companies()->detach();
            $coupon->delete();

            AdminHelper::logPut('Coupon Deleted', MasterCouponModel::class, $coupon->id);

            return redirect()->route('admin.coupon.list')
                ->with('success', 'Coupon deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.coupon.list')
                ->with('error', 'Error deleting coupon: ' . $e->getMessage());
        }
    }

    public function settings(): View
    {
        setPageTitle('Coupon Settings');
        $coupons = MasterCouponModel::where('is_active', 1)
            ->where('is_deleted', 0)
            ->where('is_private', 1)
            ->orderBy('code')
            ->get();

        $setting = [
            'referrer_coupon_id' => AppSettingsModel::where('key', 'coupon_referrer_coupon_id')->value('value'),
            'referred_coupon_id' => AppSettingsModel::where('key', 'coupon_referred_coupon_id')->value('value'),
            'kyc_coupon_id'      => AppSettingsModel::where('key', 'coupon_kyc_coupon_id')->value('value'),
            'new_user_coupon_id' => AppSettingsModel::where('key', 'coupon_new_user_coupon_id')->value('value'),
        ];

        return view('admin.pages.coupon.settings', compact('setting', 'coupons'));
    }

    public function saveSettings(Request $request): RedirectResponse
    {
        $validation = Validator::make($request->all(), [
            'coupon_referrer_coupon_id' => ['nullable', 'exists:master_coupon,id'],
            'coupon_referred_coupon_id' => ['nullable', 'exists:master_coupon,id'],
            'coupon_kyc_coupon_id'      => ['nullable', 'exists:master_coupon,id'],
            'coupon_new_user_coupon_id' => ['nullable', 'exists:master_coupon,id'],
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->with('error', 'Validation failed.');
        }

        $keys = [
            'coupon_referrer_coupon_id',
            'coupon_referred_coupon_id',
            'coupon_kyc_coupon_id',
            'coupon_new_user_coupon_id',
        ];

        foreach ($keys as $key) {
            AppSettingsModel::where('key', $key)->update(['value' => $request->input($key) ?: null]);
        }

        AdminHelper::logPut('Coupon Settings Updated', AppSettingsModel::class, null);

        return redirect()->route('admin.coupon.settings')->with('success', 'Coupon settings saved successfully.');
    }

    // ─── ASSIGN TO INVESTORS ─────────────────────────────────────────────────

    public function assignPage(): View
    {
        setPageTitle('Assign Coupon to Investors');
        $coupons   = MasterCouponModel::where('is_active', 1)->where('is_deleted', 0)->orderBy('code')->get();
        $investors = InvestorModel::where('is_deleted', 0)->where('registration_step', 3)
            ->orderBy('name')->get(['id', 'name', 'mobile_number', 'email']);
        return view('admin.pages.coupon.assign', compact('coupons', 'investors'));
    }

    public function assignToInvestors(Request $request): RedirectResponse
    {
        $validation = Validator::make($request->all(), [
            'coupon_id'    => ['required', 'exists:master_coupon,id'],
            'investor_ids' => ['required', 'array', 'min:1'],
            'investor_ids.*' => ['exists:investor,id'],
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput()
                ->with('error', 'Please fix validation errors.');
        }

        $coupon = MasterCouponModel::findOrFail($request->coupon_id);
        if (!$coupon->is_private) {
            return redirect()->back()
                ->with('error', 'This is a public coupon. It is already visible to all investors and does not need to be manually assigned.');
        }
        $assigned = 0;
        $skipped  = 0;

        DB::beginTransaction();
        try {
            foreach ($request->investor_ids as $investorId) {
                $already = InvestorCouponModel::where('investor_id', $investorId)
                    ->where('coupon_id', $coupon->id)
                    ->whereIn('status', [
                        InvestorCouponStatusEnum::active->value,
                        InvestorCouponStatusEnum::assigned->value,
                    ])
                    ->exists();

                if ($already) {
                    $skipped++;
                    continue;
                }

                InvestorCouponModel::create([
                    'investor_id'  => $investorId,
                    'coupon_id'    => $coupon->id,
                    'referral_id'  => null,
                    'display_code' => null,
                    'reward_value' => null,
                    'status'       => InvestorCouponStatusEnum::active->value,
                    'assigned_at'  => now(),
                ]);
                $assigned++;
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()
                ->with('error', 'Error assigning coupons: ' . $e->getMessage());
        }

        $msg = "Coupon assigned to {$assigned} investor(s).";
        if ($skipped) {
            $msg .= " {$skipped} skipped (already assigned).";
        }

        return redirect()->route('admin.coupon.assign')->with('success', $msg);
    }
}
