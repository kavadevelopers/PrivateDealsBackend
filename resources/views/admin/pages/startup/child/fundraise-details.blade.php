<div class="card mb-5 mb-xl-10" id="kt_profile_details_view" id="pills-home">

    <div class="card-header cursor-pointer">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Fund Raise Details</h3>
        </div>
        <!--end::Card title-->
    </div>
    <div class="card-body p-9">
        <div class="row mb-7">
            <label class="col-lg-2 fw-semibold text-muted">Fund Requirement</label>
            <!--begin::Col-->
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">{{ $startup->StartupFundRaiseOne->fund_requirement }}</span>
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
        <div class="row mb-7">
            <label class="col-lg-2 fw-semibold text-muted">Committed Investors</label>
            <!--begin::Col-->
            <div class="col-lg-8 fv-row">
                @php
                    $committedInvestors = json_decode($startup->StartupFundRaiseOne->committed_investors, true);
                @endphp
                @if (is_array($committedInvestors) && count($committedInvestors) > 0)
                    <span class="fw-semibold text-gray-800 fs-6">{{ implode(', ', $committedInvestors) }}</span>
                @else
                    <span class="fw-semibold text-gray-800 fs-6"> No committed investors found.</span>
                @endif
            </div>
            <!--end::Col-->
        </div>
        <div class="row mb-7">
            <label class="col-lg-2 fw-semibold text-muted">
                Pre Money Valuation
            </label>
            <!--begin::Col-->
            <div class="col-lg-8 d-flex align-items-center">
                <span
                    class="fw-bold fs-6 text-gray-800 me-2">{{ $startup->StartupFundRaiseOne->pre_money_valuation }}</span>
            </div>
            <!--end::Col-->
        </div>
        <div class="row mb-7">
            <label class="col-lg-2 fw-semibold text-muted">Current Fund Raise</label>
            <!--begin::Col-->
            <div class="col-lg-8">
                <span
                    class="fw-semibold fs-6 text-gray-800 ">{{ $startup->StartupFundRaiseOne->current_fund_raise }}</span>
            </div>
            <!--end::Col-->
        </div>
        <div class="row mb-7">
            <label class="col-lg-2 fw-semibold text-muted">
                Funds Required From ShuruUp
            </label>
            <!--begin::Col-->
            <div class="col-lg-8">
                <span
                    class="fw-bold fs-6 text-gray-800">{{ $startup->StartupFundRaiseOne->funds_required_from_shuru }}</span>
            </div>
            <!--end::Col-->
        </div>
        <div class="row mb-7">
            <label class="col-lg-2 fw-semibold text-muted">Minimum Ticket Size</label>
            <!--begin::Col-->
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">{{ $startup->StartupFundRaiseOne->min_ticket_size }}</span>
            </div>
            <!--end::Col-->
        </div>
        <div class="row mb-10">
            <label class="col-lg-2 fw-semibold text-muted">Pre Money Valuation Basis</label>
            <div class="col-lg-8">
                <span
                    class="fw-bold fs-6 text-gray-800">{{ $startup->StartupFundRaiseOne->pre_money_valuation_basis }}</span>
            </div>
        </div>
        <div class="row mb-10">
            <label class="col-lg-2 fw-semibold text-muted">Instrument and Conversion Condition</label>
            <div class="col-lg-8">
                <span
                    class="fw-bold fs-6 text-gray-800">{{ $startup->StartupFundRaiseOne->instrument_and_conversion_condition }}</span>
            </div>
        </div>
        <div class="row mb-10">
            <label class="col-lg-2 fw-semibold text-muted">Fund Utilisation Details</label>
            <div class="col-lg-8">
                <span
                    class="fw-bold fs-6 text-gray-800">{{ $startup->StartupFundRaiseOne->fund_utilisation_details }}</span>
            </div>
        </div>
    </div>
</div>
