<div class="card mb-5 mb-xl-10">

    <div class="card-header cursor-pointer">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Basic Details</h3>
        </div>
        <!--end::Card title-->
    </div>
    <div class="card-body p-9">
        <div class="row mb-7">
            <label class="col-lg-2 fw-semibold text-muted">Email</label>
            <!--begin::Col-->
            <div class="col-lg-8 fv-row">
                <span class="fw-semibold text-gray-800 fs-6">{{ $startup->email }}</span>
            </div>
            <!--end::Col-->
        </div>
        <div class="row mb-7">
            <label class="col-lg-2 fw-semibold text-muted">
                Mobile Number
                <span class="ms-1" data-bs-toggle="tooltip" aria-label="Phone number must be active"
                    data-bs-original-title="Phone number must be active" data-kt-initialized="1">
                    <i class="ki-duotone ki-information fs-7"><span class="path1"></span><span
                            class="path2"></span><span class="path3"></span></i> </span>
            </label>
            <!--begin::Col-->
            <div class="col-lg-8 d-flex align-items-center">
                <span
                    class="fw-bold fs-6 text-gray-800 me-2">+{{ $startup->mobile_country_code }}-{{ $startup->mobile_number }}</span>
            </div>
            <!--end::Col-->
        </div>
        <div class="row mb-7">
            <label class="col-lg-2 fw-semibold text-muted">Address</label>
            <!--begin::Col-->
            <div class="col-lg-8">
                <span class="fw-semibold fs-6 text-gray-800 ">{{ $startup->address }}</span>
            </div>
            <!--end::Col-->
        </div>
        <div class="row mb-7">
            <label class="col-lg-2 fw-semibold text-muted">Pincode</label>
            <!--begin::Col-->
            <div class="col-lg-8">
                <span class="fw-semibold fs-6 text-gray-800 ">{{ $startup->pincode }}</span>
            </div>
            <!--end::Col-->
        </div>
        <div class="row mb-7">
            <label class="col-lg-2 fw-semibold text-muted">
                Country
                <span class="ms-1" data-bs-toggle="tooltip" aria-label="Country of origination"
                    data-bs-original-title="Country of origination" data-kt-initialized="1">
                    <i class="ki-duotone ki-information fs-7"><span class="path1"></span><span
                            class="path2"></span><span class="path3"></span></i> </span>
            </label>
            <!--begin::Col-->
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">{{ $startup->country->name }}</span>
            </div>
            <!--end::Col-->
        </div>
        <div class="row mb-7">
            <label class="col-lg-2 fw-semibold text-muted">State</label>
            <!--begin::Col-->
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">{{ $startup->state->name }}</span>
            </div>
            <!--end::Col-->
        </div>
        <div class="row mb-10">
            <label class="col-lg-2 fw-semibold text-muted">City</label>
            <div class="col-lg-8">
                <span class="fw-semibold fs-6 text-gray-800">{{ $startup->city->name }}</span>
            </div>
        </div>
    </div>
</div>
