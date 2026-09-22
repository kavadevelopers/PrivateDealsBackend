<div class="card mb-5 mb-xl-10">

    <div class="card-header cursor-pointer">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Legal Details</h3>
        </div>
        <!--end::Card title-->
    </div>
    <div class="card-body p-9">
        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">Company Name</label>
            <!--begin::Col-->
            <div class="col-lg-8 fv-row">
                <span class="fw-semibold text-gray-800 fs-6">{{ $startup->legalInfo->company_name }}</span>
            </div>
            <!--end::Col-->
        </div>
        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">Corporate Identification Number</label>
            <!--begin::Col-->
            <div class="col-lg-8 fv-row">
                <span class="fw-semibold text-gray-800 fs-6">{{ $startup->legalInfo->cin }}</span>
            </div>
            <!--end::Col-->
        </div>
        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">Corporate PAN Number</label>
            <!--begin::Col-->
            <div class="col-lg-8 fv-row">
                <span class="fw-semibold text-gray-800 fs-6">{{ $startup->legalInfo->company_pan }}</span>
            </div>
            <!--end::Col-->
        </div>
        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">Incorporation Date</label>
            <!--begin::Col-->
            <div class="col-lg-8 fv-row">
                <span
                    class="fw-semibold text-gray-800 fs-6">{{ DateTimeHelper::viewDate($startup->legalInfo->incorporation_date) }}</span>
            </div>
            <!--end::Col-->
        </div>
    </div>
</div>
