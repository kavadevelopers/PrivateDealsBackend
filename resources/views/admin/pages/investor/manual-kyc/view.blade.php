<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection
    <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">
            <!--begin::Details-->
            <div class="d-flex flex-wrap flex-sm-nowrap">
                <!--begin: Pic-->
                <div class="me-7 mb-4">
                    <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                        <img class="shimmer lazy"
                            data-src="{{ FileUpDownHelper::get_investor_profile_photo_url($investor) }}" />
                        <div
                            class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px">
                        </div>
                    </div>
                </div>
                <!--end::Pic-->

                <!--begin::Info-->
                <div class="flex-grow-1">
                    <!--begin::Title-->
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <!--begin::User-->
                        <div class="d-flex flex-column">
                            <!--begin::Name-->
                            <div class="d-flex align-items-center mb-2">
                                <a class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $investor->name }}</a>
                                <a href="#"><i class="ki-duotone ki-verify fs-1 text-primary"><span
                                            class="path1"></span><span class="path2"></span></i></a>
                            </div>
                            <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                <a class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                    <i class="ki-duotone ki-profile-circle fs-4 me-1"><span class="path1"></span><span
                                            class="path2"></span><span
                                            class="path3"></span></i>{{ $investor->investor_type }}
                                </a>
                                <a class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                    <i class="ki-duotone ki-geolocation fs-4 me-1"><span class="path1"></span><span
                                            class="path2"></span></i> {{ $investor->city->name ?? 'N/A' }}
                                </a>
                                <a class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                    <i class="ki-duotone ki-sms fs-4"><span class="path1"></span><span
                                            class="path2"></span></i> {{ $investor->email }}
                                </a>
                                <a class="d-flex align-items-center text-gray-500 text-hover-primary mb-2">
                                    <i class="ki-duotone ki-phone fs-4"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    +{{ $investor->mobile_country_code }}-{{ $investor->mobile_number }}
                                </a>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->

                        <!--begin::Actions-->
                        <div class="d-flex my-4">
                            @if ($investor->kyc_status == '0')
                                <a href="#" class="btn btn-sm btn-success me-3 btn-approve"
                                    data-kycid="{{ $investor->kyc->id }}" data-type="1">Approve</a>
                                <a href="#" class="btn btn-sm btn-danger me-3 btn-approve"
                                    data-kycid="{{ $investor->kyc->id }}" data-type="0">Reject</a>
                            @endif
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Title-->

                    <!--begin::Stats-->
                    <!-- Stats can be added here if needed -->
                    <!--end::Stats-->
                </div>
                <!--end::Info-->
            </div>
            <!--end::Details-->

            <!--begin::Navs-->
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 active" href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-home">
                        Basic Details </a>
                </li>
                @if ($investor->kyc_status == '0' && $investor->kyc)
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="#" data-bs-toggle="pill"
                            data-bs-target="#pills-home2">
                            Aadhar Card Front </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="#" data-bs-toggle="pill"
                            data-bs-target="#pills-home3">
                            Aadhar Card Back </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="#" data-bs-toggle="pill"
                            data-bs-target="#pills-home4">
                            PAN Card </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="#" data-bs-toggle="pill"
                            data-bs-target="#pills-home5">
                            Cheque </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="#" data-bs-toggle="pill"
                            data-bs-target="#pills-home6">
                            CML/CMR </a>
                    </li>
                @endif
                @if ($investor->kyc_status == '1')
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5" href="#" data-bs-toggle="pill"
                            data-bs-target="#pills-kyc">
                            KYC Details</a>
                    </li>
                @endif
            </ul>
            <!--begin::Navs-->
        </div>
    </div>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            @include('admin.pages.investor.child.basic-details')
        </div>
        @if ($investor->kyc_status == '0' && $investor->kyc)
            <div class="tab-pane fade" id="pills-home2" role="tabpanel" aria-labelledby="pills-profile-tab">
                <img class="image"
                    src="{{ FileUpDownHelper::get_investor_kyc_img($investor->kyc->aadhaar_front_image) }}"
                    alt="Investor Aadhar Front Photo" style="max-width: 100%; height: auto;" />
            </div>
            <div class="tab-pane fade" id="pills-home3" role="tabpanel" aria-labelledby="pills-contact-tab">
                <img class="image"
                    src="{{ FileUpDownHelper::get_investor_kyc_img($investor->kyc->aadhaar_back_image) }}"
                    alt="Investor Aadhar Back Photo" style="max-width: 100%; height: auto;" />
            </div>
            <div class="tab-pane fade" id="pills-home4" role="tabpanel" aria-labelledby="pills-contact-tab">
                <img class="image" src="{{ FileUpDownHelper::get_investor_kyc_img($investor->kyc->pan_image) }}"
                    alt="Investor PAN Photo" style="max-width: 100%; height: auto;" />
            </div>
            <div class="tab-pane fade" id="pills-home5" role="tabpanel" aria-labelledby="pills-contact-tab">
                <img class="image" src="{{ FileUpDownHelper::get_investor_kyc_img($investor->kyc->cheque_image) }}"
                    alt="Investor PAN Photo" style="max-width: 100%; height: auto;" />
            </div>
            <div class="tab-pane fade" id="pills-home6" role="tabpanel" aria-labelledby="pills-contact-tab">
                <img class="image" src="{{ FileUpDownHelper::get_investor_kyc_img($investor->kyc->cml_image) }}"
                    alt="Investor PAN Photo" style="max-width: 100%; height: auto;" />
            </div>
        @endif
        {{-- @if ($investor->kyc_status == '1')
            <div class="tab-pane fade show" id="pills-kyc" role="tabpanel" aria-labelledby="pills-home-tab">
                @include('admin.pages.investor.child.kyc-details')
            </div>
        @endif --}}
        @if ($investor->preipo_kyc_status == '1' || $investor->kyc_status == '1')
            <div class="tab-pane fade show" id="pills-kyc" role="tabpanel" aria-labelledby="pills-home-tab">
                @include('admin.pages.investor.child.kyc-details')
            </div>
        @endif
    </div>
    <!-- Modal -->
    <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="approveForm" method="POST" action="{{ route('admin.manualkyc.approve') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="approveModalLabel">Approve Investor KYC</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="kyc_id" id="kyc_id">
                        <input type="hidden" name="status" id="status">

                        <div class="d-flex flex-wrap gap-10 mb-5 approve-block">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Aadhar no.</label>
                                <input type="text" class="form-control" name="aadhar_no"
                                    placeholder="Enter Aadhar no." required>
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Name as Aadhar</label>
                                <input type="text" class="form-control" name="aadhar_name"
                                    placeholder="Enter Name as Aadhar" required>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-10 mb-5 approve-block">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">PAN No.</label>
                                <input type="text" class="form-control" name="pan_no"
                                    placeholder="Enter PAN No." required>
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Name as PAN</label>
                                <input type="text" class="form-control" name="pan_name"
                                    placeholder="Enter Name as PAN" required>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-10 mb-5 approve-block">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">DOB</label>
                                <input type="date" class="form-control" name="dob" placeholder="Enter DOB"
                                    required>
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Address</label>
                                <textarea class="form-control" name="address" placeholder="Enter Address" required></textarea>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-10 mb-5 approve-block">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">DP ID</label>
                                <input type="text" class="form-control" name="dp_id" placeholder="Enter DP ID"
                                    required>
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Client ID</label>
                                <input type="text" class="form-control" name="client_id"
                                    placeholder="Enter Client ID" required>
                            </div>

                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Demat Account Number</label>
                                <input type="text" class="form-control" name="demat_account"
                                    placeholder="Enter Demat Account Number" required>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Notes</label>
                                <textarea class="form-control" name="notes" placeholder="Enter Notes" required></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Submit</span>
                        </button>
                    </div>
            </form>
        </div>
    </div>
    </div>
    <!--end::Modal-->
    @push('scripts')
        <script>
            $(function() {
                $('.btn-approve').on('click', function() {
                    const kycId = $(this).data('kycid');
                    const type = $(this).data('type');

                    $('#approveModal input[name=kyc_id]').val(kycId);
                    $('#approveModal input[name=status]').val(type);

                    if (type == '1') {
                        $('#approveModal .approve-block').removeClass('d-none');
                        $('#approveModal .approve-block').addClass('d-flex');
                        // Add required attribute to all input and textarea fields inside .approve-block
                        $('#approveModal .approve-block input, #approveModal .approve-block textarea').attr(
                            'required', true);
                    } else {
                        $('#approveModal .approve-block').addClass('d-none');
                        $('#approveModal .approve-block').removeClass('d-flex');
                        // Remove required attribute from all input and textarea fields inside .approve-block
                        $('#approveModal .approve-block input, #approveModal .approve-block textarea')
                            .removeAttr('required');
                    }
                    $('#approveModal').modal('show');
                });
            });
        </script>
    @endpush
</x-default-layout>
