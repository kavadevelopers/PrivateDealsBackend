@extends('front.website.master')
@section('title')
About Us
@endsection
@section('content')
{{-- <section class="about-us scroll-animate">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-lg-5 col-sm-12 col-md-12 slide-from-left">
                <h1 class="heading">We Always <span class="highlight-blue"> Make The Best</h1>
                <p class="paragraph">
                    Streamline operations, boost revenue, and cut costs with fully integrated software to manage
                    payments and revenue operations efficiently and support innovative business models.
                </p>
            </div>
            <div class="col-lg-1">
            </div>
            <div class="col-lg-6 col-sm-12 col-md-12 about-container slide-from-right">
                <div class="img-container">
                    <img src="{{ asset('website-assets/images/mockups/aboutus/main.png') }}" alt="about us" />
                </div>
            </div>
        </div>
    </div>
</section> --}}

<section class="about-us scroll-animate">
    <img class="background-img desktop-bg" src="{{ asset('website-assets/images/mockups/aboutus/main-bg.png') }}"
        alt="About Background" />
    <!-- Mobile Image -->
    <img class="background-img mobile-bg" src="{{ asset('website-assets/images/mockups/aboutus/main-bg-mobile.png') }}"
        alt="About Background Mobile" />
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12 text-center slide-from-bottom">
                <h1 class="heading animate-child">About Us</h1>
                <p class="paragraph animate-child">
                    Shuru-Up is redefining private market investing by bridging the gap between ambitious investors and
                    tomorrow’s most promising companies. We make it simple to discover, evaluate, and invest in Pre-IPO,
                    startup, and private equity opportunities — all on a secure, transparent, and seamless digital
                    platform.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- <section class="mission-section">
    <div class="container">
        <div class="mission-container">
            <!-- Mission Section -->
            <div class="left-mission">
                <div class="mission-content">
                    <h3><span class="highlight-blue"> Our Mission</span></h3>
                    <p>To make India’s private markets accessible to all by delivering a frictionless, secure, and
                        transparent investment experience across Pre-IPOs, Startups, and Private Equity.</p>
                </div>
            </div>

            <!-- Vision Section -->
            <div class="right-mission">
                <div class="mission-content">
                    <h3><span class="highlight-blue">Our Vision</span></h3>
                    <p>To lead the future of private market investing by enabling wealth managers and investors to
                        unlock early-stage value and participate in tomorrow’s success stories — today.</p>
                </div>
            </div>

            <!-- Video Container -->
            <div class="mission-video-container">
                <video autoplay muted playsinline>
                    <source src="{{ asset('website-assets/images/mockups/video/aboutus/mission-vision-goals-1.mp4') }}"
                        type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
</section>
<section class="goals-section">
    <div class="container">
        <div class="goals-container">
            <div class="goals-content">
                <div class="mission-content">
                    <h3><span class="highlight-blue">Our Goals</span></h3>
                    <ul>
                        <li>Digitize and simplify private market investing end-to-end

                        </li>
                        <li>Build a network of 10,000+ empowered wealth professionals</li>
                        <li>Offer only vetted, high-potential investment opportunities

                        </li>
                        <li>Promote financial literacy and trust in unlisted markets</li>
                    </ul>
                </div>
            </div>

            <!-- Goals Video Container -->
            <div class="goals-video-container">
                <video autoplay muted playsinline>
                    <source src="{{ asset('website-assets/images/mockups/video/aboutus/mission-vision-goals-2.mp4') }}"
                        type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>
</section> --}}

