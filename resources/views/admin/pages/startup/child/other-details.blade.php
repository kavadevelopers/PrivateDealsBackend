@if ($startup->StartupOtherOne)
    <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
        <div class="card-header cursor-pointer">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Founder Details</h3>
            </div>
            <!--end::Card title-->
        </div>
        <div class="card-body p-9">
            <!-- Display Founder Details -->
            {{-- <div class="row mb-7">
            <label class="col-lg-2 fw-semibold text-muted">Startup ID</label>
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">{{ $startup->StartupOtherOne->startup_id }}</span>
            </div>
        </div> --}}
            {{-- <div class="row mb-7">
            <label class="col-lg-2 fw-semibold text-muted">Round ID</label>
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">{{ $startup->StartupOtherOne->round_id }}</span>
            </div>
        </div> --}}
            <div class="row mb-7">
                <label class="col-lg-2 fw-semibold text-muted">Number of Founders</label>
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $startup->StartupOtherOne->number_of_founders }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-2 fw-semibold text-muted">Name of Founder</label>
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $startup->StartupOtherOne->name_of_founder }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-2 fw-semibold text-muted">Age</label>
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $startup->StartupOtherOne->age }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-2 fw-semibold text-muted">Education Qualification</label>
                <div class="col-lg-8">
                    <span
                        class="fw-bold fs-6 text-gray-800">{{ $startup->StartupOtherOne->education_qualification }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-2 fw-semibold text-muted">Work Experience</label>
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $startup->StartupOtherOne->work_exp }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-2 fw-semibold text-muted">Startup Failures/Successful Exits</label>
                <div class="col-lg-8">
                    <span
                        class="fw-bold fs-6 text-gray-800">{{ $startup->StartupOtherOne->startup_failures_successful_exits }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-2 fw-semibold text-muted">Pitch Deck</label>
                <div class="col-lg-8">
                    <span
                        class="fw-bold fs-6 text-gray-800 text-hover-primary">{{ $startup->StartupOtherOne->pitchdeck }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-2 fw-semibold text-muted">Financial Model</label>
                <div class="col-lg-8">
                    <span
                        class="fw-bold fs-6 text-gray-800 text-hover-primary">{{ $startup->StartupOtherOne->financial_model }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-2 fw-semibold text-muted">Founder Email ID</label>
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $startup->StartupOtherOne->founder_email_id }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-2 fw-semibold text-muted">Founder Contact Number</label>
                <div class="col-lg-8">
                    <span
                        class="fw-bold fs-6 text-gray-800">{{ $startup->StartupOtherOne->founder_contact_number }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-2 fw-semibold text-muted">Created At</label>
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $startup->StartupOtherOne->created_at }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-2 fw-semibold text-muted">Updated At</label>
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $startup->StartupOtherOne->updated_at }}</span>
                </div>
            </div>
        </div>
    </div>
@endif
