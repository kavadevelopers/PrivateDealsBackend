@extends('front.layouts.dashboard')

@section('child-content')
    <div class="noob tab-pane fade show" id="portfolio" role="tabpanel" aria-labelledby="v-pills-home-tab">
        <div class="top_section">
            <h3 class="main_title">Transaction</h3>
        </div>
        <div class="scroll_content">
            <div class="card-list">
                <div class="card-item">
                    <div class="row">
                        <div class="col-md-5 col-sm-6 col-xs-12">
                            <div class="user_info">
                                <div class="logo">
                                    <img src="{{ asset('front-assets/images/volt_logo.png') }}" alt="" />
                                </div>
                                <div class="name_type">
                                    <h3>Sport Volt</h3>
                                    <p>Type: <span class="bold">CCPS</span></p>
                                    <p>Amount Invested: <span class="bold">643Cr</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-6 col-xs-12">
                            <div>
                                <p>Current Status : <span class="bold">Committed</span></p>
                                <p>Next Step : <span class="bold">SSA Generation</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="actions d-flex justify-content-end gap-2">
                                <button class="download btn btn-outline-primary">
                                    <i class="fa-solid fa-download"></i> SSA
                                </button>
                                <button class="download btn btn-outline-danger">
                                    <i class="fa-solid fa-download"></i> SHA
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
