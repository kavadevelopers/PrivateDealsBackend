@extends('front.website.master')
@section('title')
Smart Investing
@endsection
@section('content')

<section class="video-section">
    <div class="video-wrapper">
        <video class="background-video desktop-video" autoplay muted playsinline>
            <source src="{{ asset('website-assets/images/mockups/video/smart-investing/how-to-use-app.mp4') }}"
                type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <video class="background-video mobile-video" autoplay muted playsinline>
            <source src="{{ asset('website-assets/images/mockups/video/smart-investing/how-to-use-app-mobile.mp4') }}"
                type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
</section>



<section class="terminal-functions scroll-animate">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-lg-6 col-sm-12 col-md-12 order-2 order-lg-1 slide-from-left">
                <div class="buttons-container">
                    <div class="terminal-functions-custom-button green">
                        <div class="arrow-btn">
                            <i class="fa fa-arrow-right"></i>
                        </div>
                        <span class="button-text">Quick KYC</span>
                        <div class="button-content">
                            Get verified in just minutes with our fully digital KYC process — no paperwork, no delays,
                            just instant access.
                        </div>
                    </div>

                    <div class="terminal-functions-custom-button yellow">
                        <div class="arrow-btn">
                            <i class="fa fa-arrow-right"></i>
                        </div>
                        <span class="button-text">Top Deals</span>
                        <div class="button-content">
                            Explore curated Pre-IPO, startup, and private equity deals tailored to help you invest early
                            and grow smarter.
                        </div>
                    </div>

                    <div class="terminal-functions-custom-button blue">
                        <div class="arrow-btn">
                            <i class="fa fa-arrow-right"></i>
                        </div>
                        <span class="button-text">Track Portfolio</span>
                        <div class="button-content">
                            Stay in control with live tracking and transparent reporting of all your investments in one
                            place.

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12 col-md-12 order-1 order-lg-2 slide-from-right">
                <div class="terminal-functions-content">
                    <h1 class="heading"><span class="highlight-blue">Invest Smarter with the</span> Shuru-Up App</h1>
                    <p class="paragraph">
                        Explore India’s booming private markets with Shuru-Up — your gateway to exclusive opportunities
                        in Pre-IPOs, startups, and private equity. Invest early, grow smarter, and manage it all
                        seamlessly through one powerful app.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="terminal-feature scroll-animate">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-lg-5 col-sm-12 col-md-12 slide-from-left">
                <h1 class="heading">
                    <span class="highlight-blue">Key Features</span> That Empower Your Investments
                </h1>
                <p class="paragraph">
                    Explore powerful tools built for modern investors — from effortless onboarding to data-driven
                    insights that help you stay ahead in private markets.
                </p>

                {{-- <ul class="feature-list">
                    <li><i class="fa fa-check"></i> One click KYC</li>
                    <li><i class="fa fa-check"></i> Portfolio Insights</li>
                    <li><i class="fa fa-check"></i> Get Latest News</li>
                    <li><i class="fa fa-check"></i> Growth Analytics</li>
                </ul> --}}
                <ul class="feature-list">
                    <li>One click KYC</li>
                    <li>Portfolio Insights</li>
                    <li>Get Latest News</li>
                    <li>Growth Analytics</li>
                </ul>

            </div>
            <div class="col-lg-1">
            </div>
            <div class="col-lg-6 col-sm-12 col-md-12 terminal-feature-container slide-from-right">
                <div class="img-container">
                    <img src="{{ asset('website-assets/images/mockups/terminal/features.png') }}" alt="about us" />
                </div>
            </div>
        </div>
    </div>
</section>


