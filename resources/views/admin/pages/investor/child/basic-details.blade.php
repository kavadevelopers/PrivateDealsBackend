<div class="card mb-5 mb-xl-10" id="kt_profile_details_view" id="pills-home">

    <div class="card-header cursor-pointer">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Profile Details</h3>
        </div>
        <!--end::Card title-->
    </div>



    <div class="card-body p-9">

        <div class="row mb-7">

            <label class="col-lg-4 fw-semibold text-muted">Full Name</label>


            <!--begin::Col-->
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">{{ $investor->name }}</span>
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->


        <div class="row mb-7">

            <label class="col-lg-4 fw-semibold text-muted">Email</label>


            <!--begin::Col-->
            <div class="col-lg-8 fv-row">
                <span class="fw-semibold text-gray-800 fs-6">{{ $investor->email }}</span>
                @if ($investor->is_verified_email)
                    <span class="badge badge-success">Verified</span>
                @else
                    <span class="badge badge-danger">Not Verified</span>
                @endif
            </div>
            <!--end::Col-->
        </div>



        <div class="row mb-7">

            <label class="col-lg-4 fw-semibold text-muted">
                Mobile Number

                <span class="ms-1" data-bs-toggle="tooltip" aria-label="Phone number must be active"
                    data-bs-original-title="Phone number must be active" data-kt-initialized="1">
                    <i class="ki-duotone ki-information fs-7"><span class="path1"></span><span
                            class="path2"></span><span class="path3"></span></i> </span>
            </label>


            <!--begin::Col-->
            <div class="col-lg-8 d-flex align-items-center">
                <span
                    class="fw-bold fs-6 text-gray-800 me-2">+{{ $investor->mobile_country_code }}-{{ $investor->mobile_number }}</span>
                @if ($investor->is_verified_mobile)
                    <span class="badge badge-success">Verified</span>
                @else
                    <span class="badge badge-danger">Not Verified</span>
                @endif
            </div>
            <!--end::Col-->
        </div>



        <div class="row mb-7">

            <label class="col-lg-4 fw-semibold text-muted">Address</label>


            <!--begin::Col-->
            <div class="col-lg-8">
                <a href="#" class="fw-semibold fs-6 text-gray-800 text-hover-primary">{!! nl2br($investor->address) !!}</a>
            </div>
            <!--end::Col-->
        </div>



        <div class="row mb-7">

            <label class="col-lg-4 fw-semibold text-muted">
                Country

                <span class="ms-1" data-bs-toggle="tooltip" aria-label="Country of origination"
                    data-bs-original-title="Country of origination" data-kt-initialized="1">
                    <i class="ki-duotone ki-information fs-7"><span class="path1"></span><span
                            class="path2"></span><span class="path3"></span></i> </span>
            </label>


            <!--begin::Col-->
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">{{ $investor->country->name ?? 'N/A' }}</span>
            </div>
            <!--end::Col-->
        </div>



        <div class="row mb-7">

            <label class="col-lg-4 fw-semibold text-muted">State</label>


            <!--begin::Col-->
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">{{ $investor->state->name ?? 'N/A' }}</span>
            </div>
            <!--end::Col-->
        </div>



        <div class="row mb-10">

            <label class="col-lg-4 fw-semibold text-muted">City</label>



            <div class="col-lg-8">
                <span class="fw-semibold fs-6 text-gray-800">{{ $investor->city->name ?? 'N/A' }}</span>
            </div>

        </div>

        <div class="row mb-10">

            <label class="col-lg-4 fw-semibold text-muted">Manager Name</label>
            <div class="col-lg-8">
                <span class="fw-semibold fs-6 text-gray-800">{{ $investor->admin->name ?? 'N/A' }}</span>
            </div>

        </div>

    </div>

</div>
