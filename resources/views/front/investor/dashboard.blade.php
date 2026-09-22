@extends('front.layouts.dashboard')
@push('custom-scripts')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="{{ asset('front-assets/js/plugin/chart.js') }}"></script>
@endpush
@section('child-content')
    <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="v-pills-home-tab">

            <div class="top_status_content">

                <div class="all_status">
                    <div class="item invested">
                        <h2>{{ $statistics['total_startup_invested'] }}</h2>
                        <p>Startup invested</p>
                    </div>
                    <div class="item invested_amount">
                        <h2>{{ UtillsHelper::rupee() }}{{ UtillsHelper::number_shorten($statistics['total_investment_amount']) }}
                        </h2>
                        <p>Total invested amount</p>
                    </div>
                    {{-- <div class="item gain">
                        <h2>{{ UtillsHelper::rupee() }}{{ UtillsHelper::number_shorten($statistics['profit_booked']) }}</h2>
                        <p>Overall Gain</p>
                    </div> --}}
                    <div class="item gain">
                        <h2>{{ UtillsHelper::rupee() }}{{ UtillsHelper::number_shorten($statistics['profit_booked']) }}</h2>
                        <p>Profit Booked</p>
                    </div>
                    <div class="item gain">
                        <h2>{{ UtillsHelper::rupee() }}{{ UtillsHelper::number_shorten($statistics['current_portfolio_value']) }}
                        </h2>
                        <p>Portfolio Value</p>
                    </div>
                </div>
                <div class="expand_details">
                    <button class=" details" type="button" data-bs-toggle="collapse" data-bs-target="#details"
                        aria-expanded="false" aria-controls="collapseExample">
                        <span class="show">Show Details</span>
                        <i class="fa-solid fa-angle-down"></i>
                    </button>
                    <div class="collapse" id="details">
                        <div class="card card-body">
                            <div class="table_scroll">
                                <table class="responsive">
                                    <thead>
                                        <tr>
                                            <th>Startup Name</th>
                                            <th>Total Invested Amount</th>
                                            {{-- <th>Overall Gain</th> --}}
                                            <th>Profit Booked</th>
                                            <th>Portfolio Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($statistics['list'] as $value)
                                            <tr>
                                                <td width="35%" data-label="User Name">
                                                    {{ $value['startup_name'] }}
                                                </td>
                                                <td width="30%" data-label="Total invested">
                                                    {{ UtillsHelper::rupee() }}{{ UtillsHelper::number_shorten($value['investment_amount']) }}
                                                </td>
                                                <td width="20%" data-label="Profit">
                                                    {{ UtillsHelper::rupee() }}0
                                                </td>
                                                <td data-label="Portfolio Value">
                                                    {{ UtillsHelper::rupee() }}{{ UtillsHelper::number_shorten($value['current_value']) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dashboard-item-block">
                <div class="row">
                    <div class="col-md-12">
                        <div class="bg_style business-pending-tasks">
                            <h4>Pending Tasks</h4>
                            <div class="row">
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <a class="pending-counter" href="#">
                                        <h3 class="pending-text">{{ $pending_tasks['ssa_sign'] }}</h3>
                                        <p class="pending-text">SSA Sign</p>
                                    </a>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <a class="pending-counter" href="#">
                                        <h3 class="pending-text">{{ $pending_tasks['offer_sign'] }}</h3>
                                        <p class="pending-text">Offer Sign</p>
                                    </a>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <a class="pending-counter" href="#">
                                        <h3 class="pending-text">{{ $pending_tasks['sha_sign'] }}</h3>
                                        <p class="pending-text">SHA Sign</p>
                                    </a>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <a class="pending-counter" href="#">
                                        <h3 class="pending-text">{{ $pending_tasks['fund_transfer'] }}</h3>
                                        <p class="pending-text">Fund Transfer</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 col-sm-12 col-xs-12">
                        <div class="bg_style">
                            <h4>Sector Bifurcation</h4>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <canvas width="100%" height="100%" id="kycNonKycChart"></canvas>
                                    <h5 class="child-title">Numbers</h5>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <canvas width="100%" height="100%" id="kycNonKycChart2"></canvas>
                                    <h5 class="child-title">Investments</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 col-sm-12 col-xs-12">
                        <div class="bg_style">
                            <h4>Investment Growth</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div width="100%" id="barchart_material"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="bg_style">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Investments</h4>
                                </div>
                                <div class="col-md-6 text-right">
                                    <ul class="wm-radio-btns">
                                        <li>
                                            <input type="radio" id="yearlylinechart" class="chkTypeRadio"
                                                name="radiolinechart" onchange="lineOnChange(this.value)" value="2"
                                                checked />
                                            <label for="yearlylinechart">Yearly</label>
                                        </li>
                                        <li>
                                            <input type="radio" id="monthlylinechart" class="chkTypeRadio"
                                                name="radiolinechart" onchange="lineOnChange(this.value)" value="0" />
                                            <label for="monthlylinechart">Monthly</label>
                                        </li>
                                        <li>
                                            <input type="radio" id="quarterlylinechart" class="chkTypeRadio"
                                                name="radiolinechart" onchange="lineOnChange(this.value)" value="1"
                                                checked />
                                            <label for="quarterlylinechart">Quarterly</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div width="100%" id="linechart_material"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="dashboard-single-card" style="padding: 27px;">
                            <h3>{{ UtillsHelper::rupee() }}{{ UtillsHelper::moneyFormatIndia($average_ticket_size) }}</h3>
                            <p>Average Ticket Size</p>
                        </div>
                        <div class="dashboard-single-card" style="padding: 27px;">
                            <h3>
                                {{ UtillsHelper::rupee() }}{{ UtillsHelper::number_shorten($statistics['profit_booked']) }}
                            </h3>
                            <p>Profit Booked</p>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="bg_style table-top3-dis-invs">
                            <h4 style="padding: 10px 20px 10px;">Recent MIS</h4>
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Start Up</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mis as $item)
                                        <tr>
                                            <td>{{ $item->startup->brand_name }} - {!! UtillsHelper::stringReadMoreInline($item->description, 15) !!}</td>
                                            <td class="text-center">
                                                <a href="{{ route('download.web', ['path' => $item->document, 'name' => 'MIS_' . $item->startup->brand_name . '_' . $item->title]) }}"
                                                    class="download btn_custom_line small-btn">
                                                    <i class="fa-solid fa-download"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('custom-scripts')
        <script src="{{ asset('front-assets/js/custom/auth/investor/dashboard.js') }}"></script>
        <script>
            setSectorNumberChart(@json($sectors));
        </script>
    @endpush
@endsection
