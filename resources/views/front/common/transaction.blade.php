@extends('front.layouts.dashboard')

@section('child-content')
    <div class="noob tab-pane fade show" id="portfolio" role="tabpanel" aria-labelledby="v-pills-home-tab">
        <div class="top_section">
            <h3 class="main_title">{{ getPageTitle() }}</h3>
        </div>
        @if ($transactionlist->count() > 0)
            <div class="scroll_content">
                <div class="card-list">
                    @foreach ($transactionlist->get() as $item)
                        <div class="card-item">
                            <div class="row">
                                <div class="col-md-5 col-sm-6 col-xs-12">
                                    <div class="user_info">
                                        <div class="logo">
                                            @if (Auth::guard('startup')->check())
                                                <img
                                                    class="lazy shimmer"data-src="{{ FileUpDownHelper::get_investor_profile_photo_url($item->investor) }}">
                                            @else
                                                <img
                                                    class="lazy shimmer"data-src="{{ FileUpDownHelper::get_startup_logo_url($item->startup) }}">
                                            @endif
                                        </div>
                                        <div class="name_type">
                                            @if (Auth::guard('startup')->check())
                                                <h3>{{ $item->investor->name }}</h3>
                                            @else
                                                <h3>{{ $item->startup->brand_name }}</h3>
                                            @endif
                                            <p>Type: <span class="bold">{{ $item->instrument }}</span></p>
                                            <p>Amount Invested: <span
                                                    class="bold">{{ UtillsHelper::number_shorten($item->investment_amount) }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7 col-sm-6 col-xs-12">
                                    <div>
                                        <p>Current Status : <span class="bold">{{ $item->current_status }}</span></p>
                                        <p>Next Step : <span class="bold">{!! $item->next_step !!}</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div>
                                        <div style="text-align: right;" class="mb-4">
                                            @if ($item->ssa_document)
                                                <a href="{{ route('download.web', ['path' => $item->ssa_document->signed_path, 'name' => $item->ssa_document->display_name]) }}"
                                                    class="btn_custom small-btn">
                                                    <i class="fa-solid fa-download"></i> SSA
                                                </a>
                                            @endif
                                            @if ($item->mgt_challan_document)
                                                <a href="{{ route('download.web', ['path' => $item->mgt_challan_document->signed_path, 'name' => $item->mgt_challan_document->display_name]) }}"
                                                    class="btn_custom small-btn">
                                                    <i class="fa-solid fa-download"></i> MGT-14 Challan
                                                </a>
                                            @endif
                                            @if ($item->mgt_zip_document)
                                                <a href="{{ route('download.web', ['path' => $item->mgt_zip_document->signed_path, 'name' => $item->mgt_zip_document->display_name]) }}"
                                                    class="btn_custom small-btn">
                                                    <i class="fa-solid fa-download"></i> MGT-14 Zip
                                                </a>
                                            @endif
                                            @if ($item->offer_document)
                                                <a href="{{ route('download.web', ['path' => $item->offer_document->signed_path, 'name' => $item->offer_document->display_name]) }}"
                                                    class="btn_custom small-btn">
                                                    <i class="fa-solid fa-download"></i> Offer Letter
                                                </a>
                                            @endif
                                            @if ($item->rtgs_receipt)
                                                <a href="{{ route('download.web', ['path' => $item->rtgs_receipt->signed_path, 'name' => $item->rtgs_receipt->display_name]) }}"
                                                    class="btn_custom small-btn">
                                                    <i class="fa-solid fa-download"></i> RTGS Receipt
                                                </a>
                                            @endif
                                            @if ($item->counter_slip)
                                                <a href="{{ route('download.web', ['path' => $item->counter_slip->signed_path, 'name' => $item->counter_slip->display_name]) }}"
                                                    class="btn_custom small-btn">
                                                    <i class="fa-solid fa-download"></i> Cheque Counter Receipt
                                                </a>
                                            @endif
                                            @if ($item->pas_zip_document)
                                                <a href="{{ route('download.web', ['path' => $item->pas_zip_document->signed_path, 'name' => $item->pas_zip_document->display_name]) }}"
                                                    class="btn_custom small-btn">
                                                    <i class="fa-solid fa-download"></i> PAS3 Zip
                                                </a>
                                            @endif
                                            @if ($item->sha_document)
                                                <a href="{{ route('download.web', ['path' => $item->sha_document->signed_path, 'name' => $item->sha_document->display_name]) }}"
                                                    class="btn_custom small-btn">
                                                    <i class="fa-solid fa-download"></i> SHA
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        @else
            @include('front.common.nodata', ['text' => 'Transactions'])
        @endif
    </div>
@endsection
