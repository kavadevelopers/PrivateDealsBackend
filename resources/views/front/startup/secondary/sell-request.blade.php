@extends('front.layouts.dashboard')
@section('child-content')
    <div class="noob tab-pane fade show" id="portfolio" role="tabpanel" aria-labelledby="v-pills-home-tab">
        <div class="top_section">
            <h3>{{ getPageTitle() }}</h3>
        </div>
        @if ($list->count() > 0)
            <div class="scroll_content">
                <div class="card-list">
                    @foreach ($list->get() as $key => $value)
                        <div class="card-item">
                            <div class="row">
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="user_info">
                                        <div class="name_type">
                                            <h3>{{ $value->investor->name }}</h3>
                                            <p class="mb-0"><b>Status : {{ $value->current_status }}</b></p>
                                            <p><b>{{ strtoupper($value->instrument) }}</b></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="user_info">
                                        <div class="name_type">
                                            <p><b>Shares : </b>{{ $value->shares }}</p>
                                            <p><b>Price :
                                                </b>{{ UtillsHelper::rupee() . UtillsHelper::moneyFormatIndia($value->price) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div style="text-align: right;" class="mb-4">
                                        @if ($value->status == 0)
                                            <a href="{{ route('front.raise.sell_requests.status', ['request' => $value->id, 'status' => '1']) }}"
                                                class="btn btn-success btn-confirm"
                                                data-message="Are you sure you want to approve?">
                                                <i class="fa-solid fa-check"></i>
                                                <span>Approve</span>
                                            </a>
                                            <a href="{{ route('front.raise.sell_requests.status', ['request' => $value->id, 'status' => '2']) }}"
                                                class="btn btn-danger btn-confirm"
                                                data-message="Are you sure you want to reject?">
                                                <i class="fa-solid fa-times"></i>
                                                <span>Reject</span>
                                            </a>
                                        @else
                                            <span class="btn btn-warning">
                                                <i class="fa-solid fa-spinner fa-spin"></i>
                                                <span>In Progress</span>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            @include('front.common.nodata', ['text' => 'Sell Request'])
        @endif
    </div>
@endsection
