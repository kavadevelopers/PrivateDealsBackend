@extends('front.layouts.dashboard')

@section('child-content')

    <div class="tab-pane fade show active" id="portfolio" role="tabpanel" aria-labelledby="v-pills-home-tab">
        <div class="notification_content">
            <div class="top_section">
                @if (request()->routeis('front.business.*'))
                    <h3>{{ getPageTitle() }}</h3>
                    <a href="{{ route('front.business.investor.add') }}" class="btn_custom">
                        <i class="fa-solid fa-circle-plus"></i>
                        <span>Add</span>
                    </a>
                @else
                    <h3>{{ getPageTitle() }}</h3>
                    <a href="{{ route('front.investor.family.add') }}" class="btn_custom">
                        <i class="fa-solid fa-circle-plus"></i>
                        <span>Add</span>
                    </a>
                @endif
            </div>
            @if ($list->count() > 0)
                <div class="scroll_content">
                    <div class="all-p-cards">
                        @foreach ($list->with('relation')->get() as $key => $value)
                            <div class="card-p-custom">
                                <div class="user_info">
                                    <div class="logo">
                                        <img class="shimmer lazy"
                                            data-src="{{ FileUpDownHelper::get_investor_profile_photo_url($value) }}" />
                                    </div>
                                    <div class="name_type">
                                        <h3>{{ $value->name }}</h3>
                                        <p>{{ UtillsHelper::isValidRow($value->relation, 'name') }}</p>
                                    </div>
                                </div>
                                <div>
                                    <p>Mobile : <span class="bold">{{ $value->mobile_number }}</span></p>
                                    <p>Email : <span class="bold">{{ $value->email }}</span></p>
                                </div>
                                <div>
                                    <p>KYC :
                                        <span class="bold">
                                            @if ($value->kyc_status == '1' && $value->kyc->status == \App\Enums\Utills\StatusEnum::approved->value)
                                                Verified
                                            @elseif ($value->status == '0' && $value->kyc->status == \App\Enums\Utills\StatusEnum::pending->value)
                                                Processing
                                            @else
                                                Pending
                                            @endif
                                        </span>
                                    </p>
                                    <p>Name as Aadhar : <span class="bold">
                                            @if ($value->kyc_status == '1' && $value->kyc->status == \App\Enums\Utills\StatusEnum::approved->value)
                                                {{ $value->kyc->name_as_aadhar }}
                                            @elseif ($value->status == '0' && $value->kyc->status == \App\Enums\Utills\StatusEnum::pending->value)
                                                Processing
                                            @else
                                                N/A
                                            @endif
                                        </span>
                                </div>
                                @if (!request()->routeis('front.business.*'))
                                    <div style="text-align: right;">
                                        <a href="{{ url('switch-profile/' . Illuminate\Support\Facades\Crypt::encrypt($value->id)) }}"
                                            class="btn_custom">
                                            <i class="fa-solid fa-share"></i>
                                            <span>Go To Profile</span>
                                        </a>
                                    </div>
                                @endif

                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                @include('front.common.nodata', [
                    'text' => request()->routeis('front.business.*') ? 'Investor' : 'Family member',
                ])
            @endif
        </div>
    </div>

@stop
