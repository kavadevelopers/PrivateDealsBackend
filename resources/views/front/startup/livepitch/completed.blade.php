@extends('front.layouts.dashboard')

@section('child-content')
    <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="v-pills-home-tab">
            <div class="update_content">
                <div class="top_section">
                    <h3>{{ getPageTitle() }}</h3>
                    <div class="col-md-6 d-flex justify-content-end">
                        <a href="{{ route('front.raise.livepitch.create') }}"  class="btn_custom">
                            <i class="fa-solid fa-circle-plus"></i>
                            <span>Create Live Pitch</span>
                        </a>
                    </div>
                </div>
                <div class="live_pitch_content">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('front.raise.livepitch.upcomingpitch') }}">
                                <button class="nav-link" id="pills-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-home" type="button" role="tab"
                                aria-controls="pills-home" aria-selected="true">Upcoming Live
                                Pitch</button></a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('front.raise.livepitch.completedpitch') }}">
                            <button class="nav-link active" id="pills-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-profile" type="button" role="tab"
                                aria-controls="pills-profile" aria-selected="false">Completed Live
                                Pitch</button>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('front.raise.livepitch.rejectedpitch') }}">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-profile" type="button" role="tab"
                                aria-controls="pills-profile" aria-selected="false">Rejected
                                Pitch</button>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            @if ($list->count() > 0)
                            <div class="all-p-cards">
                                <div class="noob tab-pane fade show" id="portfolio" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                    <div class="scroll_content">
                                        <div class="card-list">
                                            @foreach ($list as $livepitchlist)
                                            <div class="d_card">
                                                <div class="row">
                                                    <div class="col-md-5 col-sm-6 col-xs-12">
                                                        <div class="user_info">
                                                            <div class="name_type">
                                                                <p><span class="bold"> Title: </span>{{ $livepitchlist->title }}</p>  
                                                                <p><span class="bold"> Description: </span>{{ $livepitchlist->description }}</p> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7 col-sm-6 col-xs-12">
                                                        <div>
                                                            <p>Time: <span class="bold">{{ \Carbon\Carbon::parse($livepitchlist->scheduled_date)->format('h:i:s') }}</span></p>
                                                            <p>date : <span class="bold">{{ \Carbon\Carbon::parse($livepitchlist->scheduled_date)->format('d-m-Y')  }}</span></p>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                                @include('front.common.nodata', ['text' => 'Completed Livepitch'])
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script>

    </script>
@endpush



