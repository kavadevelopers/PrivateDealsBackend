@extends('front.layouts.dashboard')

@section('child-content')
    
    <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="v-pills-home-tab">
            <div class="top_status_content">
                <div class="all_status">
                    <div class="item invested">
                        <h2>67</h2>
                        <p>Startup invested</p>
                    </div>
                    <div class="item invested_amount">
                        <h2>56</h2>
                        <p>Total invested amount</p>
                    </div>
                    <div class="item gain">
                        <h2>22</h2>
                        <p>Overall Gain</p>
                    </div>
                    <div class="item gain">
                        <h2>22</h2>
                        <p>Profit</p>
                    </div>
                    <div class="item gain">
                        <h2>33</h2>
                        <p>Portfolio Value</p>
                    </div>
                </div>
                <div class="expand_details">
                    <button class=" details" type="button" data-bs-toggle="collapse"
                        data-bs-target="#details" aria-expanded="false"
                        aria-controls="collapseExample">
                        <span class="show">Show Details</span>
                        <i class="fa-solid fa-angle-down"></i>
                    </button>
                    <div class="collapse" id="details">
                        <div class="card card-body">
                            <div class="table_scroll">
                                <table class="responsive">
                                    <thead>
                                        <tr>
                                            <th>User Name</th>
                                            <th>Total Invested Amount</th>
                                            <th>Overall Gain</th>
                                            <th>Profit</th>
                                            <th>Portfolio Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="25%" data-label="User Name">
                                                Shuruup
                                            </td>
                                            <td width="20%" data-label="Total invested">
                                                00
                                            </td>
                                            <td width="25%" data-label="Total invested">
                                                00
                                            </td>
                                            <td width="20%" data-label="Overall Gain">
                                                00
                                            </td>
                                            <td data-label="Overall Gain">
                                                00    
                                            </td>
                                        </tr>
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
                                        <h3 class="pending-text">00</h3>
                                        <p class="pending-text">SSA Sign</p>
                                    </a>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <a class="pending-counter" href="#">
                                        <h3 class="pending-text">00</h3>
                                        <p class="pending-text">Offer Sign</p>
                                    </a>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <a class="pending-counter" href="#">
                                        <h3 class="pending-text">00</h3>
                                        <p class="pending-text">SHA Sign</p>
                                    </a>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <a class="pending-counter" href="#">
                                        <h3 class="pending-text">00</h3>
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
                                            <input type="radio" id="monthlylinechart" class="chkTypeRadio" name="radiolinechart" onchange="lineOnChange(this.value)" value="1" />
                                            <label for="monthlylinechart">Monthly</label>
                                        </li>
                                        <li>
                                            <input type="radio" id="quarterlylinechart" class="chkTypeRadio" name="radiolinechart" onchange="lineOnChange(this.value)" value="2" checked/>
                                            <label for="quarterlylinechart">Quarterly</label>
                                        </li>
                                        <li>
                                            <input type="radio" id="yearlylinechart" class="chkTypeRadio" name="radiolinechart" onchange="lineOnChange(this.value)" value="0" checked/>
                                            <label for="yearlylinechart">Yearly</label>
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
                            <h3>00</h3>
                            <p>Average Ticket Size</p>
                        </div>
                        <div class="dashboard-single-card" style="padding: 27px;">
                            <h3>00</h3>
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
                                    <tr>
                                        <td>startupname</td>
                                        <td class="text-center">
                                            <a href="#" class="download btn_custom_line small-btn" download>
                                                <i class="fa-solid fa-download"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>






@endsection
