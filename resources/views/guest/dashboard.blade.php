<x-default-layout>
    {{-- DUMMY ORDER FOR ALERT TESTING --}}
    {{-- @php
    if (!isset($pending_buy_orders) || !is_array($pending_buy_orders)) {
    $pending_buy_orders = [];
    }
    $pending_buy_orders[] = [
    'investor_name' => 'Test User',
    'investor_email' => 'testuser@example.com',
    'company_name' => 'Demo Company',
    'amount' => 123456.78,
    'created_at' => now(),
    ];
    @endphp --}}
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

        /* Responsive dashboard block row */
        .dashboard-block-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .dashboard-block-col {
            flex: 1 1 320px;
            max-width: 400px;
            min-width: 260px;
            margin: 0 0.5rem;
        }

        @media (max-width: 1200px) {
            .dashboard-block-col {
                max-width: 100%;
                min-width: 220px;
            }
        }

        @media (max-width: 767.98px) {
            .dashboard-block-row {
                flex-direction: column;
                gap: 1rem;
            }

            .dashboard-block-col {
                max-width: 100%;
                min-width: 0;
                margin: 0 0 1rem 0;
            }
        }
    </style>
    <!-- Pending Buy Orders Section - moved to top -->
    <div id="pending-orders-section" class="mb-4">
        <div class="card card-xl-stretch h-100 border border-warning shadow-lg" style="background: #1a1a1a;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="d-flex flex-column w-100">
                        <span class="fs-4 fw-bold text-warning mb-2">
                            <i class="bi bi-bell-fill me-2 animate__animated animate__flash animate__infinite"></i>
                            Pending Buy Orders
                        </span>
                        @if(!empty($pending_buy_orders) && count($pending_buy_orders) > 0)
                        <div class="alert d-flex align-items-center mb-3"
                            style="font-size:1.1rem; background: #fffbe6; color: #7c5700; border: 2px solid #ffe066; box-shadow: 0 2px 8px #0002;">
                            <i class="bi bi-exclamation-triangle-fill me-2" style="font-size:1.5rem;"></i>
                            <span class="fw-bold" style="font-size:1.15rem;">
                                New buy order placed by investor! Please review and take action.
                            </span>
                            {{-- <audio id="order-alert-sound" src="{{ asset('core/sounds/alert.mp3') }}" loop></audio>
                            --}}
                        </div>
                        <div class="table-responsive mb-3">
                            <table class="table table-dark table-bordered table-hover align-middle mb-0">
                                <thead class="bg-warning text-dark">
                                    <tr>
                                        <th>Investor</th>
                                        <th>Company</th>
                                        <th>Order Amount</th>
                                        <th>Status</th>
                                        <th>Placed At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pending_buy_orders as $order)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $order['investor_name'] ?? '-' }}</span>
                                            <br>
                                            <span class="text-muted fs-7">{{ $order['investor_email'] ?? '' }}</span>
                                        </td>
                                        <td>{{ $order['company_name'] ?? '-' }}</td>
                                        <td>₹{{ number_format($order['amount'] ?? 0, 2) }}</td>
                                        <td><span class="badge bg-warning text-dark">Pending</span></td>
                                        <td>{{ $order['created_at'] ?
                                            \Carbon\Carbon::parse($order['created_at'])->format('d M, h:i A') : '-' }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="p-3 bg-dark rounded shadow text-white d-inline-block">
                            <span class="fw-bold">Total Pending Orders Today:</span>
                            <span class="badge bg-warning text-dark fs-6 ms-2">{{ count($pending_buy_orders) }}</span>
                        </div>
                        @else
                        <span class="text-muted fw-bold">
                            <i class="bi bi-check-circle me-2"></i>No pending buy orders right now.
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Dashboard Blocks: Total AUM, Current Month, Private Equity Total -->
    <div class="row mb-5 g-4">
        <div class="col-md-4">
            <div class="card h-100 text-center border-0 shadow-lg" style="background: #23272b;">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <span class="fw-bold fs-2x {{ $flag_for_today ? 'text-success' : 'text-white' }} lh-1 ls-n2">
                        {{ UtillsHelper::rupee() . UtillsHelper::moneyFormatIndia($total_amount, true) }}
                    </span>
                    <span class="fw-semibold fs-3 text-primary-new mt-2">Total AUM</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 text-center border-0 shadow-lg" style="background: #23272b;">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <span class="fw-bold fs-2x {{ $flag_for_today ? 'text-success' : 'text-white' }} lh-1 ls-n2">
                        {{ UtillsHelper::rupee() . UtillsHelper::moneyFormatIndia($current_month_total, true) }}
                    </span>
                    <span class="fw-semibold fs-6 text-primary-new mt-2">
                        {{ number_format($current_month_count) }} transactions (P: {{ $current_month_primary_count }},
                        S: {{ $current_month_secondary_count }}, PE: {{ $current_month_preipo_count }})
                    </span>
                    <span class="fw-semibold fs-3 text-primary-new mt-2">Current Month</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 text-center border-0 shadow-lg" style="background: #23272b;">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <span class="fw-bold fs-2x {{ $preipo_made_today ? 'text-success' : 'text-white' }} lh-1 ls-n2">
                        {{ UtillsHelper::rupee() . UtillsHelper::number_shorten($preipo_total) }}
                    </span>
                    <span class="fw-semibold fs-6 text-primary-new mt-2">
                        {{ number_format($preipo_total_count) }} transactions
                    </span>
                    <span class="fw-semibold fs-3 text-primary-new mt-2">Private Equity Total</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Clock Block (right aligned) -->
    {{-- <div class="row mb-4">
        <div class="col-12 d-flex justify-content-end">
            <div id="clockdate">
                <div class="clockdate-wrapper">
                    <div id="clock">{{ date('h') }}:{{ date('i') }}:{{ date('s') }}
                        <span>{{ date('A') }}</span>
                    </div>
                    <div id="date">{{ date('D') }}, {{ date('d') }} {{ date('F') }}</div>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- <div class="row mb-5"> --}}

        {{-- <div class="col-sm-6 col-xl-2-4">

            <div class="card h-lg-100">

                <div class="card-body d-flex justify-content-center align-items-center flex-column text-center p-2">

                    <div class="m-0">
                        {!! getIcon('abstract-18', 'fs-3hx text-primary') !!}
                    </div>



                    <div class="d-flex flex-column my-7 mb-0">

                        <span class="fw-bold fs-3x {{ $flag_for_today ? 'text-success' : 'text-white' }} lh-1 ls-n2">
                            {{ UtillsHelper::rupee() . UtillsHelper::moneyFormatIndia($current_month_total, true) }}
                        </span>


                        <div class="m-0">
                            <span class="fw-semibold fs-6 text-primary-new">
                                {{ number_format($current_month_count) }} transactions
                                (P: {{ $current_month_primary_count }},
                                S: {{ $current_month_secondary_count }},
                                PE: {{ $current_month_preipo_count }})
                            </span>
                        </div>

                        <div class="m-0">
                            <span class="fw-semibold fs-2x text-primary-new">
                                Current month
                            </span>
                        </div>

                        <hr style="border-color: #444; margin: 1rem 0; width: 100%;">


                        <span class="fw-bold fs-3x text-white lh-1 ls-n2" style="margin-top: 1rem;">
                            {{ UtillsHelper::rupee() . UtillsHelper::moneyFormatIndia($total_amount, true) }}
                        </span>


                        <div class="m-0">
                            <span class="fw-semibold fs-6 text-primary-new">
                                {{ number_format($total_count) }} total transactions
                            </span>
                        </div>

                        <div class="m-0" style="margin-top: 1rem;">
                            <span class="fw-semibold fs-6 text-primary-new">
                                {{ number_format($overall_active_investor_count) }} active investors overall
                            </span>
                        </div>


                        <div class="m-0">
                            <span class="fw-semibold fs-2x text-primary-new">
                                Overall total
                            </span>
                        </div>

                    </div>

                </div>

            </div>

        </div> --}}


        <!--begin::Col-->
        {{-- <div class="col-sm-6 col-xl-2-4">
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

                        <div class="m-0">
                            <span class="fw-semibold fs-6 text-primary-new">
                                {{ number_format($primary_total_count) }} transactions
                            </span>
                        </div>

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
        </div> --}}
        <!--end::Col-->

        <!--begin::Col-->
        {{-- <div class="col-sm-6 col-xl-2-4">
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

                        <div class="m-0">
                            <span class="fw-semibold fs-6 text-primary-new">
                                {{ number_format($secondary_total_count) }} transactions
                            </span>
                        </div>

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
        </div> --}}
        <!--end::Col-->

        <!--begin::Col-->
        {{-- <div class="col-sm-6 col-xl-2-4">
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

                        <div class="m-0">
                            <span class="fw-semibold fs-6 text-primary-new">
                                {{ number_format($preipo_total_count) }} transactions
                            </span>
                        </div>

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
        </div> --}}
        <!--end::Col-->

        <!--begin::Col-->
        {{-- <div class="col-sm-6 col-xl-2-4">
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
                        <div class="dashboard-block-row">
                            <div class="dashboard-block-col">
                                <div class="card h-100 text-center border-0 shadow-lg" style="background: #23272b;">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                        <span
                                            class="fw-bold fs-2x {{ $flag_for_today ? 'text-success' : 'text-white' }} lh-1 ls-n2">
                                            {{ UtillsHelper::rupee() . UtillsHelper::moneyFormatIndia($total_amount,
                                            true) }}
                                        </span>
                                        <span class="fw-semibold fs-3 text-primary-new mt-2">Total AUM</span>
                                    </div>
                                </div>
                            </div>
                            <div class="dashboard-block-col">
                                <div class="card h-100 text-center border-0 shadow-lg" style="background: #23272b;">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                        <span
                                            class="fw-bold fs-2x {{ $flag_for_today ? 'text-success' : 'text-white' }} lh-1 ls-n2">
                                            {{ UtillsHelper::rupee() .
                                            UtillsHelper::moneyFormatIndia($current_month_total, true) }}
                                        </span>
                                        <span class="fw-semibold fs-6 text-primary-new mt-2">
                                            {{ number_format($current_month_count) }} transactions (P: {{
                                            $current_month_primary_count }}, S: {{ $current_month_secondary_count }},
                                            PE: {{ $current_month_preipo_count }})
                                        </span>
                                        <span class="fw-semibold fs-3 text-primary-new mt-2">Current Month</span>
                                    </div>
                                </div>
                            </div>
                            <div class="dashboard-block-col">
                                <div class="card h-100 text-center border-0 shadow-lg" style="background: #23272b;">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                        <span
                                            class="fw-bold fs-2x {{ $preipo_made_today ? 'text-success' : 'text-white' }} lh-1 ls-n2">
                                            {{ UtillsHelper::rupee() . UtillsHelper::number_shorten($preipo_total) }}
                                        </span>
                                        <span class="fw-semibold fs-6 text-primary-new mt-2">
                                            {{ number_format($preipo_total_count) }} transactions
                                        </span>
                                        <span class="fw-semibold fs-3 text-primary-new mt-2">Private Equity Total</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="tns mb-3" style="direction: ltr">
                            <div data-tns="true" data-tns-loop="true" data-tns-swipe-angle="false" data-tns-speed="2000"
                                data-tns-autoplay="true" data-tns-autoplay-timeout="18000" data-tns-items="3"
                                data-tns-center="true" data-tns-slide-by="true"
                                data-tns-nav-container="#kt_slider_thumbnails" data-tns-nav-as-thumbnails="true"
                                data-tns-prev-button="#kt_slider_prev" data-tns-next-button="#kt_slider_next"
                                class="slider">
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
                                                        UtillsHelper::moneyFormatIndia($startup->fund_requirement, true)
                                                        }}
                                                        /
                                                        {{ UtillsHelper::rupee() .
                                                        UtillsHelper::moneyFormatIndia($startup->total_fund_requirement,
                                                        true) }}
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

                        {{-- <div class="tns mb-3" style="direction: ltr">
                            <div data-tns="true" data-tns-loop="true" data-tns-swipe-angle="false" data-tns-speed="2000"
                                data-tns-autoplay="true" data-tns-autoplay-timeout="18000" data-tns-items="3"
                                data-tns-center="true" data-tns-slide-by="true"
                                data-tns-nav-container="#kt_slider_thumbnails" data-tns-nav-as-thumbnails="true"
                                data-tns-prev-button="#kt_slider_prev" data-tns-next-button="#kt_slider_next"
                                class="slider">
                                @foreach ($raising_now_startups as $startup)
                                <div class="col-xl-4 me-3">
                                    <div class="card h-lg-100">
                                        <div class="card-body p-2">
                                            <div class="d-flex">
                                                <div class="symbol symbol-70px flex-shrink-0 me-2">
                                                    <img class="shimmer lazy"
                                                        data-src="{{ FileUpDownHelper::get_startup_logo_url($startup) }}"
                                                        class="mw-100" alt="">
                                                </div>
                                                <div
                                                    class="d-flex align-items-center flex-wrap flex-grow-1 mt-n2 mt-lg-n1">
                                                    <div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 pe-3">
                                                        <a href="#" class="fs-1 text-white text-hover-primary fw-bold">
                                                            {{ $startup->brand_name }}
                                                        </a>
                                                        <span class="text-gray-700 fw-semibold fs-2">
                                                            Total Ask:

                                                            <span class="text-primary fw-bold">
                                                                {{ UtillsHelper::rupee() .
                                                                UtillsHelper::moneyFormatIndia($startup->fund_requirement,
                                                                true) }}
                                                            </span>
                                                        </span>
                                                    </div>
                                                    <div class="text-end py-lg-0 py-2">
                                                        <span
                                                            class="{{ $startup->percentage_completed > 70 ? 'text-success' : 'text-danger' }} fw-bolder fs-2x">
                                                            {{ $startup->percentage_completed }}%
                                                        </span>
                                                        <span
                                                            class="text-gray-700 fs-7 fw-semibold d-block">Completed</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center mt-2">
                                                <div class="text-center">
                                                    <span class="text-white fs-1">
                                                        {{ UtillsHelper::rupee() .
                                                        UtillsHelper::moneyFormatIndia($startup->investment_amount,
                                                        true) }}
                                                    </span>
                                                    <span class="text-gray-700 fs-7 fw-semibold d-block">Ask
                                                        Completed</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div> --}}



                        <!-- Today's Registered Investors Section -->
                        <div class="mb-5">
                            <div class="card card-xl-stretch h-100 border border-info shadow-lg"
                                style="background: #1a1a1a;">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="d-flex flex-column w-100">
                                            <span class="fs-4 fw-bold text-info mb-2">
                                                <i class="bi bi-person-plus-fill me-2"></i>
                                                Investors Registered Today ({{ date('d M Y') }})
                                            </span>
                                            @if(!empty($today_registered_investors) &&
                                            count($today_registered_investors) > 0)
                                            <span class="fw-bold text-white fs-5">{{ count($today_registered_investors)
                                                }} new investors
                                                registered today</span>
                                            <div class="row mt-3">
                                                @foreach($today_registered_investors as $investor)
                                                <div class="col-md-4 mb-2">
                                                    <span class="text-info fw-semibold d-block">
                                                        <i class="bi bi-person me-2"></i>{{ $investor['name'] ?? '-' }}
                                                    </span>
                                                </div>
                                                @endforeach
                                            </div>
                                            @else
                                            <span class="text-muted fw-bold">
                                                <i class="bi bi-people me-2"></i>No new registrations today
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                var hasPending = @json(!empty($pending_buy_orders) && count($pending_buy_orders) > 0);

                                if (hasPending) {
                                    function playBeep() {
                                        var ctx = new (window.AudioContext || window.webkitAudioContext)();
                                        [
                                            { freq: 523, t: 0,    dur: 0.12 }, // C5
                                            { freq: 659, t: 0.14, dur: 0.12 }, // E5
                                            { freq: 784, t: 0.28, dur: 0.12 }, // G5
                                            { freq: 1046,t: 0.42, dur: 0.3  }, // C6 - high hold
                                        ].forEach(function(n) {
                                            var osc = ctx.createOscillator();
                                            var gain = ctx.createGain();
                                            osc.connect(gain);
                                            gain.connect(ctx.destination);
                                            osc.type = 'sine';
                                            osc.frequency.setValueAtTime(n.freq, ctx.currentTime + n.t);
                                            gain.gain.setValueAtTime(0.5, ctx.currentTime + n.t);
                                            gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + n.t + n.dur);
                                            osc.start(ctx.currentTime + n.t);
                                            osc.stop(ctx.currentTime + n.t + n.dur);
                                        });
                                    }

                                    // Play 3 beeps immediately
                                    function playAlertBeeps(times, interval) {
                                        var count = 0;
                                        function beep() {
                                            if (count < times) {
                                                playBeep();
                                                count++;
                                                setTimeout(beep, interval);
                                            }
                                        }
                                        beep();
                                    }

                                    // Try to play on load
                                    try {
                                        playAlertBeeps(3, 600);
                                    } catch (e) {
                                        // Autoplay blocked — show button
                                        var btn = document.createElement('button');
                                        btn.innerText = '🔔 Play Alert Sound';
                                        btn.className = 'btn btn-warning ms-3 mt-2';
                                        btn.onclick = function () {
                                            playAlertBeeps(3, 600);
                                            btn.remove();
                                        };
                                        document.getElementById('pending-orders-section').appendChild(btn);
                                    }

                                    // Also keep repeating every 10 seconds to keep alerting
                                    setInterval(function () {
                                        playAlertBeeps(3, 600);
                                    }, 10000);
                                }
                            });
                        </script>

                        <div class="row">
                            <!-- Investor Card - Left Half -->
                            <div class="col-md-6">
                                <div class="card card-xl-stretch h-100">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="d-flex flex-column w-100">
                                                @if($active_user_today > 0)
                                                <span class="text-white text-hover-primary fs-6 fw-bold mb-2">
                                                    Today's Active Investors <span
                                                        class="badge bg-light text-dark fs-8  ms-2 align-middle">
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
                            {{-- <div class="col-md-6">
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
                            </div> --}}
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
    document.addEventListener('DOMContentLoaded', function() {
        function startTime() {
            var clockEl = document.getElementById("clock");
            if (!clockEl) return;
            clockEl.innerHTML = '';
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
            clockEl.innerHTML = hr + ":" + min + ":" + sec + " " + ap;

            var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October',
                'November', 'December'
            ];
            var days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            var curWeekDay = days[today.getDay()];
            var curDay = today.getDate();
            var curMonth = months[today.getMonth()];
            var curYear = today.getFullYear();
            var date = curWeekDay + ", " + curDay + " " + curMonth;
            var dateEl = document.getElementById("date");
            if (dateEl) dateEl.innerHTML = date;

            setTimeout(function() {
                startTime()
            }, 500);
        }
        function checkTime(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }
        startTime();

        // Fullscreen clock double-click
        var clockDateDiv = document.getElementById('clockdate');
        if (clockDateDiv) {
            clockDateDiv.addEventListener('dblclick', () => {
                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen().catch(err => {
                        alert(`Error trying to enable fullscreen: ${err.message}`);
                    });
                } else {
                    document.exitFullscreen();
                }
            });
        }

        // Play sound only if there are pending orders
        var hasPending = @json(!empty($pending_buy_orders) && count($pending_buy_orders) > 0);
        if (hasPending) {
            var audio = document.getElementById('order-alert-sound');
            if (audio) {
                // Check if audio file loads
                audio.onerror = function() {
                    var msg = document.createElement('span');
                    msg.innerText = 'Alert sound file missing or not supported!';
                    msg.className = 'text-danger fw-bold ms-3';
                    audio.parentNode.appendChild(msg);
                };
                // Required for Chrome/modern browsers: play after user interaction
                var playPromise = audio.play();
                if (playPromise !== undefined) {
                    playPromise.catch(function(error) {
                        // Show a button if autoplay fails
                        var btn = document.createElement('button');
                        btn.innerText = 'Play Alert Sound';
                        btn.className = 'btn btn-warning ms-3';
                        btn.onclick = function() { audio.play(); btn.remove(); };
                        audio.parentNode.appendChild(btn);
                    });
                }
            }
        }
    });
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