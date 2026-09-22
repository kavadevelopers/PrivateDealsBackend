@extends('front.layouts.dashboard')

@section('child-content')
    <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="portfolio" role="tabpanel" aria-labelledby="v-pills-home-tab">
            <div class="live_pitch_content">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#equity-portfolio" type="button" role="tab" aria-controls="pills-home"
                            aria-selected="true">Equity Portfolio</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#ccps-portfolio" type="button" role="tab" aria-controls="pills-profile"
                            aria-selected="false">CCPS Portfolio</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#ccd-portfolio" type="button" role="tab" aria-controls="pills-profile"
                            aria-selected="false">CCD Portfolio</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="equity-portfolio" role="tabpanel"
                        aria-labelledby="pills-home-tab">
                        <div class="scroll_content">
                            <div class="all-p-cards">
                                @if ($equity->count() > 0)
                                    @foreach ($equity->get() as $item)
                                        @include('front.investor.partials.portfolio', ['item' => $item])
                                    @endforeach
                                @else
                                    @include('front.common.nodata', ['text' => 'Startup'])
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="ccps-portfolio" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="scroll_content">
                            <div class="all-p-cards">
                                @if ($ccps->count() > 0)
                                    @foreach ($ccps->get() as $item)
                                        @include('front.investor.partials.portfolio', ['item' => $item])
                                    @endforeach
                                @else
                                    @include('front.common.nodata', ['text' => 'Startup'])
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="ccd-portfolio" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="scroll_content">
                            <div class="all-p-cards">
                                @if ($ccd->count() > 0)
                                    @foreach ($ccd->get() as $item)
                                        @include('front.investor.partials.portfolio', ['item' => $item])
                                    @endforeach
                                @else
                                    @include('front.common.nodata', ['text' => 'Startup'])
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
