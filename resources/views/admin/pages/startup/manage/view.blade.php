<x-default-layout>
    @section('title')
    {{ getPageTitle() }}
    @endsection
    @section('breadcrumbs')
    {{ Breadcrumbs::render('startup.manage') }}
    @endsection
    <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">
            <!--begin::Details-->
            <div class="d-flex flex-wrap flex-sm-nowrap">
                <!--begin: Pic-->
                <div class="me-7 mb-4">
                    <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                        <img class="shimmer lazy" data-src="{{ FileUpDownHelper::get_startup_logo_url($startup) }}" />
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
                                <a class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $startup->brand_name
                                    }}</a>
                                <a href="#"><i class="ki-duotone ki-verify fs-1 text-primary"><span
                                            class="path1"></span><span class="path2"></span></i></a>
                            </div>
                            <!--end::Name-->

                            <!--begin::Info-->
                            <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                <a class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                    <i class="ki-duotone ki-profile-circle fs-4 me-1"><span class="path1"></span><span
                                            class="path2"></span><span class="path3"></span></i>{{
                                    $startup->legalInfo->company_name ?? 'N/A' }}
                                </a>
                                <a class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                    <i class="ki-duotone ki-sms fs-4"><span class="path1"></span><span
                                            class="path2"></span></i> {{ $startup->email }}
                                </a>
                                <a class="d-flex align-items-center text-gray-500 text-hover-primary mb-2">
                                    <i class="ki-duotone ki-phone fs-4"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    +{{ $startup->mobile_country_code }}-{{ $startup->mobile_number }}
                                </a>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->

                        <!--begin::Actions-->
                        <div class="d-flex my-4">

                            <!--begin::Indicator progress-->
                            <span class="indicator-progress">
                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                            <!--end::Indicator progress--> </a>

                            <a href="{{ route('admin.startup.edit', ['uuid' => $startup->uuid]) }}"
                                class="btn btn-sm btn-primary me-3">Edit</a>

                            <a href="{{ route('admin.startup.updateteam.get', ['uuid' => $startup->uuid]) }}"
                                class="btn btn-sm btn-primary me-3">Edit Team</a>

                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Info-->
            </div>
            <!--end::Details-->

            <!--begin::Navs-->
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ session('activeTab', 'pills-home') == 'pills-home' ? 'active' : '' }}"
                        href="#pills-home" data-bs-toggle="pill" data-bs-target="#pills-home">
                        Basic Details </a>
                </li>
                @if ($startup->legalInfo)
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="#" data-bs-toggle="pill"
                        data-bs-target="#legal-details">
                        Legal Details </a>
                </li>
                @endif
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" href="#" data-bs-toggle="pill"
                        data-bs-target="#files-details">
                        Files</a>
                </li>
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" href="#" data-bs-toggle="pill"
                        data-bs-target="#content-details">
                        Content</a>
                </li>

                <!--end::Nav item-->
                <!--begin::Nav item-->
                {{-- <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-home2">
                        Fund Raise </a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-home3">
                        Key Metrics </a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-home4">
                        Financial </a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-home5">
                        Other Details </a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-home6">
                        Documents </a>
                </li>
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-home7">
                        Team Details </a>
                </li> --}}
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ session('activeTab') == 'pills-home8' ? 'active' : '' }}"
                        href="#pills-home8" data-bs-toggle="pill" data-bs-target="#pills-home8">
                        Rounds</a>
                </li>
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" href="#" data-bs-toggle="pill"
                        data-bs-target="#investments">
                        Investments</a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                {{-- <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 "
                        href="/metronic8/demo1/account/referrals.html">
                        Referrals </a>
                </li> --}}
                <!--end::Nav item-->
                <!--begin::Nav item-->
                {{-- <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 "
                        href="/metronic8/demo1/account/api-keys.html">
                        API Keys </a>
                </li> --}}
                <!--end::Nav item-->
                <!--begin::Nav item-->
                {{-- <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="/metronic8/demo1/account/logs.html">
                        Logs </a>
                </li> --}}
                <!--end::Nav item-->
            </ul>
            <!--begin::Navs-->
        </div>
    </div>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            @include('admin.pages.startup.child.basic-details')
        </div>
        @if ($startup->legalInfo)
        <div class="tab-pane fade" id="legal-details" role="tabpanel" aria-labelledby="pills-home-tab">
            @include('admin.pages.startup.child.legal-details')
        </div>
        @endif
        <div class="tab-pane fade" id="files-details" role="tabpanel" aria-labelledby="pills-profile-tab">
            @include('admin.pages.startup.child.file-details')
        </div>
        <div class="tab-pane fade" id="content-details" role="tabpanel" aria-labelledby="pills-profile-tab">
            @include('admin.pages.startup.child.content-details')
        </div>
        <div class="tab-pane fade" id="investments" role="tabpanel" aria-labelledby="pills-profile-tab">
            @include('admin.pages.startup.child.investments')
        </div>
        {{-- <div class="tab-pane fade" id="pills-home2" role="tabpanel" aria-labelledby="pills-profile-tab">
            @include('admin.pages.startup.child.fundraise-details')
        </div>
        <div class="tab-pane fade" id="pills-home3" role="tabpanel" aria-labelledby="pills-contact-tab">
            @include('admin.pages.startup.child.keymetrics-details')
        </div>
        <div class="tab-pane fade" id="pills-home4" role="tabpanel" aria-labelledby="pills-contact-tab">
            @include('admin.pages.startup.child.financial-details')
        </div>
        <div class="tab-pane fade" id="pills-home5" role="tabpanel" aria-labelledby="pills-contact-tab">
            @include('admin.pages.startup.child.other-details')
        </div>
        <div class="tab-pane fade" id="pills-home6" role="tabpanel" aria-labelledby="pills-contact-tab">
            @include('admin.pages.startup.child.document-details')
        </div>
        <div class="tab-pane fade" id="pills-home7" role="tabpanel" aria-labelledby="pills-contact-tab">
            @include('admin.pages.startup.child.team-details')
        </div> --}}
        <div class="tab-pane fade" id="pills-home8" role="tabpanel" aria-labelledby="pills-contact-tab">
            @include('admin.pages.startup.child.round-details')
        </div>

    </div>
</x-default-layout>