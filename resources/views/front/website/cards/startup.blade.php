@extends('front.website.master')
@section('title')
Startup
@endsection
@section('content')
<section class="startup-companies scroll-animate">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-lg-5 col-sm-12 col-md-12 slide-from-left">
                <h1 class="heading mb-4">Fuel Your <span class="highlight-blue"> Startup’s Growth</h1>
                <p class="paragraph animate-child" style="margin-bottom: 3.5rem;">
                    Launch and grow your venture with a platform built for speed, scale, and simplicity. PrivateDeals helps
                    startups access private investments, streamline fundraising, and focus on what matters most —
                    building the future.
                </p>
                <a href="#startup-secondary-section" class="common-cta-btn">Explore More <i
                        class="fa fa-arrow-right"></i></a>
            </div>
            <div class="col-lg-1">
            </div>
            <div class="col-lg-6 col-sm-12 col-md-12 startup-companies-container slide-from-right">
                <div class="img-container">
                    <img src="{{ asset('website-assets/images/mockups/startup/startup_companies.png') }}"
                        alt="preipo" />
                </div>
            </div>
        </div>
    </div>
</section>

<section class="startup-secondary-section scroll-animate" id="startup-secondary-section">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div
                class="col-lg-6 col-sm-12 col-md-12 order-2 order-lg-1 startup-secondary-image-container slide-from-left">
                <div class="img-container">
                    <img src="{{ asset('website-assets/images/mockups/startup/secondary.png') }}"
                        alt="Financial & Payments Products" />
                </div>
            </div>
            <div class="col-lg-6 col-sm-12 col-md-12 order-1 order-lg-2 slide-from-right">
                <div class="startup-secondary-content">
                    <h1 class="heading"><span class="highlight-blue">Smart Financial
                        </span> Tools</h1>
                    <p class="paragraph animate-child" style="margin-bottom: 3.5rem;">
                        Run leaner and smarter with integrated solutions for payments, subscriptions, and revenue
                        operations. Our tech-driven tools reduce overhead, improve cash flow, optimize resources, and
                        keep your startup financially agile, scalable, and ready for sustainable growth.
                    </p>
                    <a href="https://play.google.com/store/apps/developer?id=PrivateDeals" target="_blank"
                        class="common-cta-btn mt-4">Explore More <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="start-growth-detail scroll-animate">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-lg-6 col-sm-12 col-md-12 order-1 order-lg-1 slide-from-left">
                <div class="financial-content">
                    <h1 class="heading animate-child">Comprehensive Growth Analytics for
                        <span class="highlight-blue">Smarter Startup Investments</span>
                    </h1>
                </div>
                <div class="store-buttons animate-child">
                    <a href="https://play.google.com/store/apps/developer?id=PrivateDeals" class="store-button play-store"
                        target="_blank" onclick="addRipple(event, this)">
                        <svg class="store-icon" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M3,20.5V3.5C3,2.91 3.34,2.39 3.84,2.15L13.69,12L3.84,21.85C3.34,21.61 3,21.09 3,20.5M16.81,15.12L6.05,21.34L14.54,12.85L16.81,15.12M20.16,10.81C20.5,11.08 20.75,11.5 20.75,12C20.75,12.5 20.53,12.92 20.18,13.18L17.89,14.5L15.39,12L17.89,9.5L20.16,10.81M6.05,2.66L16.81,8.88L14.54,11.15L6.05,2.66Z" />
                        </svg>
                        <div class="store-text">
                            <div class="store-text-small">Download on</div>
                            <div class="store-text-large">Play Store</div>
                        </div>
                    </a>

                    <a href="https://apps.apple.com/us/developer/shuru-advisory-private-limited/id1773764563"
                        target="_blank" class="store-button app-store" onclick="addRipple(event, this)">
                        <svg class="store-icon" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M18.71,19.5C17.88,20.74 17,21.95 15.66,21.97C14.32,22 13.89,21.18 12.37,21.18C10.84,21.18 10.37,21.95 9.1,22C7.79,22.05 6.8,20.68 5.96,19.47C4.25,17 2.94,12.45 4.7,9.39C5.57,7.87 7.13,6.91 8.82,6.88C10.1,6.86 11.32,7.75 12.11,7.75C12.89,7.75 14.37,6.68 15.92,6.84C16.57,6.87 18.39,7.1 19.56,8.82C19.47,8.88 17.39,10.1 17.41,12.63C17.44,15.65 20.06,16.66 20.09,16.67C20.06,16.74 19.67,18.11 18.71,19.5M13,3.5C13.73,2.67 14.94,2.04 15.94,2C16.07,3.17 15.6,4.35 14.9,5.19C14.21,6.04 13.07,6.7 11.95,6.61C11.8,5.46 12.36,4.26 13,3.5Z" />
                        </svg>
                        <div class="store-text">
                            <div class="store-text-small">Get it on</div>
                            <div class="store-text-large">App Store</div>
                        </div>
                    </a>
                </div>
            </div>
            <div
                class="col-lg-6 col-sm-12 col-md-12 order-2 order-lg-2 start-growth-detail-image-container slide-from-right">
                <div class="img-container">
                    <img src="{{ asset('website-assets/images/mockups/startup/growth.png') }}"
                        alt="Growth Analytics Dashboard" />
                </div>
            </div>
        </div>
    </div>
</section>

<section class="start-news-slider scroll-animate">
    <div class="container">
        <!-- Content section - left aligned -->
        <div class="row">
            <div class="col-12">
                <h1 class="heading animate-child">Startup <span class="highlight-blue">Insights</span></h1>
                <p class="paragraph animate-child">
                    Stay updated with the latest stories, market insights, and platform announcements from the world of
                    private equity, startups, and Pre-IPOs. Explore expert opinions, company highlights, and PrivateDeals's
                    media coverage — all in one place.
                </p>
            </div>
        </div>

        <!-- Slider section below -->
        <div class="row">
            <div class="col-12">
                <div class="news-slider-wrapper">
                    <div class="news-slider" id="startNewsSlider">
                        @if(isset($bloglist) && $bloglist->count() > 0)
                        @foreach ($bloglist as $blog)
                        <div class="news-card">
                            <div class="image-wrap">
                                <img src="{{ $blog['banner_url'] ?? asset('assets/images/placeholder-blog.jpg') }}"
                                    alt="{{ $blog['title'] }}" loading="lazy" />

                                <!-- Overlay info box -->
                                <div class="info-overlay">
                                    <div class="title">
                                        {{ UtillsHelper::read_more_hide($blog['title'], 80) }}
                                    </div>
                                    <div class="description">
                                        {{ UtillsHelper::read_more_hide($blog['description'] ??
                                        $blog['short_description'], 200) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <!-- Placeholder cards if no blogs -->
                        <div class="news-card placeholder-card">
                            <div class="image-wrap">
                                <div class="placeholder-image"></div>
                                <div class="info-overlay">
                                    <div class="title">No content available at the moment</div>
                                    <div class="description">We're working hard to bring you the latest news and
                                        insights from the world of private equity, startups, and Pre-IPOs. Check back
                                        soon for exciting updates, market analysis, and exclusive stories that matter to
                                        your investment journey.</div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Pagination dots -->
                    {{-- <div class="slider-pagination" id="sliderPagination"></div> --}}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.documentElement.style.scrollBehavior = 'smooth';
        const exploreButton = document.querySelector('a[href="#startup-secondary-section"]');
        if (exploreButton) {
            exploreButton.addEventListener('click', function(e) {
                e.preventDefault();
                const targetSection = document.getElementById('startup-secondary-section');
                if (targetSection) {
                    targetSection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        }
    });


</script>