<section class="vision-mission-section">
    <div class="container">
        <div class="vision-mission-container">
            <!-- Mission Content -->
            <div class="left-mission">
                <div class="mission-content">
                    <h3><span class="highlight-blue">Mission</span></h3>
                    <p>To democratize access to India's private markets by providing seamless, secure</p>
                </div>
            </div>

            <!-- Vision Content -->
            <div class="right-mission">
                <div class="mission-content">
                    <h3><span class="highlight-blue">Vision</span></h3>
                    <p>To be the leading private market platform — empowering wealth managers and investors with early,
                        transparent access.</p>
                </div>
            </div>

            <!-- Video Container -->
            <div class="vision-mission-video-container">
                <!-- Desktop Video -->
                <video id="visionMissionVideo" class="desktop-video" muted playsinline>
                    <source src="{{ asset('website-assets/images/mockups/video/aboutus/mission-vision.mp4') }}"
                        type="video/mp4">
                    Your browser does not support the video tag.
                </video>

                <!-- Mobile Video -->
                <video id="visionMissionVideoMobile" class="mobile-video" muted playsinline>
                    <source src="{{ asset('website-assets/images/mockups/video/aboutus/mission-vision-mobile.mp4') }}"
                        type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>
</section>




<section class="journey-section">
    <div class="container">
        <!-- Journey Heading -->
        <h1 class="heading" style="text-align: center;">Our <span class="highlight-blue">Journey</span></h1>

        <div class="journey-container">
            <!-- Step 01 - Spotted the Gap -->
            <div class="step-01">
                <div class="journey-content">
                    <h3>Spotted the Gap</h3>
                    <p>Limited access to high-growth private markets inspired us to build a better solution.</p>
                </div>
            </div>

            <!-- Step 02 - Built the Platform -->
            <div class="step-02">
                <div class="journey-content">
                    <h3>Built the Platform</h3>
                    <p>We created a seamless, digital gateway to Pre-IPO, Startup & Private Equity deals.</p>
                </div>
            </div>

            <!-- Step 03 - Enabled Easy Access -->
            <div class="step-03">
                <div class="journey-content">
                    <h3>Enabled Easy Access</h3>
                    <p>One-click KYC, curated deals & real-time tracking made investing simple and secure.</p>
                </div>
            </div>

            <!-- Step 04 - Growing the Network -->
            <div class="step-04">
                <div class="journey-content">
                    <h3>Growing the Network</h3>
                    <p>Now trusted by wealth managers and investors across India — and growing fast.</p>
                </div>
            </div>

            <!-- Desktop Video Container -->
            <div class="journey-video-container desktop-video">
                <video autoplay muted playsinline>
                    <source src="{{ asset('website-assets/images/mockups/video/aboutus/journey.mp4') }}"
                        type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>

            <!-- Mobile Video Container -->
            <div class="journey-video-container mobile-video">
                <video autoplay muted playsinline>
                    <source src="{{ asset('website-assets/images/mockups/video/aboutus/journey-mobile.mp4') }}"
                        type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>
</section>




<section class="why-shuru-up scroll-animate">
    <div class="container">
        <!-- Centered heading section -->
        <div class="row justify-content-center">
            <div class="col-lg-12 text-center mb-4">
                <h2 class="main-heading">Why <span class="highlight-blue">Choose Shuru–Up?</span></h2>
            </div>
        </div>

        <!-- Content and image section -->
        <div class="row d-flex align-items-center">
            <div class="col-lg-6 col-sm-12 col-md-12 order-1 order-lg-1 slide-from-left">
                <div class="shuru-up-content">
                    <h2 class="heading">Step Into Elite Startup Deals <span class="highlight-blue">Startup Deals</span>
                    </h2>
                    <p class="paragraph">
                        Experience the future of startup investments with our platform. We provide curated, high-growth
                        opportunities with digital onboarding and transparent reporting. From advisory support to
                        real-time tracking, Shuru-Up empowers investors and wealth managers to invest in the next
                        generation of startups.
                    </p>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12 col-md-12 order-2 order-lg-2 why-shuru-up-image-container slide-from-right">
                <div class="img-container">
                    <img src="{{ asset('website-assets/images/mockups/aboutus/why-shuruup.png') }}"
                        alt="Why Shuru-Up" />
                </div>
            </div>
        </div>
    </div>
