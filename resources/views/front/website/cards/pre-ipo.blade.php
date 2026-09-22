@extends('front.website.master')
@section('title')
Pre-IPO
@endsection
@section('content')
<section class="pre-ipo-main-companies scroll-animate">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-lg-5 col-sm-12 col-md-12 slide-from-left">
                <h1 class="heading mb-4">Invest in <span class="highlight-blue"> the Future</h1>
                <p class="paragraph animate-child" style="margin-bottom: 3.5rem;">
                    Discover exclusive opportunities in high-growth Pre-IPO companies. Tap into private markets, gain
                    early access to potential unicorns, and diversify your portfolio before they go public.
                </p>
                <a href="{{ route('front.abt') }}" class="common-cta-btn">Trending Stocks <i
                        class="fa fa-arrow-right"></i></a>
            </div>
            <div class="col-lg-1">
            </div>
            <div class="col-lg-6 col-sm-12 col-md-12 pre-ipo-container slide-from-right">
                <div class="img-container">
                    <img src="{{ asset('website-assets/images/mockups/preipo/main_companies.png') }}" alt="preipo" />
                </div>
            </div>
        </div>
    </div>
</section>

<section class="listed-companies-slider scroll-animate">
    <div class="container">
        <h2 class="heading mb-5"><span class="highlight-blue">Trending</span> Companies</h2>
        <div class="slider-container">
            <div class="company-slider" id="companySlider">
                @foreach($listedCompanies as $company)
                <div class="company-card">
                    <div class="card-logo">
                        <img src="{{ \App\Helpers\FileUpDownHelper::get_company_logo_url($company) }}"
                            alt="{{ $company->company_name }}">
                    </div>
                    <div class="card-content">
                        <div class="card-details">
                            <p><strong>Industry:</strong> <span>{{ $company->sector->MasterIndustry->name ?? 'N/A'
                                    }}</span></p>
                            <p><strong>Sector:</strong> <span>{{ $company->sector->name ?? 'N/A' }}</span></p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('front.company.detail', $company->uuid) }}" class="learn-more-btn">
                                Learn More <i class="fa fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach

                {{-- Duplicate cards for seamless loop --}}
                @foreach($listedCompanies as $company)
                <div class="company-card" style="border-color: {{ $company->bg_color_code ?? '#333' }}">
                    <div class="card-logo">
                        <img src="{{ \App\Helpers\FileUpDownHelper::get_company_logo_url($company) }}"
                            alt="{{ $company->company_name }}">
                    </div>
                    <div class="card-content">
                        <div class="card-details">
                            <p><strong>Industry:</strong> <span>{{ $company->sector->MasterIndustry->name ?? 'N/A'
                                    }}</span></p>
                            <p><strong>Sector:</strong> <span>{{ $company->sector->name ?? 'N/A' }}</span></p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('front.company.detail', $company->uuid) }}" class="learn-more-btn">
                                Learn More <i class="fa fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>


<section class="invest-early-preipo scroll-animate">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-10 col-md-12 col-sm-12">
                <div class="preipo-content">
                    <h1 class="heading">Invest Early in <span class="highlight-blue">India's Top Pre-IPO
                            Companies</span></h1>
                    <p class="paragraph">
                        Invest early in tomorrow’s market leaders with PrivateDeals. Get access to exclusive Pre-IPO
                        opportunities shaping India’s future.
                    </p>

                    <div class="store-buttons animate-child"
                        style="display: flex; justify-content: center; gap: 20px; margin-top: 40px; flex-wrap: nowrap;">
                        <a href="https://play.google.com/store/apps/developer?id=PrivateDeals"
                            class="store-button play-store" target="_blank" onclick="addRipple(event, this)">
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
            </div>
        </div>
    </div>
</section>


<section class="exclusive-deals-slider scroll-animate">
    <div class="container">
        <h2 class="heading mb-5">Exclusive <span class="highlight-blue">Deals</span></h2>
        <div class="row">
            @foreach($exclusiveDealsCompanies as $company)
            <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                <div class="exclusive-card">
                    <div class="exclusive-card-logo">
                        <img src="{{ \App\Helpers\FileUpDownHelper::get_company_logo_url($company) }}"
                            alt="{{ $company->company_name }}">
                    </div>
                    <div class="exclusive-card-content">
                        <h3 class="exclusive-company-name">{{ $company->company_name }}</h3>
                        <div class="exclusive-card-details">
                            <p><strong>Industry:</strong> <span>{{ $company->sector->MasterIndustry->name ?? 'Sports'
                                    }}</span></p>
                            <p><strong>Sector:</strong> <span>{{ $company->sector->name ?? 'Cricket' }}</span></p>
                        </div>
                    </div>
                    <div class="exclusive-card-arrow">
                        <a href="{{ route('front.company.detail', $company->uuid) }}">
                            <i class="fa-solid fa-chevron-right" style="font-weight: 900;font-size: 1.3rem;"></i>

                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>



@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
    let slider = document.getElementById('companySlider');
    let isTouch = false;

    // Detect touch devices
    if ('ontouchstart' in window || navigator.maxTouchPoints > 0) {
        isTouch = true;
    }

    // For mobile devices, pause animation on touch
    if (isTouch) {
        slider.addEventListener('touchstart', function() {
            slider.style.animationPlayState = 'paused';
        });

        slider.addEventListener('touchend', function() {
            setTimeout(() => {
                slider.style.animationPlayState = 'running';
            }, 2000); // Resume after 2 seconds
        });
    }

    // Pause on focus for accessibility
    slider.addEventListener('focusin', function() {
        slider.style.animationPlayState = 'paused';
    });

    slider.addEventListener('focusout', function() {
        slider.style.animationPlayState = 'running';
    });
});
</script>