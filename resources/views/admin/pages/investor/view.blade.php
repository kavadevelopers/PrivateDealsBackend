<x-default-layout>
    @section('title')
    {{ getPageTitle() }}
    @endsection
    @section('breadcrumbs')
    {{ Breadcrumbs::render('investor.create') }}
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
                            <!--end::Name-->

                            <!--begin::Info-->
                            <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                <a class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                    <i class="ki-duotone ki-profile-circle fs-4 me-1"><span class="path1"></span><span
                                            class="path2"></span><span class="path3"></span></i>{{
                                    $investor->investor_type }}
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
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Info-->
            </div>
            <!--end::Details-->

            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 active" href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-home">
                        Basic Details </a>
                </li>
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-documents">
                        Documents
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-demat-kyc">
                        Demat KYC
                    </a>
                </li>
                @if ($investor->kyc_status == '1')
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-kyc">
                        KYC Details</a>
                </li>
                @endif
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-startup-portfolio">
                        Startup Portfolio</a>
                </li>
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-private-equity-portfolio">
                        Private Equity Portfolio</a>
                </li>
                @if ($investor->kyc)
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
            </ul>
        </div>
    </div>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            @include('admin.pages.investor.child.basic-details')
        </div>
        <div class="tab-pane fade" id="pills-documents" role="tabpanel" aria-labelledby="pills-documents-tab">
            @include('admin.pages.investor.child.documents')
        </div>
        <div class="tab-pane fade" id="pills-demat-kyc" role="tabpanel" aria-labelledby="pills-demat-kyc-tab">
            @include('admin.pages.investor.child.demat-kyc')
        </div>
        @if ($investor->kyc_status == '1')
        <div class="tab-pane fade show" id="pills-kyc" role="tabpanel" aria-labelledby="pills-home-tab">
            {{-- @include('admin.pages.investor.child.kyc-details') --}}
        </div>
        @endif
        <div class="tab-pane fade show" id="pills-startup-portfolio" role="tabpanel" aria-labelledby="pills-home-tab">
            @include('admin.pages.investor.child.startup-portfolio')
        </div>
        <div class="tab-pane fade show" id="pills-private-equity-portfolio" role="tabpanel"
            aria-labelledby="pills-home-tab">
            @include('admin.pages.investor.child.private-equity-portfolio')
        </div>
        @if ($investor->kyc)
        <div class="tab-pane fade" id="pills-home2" role="tabpanel" aria-labelledby="pills-profile-tab">
            <img class="image" src="{{ FileUpDownHelper::get_investor_kyc_img($investor->kyc->aadhaar_front_image) }}"
                alt="Investor Aadhar Front Photo" style="max-width: 100%; height: auto;" />
        </div>
        <div class="tab-pane fade" id="pills-home3" role="tabpanel" aria-labelledby="pills-contact-tab">
            <img class="image" src="{{ FileUpDownHelper::get_investor_kyc_img($investor->kyc->aadhaar_back_image) }}"
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
        <div class="tab-pane fade" id="pills-home2" role="tabpanel" aria-labelledby="pills-profile-tab">2</div>
        <div class="tab-pane fade" id="pills-home3" role="tabpanel" aria-labelledby="pills-contact-tab">3</div>
    </div>
</x-default-layout>