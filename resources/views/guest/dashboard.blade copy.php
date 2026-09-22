<x-default-layout>
    @section('title')
    Clock Dashboard
    @endsection
    @inject('carbon', 'Carbon\Carbon')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap');

        [data-kt-app-sidebar-fixed=true] .app-wrapper {
            margin-left: 0;
        }

        [data-kt-app-header-fixed=true] .app-wrapper {
            margin-top: 30px;
        }

        blockquote {
            font-family: 'Georgia', serif;
            font-style: italic;
            color: #333;
            padding-left: 1rem;
            margin: 1.5rem 0;
            border-radius: 8px;
            padding: 1.5rem;
            position: relative;
        }

        blockquote footer {
            display: block;
            /* Ensure the footer goes to a new line */
            font-weight: bold;
            text-align: right;
            color: #666;
            margin-top: 1rem;
        }

        body {
            background: #000 !important;
        }

        .card {
            background: #262424;
            border: none;
        }

        .text-primary-new {
            color: #bac1cc;
        }

        .clockdate-wrapper {
            text-align: right;
            font-family: 'Orbitron', sans-serif;
        }

        #clock {
            line-height: 1;
            font-size: 30px;
            text-shadow: 0px 0px 1px #fff;
            color: #fff;
        }

        #clock span {
            color: #1b84ff;
            text-shadow: 0px 0px 1px #333;
            font-size: 20px;
            position: relative;
            top: -5px;
            left: 0px;
        }

        #date {
            margin-top: 5px;
            letter-spacing: 3px;
            font-size: 16px;
            color: #fff;
        }

        .lazy {
            background: #000 !important;
            border: none !important;
        }

        .slider {
            animation: slide-animation 40s linear infinite;
        }

        .slider:hover {
            animation-play-state: paused;
        }

        @keyframes slide-animation {
            0% {
                transform: translateX(0%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        .button-container {
            display: flex;
            justify-content: flex-end;
            /* Push content to the right */
        }

        .col-xl-2-4 {
            flex: 0 0 20%;
            max-width: 20%;
        }

        @media (max-width: 1199.98px) {
            .col-xl-2-4 {
                flex: 0 0 33.333333%;
                max-width: 33.333333%;
            }
        }

        @media (max-width: 767.98px) {
            .col-xl-2-4 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }
    </style>
    <div class="row d-flex mb-5 align-items-center">
        <div class="col-sm-3 col-xl-2">
            <a href="" style="display:block;">
                <img src="{{ asset('core/images/white-logo.svg') }}" style="max-width: 150px; margin: 0 auto;">
            </a>
        </div>
        <div class="col-sm-3 col-xl-2 text-center">
            <span class="fw-bold fs-2x {{ $request_access_today ? 'text-success' : 'text-white' }} lh-1 ls-n2">
                {{ $request_access }} ({{ $request_access_converted }}/{{ $request_access_all }})
            </span>
            <div class="m-0">
                <span class="fw-semibold fs-3 text-primary-new">
                    Request Access
                </span>
            </div>
        </div>
        <div class="col-sm-3 col-xl-2 text-center">
            <span class="fw-bold fs-2x {{ $active_user_today > 0 ? 'text-success' : 'text-white' }} lh-1 ls-n2">
                {{ $active_user_today }} ({{ $active_user_total }}/{{ $total_user }})
                {{-- {{ $active_guest_total }} --}}
            </span><br>
            <span class="fw-bold fs-2x {{ $active_partner_today > 0 ? 'text-success' : 'text-white' }} lh-1 ls-n2">
                {{ $active_partner_today }} ({{ $active_partner_total }}/{{ $total_partner }})
                {{-- {{ $active_guest_total }} --}}
            </span>
            <div class="m-0">
                <span class="fw-semibold fs-3 text-primary-new">
                    Users
                </span>
            </div>
        </div>

        <div class="col-sm-3 col-xl-2 text-center">
            <span class="fw-bold fs-2x  lh-1 ls-n2">
                <span class="{{ $pre_request_access_today ? 'text-success' : 'text-white' }}">
                    {{ $pre_request_access }} / {{ $pre_request_access_all }} | <span
                        class="{{ $pre_request_access_older > 0 ? 'text-danger' : 'text-white' }}">{{
                        $pre_request_access_older }}</span>
                </span>
            </span>
            <div class="m-0">
                <span class="fw-semibold fs-3 text-primary-new">
                    PrivateEq-Reqest
                </span>
            </div>
        </div>
        <div class="col-sm-3 col-xl-2 text-center">
            <span class="fw-bold fs-2x {{ $flag_for_today ? 'text-success' : 'text-white' }} lh-1 ls-n2">
                {{ UtillsHelper::rupee() . UtillsHelper::moneyFormatIndia($total_amount, true) }}
            </span>
            <div class="m-0">
                <span class="fw-semibold fs-3 text-primary-new">
                    Total AUM
                </span>
            </div>
        </div>
        <div class="col-sm-3 col-xl-2 cursor-pointer text-center">
            <div id="clockdate">
                <div class="clockdate-wrapper">
                    <div id="clock">{{ date('h') }}:{{ date('i') }}:{{ date('s') }}
                        <span>{{ date('A') }}</span>
                    </div>
                    <div id="date">{{ date('D') }}, {{ date('d') }} {{ date('F') }}

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-5">
        <!--begin::Col-->
        <div class="col-sm-6 col-xl-2-4">
            <!--begin::Card widget 2-->
            <div class="card h-lg-100">
                <!--begin::Body-->
                <div class="card-body d-flex justify-content-center align-items-center flex-column text-center p-2">
                    <!--begin::Icon-->
                    <div class="m-0">
                        {!! getIcon('abstract-18', 'fs-3hx text-primary') !!}
                    </div>
                    <!--end::Icon-->

                    <!--begin::Section-->
                    <div class="d-flex flex-column my-7 mb-0">
                        <!--begin::Number-->
                        <span class="fw-bold fs-3x {{ $flag_for_today ? 'text-success' : 'text-white' }} lh-1 ls-n2">
                            {{ UtillsHelper::rupee() . UtillsHelper::moneyFormatIndia($current_month_total, true) }}
                        </span>
                        <!--end::Number-->

                        <!--begin::Follower-->
                        <div class="m-0">
                            <span class="fw-semibold fs-2x text-primary-new">
                                Current month
                            </span>
                        </div>
                        <!--end::Follower-->
                    </div>
                    <!--end::Section-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card widget 2-->
        </div>
        <!--end::Col-->

        <!--begin::Col-->
        <div class="col-sm-6 col-xl-2-4">
            <!--begin::Card widget 2-->
            <div class="card h-lg-100">
                <!--begin::Body-->
                <div class="card-body d-flex justify-content-center align-items-center flex-column text-center p-2">
                    <!--begin::Icon-->
                    <div class="m-0">
                        {!! getIcon('chart-simple-3', 'fs-3hx text-primary') !!}
                    </div>
                    <!--end::Icon-->

                    <!--begin::Section-->
                    <div class="d-flex flex-column my-7 mb-0">
                        <!--begin::Number-->
                        <span
                            class="fw-bold fs-3x {{ $primary_made_today ? 'text-success' : 'text-white' }} lh-1 ls-n2">
                            {{ UtillsHelper::rupee() . UtillsHelper::number_shorten($primary_total) }}
                        </span>
                        <!--end::Number-->

                        <!--begin::Follower-->
                        <div class="m-0">
                            <span class="fw-semibold fs-2x text-primary-new">
                                Primary Total
                            </span>
                        </div>
                        <!--end::Follower-->
                    </div>
                    <!--end::Section-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card widget 2-->
        </div>
        <!--end::Col-->

        <!--begin::Col-->
        <div class="col-sm-6 col-xl-2-4">
            <!--begin::Card widget 2-->
            <div class="card h-lg-100">
                <!--begin::Body-->
                <div class="card-body d-flex justify-content-center align-items-center flex-column text-center p-2">
                    <!--begin::Icon-->
                    <div class="m-0">
                        {!! getIcon('graph-up', 'fs-3hx text-primary') !!}
                    </div>
                    <!--end::Icon-->

                    <!--begin::Section-->
                    <div class="d-flex flex-column my-7 mb-0">
                        <!--begin::Number-->
                        <span
                            class="fw-bold fs-3x {{ $secondary_made_today ? 'text-success' : 'text-white' }} lh-1 ls-n2">
                            {{ UtillsHelper::rupee() . UtillsHelper::number_shorten($secondary_total) }}
                        </span>
                        <!--end::Number-->

                        <!--begin::Follower-->
                        <div class="m-0">
                            <span class="fw-semibold fs-2x text-primary-new">
                                Secondary Total
                            </span>
                        </div>
                        <!--end::Follower-->
                    </div>
                    <!--end::Section-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card widget 2-->
        </div>
        <!--end::Col-->

        <!--begin::Col-->
        <div class="col-sm-6 col-xl-2-4">
            <!--begin::Card widget 2-->
            <div class="card h-lg-100">
                <!--begin::Body-->
                <div class="card-body d-flex justify-content-center align-items-center flex-column text-center p-2">
                    <!--begin::Icon-->
                    <span class="{{ $company_Price_updated ? 'text-success' : 'text-danger' }}"
                        style="position: absolute; top: 6px; right: 15px; font-size: 35px;">*</span>
                    <div class="m-0">
                        {!! getIcon('chart-pie-simple', 'fs-3hx text-primary') !!}
                    </div>
                    <!--end::Icon-->

                    <!--begin::Section-->
                    <div class="d-flex flex-column my-7 mb-0">
                        <!--begin::Number-->
                        <span class="fw-bold fs-3x {{ $preipo_made_today ? 'text-success' : 'text-white' }} lh-1 ls-n2">
                            {{ UtillsHelper::rupee() . UtillsHelper::number_shorten($preipo_total) }}
                        </span>
                        <!--end::Number-->

                        <!--begin::Follower-->
                        <div class="m-0">
                            <span class="fw-semibold fs-2x text-primary-new">
                                Private Equity Total
                            </span>
                        </div>
                        <!--end::Follower-->
                    </div>
                    <!--end::Section-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card widget 2-->
        </div>
        <!--end::Col-->

        <!--begin::Col-->
        <div class="col-sm-6 col-xl-2-4">
            <div class="card h-lg-100">
                <div class="card-body p-2">
                    <!-- Top Gainers Section -->
                    <div class="mb-4">
                        <div class="text-center mb-2">
                            <span class="fw-bold fs-6 text-success">Top Gainers (30D)</span>
                        </div>
                        @if(count($price_fluctuation['up']) > 0)
                        @foreach($price_fluctuation['up'] as $company)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="text-truncate" style="max-width: 60%">
                                <span class="fw-bold fs-6 text-warning">{{ $company['company_name'] }}</span>
                                <span class="fs-7 text-muted d-block">₹{{ number_format($company['current_price'], 2)
                                    }}</span>
                            </div>
                            <span class="fw-bold fs-6 text-success">
                                ↑ {{ number_format($company['fluctuation_percentage'], 2) }}%
                            </span>
                        </div>
                        @endforeach
                        @else
                        <div class="text-center">
                            <span class="fw-bold fs-7 text-muted">No significant gainers</span>
                        </div>
                        @endif
                    </div>

                    <!-- Top Losers Section -->
                    <div class="mt-4">
                        <div class="text-center mb-2">
                            <span class="fw-bold fs-6 text-danger">Top Losers (30D)</span>
                        </div>
                        @if(count($price_fluctuation['down']) > 0)
                        @foreach($price_fluctuation['down'] as $company)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="text-truncate" style="max-width: 60%">
                                <span class="fw-bold fs-6 text-warning">{{ $company['company_name'] }}</span>
                                <span class="fs-7 text-muted d-block">₹{{ number_format($company['current_price'], 2)
                                    }}</span>
                            </div>
                            <span class="fw-bold fs-6 text-danger">
                                ↓ {{ number_format(abs($company['fluctuation_percentage']), 2) }}%
                            </span>
                        </div>
                        @endforeach
                        @else
                        <div class="text-center">
                            <span class="fw-bold fs-7 text-muted">No significant losers</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!--end::Col-->
    </div>

    <div class="row">
        @foreach ($manager_list as $key => $manager)
        <div class="col-sm-6 col-xl-4 mb-5">
            <div class="card h-lg-100">
                <div class="card-body p-2">
                    <div class="d-flex">
                        <div class="symbol symbol-70px flex-shrink-0 me-2">
                            <img class="shimmer lazy"
                                data-src="{{ FileUpDownHelper::subadmin_profile_photo_url($manager['profile_photo']) }}"
                                class="mw-100" alt="">
                        </div>
                        <div class="d-flex align-items-center flex-wrap flex-grow-1 mt-n2 mt-lg-n1">
                            <div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 pe-3">
                                <a href="javascript:;" class="fs-1 text-white text-hover-primary fw-bold">{{
                                    $manager['name'] }}</a>
                                {{-- <span class="text-gray-500 fw-semibold fs-7 my-1 fs-2">{{ $manager['role']
                                    }}</span> --}}
                                <span class="text-gray-700 fw-semibold fs-2">
                                    Investors: <a href="javascript:;" class="text-primary fw-bold">{{
                                        $manager['investor_count'] }}</a>
                                </span>
                            </div>
                            <div class="text-end py-lg-0 py-2">
                                <span
                                    class="{{ $manager['investment_made_today'] ? 'text-success' : 'text-white' }} fw-bolder fs-1">{{
                                    UtillsHelper::rupee() . UtillsHelper::moneyFormatIndia($manager['total_investment'],
                                    true) }}</span>
                                <span class="text-gray-700 fs-7 fw-semibold d-block">AUM</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2 rows-cols-xl-2">
                        @foreach ($manager['investments'] as $iKey => $iValue)
                        <div class="col text-center">
                            <div class="symbol symbol-50px flex-shrink-0 me-2">
                                <img class="shimmer lazy" data-src="{{ $iValue['logo'] }}" class="mw-100" alt="">
                            </div>
                            <div class="mb-0">
                                <div
                                    class="{{ $iValue['made_today'] ? 'text-success' : 'text-white' }} fs-6 fw-semibold">
                                    {{ UtillsHelper::rupee() . UtillsHelper::number_shorten($iValue['amount']) }}
                                </div>
                                {{-- <div class="text-muted fs-8 fw-semibold">
                                    {{ UtillsHelper::read_more_hide($iValue['name'], 7) }}
                                </div> --}}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- <div class="tns mb-3" style="direction: ltr">
        <div data-tns="true" data-tns-loop="true" data-tns-swipe-angle="false" data-tns-speed="2000"
            data-tns-autoplay="true" data-tns-autoplay-timeout="18000" data-tns-items="3" data-tns-center="true"
            data-tns-slide-by="true" data-tns-nav-container="#kt_slider_thumbnails" data-tns-nav-as-thumbnails="true"
            data-tns-prev-button="#kt_slider_prev" data-tns-next-button="#kt_slider_next" class="slider">
            @foreach ($raising_now_startups as $startup)
            <div class="card h-100 me-3">
                <div class="card-header flex-nowrap border-0 pt-9 mb-5">
                    <div class="card-title m-0">
                        <div class="symbol symbol-70px flex-shrink-0 me-2">
                            <img class="shimmer lazy p-3"
                                data-src="{{ FileUpDownHelper::get_startup_logo_url($startup) }}" />
                        </div>
                        <div class="mb-2">
                            <a href="#" class="fs-1 text-white text-hover-primary fw-bold">
                                {{ $startup->brand_name }} </a>

                            <div class="text-start">
                                <span class="text-white fs-1">
                                    {{ UtillsHelper::rupee() .
                                    UtillsHelper::moneyFormatIndia($startup->fund_requirement, true) }}
                                    /
                                    {{ UtillsHelper::rupee() .
                                    UtillsHelper::moneyFormatIndia($startup->total_fund_requirement, true) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="text-end py-lg-0 py-2">
                        <span
                            class="{{ $startup->percentage_completed ? 'text-success' : 'text-white' }} fw-bolder fs-2x">{{
                            $startup->percentage_completed }}%</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div> --}}

    <div class="tns mb-3" style="direction: ltr">
        <div data-tns="true" data-tns-loop="true" data-tns-swipe-angle="false" data-tns-speed="2000"
            data-tns-autoplay="true" data-tns-autoplay-timeout="18000" data-tns-items="3" data-tns-center="true"
            data-tns-slide-by="true" data-tns-nav-container="#kt_slider_thumbnails" data-tns-nav-as-thumbnails="true"
            data-tns-prev-button="#kt_slider_prev" data-tns-next-button="#kt_slider_next" class="slider">
            @foreach ($raising_now_startups as $startup)
            <div class="col-xl-4 me-3">
                <div class="card h-lg-100">
                    <div class="card-body p-2">
                        <div class="d-flex">
                            <div class="symbol symbol-70px flex-shrink-0 me-2">
                                <img class="shimmer lazy"
                                    data-src="{{ FileUpDownHelper::get_startup_logo_url($startup) }}" class="mw-100"
                                    alt="">
                            </div>
                            <div class="d-flex align-items-center flex-wrap flex-grow-1 mt-n2 mt-lg-n1">
                                <div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 pe-3">
                                    <a href="#" class="fs-1 text-white text-hover-primary fw-bold">
                                        {{ $startup->brand_name }}
                                    </a>
                                    <span class="text-gray-700 fw-semibold fs-2">
                                        Total Ask:

                                        <span class="text-primary fw-bold">
                                            {{ UtillsHelper::rupee() .
                                            UtillsHelper::moneyFormatIndia($startup->fund_requirement, true) }}
                                        </span>
                                    </span>
                                </div>
                                <div class="text-end py-lg-0 py-2">
                                    <span
                                        class="{{ $startup->percentage_completed > 70 ? 'text-success' : 'text-danger' }} fw-bolder fs-2x">
                                        {{ $startup->percentage_completed }}%
                                    </span>
                                    <span class="text-gray-700 fs-7 fw-semibold d-block">Completed</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-2">
                            <div class="text-center">
                                <span class="text-white fs-1">
                                    {{ UtillsHelper::rupee() .
                                    UtillsHelper::moneyFormatIndia($startup->investment_amount, true) }}
                                </span>
                                <span class="text-gray-700 fs-7 fw-semibold d-block">Ask Completed</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="row">
        <!-- Investor Card - Left Half -->
        <div class="col-md-6">
            <div class="card card-xl-stretch h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-3">
                        <div class="d-flex flex-column w-100">
                            @if($active_user_today > 0)
                            <span class="text-white text-hover-primary fs-6 fw-bold mb-2">
                                Today's Active Investors <span class="badge bg-light text-dark fs-8  ms-2 align-middle">
                                    {{ $recent_registered_investors }} new since 09 June , 2025
                                </span>
                            </span>
                            @if(!empty($active_investors_today_names))
                            <div class="row">
                                @foreach($active_investors_today_names as $investor)
                                <div class="col-4 mb-2">
                                    <span class="text-success fw-semibold d-block">
                                        <i class="bi bi-person-check me-2"></i>
                                        @if(!empty($investor['version_code']))
                                        -{{ UtillsHelper::read_more_hide($investor['name'], 20) }}
                                        @else
                                        {{ UtillsHelper::read_more_hide($investor['name'], 20) }}
                                        @endif
                                    </span>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <span class="text-muted fw-bold">
                                <i class="bi bi-exclamation-circle me-2"></i>Names not available
                            </span>
                            @endif
                            @else
                            <span class="text-white text-hover-primary fs-6 fw-bold">
                                <i class="bi bi-people me-2"></i>No active investors today
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Partner Card - Right Half -->
        <div class="col-md-6">
            <div class="card card-xl-stretch h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-3">
                        <div class="d-flex flex-column w-100">
                            @if($active_partner_today > 0)
                            <span class="text-white text-hover-primary fs-6 fw-bold mb-2">
                                Today's Active Partners
                            </span>
                            @if(!empty($active_partners_today_names))
                            <div class="row">
                                @foreach($active_partners_today_names as $name)
                                <div class="col-4 mb-2">
                                    <span class="text-success fw-semibold d-block">
                                        <i class="bi bi-person-check me-2"></i>{{
                                        UtillsHelper::read_more_hide($name,20)}}
                                    </span>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <span class="text-muted fw-bold">
                                <i class="bi bi-exclamation-circle me-2"></i>Names not available
                            </span>
                            @endif
                            @else
                            <span class="text-white text-hover-primary fs-6 fw-bold">
                                <i class="bi bi-people me-2"></i>No active Partner today
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




</x-default-layout>
@if (strpos(url()->current(), '127.0.0.1:8000') === false)
<script>
    setTimeout(
            function() {
                window.location.reload(1);
            },
            60000,
        );
</script>
@endif
<script>
    startTime();

    function startTime() {
        document.getElementById("clock").innerHTML = '';
        var today = new Date();
        var hr = today.getHours();
        var min = today.getMinutes();
        var sec = today.getSeconds();
        ap = (hr < 12) ? "<span>AM</span>" : "<span>PM</span>";
        hr = (hr == 0) ? 12 : hr;
        hr = (hr > 12) ? hr - 12 : hr;
        //Add a zero in front of numbers<10
        hr = checkTime(hr);
        min = checkTime(min);
        sec = checkTime(sec);
        document.getElementById("clock").innerHTML = hr + ":" + min + ":" + sec + " " + ap;

        var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October',
            'November', 'December'
        ];
        var days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        var curWeekDay = days[today.getDay()];
        var curDay = today.getDate();
        var curMonth = months[today.getMonth()];
        var curYear = today.getFullYear();
        // var date = curWeekDay + ", " + curDay + " " + curMonth + " " + curYear;
        var date = curWeekDay + ", " + curDay + " " + curMonth;
        document.getElementById("date").innerHTML = date;

        var time = setTimeout(function() {
            startTime()
        }, 500);
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }
</script>

<script>
    const clockDateDiv = document.getElementById('clockdate');

    clockDateDiv.addEventListener('dblclick', () => {
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen().catch(err => {
        alert(`Error trying to enable fullscreen: ${err.message}`);
        });
    } else {
        document.exitFullscreen();
    }
    });
</script>