<div class="card mb-5 mb-xl-10" id="kt_profile_details_view" id="pills-home">

    <div class="card-header cursor-pointer">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Key Metrics Details</h3>
        </div>
        <!--end::Card title-->
    </div>
    <div class="card-body p-9">
        <div class="row mb-7">
            <label class="col-lg-2 fw-semibold text-muted">Founder Capital Contribution</label>
            <!--begin::Col-->
            <div class="col-lg-8">
                <span
                    class="fw-bold fs-6 text-gray-800">{{ $startup->StartupKeyMetricsOne->founder_capital_contribution }}</span>
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
        <div class="row mb-7">
            <label class="col-lg-2 fw-semibold text-muted">Monthly Revenue Run Rate</label>
            <!--begin::Col-->
            <div class="col-lg-8 fv-row">
                <span
                    class="fw-bold fs-6 text-gray-800">{{ $startup->StartupKeyMetricsOne->monthly_revenue_run_rate }}</span>
            </div>
            <!--end::Col-->
        </div>
        <div class="row mb-7">
            <label class="col-lg-2 fw-semibold text-muted">
                Annualized Revenue Run Rate
            </label>
            <!--begin::Col-->
            <div class="col-lg-8 d-flex align-items-center">
                <span
                    class="fw-bold fs-6 text-gray-800 me-2">{{ $startup->StartupKeyMetricsOne->annualized_revenue_run_rate }}</span>
            </div>
            <!--end::Col-->
        </div>
        <div class="row mb-7">
            <label class="col-lg-2 fw-semibold text-muted">Current Monthly Burn</label>
            <!--begin::Col-->
            <div class="col-lg-8">
                <span
                    class="fw-semibold fs-6 text-gray-800 ">{{ $startup->StartupKeyMetricsOne->current_monthly_burn }}</span>
            </div>
            <!--end::Col-->
        </div>
        <div class="row mb-7">
            <label class="col-lg-2 fw-semibold text-muted">
                Current Cash Balance
            </label>
            <!--begin::Col-->
            <div class="col-lg-8">
                <span
                    class="fw-bold fs-6 text-gray-800">{{ $startup->StartupKeyMetricsOne->current_cash_balance }}</span>
            </div>
            <!--end::Col-->
        </div>
        <div class="row mb-7">
            <label class="col-lg-2 fw-semibold text-muted">Runway Months</label>
            <!--begin::Col-->
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">{{ $startup->StartupKeyMetricsOne->runway_months }}</span>
            </div>
            <!--end::Col-->
        </div>
        <div class="row mb-10">
            <label class="col-lg-2 fw-semibold text-muted">Traction Metrics</label>
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">{{ $startup->StartupKeyMetricsOne->traction_metrics }}</span>
            </div>
        </div>
        <div class="row mb-10">
            <label class="col-lg-2 fw-semibold text-muted">Key USP Differentiator Entry Barrier</label>
            <div class="col-lg-8">
                <span
                    class="fw-bold fs-6 text-gray-800">{{ $startup->StartupKeyMetricsOne->key_usp_differentiator_entry_barrier }}</span>
            </div>
        </div>
        <div class="row mb-10">
            <label class="col-lg-2 fw-semibold text-muted">Competitors</label>
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">{{ $startup->StartupKeyMetricsOne->competitors }}</span>
            </div>
        </div>
    </div>
</div>