</section>



{{-- <section class="financial-payments scroll-animate">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-lg-6 col-sm-12 col-md-12 order-2 order-lg-1 financial-image-container slide-from-left">
                <div class="img-container">
                    <img src="{{ asset('website-assets/images/mockups/aboutus/main-bg.png') }}"
                        alt="Financial & Payments Products" />
                </div>
            </div>
            <div class="col-lg-6 col-sm-12 col-md-12 order-1 order-lg-2 slide-from-right">
                <div class="financial-content">
                    <h1 class="heading"><span class="highlight-blue">Financial & Payments</span> Products</h1>
                    <p class="paragraph">
                        Reduce costs, grow revenue, and run your business more efficiently on a fully integrated
                        platform. Use Stripe to handle payments, subscriptions, and financial operations seamlessly.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section> --}}

{{-- <section class="business-solutions scroll-animate">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-lg-6 col-sm-12 col-md-12 order-1 order-lg-1 slide-from-left">
                <div class="business-content">
                    <h1 class="heading"><span class="highlight-blue">Why Choose Us</span> for Your Investment Journey
                    </h1>
                    <p class="paragraph">
                        Scale your business with our comprehensive suite of tools designed to streamline operations,
                        enhance customer experience, and drive sustainable growth across all your business verticals.
                    </p>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12 col-md-12 order-2 order-lg-2 business-image-container slide-from-right">
                <div class="img-container">
                    <img src="{{ asset('website-assets/images/mockups/aboutus/business_solution.png') }}"
                        alt="Advanced Solutions" />
                </div>
            </div>
        </div>
    </div>
</section> --}}

{{-- <section class="about-us-detail" id="about-us-details-section">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-lg-6 col-sm-12 col-md-12">
                <div class="row text-center">
                    <div class="col-6 mb-4">
                        <div class="box">
                            <img src="{{ asset('website-assets/images/about-us/bulb.svg') }}" alt="Innovative"
                                class="box-icon">
                            <h4>Innovative</h4>
                        </div>
                    </div>
                    <div class="col-6 mb-4 mt-3">
                        <div class="box">
                            <img src="{{ asset('website-assets/images/about-us/leadership.svg') }}" alt="Opportunity"
                                class="box-icon">
                            <h4>Opportunity</h4>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="box">
                            <img src="{{ asset('website-assets/images/about-us/insights.svg') }}"
                                alt="Data-Driven Insights" class="box-icon">
                            <h4>Data-Driven Insights</h4>
                        </div>
                    </div>
                    <div class="col-6 mb-4 mt-3">
                        <div class="box">
                            <img src="{{ asset('website-assets/images/about-us/growth.svg') }}" alt="Growth-Focused"
                                class="box-icon">
                            <h4>Growth-Focused</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12 col-md-12">
                <h1 class="mb-4 heading">Why Choose Shuru-Up for Your Investment Journey</h1>
                <p class="paragraph">Discover the unique advantages, expert insights, and growth-driven opportunities at
                    your fingertips, making Shuru-Up the trusted partner for innovative and impactful investments.
                </p>
                <a href="{{ url('contactus') }}" class="btn btn-light custom-button">Contact Us</a>
            </div>
        </div>
    </div>
</section>
<section class="about-portfolio" id="about-portfolio-section">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-lg-5 col-sm-12 col-md-12">
                <h6 class="mb-4">Our Portfolio</h6>
                <h1 class="mb-4 heading">Investing in Startups That Shape the Future</h1>
                <p class="paragraph">Our portfolio showcases a diverse range of high-potential startups that are
                    redefining industries and driving innovation. We focus on partnering with visionary entrepreneurs
                    who are developing disruptive technologies and business models. By providing strategic support and
                    resources, we empower these startups to scale rapidly, unlock new opportunities, and deliver
                    exceptional growth and value to our investors.</p>
                <div style="clear:both;"></div>
            </div>
            <div class="col-lg-1">
            </div>
            <div class="col-lg-6 col-sm-12 col-md-12">
                <div class="img-container">
                    <img src="{{ asset('website-assets/images/portfolio-banner.svg') }}" alt="About Shuru">
                </div>
            </div>
        </div>
    </div>
</section> --}}


