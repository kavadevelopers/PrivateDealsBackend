@extends('front.layouts.dashboard')

@section('child-content')
    <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="portfolio" role="tabpanel" aria-labelledby="v-pills-home-tab">
            <div class="top_section">
                <h3>{{ getPageTitle() }}</h3>
                <a href="{{ route('front.business.channel_partner.create') }}" class="btn_custom">
                    <i class="fa-solid fa-circle-plus"></i>
                    <span>Create</span>
                </a>
            </div>
            @if ($list->count() > 0)
                <div class="scroll_content">
                    <div class="all-p-cards">
                        @foreach ($list->get() as $key => $value)
                            <div class="card-p-custom">
                                <div class="user_info">
                                    <div class="logo">
                                        <img class="lazy shimmer"
                                            data-src="{{ FileUpDownHelper::get_partner_profile_photo_url($value) }}" />
                                    </div>
                                    <div class="name_type">
                                        <h3>{{ $value->name }}</h3>
                                        <p>Mobile : <span class="bold">{{ $value->mobile_number }}</span></p>
                                        <p>Email: <span class="bold">{{ $value->email }}</span></p>
                                        <p>Type: <span class="bold">{{ $value->type }}</span></p>
                                    </div>
                                </div>
                                <div>
                                    <p>Total Investors :
                                        <span class="bold">
                                            {{ count($value->investorCounter) }}
                                        </span>
                                    </p>
                                    <p>Amount Invested:
                                        <span class="bold">
                                            0
                                        </span>
                                    </p>
                                    <p>No. of StartUp:
                                        <span class="bold">0</span>
                                    </p>
                                    <p>Commission Earned:
                                        <span class="bold">
                                            0
                                        </span>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                @include('front.common.nodata', [
                    'text' => 'Channel Partner',
                ])
            @endif
        </div>
    </div>
@endsection
