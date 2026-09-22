<div class="card mb-5 mb-xl-10" id="kt_profile_details_view" id="pills-home">
    <div class="card-header cursor-pointer">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Profile Details</h3>
        </div>
    </div>
    <div class="card-body p-9">
        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">Full Name</label>
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">{{ ucfirst($partner->name) }}</span>
            </div>
        </div>
        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">Email</label>
            <div class="col-lg-8 fv-row">
                <span class="fw-semibold text-gray-800 fs-6">{{ $partner->email }}</span>
                @if ($partner->is_verified_email)
                    <span class="badge badge-success">Verified</span>
                @else
                    <span class="badge badge-danger">Not Verified</span>
                @endif
            </div>
        </div>
        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">
                Mobile Number
                <span class="ms-1" data-bs-toggle="tooltip" aria-label="Phone number must be active"
                    data-bs-original-title="Phone number must be active" data-kt-initialized="1">
                    <i class="ki-duotone ki-information fs-7"><span class="path1"></span><span
                            class="path2"></span><span class="path3"></span></i> </span>
            </label>
            <div class="col-lg-8 d-flex align-items-center">
                <span
                    class="fw-bold fs-6 text-gray-800 me-2">+{{ $partner->mobile_country_code }}-{{ $partner->mobile_number }}</span>
                @if ($partner->is_verified_mobile)
                    <span class="badge badge-success">Verified</span>
                @else
                    <span class="badge badge-danger">Not Verified</span>
                @endif
            </div>
        </div>
    </div>
</div>
