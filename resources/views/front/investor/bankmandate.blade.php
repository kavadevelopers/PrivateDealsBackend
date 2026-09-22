@extends('front.layouts.dashboard')

@section('child-content')
    <div class="noob tab-pane fade show" id="portfolio" role="tabpanel" aria-labelledby="v-pills-home-tab">
        <div class="top_section">
            <h3>{{ getPageTitle() }}</h3>
        </div>
        @if ($mandates->count() > 0)
            <div class="scroll_content">
                <div class="card-list">
                    @foreach ($mandates->get() as $mandateinfo)
                        <div class="card-item">
                            <div class="row">
                                <div class="col-md-5 col-sm-6 col-xs-12">
                                    <div class="user_info">
                                        <div class="logo">
                                            <img src="{{ asset('front-assets/images/bankmandate.png') }}" alt="" />
                                        </div>
                                        <div class="name_type">
                                            <h3>{{ $mandateinfo->bank_account_no }}</h3>
                                            <p>Bank : <span class="bold">{{ $mandateinfo->bank->name }}</span></p>
                                            <p>Amount : <span
                                                    class="bold">{{ UtillsHelper::rupee() }}{{ UtillsHelper::number_shorten($mandateinfo->amount) }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7 col-sm-6 col-xs-12">
                                    <div>
                                        <p>Status : <span class="bold">{{ $mandateinfo->state }}</span></p>
                                        <p>IFSC : <span class="bold">{{ $mandateinfo->bank_ifsc_code }}</span></p>
                                        <p>Account Type : <span class="bold">{{ $mandateinfo->bank_account_type }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            @include('front.common.nodata', ['text' => 'Bank Mandate'])
        @endif
    </div>
    {{-- <div class="tab-content custom-mis-list" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="v-pills-home-tab">
            <div class="top_section">
                <h3>{{ getPageTitle() }}</h3>
            </div>
            <div class="mis_upload mis_upload_list">
                @if ($mandate->count() > 0)
                    <div class="scroll_content">
                        <div class="mis_list update_list">
                            <div class="all-p-cards">
                                @foreach ($mandate as $mandateinfo)
                                    <div class="card-p-custom">
                                        <div class="user_info">
                                            <div class="logo">
                                                <img src="{{ asset('front-assets/images/bankmandate.png') }}"
                                                    alt="" />
                                            </div>
                                            <div class="name_type">
                                                <h3>{{ $mandateinfo->bank->name }}</h3>
                                            </div>
                                            <div class="name_type">
                                                <h3>{{ $mandateinfo->bank_account_no }}</h3>
                                            </div>
                                            <div class="name_type">
                                                <h3>{{ $mandateinfo->bank_account_type }}</h3>
                                            </div>
                                            <div class="name_type">
                                                <h3>{{ $mandateinfo->bank_ifsc_code }}</h3>
                                            </div>
                                        </div>
                                        <div class="descriptions">
                                            <p>
                                                Updated At :
                                                <span
                                                    class="bold">{{ DateTimeHelper::formatDateTime($mandateinfo->created_at, 'd-m-Y') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    @include('front.common.nodata', ['text' => 'Bank Mandate'])
                @endif
            </div>
        </div>

    </div> --}}
@endsection