{{--
<section class="terminal-exclusive-deals scroll-animate">
    <div class="container">
        <div class="terminal-exclusive-deals-content">
            <h1>
                A fully integrated suite of
                <span class="highlight-blue">financial and
                    payments</span> products
            </h1>
            <p>
                At Shuru–Up, we are redefining how private equity investments are made. Our mission is simple –
                unlocking
                opportunities in private markets by providing investors exclusive access to high-potential private
                companies.
                We aim to bridge the gap between investors and exceptional private companies, empowering you to access
                unique opportunities that have the potential for exponential growth.unique opportunities that have the
                potential for exponential growth.unique opportunities that have the potential for exponential
                growth.unique opportunities that have the potential for exponential growth.unique opportunities that
                have the potential for exponential growth.
            </p>
            <div class="store-buttons">
                <a href="https://play.google.com/store/apps/developer?id=Shuru-Up" class="store-button play-store"
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
    </div>
</section> --}}


{{-- <div class="terminal-details">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-lg-3 col-md-12">
                <h6 class="">About Terminal</h6>
                <h1 class="heading">Shuru-Up Terminal Functions</h1>
                <p style="paragraph">Shuruup focuses on connecting retail investors and startups in the
                    unlisted
                    space.
                    Our ecosystem fosters a healthy investment flow and enables startups to secure the funds they
                    need
                    while
                    providing liquidity options for investors.</p>
            </div>

            <div class="col-lg-6 col-md-12 mb-4">
                <div class="img-container">
                    <img src="{{ asset('website-assets/images/terminal-details/invest-details.svg') }}"
                        alt="Shuru-Up Terminal Functions" class="p-5">
                </div>
            </div>

            <div class="col-lg-3 col-md-12 col-sm-12">
                <ul class="list">
                    <h6 class="pb-4">Features</h6>
                    <li>Democratizing Investments</li>
                    <li>Startup Growth Support</li>
                    <li>Secondary Transactions</li>
                    <li>Community-Driven Ecosystem</li>
                    <li>Data-Driven Insights</li>
                    <li>Diverse Startup Portfolio</li>
                    <li>Long-Term Value Creation</li>
                </ul>
            </div>
        </div>
    </div>
</div> --}}

