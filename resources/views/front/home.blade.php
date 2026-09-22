@extends('front.layouts.master')
@section('content')
    <div class="home">
        <div id="main">
            <section class="container_custom">
                <div class="slider">
                    <div class="content">
                        <div class="info">
                            <h1>Providing A Better Way To Invest</h1>
                            <p>
                                Investing in start-ups is now at your fingertips. You can Meet, Greet, Invest, Exit and Stay
                                connected with start-ups on the same platform.
                            </p>
                            <div class="button_group">
                                <a href="#" class="btn_custom">Get Started</a>
                                <a href="#" class="video btn-open-video-player"
                                    data-video="{{ asset('core/video/intro-video.mp4') }}"><i
                                        class="far fa-circle-play"></i><span>Tour
                                        Video</span></a>
                            </div>
                        </div>
                        <div class="image">
                            <img src="{{ asset('front-assets/images/slider_banner.png') }}" alt="" />
                        </div>
                    </div>
                </div>
            </section>

            @include('front.partials.statistics')

            <section class="sector">
                <div class="container_custom">
                    <div class="content">
                        <div class="top">
                            <h2>Featured Sectors</h2>
                        </div>
                        <div class="feature-swiper">
                            <div class="swiper-wrapper">
                                @foreach (App\Models\MasterSectorsModel::where('is_deleted', '0')->orderby('display_order', 'asc')->get() as $item)
                                    <div class="swiper-slide">
                                        <a href="{{ route('front.sector.startups', $item->url_slug) }}"
                                            class="card_custom_feature">
                                            <div class="icon">
                                                <img class="lazy shimmer"
                                                    data-src="{{ FileUpDownHelper::get_master_sector_url($item->icon_image) }}" />
                                            </div>
                                            <h3>{{ $item->name }}</h3>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="live_deals">
                <section class="container_custom">
                    <div class="content">
                        <div class="top">
                            <h2>Live Deals</h2>
                        </div>
                        <div class="all_card">
                            {{-- @if ($livedeals)
                                @foreach ($livedeals as $key => $value)
                                    @include('front.child.startup-block', ['value' => $value])
                                @endforeach
                            @endif --}}
                        </div>
                        {{-- <a href="{{ url(Common::business('startups/raising-now')) }}" class="btn_custom explore">Explore All</a> --}}
                    </div>
                </section>
            </div>

            <section class="insights home-insights" style="margin-top:50px;">
                <div class="container_custom">
                    <div class="content">
                        <div class="top">
                            <h2>Featured</h2>
                        </div>
                        <div class="all_cards">
                            @foreach (App\Models\MasterBlogModel::where('is_deleted', '0')->orderby('display_order', 'asc')->limit(4)->get() as $key => $value)
                                @include('front.partials.childs.blog-card', compact('value'))
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            @include('front.partials.childs.home-terms-condition')
        </div>
    </div>
@endsection