<section class="faq-section scroll-animate">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="faq-header">
                    <h1 class="heading">
                        <span class="highlight-blue">Frequently Asked</span> Questions
                    </h1>
                    {{-- <p class="paragraph">
                        Get answers to the most common questions about our investment platform and services.
                    </p> --}}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="faq-container">
                    @if($faqs && $faqs->count() > 0)
                    @foreach($faqs as $index => $faq)
                    <div class="faq-item">
                        <div class="faq-question">
                            <h5>{{ $faq->question }}</h5>
                            <span class="faq-toggle">
                                <i class="fas fa-plus"></i>
                            </span>
                        </div>
                        <div class="faq-answer" style="display: none;">
                            <div class="faq-answer-content">
                                <p>{!! nl2br(e($faq->answer)) !!}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="text-center">
                        <p style="color: #ffffff;">No FAQs available at the moment.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- @section('content') --}}
{{-- <section class="ezy__team4 dark">
    <div class="container">
        <div class="row justify-content-center mb-4 mb-md-5 mt-4">
            <div class="col-lg-6 col-xl-5 text-center">
                <h2 class="ezy__team4-heading mb-3">Our Team</h2>
                <p class="ezy__team4-sub-heading mb-0">
                    Meet our passionate team dedicated to innovation, excellence, and delivering impactful results.
                </p>
            </div>
        </div>

        <!-- Co-Founders Row -->
        <div class="row justify-content-center mb-4">
            <div class="col-6 col-md-4 col-xl-2 mb-4">
                <div class="ezy__team4-item">
                    <img src="{{ asset('website-assets/images/team/kedar.jpg') }}" alt="Kedar Dave"
                        class="img-fluid w-100" />
                    <div class="ezy__team4-content px-3 py-3 px-xl-4">
                        <h4 class="mb-1">Kedar Dave</h4>
                        <p class="small mb-2">Co-Founder / CEO</p>
                        <div class="ezy__team4-social-links">
                            <a href="https://www.linkedin.com/in/kedar-dave-0b897855/" target="_blank">
                                <span class="fab fa-linkedin-in"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl-2 mb-4">
                <div class="ezy__team4-item">
                    <img src="{{ asset('website-assets/images/team/viral.jpg') }}" alt="Dr. Viral Shah"
                        class="img-fluid w-100" />
                    <div class="ezy__team4-content px-3 py-3 px-xl-4">
                        <h4 class="mb-1">Dr. Viral Shah</h4>
                        <p class="small mb-2">Co-Founder</p>
                        <div class="ezy__team4-social-links">
                            <a href="https://www.linkedin.com/in/viral-shah-79213211a/" target="_blank">
                                <span class="fab fa-linkedin-in"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl-2 mb-4">
                <div class="ezy__team4-item">
                    <img src="{{ asset('website-assets/images/team/harsh.png') }}" alt="CA Harsh Mehta"
                        class="img-fluid w-100" />
                    <div class="ezy__team4-content px-3 py-3 px-xl-4">
                        <h4 class="mb-1">CA Harsh Mehta</h4>
                        <p class="small mb-2">Co-Founder</p>
                        <div class="ezy__team4-social-links">
                            <a href="https://www.linkedin.com/in/ca-harsh-mehta-6334664a/" target="_blank">
                                <span class="fab fa-linkedin-in"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl-2 mb-4">
                <div class="ezy__team4-item">
                    <img src="{{ asset('website-assets/images/team/kunal.jpg') }}" alt="Kunal Mehta"
                        class="img-fluid w-100" />
                    <div class="ezy__team4-content px-3 py-3 px-xl-4">
                        <h4 class="mb-1">Kunal Mehta</h4>
                        <p class="small mb-2">Co-Founder</p>
                        <div class="ezy__team4-social-links">
                            <a href="https://www.linkedin.com/in/kunal-mehta-6083a325/" target="_blank">
                                <span class="fab fa-linkedin-in"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl-2 mb-4">
                <div class="ezy__team4-item">
                    <img src="{{ asset('website-assets/images/team/lokesh.jpg') }}" alt="ADV. Lokesh Shah"
                        class="img-fluid w-100" />
                    <div class="ezy__team4-content px-3 py-3 px-xl-4">
                        <h4 class="mb-1">ADV. Lokesh Shah</h4>
                        <p class="small mb-2">Co-Founder</p>
                        <div class="ezy__team4-social-links">
                            <a href="https://www.linkedin.com/in/adv-cs-lokesh-shah-93b5aa87/" target="_blank">
                                <span class="fab fa-linkedin-in"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Other Team Members -->
        <div class="row justify-content-center">
            <div class="col-6 col-md-4 col-xl-2 mb-4">
                <div class="ezy__team4-item">
                    <img src="{{ asset('website-assets/images/team/naishadh.jpeg') }}" alt="Naishadh Dave"
                        class="img-fluid w-100" />
                    <div class="ezy__team4-content px-3 py-3 px-xl-4">
                        <h4 class="mb-1">Naishadh Dave</h4>
                        <p class="small mb-2">CTO</p>
                        <div class="ezy__team4-social-links">
                            <a href="https://www.linkedin.com/in/dave-naishadh/" target="_blank">
                                <span class="fab fa-linkedin-in"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl-2 mb-4">
                <div class="ezy__team4-item">
                    <img src="{{ asset('website-assets/images/team/punit.jpg') }}" alt="Punit Keswani"
                        class="img-fluid w-100" />
                    <div class="ezy__team4-content px-3 py-3 px-xl-4">
                        <h4 class="mb-1">Punit Keswani</h4>
                        <p class="small mb-2">Investment Associate</p>
                        <div class="ezy__team4-social-links">
                            <a href="https://www.linkedin.com/in/punitkeswani/" target="_blank">
                                <span class="fab fa-linkedin-in"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl-2 mb-4">
                <div class="ezy__team4-item">
                    <img src="{{ asset('website-assets/images/team/swati.jpg') }}" alt="Swati Kaushik"
                        class="img-fluid w-100" />
                    <div class="ezy__team4-content px-3 py-3 px-xl-4">
                        <h4 class="mb-1">Swati Kaushik</h4>
                        <p class="small mb-2">Investment Analyst</p>
                        <div class="ezy__team4-social-links">
                            <a href="https://www.linkedin.com/in/swati-kaushik-0435741a2/" target="_blank">
                                <span class="fab fa-linkedin-in"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl-2 mb-4">
                <div class="ezy__team4-item">
                    <img src="{{ asset('website-assets/images/team/satya.jpg') }}" alt="Satya Patel"
                        class="img-fluid w-100" />
                    <div class="ezy__team4-content px-3 py-3 px-xl-4">
                        <h4 class="mb-1">Satya Patel</h4>
                        <p class="small mb-2">Investment Associate</p>
                        <div class="ezy__team4-social-links">
                            <a href="https://www.linkedin.com/in/satya-patel-52b090219/" target="_blank">
                                <span class="fab fa-linkedin-in"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl-2 mb-4">
                <div class="ezy__team4-item">
                    <img src="{{ asset('website-assets/images/team/mehul.jpg') }}" alt="Mehul Kava"
                        class="img-fluid w-100" />
                    <div class="ezy__team4-content px-3 py-3 px-xl-4">
                        <h4 class="mb-1">Mehul Kava</h4>
                        <p class="small mb-2">Product Manager</p>
                        <div class="ezy__team4-social-links">
                            <a href="https://www.linkedin.com/in/mehul-kava-6140b0105/" target="_blank">
                                <span class="fab fa-linkedin-in"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl-2 mb-4">
                <div class="ezy__team4-item">
                    <img src="{{ asset('website-assets/images/team/jigyasa.jpg') }}" alt="CS Jigyasa Sukhwal"
                        class="img-fluid w-100" />
                    <div class="ezy__team4-content px-3 py-3 px-xl-4">
                        <h4 class="mb-1">CS Jigyasa Sukhwal</h4>
                        <p class="small mb-2">Legal & Compliance</p>
                        <div class="ezy__team4-social-links">
                            <a href="https://www.linkedin.com/in/jigyasasukhwal11/" target="_blank">
                                <span class="fab fa-linkedin-in"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl-2 mb-4">
                <div class="ezy__team4-item">
                    <img src="{{ asset('website-assets/images/team/yash.png') }}" alt="Yash Savaj"
                        class="img-fluid w-100" />
                    <div class="ezy__team4-content px-3 py-3 px-xl-4">
                        <h4 class="mb-1">Yash Savaj</h4>
                        <p class="small mb-2">Flutter Developer</p>
                        <div class="ezy__team4-social-links">
                            <a href="https://www.linkedin.com/in/yash-savaj-2979621aa/" target="_blank">
                                <span class="fab fa-linkedin-in"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl-2 mb-4">
                <div class="ezy__team4-item">
                    <img src="{{ asset('website-assets/images/team/mohit.jpg') }}" alt="Mohit Janwani"
                        class="img-fluid w-100" />
                    <div class="ezy__team4-content px-3 py-3 px-xl-4">
                        <h4 class="mb-1">Mohit Janwani</h4>
                        <p class="small mb-2">Full-Stack Developer</p>
                        <div class="ezy__team4-social-links">
                            <a href="https://www.linkedin.com/in/mohit-janwani-40081822a/" target="_blank">
                                <span class="fab fa-linkedin-in"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}

<style>
    .ezy__team4 {
        /* Bootstrap variables */
        --bs-body-color: #212529;
        --bs-body-bg: rgb(255, 255, 255);

        /* Easy Frontend variables */
        --ezy-theme-color: rgb(13, 110, 253);
        --ezy-theme-color-rgb: 13, 110, 253;
        --ezy-item-bg: #ffffff;
        --ezy-item-shadow: 0px 4px 44px rgba(159, 190, 218, 0.37);

        background: var(--bs-body-bg);
        overflow: hidden;
        padding: 40px 0;
    }

    @media (min-width: 768px) {
        .ezy__team4 {
            padding: 80px 0;
        }
    }

    @media (min-width: 992px) {
        .ezy__team4 {
            padding: 100px 0;
        }
    }

    /* Gray Block Style */
    .gray .ezy__team4,
    .ezy__team4.gray {
        /* Bootstrap variables */
        --bs-body-bg: rgb(246, 246, 246);

        /* Easy Frontend variables */
        --ezy-item-bg: #fff;
        --ezy-item-shadow: 0px 4px 44px rgba(199, 227, 252, 0.17);
    }

    /* Dark Gray Block Style */
    .dark-gray .ezy__team4,
    .ezy__team4.dark-gray {
        /* Bootstrap variables */
        --bs-body-color: #ffffff;
        --bs-body-bg: rgb(30, 39, 53);

        /* Easy Frontend variables */
        --ezy-item-bg: rgb(11, 23, 39);
        --ezy-item-shadow: none;
    }

    /* Dark Block Style */
    .dark .ezy__team4,
    .ezy__team4.dark {
        /* Bootstrap variables */
        --bs-body-color: #ffffff;
        /* --bs-body-bg: rgb(11, 23, 39); */
        --bs-body-bg: #000000;

        /* Easy Frontend variables */
        --ezy-item-bg: rgb(30, 39, 53);
        --ezy-item-shadow: none;
    }

    .ezy__team4-heading {
        font-weight: bold;
        font-size: 28px;
        line-height: 32px;
        color: var(--bs-body-color);
    }

    @media (min-width: 768px) {
        .ezy__team4-heading {
            font-size: 36px;
            line-height: 40px;
        }
    }

    @media (min-width: 992px) {
        .ezy__team4-heading {
            font-size: 45px;
            line-height: 45px;
        }
    }

    .ezy__team4-sub-heading {
        font-size: 14px;
        line-height: 20px;
        color: var(--bs-body-color);
    }

    @media (min-width: 768px) {
        .ezy__team4-sub-heading {
            font-size: 16px;
            line-height: 22px;
        }
    }

    .ezy__team4-item {
        background-color: var(--ezy-item-bg);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: var(--ezy-item-shadow);
        transition: transform 0.25s ease-in-out, box-shadow 0.25s ease-in-out;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .ezy__team4-item:hover {
        transform: translateY(-3px);
    }

    .ezy__team4-item img {
        border-radius: 8px;
        padding: 6px;
        filter: grayscale(100%);
        transition: filter 0.3s ease-in-out;
        aspect-ratio: 1;
        object-fit: cover;
    }

    @media (min-width: 768px) {
        .ezy__team4-item img {
            border-radius: 12px;
            padding: 8px;
        }
    }

    .ezy__team4-item:hover img {
        filter: grayscale(0%);
    }

    .ezy__team4-content {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 12px 16px !important;
    }

    @media (min-width: 768px) {
        .ezy__team4-content {
            padding: 16px 20px !important;
        }
    }

    .ezy__team4-content * {
        color: var(--bs-body-color);
    }

    .ezy__team4-content h4 {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 4px !important;
    }

    @media (min-width: 768px) {
        .ezy__team4-content h4 {
            font-size: 1.1rem;
            margin-bottom: 6px !important;
        }
    }

    @media (min-width: 992px) {
        .ezy__team4-content h4 {
            font-size: 1.2rem;
            margin-bottom: 8px !important;
        }
    }

    .ezy__team4-content p.small {
        font-size: 0.8rem;
        margin-bottom: 8px !important;
        opacity: 0.8;
    }

    @media (min-width: 768px) {
        .ezy__team4-content p.small {
            font-size: 0.85rem;
            margin-bottom: 10px !important;
        }
    }

    @media (min-width: 992px) {
        .ezy__team4-content p.small {
            font-size: 0.9rem;
            margin-bottom: 12px !important;
        }
    }

    .ezy__team4-social-links {
        margin-top: auto;
    }

    .ezy__team4-social-links a {
        display: inline-block;
        opacity: 0.6;
        transition: opacity 0.25s ease-in-out, transform 0.25s ease-in-out, color 0.25s ease-in-out;
        font-size: 16px;
    }

    @media (min-width: 768px) {
        .ezy__team4-social-links a {
            font-size: 18px;
        }
    }

    .ezy__team4-social-links a:hover {
        opacity: 1;
    }

    /* Mobile-specific improvements */
    @media (max-width: 575px) {
        .ezy__team4 {
            padding: 60px 0;
        }

        .ezy__team4-heading {
            font-size: 24px;
            line-height: 28px;
        }

        .ezy__team4-sub-heading {
            font-size: 13px;
            line-height: 18px;
        }

        .ezy__team4-item {
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .ezy__team4-content h4 {
            font-size: 0.9rem;
        }

        .ezy__team4-content p.small {
            font-size: 0.75rem;
        }
    }

    /* Tablet-specific improvements */
    @media (min-width: 576px) and (max-width: 991px) {
        .ezy__team4-item {
            margin-bottom: 25px;
        }
    }

    /* Remove active class styling since we're not using it */
    .ezy__team4-item.active {
        /* No special styling needed */
    }
</style>
{{-- @endsection --}}

@endsection