{{-- <section class="investors-dashboard" id="investors-dashboard">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-lg-6 col-sm-12 col-md-12 text-section">
                <h1 class="heading">Investors<br>Dashboard</h1>
                <div class="custom-line"> </div>
                <div class="feature">
                    <h3>Comprehensive Investment Overview</h3>
                    <p>The dashboard provides users with a clear snapshot of their overall gain, total invested
                        amount,
                        portfolio value, and profit, helping them track their investment performance at a
                        glance.</p>
                </div>
                <div class="feature">
                    <h3>Startup Growth Support</h3>
                    <p>The dashboard showcases key metrics such as the number of startups invested in, making it
                        easy
                        for investors to stay informed about their portfolio's diversity and growth.</p>
                </div>
                <div class="feature">
                    <h3>Secondary Transactions</h3>
                    <p>It highlights pending tasks such as signing agreements (SSA, SHA, Offer Sign) and fund
                        transfers,
                        streamlining the investment process and keeping users on track with their commitments.
                    </p>
                </div>
                <div class="feature">
                    <h3>Data-Driven Insights</h3>
                    <p>With clear investment growth charts, users can track how their investments have performed
                        over
                        time, offering them a visual representation of growth and helping to forecast future
                        trends.</p>
                </div>
            </div>

            <!-- Dashboard UI Section -->
            <div class="col-lg-6 col-sm-12 col-md-12">
                <div class="img-container">
                    <img class="desktop-image"
                        src="{{ asset('website-assets/images/terminal-details/dashboard-1.svg') }}" alt="Dashboard UI">
                    <img class="mobile-image" src="{{ asset('website-assets/images/terminal-details/mobile-1.svg') }}"
                        alt="Mobile UI">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="investors-dashboard" id="investors-dashboard">
    <div class="container">
        <div class="content-wrapper">
            <div class="row d-flex align-items-center">
                <div class="col-lg-6 col-sm-12 col-md-12">
                    <div class="img-container">
                        <img class="desktop-image"
                            src="{{ asset('website-assets/images/terminal-details/dashboard-2.svg') }}" alt="Dashboard">
                        <img class="mobile-image"
                            src="{{ asset('website-assets/images/terminal-details/mobile-2.svg') }}" alt="Mobile UI">
                    </div>
                </div>

                <div class="col-lg-6 col-sm-12 col-md-12 text-section">
                    <h1 class="heading">Secondary<br>Transaction</h1>
                    <div class="custom-line"> </div>
                    <div class="feature">
                        <h3>Enhanced Portfolio Liquidity
                        </h3>
                        <p>Unlock flexibility and control over your investments with improved liquidity options,
                            allowing
                            you to navigate and capitalize on market opportunities with ease.

                        </p>
                    </div>
                    <div class="feature">
                        <h3>Data-Driven Investment Insights
                        </h3>
                        <p>Make informed investment decisions supported by real-time, data-driven insights tailored to
                            optimize your portfolio's performance and growth.
                        </p>
                    </div>
                    <div class="feature">
                        <h3>Low-Cost Transactions
                        </h3>
                        <p>Maximize returns with a cost-efficient transaction model designed to reduce expenses,
                            empowering
                            you to focus on growth without the burden of high fees.

                        </p>
                    </div>
                    <div class="feature">
                        <h3>Integrated Escrow for Secure Transactions
                        </h3>
                        <p>Benefit from an added layer of security with escrow services that ensure funds are securely
                            held
                            and released only when all transaction conditions are met</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="investors-dashboard" id="investors-dashboard">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-lg-6 col-sm-12 col-md-12 text-section">
                <h1 class="heading">Wealth Manager<br>Dashboard</h1>
                <div class="custom-line"> </div>
                <div class="feature">
                    <h3>Comprehensive Dashboard for Investment Overview
                    </h3>
                    <p>The Wealth Manager Dashboard provides a detailed overview, regular updates, and MIS reports of
                        clients' investments, allowing wealth managers to monitor and manage client portfolios
                        efficiently within one unified platform.
                    </p>
                </div>
                <div class="feature">
                    <h3>Manage Investment on Behalf of Investors
                    </h3>
                    <p>This feature enables wealth managers to commit investments on behalf of clients, streamlining
                        processes and ensuring timely, hassle-free transactions for a smoother investment experience.
                    </p>
                </div>
                <div class="feature">
                    <h3>Fund Management for Startup Portfolios
                    </h3>
                    <p>Wealth managers can fully oversee clients’ startup portfolios, providing personalized insights
                        and optimizing investment decisions to align with each client’s unique goals and growth
                        strategy.

                    </p>
                </div>
                <div class="feature">
                    <h3>One-Stop Solution for Your Private Equity Needs
                    </h3>
                    <p>Shuru-Up provides wealth managers with a comprehensive, customizable platform to manage and
                        optimize clients' private equity investments seamlessly.</p>
                </div>
            </div>

            <!-- Dashboard UI Section -->
            <div class="col-lg-6 col-sm-12 col-md-12">
                <div class="img-container">
                    <img class="desktop-image"
                        src="{{ asset('website-assets/images/terminal-details/dashboard-3.svg') }}" alt="Dashboard">
                    <img class="mobile-image" src="{{ asset('website-assets/images/terminal-details/mobile-3.svg') }}"
                        alt="Mobile UI">
                </div>
            </div>
        </div>
    </div>
</section> --}}


<section class="how-it-works-section">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="heading">
                    How it <span class="highlight-blue">Works?</span>
                </h2>
            </div>
        </div>
    </div>
    <div class="video-container">
        <video class="how-it-works-video" autoplay muted playsinline>
            <source src="{{ asset('website-assets/images/mockups/video/smart-investing/how-it-works.mp4') }}"
                type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
</section>
@endsection