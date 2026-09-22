<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection
    <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">
            <div class="d-flex flex-wrap flex-sm-nowrap">
                <div class="me-7 mb-4">
                    <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                        {{-- <img class="shimmer lazy"
                            data-src="{{ FileUpDownHelper::subadmin_profile_photo_url($user->profile_photo) }}" /> --}}
                        @if (Auth::guard('admin')->user()->profile_photo != null)
                            <img class="shimmer lazy"
                                data-src="{{ FileUpDownHelper::subadmin_profile_photo_url(Auth::guard('admin')->user()->profile_photo) }}" />
                        @else
                            <div
                                class="symbol-label fs-1 {{ app(\App\Actions\GetThemeType::class)->handle('bg-light-? text-?', Auth::guard('admin')->user()->name) }}">
                                {{ substr(Auth::guard('admin')->user()->name, 0, 1) }}
                            </div>
                        @endif
                        <div
                            class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px">
                        </div>
                    </div>
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center mb-2">
                                <a class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $user->name }}</a>
                                <a href="#"><i class="ki-duotone ki-verify fs-1 text-primary"><span
                                            class="path1"></span><span class="path2"></span></i></a>
                            </div>
                            <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                <a class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                    <i class="ki-duotone ki-profile-circle fs-4 me-1"><span class="path1"></span><span
                                            class="path2"></span><span class="path3"></span></i>{{ $user->username }}
                                </a>
                                <a class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                    <i class="ki-duotone ki-geolocation fs-4 me-1"><span class="path1"></span><span
                                            class="path2"></span></i> {{ $user->name }}
                                </a>
                                <a class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                    <i class="ki-duotone ki-sms fs-4"><span class="path1"></span><span
                                            class="path2"></span></i> {{ $user->email }}
                                </a>
                                <a class="d-flex align-items-center text-gray-500 text-hover-primary mb-2">
                                    <i class="ki-duotone ki-phone fs-4"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    +91-{{ $user->mobile_no }}
                                </a>
                            </div>
                        </div>

                        <div class="d-flex my-4">
                            <span class="indicator-progress">
                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                            </a>

                            {{-- <a href="{{ route('admin.investor.update', ['uuid' => $investor->uuid]) }}"
                                class="btn btn-sm btn-primary me-3">Edit</a> --}}

                        </div>
                    </div>
                    <div class="d-flex flex-wrap flex-stack">
                        <div class="d-flex flex-column flex-grow-1 pe-8">
                            <!--begin::Stats-->
                            {{-- <div class="d-flex flex-wrap">
                                <!--begin::Stat-->
                                <div
                                    class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        <i class="ki-duotone ki-arrow-up fs-3 text-success me-2"><span
                                                class="path1"></span><span class="path2"></span></i>
                                        <div class="fs-2 fw-bold counted" data-kt-countup="true"
                                            data-kt-countup-value="4500" data-kt-countup-prefix="$"
                                            data-kt-initialized="1">$4,500</div>
                                    </div>
                                    <!--end::Number-->

                                    
                                    <div class="fw-semibold fs-6 text-gray-500">Earnings</div>
                                    
                                </div>
                                <!--end::Stat-->

                                <!--begin::Stat-->
                                <div
                                    class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        <i class="ki-duotone ki-arrow-down fs-3 text-danger me-2"><span
                                                class="path1"></span><span class="path2"></span></i>
                                        <div class="fs-2 fw-bold counted" data-kt-countup="true"
                                            data-kt-countup-value="80" data-kt-initialized="1">80</div>
                                    </div>
                                    <!--end::Number-->

                                    
                                    <div class="fw-semibold fs-6 text-gray-500">Projects</div>
                                    
                                </div>
                                <!--end::Stat-->

                                <!--begin::Stat-->
                                <div
                                    class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        <i class="ki-duotone ki-arrow-up fs-3 text-success me-2"><span
                                                class="path1"></span><span class="path2"></span></i>
                                        <div class="fs-2 fw-bold counted" data-kt-countup="true"
                                            data-kt-countup-value="60" data-kt-countup-prefix="%"
                                            data-kt-initialized="1">%60</div>
                                    </div>
                                    <!--end::Number-->

                                    
                                    <div class="fw-semibold fs-6 text-gray-500">Success Rate</div>
                                    
                                </div>
                                <!--end::Stat-->
                            </div> --}}
                            <!--end::Stats-->
                        </div>
                        <!--end::Wrapper-->

                        <!--begin::Progress-->
                        {{-- <div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
                            <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                <span class="fw-semibold fs-6 text-gray-500">Profile Compleation</span>
                                <span class="fw-bold fs-6">50%</span>
                            </div>

                            <div class="h-5px mx-3 w-100 bg-light mb-3">
                                <div class="bg-success rounded h-5px" role="progressbar" style="width: 50%;"
                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div> --}}
                        <!--end::Progress-->
                    </div>
                    <!--end::Stats-->
                </div>
                <!--end::Info-->
            </div>
            <!--end::Details-->

            <!--begin::Navs-->
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 active" href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-home">
                        Profile Details </a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                {{-- <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-home2">
                        Settings </a>
                </li> --}}
                <!--end::Nav item-->
                <!--begin::Nav item-->
                {{-- <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="#" data-bs-toggle="pill"
                        data-bs-target="#pills-home3">
                        Security </a>
                </li> --}}
                <!--end::Nav item-->
                <!--begin::Nav item-->
                {{-- <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 "
                        href="/metronic8/demo1/account/activity.html">
                        Activity </a>
                </li> --}}
                <!--end::Nav item-->
                <!--begin::Nav item-->
                {{-- <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 "
                        href="/metronic8/demo1/account/billing.html">
                        Billing </a>
                </li> --}}
                <!--end::Nav item-->
                <!--begin::Nav item-->
                {{-- <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 "
                        href="/metronic8/demo1/account/statements.html">
                        Statements </a>
                </li> --}}
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
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 "
                        href="/metronic8/demo1/account/logs.html">
                        Logs </a>
                </li> --}}
                <!--end::Nav item-->
            </ul>
            <!--begin::Navs-->
        </div>
    </div>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            @include('admin.pages.myprofile.child.profile-details')
        </div>
        {{-- <div class="tab-pane fade" id="pills-home2" role="tabpanel" aria-labelledby="pills-profile-tab">
            @include('admin.pages.myprofile.edit')
        </div> --}}
        <div class="tab-pane fade" id="pills-home3" role="tabpanel" aria-labelledby="pills-contact-tab">3</div>
    </div>
</x-default-layout>
