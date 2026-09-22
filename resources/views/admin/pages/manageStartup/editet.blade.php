<x-default-layout>
    @section('title')
    {{ getPageTitle() }}
    @endsection

    <!-- @section('breadcrumbs')
    {{ Breadcrumbs::render('investor.edit') }}
    @endsection -->

    <div class="d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
        @if (isset($item))
        <div class="w-100 flex-lg-row-auto mb-7 me-7 me-lg-10">
            <form class="form" method="POST" action="{{ route('admin.startup.update', ['uuid' => $item->uuid]) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <h2 class="card-title">Basic Details</h2>
                    </div>
                    <div class="card-body pt-0">
                        <!-- Basic Details -->
                        <div class="row mb-7">
                            <div class="col-lg-6 fv-row">
                                <label class="required form-label">Company Name (Legal Name)</label>
                                <input name="company_name" class="form-control mb-2 input"
                                    placeholder="Enter Company Name" tabindex="0" type="text"
                                    value="{{ old('company_name', $item->company_name) }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'company_name',
                                ])
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="required form-label">Brand Name</label>
                                <input name="brand_name" class="form-control mb-2 input"
                                    placeholder="Enter Brand Name" tabindex="0" type="text"
                                    value="{{ old('brand_name', $item->brand_name) }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'brand_name',
                                ])
                            </div>
                        </div>
                        <div class="row mb-7">
                            <div class="col-lg-6 fv-row">
                                <label class="required form-label">Brief Description of Startup</label>
                                <textarea name="brief_description" class="form-control mb-2 input" placeholder="Enter Brief Description of Startup"
                                    tabindex="0">{{ old('brief_description', $list->startup->brief_information) }}</textarea>
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'brief_description',
                                ])
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="required form-label">Registered Address</label>
                                <textarea name="registered_address" class="form-control mb-2 input" placeholder="Enter Registered Address"
                                    tabindex="0">{{ old('registered_address', $list->startup->address) }}</textarea>
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'registered_address',
                                ])
                            </div>
                        </div>
                        <div class="row mb-7">
                            <div class="col-lg-6 fv-row">
                                <label class="required form-label">Email</label>
                                <input name="email" class="form-control mb-2 input" placeholder="Enter Email"
                                    tabindex="0" type="text" value="{{ old('email', $list->startup->email) }}">
                                @include('admin.partials.form.input-error-message', ['key' => 'email'])
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="required form-label">Website URL</label>
                                <input name="website_url" class="form-control mb-2 input"
                                    placeholder="Enter Website URL" tabindex="0" type="text"
                                    value="{{ old('website_url', $list->startup->details ? $list->startup->details->website_url : '') }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'website_url',
                                ])
                            </div>
                        </div>

                    </div>
                </div>
                <br />
                <!-- Fund Raise Details -->
                <div class="card card-flush py-4">
                    <div class="card-header mt-4">
                        <h2 class="card-title">Fund Raise Details</h2>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row mb-7">
                            <div class="col-lg-6 fv-row">
                                <label class="form-label">Fund Requirement</label>
                                <input name="fund_requirement" class="form-control mb-2 input"
                                    placeholder="Enter Fund Requirement" tabindex="0" type="text"
                                    value="{{ old('fund_requirement', $list->startup->StartupFundRaiseOne->fund_requirement) }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'fund_requirement',
                                ])
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="form-label">Valuation of previous round fund</label>
                                <input name="valuation_of_previous_round"
                                    class="form-control mb-2 input input-number-words input-decimal-number"
                                    placeholder="Enter Valuation of previous round fund" tabindex="0"
                                    type="text"
                                    value="{{ old('valuation_of_previous_round', $list->startup->StartupFundRaiseOne->valuation_of_previous_round) }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'valuation_of_previous_round',
                                ])
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="form-label">Committed Investors</label>
                                @php
                                $committedInvestors = json_decode(
                                $list->startup->StartupFundRaiseOne->committed_investors,
                                true,
                                );
                                @endphp
                                <input name="committed_investors" class="form-control mb-2 input"
                                    placeholder="Enter Committed Investors" tabindex="0" type="text"
                                    value="{{ old('committed_investors', is_array($committedInvestors) && count($committedInvestors) > 0 ? implode(', ', $committedInvestors) : '') }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'committed_investors',
                                ])
                            </div>
                        </div>
                        <div class="row mb-7">
                            <div class="col-lg-6 fv-row">
                                <label class="form-label">Pre Money Valuation</label>
                                <input name="pre_money_valuation" class="form-control mb-2 input"
                                    placeholder="Enter Pre Money Valuation" tabindex="0" type="text"
                                    value="{{ old('pre_money_valuation', $list->startup->StartupFundRaiseOne->pre_money_valuation) }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'pre_money_valuation',
                                ])
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="form-label">Current Fund Raise</label>
                                <input name="current_fund_raise" class="form-control mb-2 input"
                                    placeholder="Enter Current Fund Raise" tabindex="0" type="text"
                                    value="{{ old('current_fund_raise', $list->startup->StartupFundRaiseOne->current_fund_raise) }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'current_fund_raise',
                                ])
                            </div>
                        </div>
                        <div class="row mb-7">
                            <div class="col-lg-6 fv-row">
                                <label class="form-label">Funds Required From PrivateDeals</label>
                                <input name="funds_required_from_shuru" class="form-control mb-2 input"
                                    placeholder="Enter Funds Required From PrivateDeals" tabindex="0" type="text"
                                    value="{{ old('funds_required_from_shuru', $list->startup->StartupFundRaiseOne->funds_required_from_shuru) }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'funds_required_from_shuru',
                                ])
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="form-label">Minimum Ticket Size</label>
                                <input name="min_ticket_size" class="form-control mb-2 input"
                                    placeholder="Enter Minimum Ticket Size" tabindex="0" type="text"
                                    value="{{ old('min_ticket_size', $list->startup->StartupFundRaiseOne->min_ticket_size) }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'min_ticket_size',
                                ])
                            </div>
                        </div>
                        <div class="row mb-7">
                            <div class="col-lg-6 fv-row">
                                <label class="form-label">Pre Money Valuation Basis</label>
                                <input name="pre_money_valuation_basis" class="form-control mb-2 input"
                                    placeholder="Enter Pre Money Valuation Basis" tabindex="0" type="text"
                                    value="{{ old('pre_money_valuation_basis', $list->startup->StartupFundRaiseOne->pre_money_valuation_basis) }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'pre_money_valuation_basis',
                                ])
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="form-label">Instrument and Conversion Condition</label>
                                <input name="instrument_and_conversion_condition" class="form-control mb-2 input"
                                    placeholder="Enter Instrument and Conversion Condition" tabindex="0"
                                    type="text"
                                    value="{{ old('instrument_and_conversion_condition', $list->startup->StartupFundRaiseOne->instrument_and_conversion_condition) }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'instrument_and_conversion_condition',
                                ])
                            </div>
                        </div>
                        <div class="row mb-7">
                            <div class="col-lg-6 fv-row">
                                <label class="form-label">Fund Utilisation Details</label>
                                <input name="fund_utilisation_details" class="form-control mb-2 input"
                                    placeholder="Enter Fund Utilisation Details" tabindex="0" type="text"
                                    value="{{ old('fund_utilisation_details', $list->startup->StartupFundRaiseOne->fund_utilisation_details) }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'fund_utilisation_details',
                                ])
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="form-label">Share Price</label>
                                <input name="share_price" class="form-control mb-2 input"
                                    placeholder="Enter Share Price" tabindex="0" type="text"
                                    value="{{ old('share_price', $list->startup->lastRounds->share_price) }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'share_price',
                                ])
                            </div>
                        </div>
                        <div class="row mb-7">
                            <div class="col-lg-6 fv-row">
                                <label class="form-label">Equity Offered</label>
                                <input name="equity_offered" class="form-control mb-2 input input-decimal-number"
                                    placeholder="Enter Fund Utilisation Details" tabindex="0" type="text"
                                    value="{{ old('equity_offered', $list->startup->StartupOtherOne ? $list->startup->StartupOtherOne->equity_offered : '') }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'equity_offered',
                                ])
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="form-label">Incorporation Date</label>
                                <input name="incorporation_date" class="form-control mb-2 input"
                                    placeholder="Enter Incorporation Date" tabindex="0" type="date"
                                    value="{{ old('incorporation_date', $list->startup->legalInfo ? Carbon\Carbon::parse($list->startup->legalInfo->incorporation_date)->format('Y-m-d') : '') }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'incorporation_date',
                                ])
                            </div>
                        </div>
                        <div class="row mb-7">
                            <div class="col-lg-6 fv-row">
                                <label class="form-label">CIN</label>
                                <input name="cin" class="form-control mb-2 input" placeholder="Enter CIN"
                                    tabindex="0" type="text"
                                    value="{{ old('cin', $list->startup->legalInfo ? $list->startup->legalInfo->cin : '') }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'cin',
                                ])
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="form-label">SSA ID</label>
                                <input name="ssa_id" class="form-control mb-2 input" placeholder="Enter SSA ID"
                                    tabindex="0" type="text"
                                    value="{{ old('ssa_id', $list->startup->StartupOtherOne ? $list->startup->StartupOtherOne->ssa_id : '') }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'ssa_id',
                                ])
                            </div>
                        </div>
                        <div class="row mb-7">
                            <div class="col-lg-6 fv-row">
                                <label class="form-label">SSA Sign Coordinates</label>
                                <input name="ssa_sign_coordinates" class="form-control mb-2 input"
                                    placeholder="Enter SSA ID" tabindex="0" type="text"
                                    value="{{ old('ssa_sign_coordinates', $list->startup->StartupOtherOne ? $list->startup->StartupOtherOne->ssa_sign_coordinates : '') }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'ssa_sign_coordinates',
                                ])
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="form-label">Offer ID</label>
                                <input name="offer_id" class="form-control mb-2 input"
                                    placeholder="Enter Offer ID" tabindex="0" type="text"
                                    value="{{ old('offer_id', $list->startup->StartupOtherOne ? $list->startup->StartupOtherOne->offer_id : '') }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'offer_id',
                                ])
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="form-label">Offer Sign Coordinates</label>
                                <input name="offer_sign_coordinates" class="form-control mb-2 input"
                                    placeholder="Enter Offer Sign Coordinates" tabindex="0" type="text"
                                    value="{{ old('offer_sign_coordinates', $list->startup->StartupOtherOne ? $list->startup->StartupOtherOne->offer_sign_coordinates : '') }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'offer_sign_coordinates',
                                ])
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="form-label">Floor</label>
                                <input name="floor" class="form-control mb-2 input" placeholder="Enter Floor"
                                    tabindex="0" type="text"
                                    value="{{ old('floor', $list->startup->StartupOtherOne ? $list->startup->StartupOtherOne->floor : '') }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'floor',
                                ])
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="form-label">Cap</label>
                                <input name="cap" class="form-control mb-2 input" placeholder="Enter Cap"
                                    tabindex="0" type="text"
                                    value="{{ old('cap', $list->startup->StartupOtherOne ? $list->startup->StartupOtherOne->cap : '') }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'cap',
                                ])
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="form-label">Instrument</label>
                                <select class="form-select" name="instrument" aria-label="Select example">
                                    <option value="">Select Instrument</option>
                                    @foreach (App\Enums\InstrumentTypeEnum::cases() as $type)
                                    <option value="{{ $type->value }}"
                                        {{ old('instrument', $list->startup->lastRounds ? $list->startup->lastRounds->instrument : '') == $type->value ? 'selected' : '' }}>
                                        {{ $type->value }}
                                    </option>
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'instrument',
                                ])
                            </div>
                        </div>
                    </div>
                </div><br />
                <div class="card card-flush py-4">
                    <!-- Key Metrics Details -->
                    <div class="card-header mt-4">
                        <h2 class="card-title">Key Metrics Details</h2>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row mb-7">
                            <div class="col-lg-6 fv-row">
                                <label class="required form-label">Founder Capital Contribution</label>
                                <input name="founder_capital_contribution" class="form-control mb-2 input"
                                    placeholder="Enter Founder Capital Contribution" tabindex="0"
                                    type="text"
                                    value="{{ old('founder_capital_contribution', $list->startup->StartupKeyMetricsOne->founder_capital_contribution) }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'founder_capital_contribution',
                                ])
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="required form-label">Monthly Revenue Run Rate</label>
                                <input name="monthly_revenue_run_rate" class="form-control mb-2 input"
                                    placeholder="Enter Monthly Revenue Run Rate" tabindex="0" type="text"
                                    value="{{ old('monthly_revenue_run_rate', $list->startup->StartupKeyMetricsOne->monthly_revenue_run_rate) }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'monthly_revenue_run_rate',
                                ])
                            </div>
                        </div>
                        <div class="row mb-7">
                            <div class="col-lg-6 fv-row">
                                <label class="required form-label">Annualized Revenue Run Rate</label>
                                <input name="annualized_revenue_run_rate" class="form-control mb-2 input"
                                    placeholder="Enter Annualized Revenue Run Rate" tabindex="0" type="text"
                                    value="{{ old('annualized_revenue_run_rate', $list->startup->StartupKeyMetricsOne->annualized_revenue_run_rate) }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'annualized_revenue_run_rate',
                                ])
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="required form-label">Current Monthly Burn</label>
                                <input name="current_monthly_burn" class="form-control mb-2 input"
                                    placeholder="Enter Current Monthly Burn" tabindex="0" type="text"
                                    value="{{ old('current_monthly_burn', $list->startup->StartupKeyMetricsOne->current_monthly_burn) }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'current_monthly_burn',
                                ])
                            </div>
                        </div>
                        <div class="row mb-7">
                            <div class="col-lg-6 fv-row">
                                <label class="required form-label">Current Cash Balance</label>
                                <input name="current_cash_balance" class="form-control mb-2 input"
                                    placeholder="Enter Current Cash Balance" tabindex="0" type="text"
                                    value="{{ old('current_cash_balance', $list->startup->StartupKeyMetricsOne->current_cash_balance) }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'current_cash_balance',
                                ])
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="required form-label">Runway Months</label>
                                <input name="runway_months" class="form-control mb-2 input"
                                    placeholder="Enter Runway Months" tabindex="0" type="text"
                                    value="{{ old('runway_months', $list->startup->StartupKeyMetricsOne->runway_months) }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'runway_months',
                                ])
                            </div>
                        </div>
                        <div class="row mb-7">
                            <div class="col-lg-6 fv-row">
                                <label class="required form-label">Traction Metrics</label>
                                <input name="traction_metrics" class="form-control mb-2 input"
                                    placeholder="Enter Traction Metrics" tabindex="0" type="text"
                                    value="{{ old('traction_metrics', $list->startup->StartupKeyMetricsOne->traction_metrics) }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'traction_metrics',
                                ])
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="required form-label">Key USP Differentiator Entry Barrier</label>
                                <input name="key_usp_differentiator_entry_barrier" class="form-control mb-2 input"
                                    placeholder="Enter Key USP Differentiator Entry Barrier" tabindex="0"
                                    type="text"
                                    value="{{ old('key_usp_differentiator_entry_barrier', $list->startup->StartupKeyMetricsOne->key_usp_differentiator_entry_barrier) }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'key_usp_differentiator_entry_barrier',
                                ])
                            </div>
                        </div>
                        <div class="row mb-7">
                            <div class="col-lg-6 fv-row">
                                <label class="required form-label">Competitors</label>
                                <input name="competitors" class="form-control mb-2 input"
                                    placeholder="Enter Competitors" tabindex="0" type="text"
                                    value="{{ old('competitors', $list->startup->StartupKeyMetricsOne->competitors) }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'competitors',
                                ])
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="required form-label">Primary Round Status</label>
                                <select name="primary_round_status" class="form-control mb-2 input"
                                    tabindex="0">
                                    @foreach (\App\Enums\StartupPrimaryRoundStatusEnum::cases() as $status)
                                    <option value="{{ $status->value }}"
                                        {{ old('primary_round_status', $list->startup->lastRounds->round_status ?? '') === $status->value ? 'selected' : '' }}>
                                        {{ ucfirst($status->value) }}
                                    </option>
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'primary_round_status',
                                ])
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <!-- Financial Details -->
                <div class="card card-flush py-4">
                    <div class="card-header mt-4">
                        <h2 class="card-title">Financial Details</h2>
                    </div>
                    <div class="card-body pt-0">
                        <div class="collapsible-content" id="postFundRaiseDetails">
                            <div class="all_field">
                                <div class="group">
                                    <h3><span>Enter financial details for the current financial year</span></h3>
                                </div>
                                <div class="repeater" id="fund-raises">
                                    @foreach ($financialDetails['previous'] as $index => $detail)
                                    <div class="repeater-item">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="field_group">

                                                    <label
                                                        for="previous_raised_year_{{ $index }}">Year<span
                                                            class="required">*</span></label>
                                                    <input class="field" type="number"
                                                        name="previous_raised_year[]"
                                                        value="{{ $detail['year'] }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="field_group">
                                                    <label for="net_revenue_{{ $index }}">Net
                                                        Revenue<span class="required">*</span></label>
                                                    <input class="field" type="number" name="net_revenue[]"
                                                        value="{{ $detail['net_revenue'] }}"
                                                        placeholder="Enter Net Revenue" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="field_group">
                                                    <label for="ebitda_{{ $index }}">EBITDA<span
                                                            class="required">*</span></label>
                                                    <input class="field" type="number" name="ebitda[]"
                                                        value="{{ $detail['ebitda'] }}"
                                                        placeholder="Enter EBITDA" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="field_group">
                                                    <label for="pat_{{ $index }}">PAT<span
                                                            class="required">*</span></label>
                                                    <input class="field" type="number" name="pat[]"
                                                        value="{{ $detail['pat'] }}" placeholder="Enter PAT"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-actions">
                                                    <button type="button" class="btn btn-danger remove-item">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-primary add-item">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="group">
                                    <h3><span>Enter post fund raise financial details</span></h3>
                                </div>
                                <div id="post-financial-details">
                                    @foreach ($financialDetails['post'] as $index => $detail)
                                    <div class="repeater-item">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="field_group">
                                                    <label
                                                        for="post_raised_year_{{ $index }}">Year<span
                                                            class="required">*</span></label>
                                                    <input class="field" type="number"
                                                        name="post_raised_year[]"
                                                        value="{{ $detail['year'] }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="field_group">
                                                    <label for="revenue_expected_{{ $index }}">Expected
                                                        Revenue (in Rs Cr)<span
                                                            class="required">*</span></label>
                                                    <input class="field" type="number"
                                                        name="revenue_expected[]"
                                                        value="{{ $detail['revenue_expected'] }}"
                                                        placeholder="Enter revenue expected" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="field_group">
                                                    <label
                                                        for="current_fy_closing_ebitda_{{ $index }}">Current
                                                        FY closing EBITDA<span
                                                            class="required">*</span></label>
                                                    <input class="field" type="number"
                                                        name="current_fy_closing_ebitda[]"
                                                        value="{{ $detail['current_fy_closing_ebitda'] }}"
                                                        placeholder="Enter closing EBITDA" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="field_group">
                                                    <label
                                                        for="current_fy_closing_pat_{{ $index }}">Current
                                                        FY closing PAT<span class="required">*</span></label>
                                                    <input class="field" type="number"
                                                        name="current_fy_closing_pat[]"
                                                        value="{{ $detail['current_fy_closing_pat'] }}"
                                                        placeholder="Enter closing PAT" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="field_group">
                                                    <label for="next_fy_revenue_{{ $index }}">Next FY
                                                        revenue<span class="required">*</span></label>
                                                    <input class="field" type="number"
                                                        name="next_fy_revenue[]"
                                                        value="{{ $detail['next_fy_revenue'] }}"
                                                        placeholder="Enter next FY revenue" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="field_group">
                                                    <label for="next_fy_expense_{{ $index }}">Next FY
                                                        expense<span class="required">*</span></label>
                                                    <input class="field" type="number"
                                                        name="next_fy_expense[]"
                                                        value="{{ $detail['next_fy_expense'] }}"
                                                        placeholder="Enter next FY expense" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="field_group">
                                                    <label for="next_fy_ebitda_{{ $index }}">Next FY
                                                        EBITDA<span class="required">*</span></label>
                                                    <input class="field" type="number"
                                                        name="next_fy_ebitda[]"
                                                        value="{{ $detail['next_fy_ebitda'] }}"
                                                        placeholder="Enter next FY EBITDA" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="field_group">
                                                    <label for="next_fy_pat_{{ $index }}">Next FY
                                                        PAT<span class="required">*</span></label>
                                                    <input class="field" type="number" name="next_fy_pat[]"
                                                        value="{{ $detail['next_fy_pat'] }}"
                                                        placeholder="Enter next FY PAT" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-actions">
                                                    <button type="button" class="btn btn-danger remove-item">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-primary add-item">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Financial Details -->
                <br />
                <!---- Other Details ---->
                <div class="card card-flush py-4">
                    <!-- Key Metrics Details -->
                    <div class="card-header mt-4">
                        <h2 class="card-title">Other Details</h2>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row mb-7">
                            <div class="col-lg-6 fv-row">
                                <label class="required form-label">Number of Founders</label>
                                <input name="number_of_founders" class="form-control mb-2 input"
                                    placeholder="Enter Number of Founders" tabindex="0" type="number"
                                    value="{{ old('number_of_founders', $list->startup->StartupOtherOne ? $list->startup->StartupOtherOne->number_of_founders : '') }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'number_of_founders',
                                ])
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="required form-label">Name of Founder</label>
                                <input name="name_of_founder" class="form-control mb-2 input"
                                    placeholder="Enter Name of Founder" tabindex="0" type="text"
                                    value="{{ old('name_of_founder', $list->startup->StartupOtherOne ? $list->startup->StartupOtherOne->name_of_founder : '') }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'name_of_founder',
                                ])
                            </div>
                        </div>
                        <div class="row mb-7">
                            <div class="col-lg-6 fv-row">
                                <label class="required form-label">Age</label>
                                <input name="age" class="form-control mb-2 input" placeholder="Enter Age"
                                    tabindex="0" type="number"
                                    value="{{ old('age', $list->startup->StartupOtherOne ? $list->startup->StartupOtherOne->age : '') }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'age',
                                ])
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="required form-label">Education Qualification</label>
                                <input name="education_qualification" class="form-control mb-2 input"
                                    placeholder="Enter Education Qualification" tabindex="0" type="text"
                                    value="{{ old('education_qualification', $list->startup->StartupOtherOne ? $list->startup->StartupOtherOne->education_qualification : '') }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'education_qualification',
                                ])
                            </div>
                        </div>
                        <div class="row mb-7">
                            <div class="col-lg-6 fv-row">
                                <label class="required form-label">Work Experience</label>
                                <input name="work_exp" class="form-control mb-2 input"
                                    placeholder="Enter Work Experience" tabindex="0" type="text"
                                    value="{{ old('work_exp', $list->startup->StartupOtherOne ? $list->startup->StartupOtherOne->work_exp : '') }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'work_exp',
                                ])
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="required form-label">Startup Failures/Successful Exits</label>
                                <input name="startup_failures_successful_exits" class="form-control mb-2 input"
                                    placeholder="Enter Startup Failures/Successful Exits" tabindex="0"
                                    type="text"
                                    value="{{ old('startup_failures_successful_exits', $list->startup->StartupOtherOne ? $list->startup->StartupOtherOne->startup_failures_successful_exits : '') }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'startup_failures_successful_exits',
                                ])
                            </div>
                        </div>
                        <div class="row mb-7">
                            <div class="col-lg-6 fv-row">
                                <label class="required form-label">Pitch Deck</label>
                                <input name="pitch_deck_file" class="form-control mb-2 input"
                                    placeholder="Enter Pitch Deck" tabindex="0" type="text"
                                    value="{{ old('pitchdeck', $list->startup->StartupOtherOne ? $list->startup->StartupOtherOne->pitchdeck : '') }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'pitchdeck',
                                ])
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="required form-label">Financial Model</label>
                                <input name="financial_model" class="form-control mb-2 input"
                                    placeholder="Enter Financial Model" tabindex="0" type="text"
                                    value="{{ old('financial_model', $list->startup->StartupOtherOne ? $list->startup->StartupOtherOne->financial_model : '') }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'financial_model',
                                ])
                            </div>
                        </div>
                        <div class="row mb-7">
                            <div class="col-lg-6 fv-row">
                                <label class="required form-label">Founder Email ID</label>
                                <input name="founder_email_id" class="form-control mb-2 input"
                                    placeholder="Enter Founder Email ID" tabindex="0" type="email"
                                    value="{{ old('founder_email_id', $list->startup->StartupOtherOne ? $list->startup->StartupOtherOne->founder_email_id : '') }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'founder_email_id',
                                ])
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="required form-label">Founder Contact Number</label>
                                <input name="founder_contact_number" class="form-control mb-2 input"
                                    placeholder="Enter Founder Contact Number" tabindex="0" type="text"
                                    value="{{ old('founder_contact_number', $list->startup->StartupOtherOne ? $list->startup->StartupOtherOne->founder_contact_number : '') }}">
                                @include('admin.partials.form.input-error-message', [
                                'key' => 'founder_contact_number',
                                ])
                            </div>
                        </div>
                    </div>
                </div>
                <!---- End Other Details ---->
                <br />
                <!-- Highlights -->
                <div class="card card-flush py-4">
                    <div class="card-header mt-4">
                        <h2 class="card-title">Highlights</h2>
                    </div>
                    <div class="card-body pt-0">
                        <textarea id="highlights" name="highlights" class="form-control mb-2 input kt_docs_tinymce_basic"
                            placeholder="Enter Highlights" tabindex="0">{{ old('highlights', $list->startup->StartupOtherOne->highlights ?? '') }}</textarea>
                        <div class="text-muted fs-7">Set the long description of the highlights.</div>
                        <div
                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                </div>
                <!-- End Highlights -->
                <br />

                <!-- Idea -->
                <div class="card card-flush py-4">
                    <div class="card-header mt-4">
                        <h2 class="card-title">Idea</h2>
                    </div>
                    <div class="card-body pt-0">
                        <textarea id="idea" name="idea" class="form-control mb-2 input kt_docs_tinymce_basic"
                            placeholder="Enter Idea" tabindex="0">{{ old('idea', $list->startup->StartupOtherOne->idea ?? '') }}</textarea>
                        <div class="text-muted fs-7">Set the long description of the idea.</div>
                        <div
                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                </div>
                <!-- End Idea -->
                <br />

                <!-- Key Information -->
                <div class="card card-flush py-4">
                    <div class="card-header mt-4">
                        <h2 class="card-title">Key Information</h2>
                    </div>
                    <div class="card-body pt-0">
                        <textarea id="key_information" name="key_information" class="form-control mb-2 input kt_docs_tinymce_basic"
                            placeholder="Enter Key Information" tabindex="0">{{ old('key_information', $list->startup->StartupOtherOne->key_information ?? '') }}</textarea>
                        <div class="text-muted fs-7">Set the long description of the key information.</div>
                        <div
                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                </div>
                <!-- End Key Information -->
                <br />

                <!-- FAQ Section -->
                <div class="card card-flush py-4">
                    <div class="card-header mt-4">
                        <h2 class="card-title">FAQs</h2>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Question</th>
                                            <th>Answer</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyFaqs">
                                        @foreach ($item->faqs as $index => $faq)
                                        <tr>
                                            <td>
                                                <input name="question[]" type="text" class="form-control"
                                                    value="{{ old('question.' . $index, $faq->question) }}"
                                                    placeholder="Question" required>
                                            </td>
                                            <td>
                                                <textarea name="answer[]" class="form-control" placeholder="Answer" required>{{ old('answer.' . $index, $faq->answer) }}</textarea>
                                            </td>
                                            <td class="text-center">
                                                <button type="button"
                                                    class="btn btn-mini btn-danger btnDeleteFaq"
                                                    title="remove">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-right">
                                                <button type="button"
                                                    class="btn btn-mini btn-primary btn-outline-primary"
                                                    id="btnAddFaq">
                                                    <i class="fa fa-plus"></i> Add FAQ row
                                                </button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End FAQ Section -->
                <br />

                <!-- Main Details Section -->
                <div class="card card-flush py-4">
                    <div class="card-header mt-4">
                        <h2 class="card-title">Main Details</h2>
                    </div>
                    <div class="card-body pt-0">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="required form-label">Logo</label>
                                        <label class="change-logo-lable">
                                            <input type="file" class="form-control" name="logo">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="required form-label">Banner</label>
                                        <label class="change-logo-lable">
                                            <input type="file" class="form-control" name="banner">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="required form-label">Long Banner</label>
                                        <label class="change-logo-lable">
                                            <input type="file" class="form-control" name="long_banner">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="required form-label">Product Video</label>
                                        <input type="file" name="product_video" class="form-control"
                                            onchange="fileExAllowedVideo(this,'.mkv,.mp4,.avi')">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="required form-label">Pitch Video</label>
                                        <input type="file" name="pitch_video" class="form-control"
                                            onchange="fileExAllowedVideo(this,'.mkv,.mp4,.avi')">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="required form-label">Short Description</label>
                                        <textarea name="short_description" class="form-control" placeholder="Short Description" required>{{ old('short_description', $shortDescription ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Main Details Section -->
                <br />

                <!-- Documents Section -->
                <div class="card card-flush py-4">
                    <div class="card-header mt-4">
                        <h2 class="card-title">Documents</h2>
                    </div>
                    <div class="card-body pt-0">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="required form-label">Pitch-deck</label>
                                        <label class="change-logo-lable">
                                            <input type="file" class="form-control" name="pitch_deck_file"
                                                onchange="fileExAllowedWithSize(this,'.pdf,.xlsx,.csv','{{ CommonHelper::appSettings('file_document_max_size') }}')">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="required form-label">Financial Projections</label>
                                        <label class="change-logo-lable">
                                            <input type="file" class="form-control" name="fina_projection"
                                                onchange="fileExAllowedWithSize(this,'.pdf,.xlsx,.csv','{{ CommonHelper::appSettings('file_document_max_size') }}')">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="required form-label">DD Report</label>
                                        <input type="file" name="dd_report" class="form-control"
                                            onchange="fileExAllowedWithSize(this,'.pdf,.xlsx,.csv','{{ CommonHelper::appSettings('file_document_max_size') }}')">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="required form-label">DIPP Start-up Certificate</label>
                                        <input type="file" name="dpiit_file" class="form-control"
                                            onchange="fileExAllowedWithSize(this,'.pdf,.xlsx,.csv','{{ CommonHelper::appSettings('file_document_max_size') }}')">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="required form-label">PrivateDeals Research Report</label>
                                        <input type="file" name="shuruup_research_report" class="form-control"
                                            onchange="fileExAllowedWithSize(this,'.pdf,.xlsx,.csv','{{ CommonHelper::appSettings('file_document_max_size') }}')">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="required form-label">Valuation Report</label>
                                        <input type="file" name="valuation_report" class="form-control"
                                            onchange="fileExAllowedWithSize(this,'.pdf,.xlsx,.csv','{{ CommonHelper::appSettings('file_document_max_size') }}')">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Documents Section -->
                <br />

                <!-- Social Media Links Section -->
                <div class="card card-flush py-4">
                    <div class="card-header mt-4">
                        <h2 class="card-title">Social Media Links</h2>
                    </div>
                    <div class="card-body pt-0">
                        <div class="card-block">
                            <div class="row">
                                @foreach ($socialMediaLinks as $socialMedia)
                                @php
                                $soItem = App\Models\StartupSocialMediaModel::where(
                                'master_socialmedia_link_id',
                                $socialMedia->id,
                                )
                                ->where('startup_id', $list->startup->id)
                                ->first();
                                @endphp
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">{{ $socialMedia->name }} URL</label>
                                        <input type="text" name="{{ $socialMedia->id }}_url"
                                            class="form-control"
                                            placeholder="Enter {{ $socialMedia->name }} URL"
                                            value="{{ old($socialMedia->id . '_url', $soItem ? $soItem->link : '') }}">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Social Media Links Section -->

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ url()->previous() }}" class="btn btn-light me-3">Cancel</a>
                    <button type="submit" id="kt_ecommerce_edit_order_submit" class="btn btn-primary">
                        <span class="indicator-label">Update</span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
        </div>
    </div>
    </div>
    </form>
    </div>
    @endif
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            function addNewItem(containerId) {
                let container = $('#' + containerId);
                let newItem = container.children('.repeater-item:first').clone();
                newItem.find('input').val('');
                container.append(newItem);
            }

            function removeItem(button) {
                let item = button.closest('.repeater-item');
                if (item.siblings().length > 0) {
                    item.remove();
                } else {
                    alert('At least one item is required.');
                }
            }

            function addNewItem(containerId) {
                let container = $('#' + containerId);
                let newItem = container.children('.repeater-item:first').clone();

                // Clear values of new item inputs
                newItem.find('input').each(function() {
                    $(this).val('');
                });

                // Increment the year values for new items if necessary
                let baseYear = new Date().getFullYear();
                let newYear = baseYear + container.children('.repeater-item').length;
                newItem.find('input[name$="year[]"]').val(newYear);

                container.append(newItem);
            }

            function removeItem(button) {
                let item = button.closest('.repeater-item');
                if (item.siblings().length > 0) {
                    item.remove();
                } else {
                    alert('At least one item is required.');
                }
            }

            // Add item
            $(document).on('click', '.add-item', function() {
                let containerId = $(this).closest('.repeater').attr('id');
                addNewItem(containerId);
            });

            // Remove item
            $(document).on('click', '.remove-item', function() {
                removeItem($(this));
            });

        });
        document.addEventListener('DOMContentLoaded', function() {
            // Add new FAQ row
            document.getElementById('btnAddFaq').addEventListener('click', function() {
                const tbody = document.getElementById('tbodyFaqs');
                const index = tbody.children.length;
                const newRow = `
                    <tr>
                        <td>
                            <input name="question[]" type="text" class="form-control" placeholder="Question" required>
                        </td>
                        <td>
                            <textarea name="answer[]" class="form-control" placeholder="Answer" required></textarea>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-mini btn-danger btnDeleteFaq" title="remove">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                tbody.insertAdjacentHTML('beforeend', newRow);
            });

            // Remove FAQ row
            document.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('btnDeleteFaq')) {
                    e.target.closest('tr').remove();
                }
            });
        });
    </script>
    @endpush
</x-default-layout>