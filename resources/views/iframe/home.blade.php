<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Startups - Investment Platform</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Loader Styles */
        .loader-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10000;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }

        .loader-container.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .loader {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #e3e3e3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .loader-text {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 16px;
            color: #667eea;
            font-weight: 500;
        }

        .loading-dots::after {
            content: '';
            animation: dots 1.5s infinite;
        }

        @keyframes dots {

            0%,
            20% {
                content: '';
            }

            40% {
                content: '.';
            }

            60% {
                content: '..';
            }

            80%,
            100% {
                content: '...';
            }
        }

        /* Main content initially hidden */
        .main-content {
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.5s ease 0.2s, visibility 0.5s ease 0.2s;
        }

        .main-content.loaded {
            opacity: 1;
            visibility: visible;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f8f9fa;
            color: #333;
            padding: 20px;
            min-height: 100vh;
        }

        .section {
            margin-bottom: 50px;
        }

        .section-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 28px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 8px;
        }

        .section-subtitle {
            color: #6c757d;
            font-size: 16px;
            margin: 0 auto;
            max-width: 600px;
        }

        .swiper {
            width: 100%;
            height: auto;
            padding: 20px 0 40px 0;
        }

        /* Raising Now Cards - Large with Banner */
        .swiper-slide {
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            height: auto;
            display: flex;
            flex-direction: column;
        }

        .swiper-slide:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .startup-card {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .startup-image-container {
            width: 100%;
            height: 160px;
            background: #000;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .startup-banner {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .startup-banner-placeholder {
            color: white;
            font-size: 48px;
            font-weight: bold;
            text-transform: uppercase;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .startup-content {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .startup-name {
            font-size: 18px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 8px;
            line-height: 1.3;
        }

        .startup-description {
            color: #6c757d;
            font-size: 14px;
            line-height: 1.4;
            margin-bottom: 16px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex-grow: 1;
        }

        .startup-metrics {
            display: flex;
            justify-content: space-between;
            margin-bottom: 16px;
            gap: 8px;
        }

        .metric-item {
            flex: 1;
            text-align: center;
        }

        .metric-label {
            font-size: 11px;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .metric-value {
            font-size: 14px;
            font-weight: 700;
            color: #2c3e50;
        }

        .startup-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 16px;
            border-top: 1px solid #e9ecef;
            margin-top: auto;
        }

        .startup-location {
            display: flex;
            align-items: center;
            gap: 4px;
            color: #6c757d;
            font-size: 13px;
        }

        .startup-sector {
            background: #e8f4f8;
            color: #2980b9;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        /* Completed Campaigns - Vertical Layout with Banner */
        .completed-slide {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            height: 240px !important;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .completed-slide:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }

        .completed-card {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .completed-banner-container {
            width: 100%;
            height: 120px;
            background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            flex-shrink: 0;
        }

        .completed-banner {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .completed-banner-placeholder {
            color: white;
            font-size: 32px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .completed-content {
            height: 120px;
            padding: 12px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
        }

        .completed-name {
            font-size: 14px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 6px;
            line-height: 1.2;
            height: 17px;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            flex-shrink: 0;
        }

        .completed-description {
            font-size: 11px;
            color: #6c757d;
            line-height: 1.2;
            margin-bottom: 8px;
            height: 26px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            flex-shrink: 0;
        }

        .completed-date {
            font-size: 10px;
            color: #95a5a6;
            font-weight: 500;
            height: 12px;
            line-height: 1.2;
            margin-top: auto;
            flex-shrink: 0;
        }

        /* Navigation buttons */
        .swiper-button-next,
        .swiper-button-prev {
            background: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            color: #667eea;
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 14px;
            font-weight: bold;
        }

        .swiper-pagination {
            bottom: 10px;
        }

        .swiper-pagination-bullet {
            background: #bdc3c7;
            opacity: 1;
        }

        .swiper-pagination-bullet-active {
            background: #667eea;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .startup-metrics {
                flex-direction: column;
                gap: 8px;
            }

            .metric-item {
                display: flex;
                justify-content: space-between;
                text-align: left;
            }

            .startup-details {
                flex-direction: column;
                gap: 8px;
                align-items: flex-start;
            }

            .completed-slide {
                height: 220px !important;
            }

            .completed-banner-container {
                height: 100px;
            }

            .completed-content {
                padding: 10px;
            }

            .section-title {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>
    <!-- Loader -->
    <div class="loader-container" id="loader">
        <div class="loader">
            <div class="spinner"></div>
            <div class="loader-text loading-dots">Loading</div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Raising Now Section -->
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">Raising Now</h2>
                <p class="section-subtitle">Discover promising startups currently seeking investment</p>
            </div>

            @if(!empty($data['raisingNow']))
            <div class="swiper raising-now-swiper">
                <div class="swiper-wrapper">
                    @foreach($data['raisingNow'] as $item)
                    <div class="swiper-slide">
                        <a href="/iframe/startup/{{ $item['id'] }}?access_token={{ request()->query('access_token') }}"
                            style="text-decoration: none; color: inherit; display: block; height: 100%;">
                            <div class="startup-card">
                                <div class="startup-image-container">
                                    @if(!empty($item['banner_url']))
                                    <img src="{{ $item['banner_url'] }}" alt="Banner" class="startup-banner"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="startup-banner-placeholder" style="display: none;">
                                        {{ substr($item['brand_name'] ?? $item['company_name'] ?? 'S', 0, 1) }}
                                    </div>
                                    @else
                                    <div class="startup-banner-placeholder">
                                        {{ substr($item['brand_name'] ?? $item['company_name'] ?? 'S', 0, 1) }}
                                    </div>
                                    @endif
                                </div>

                                <div class="startup-content">
                                    <h3 class="startup-name">{{ $item['brand_name'] ?? $item['company_name'] ?? 'Unnamed
                                        Startup' }}</h3>

                                    <p class="startup-description">
                                        {{ $item['brief_information'] ?? 'Innovative startup providing cutting-edge
                                        solutions for modern businesses.' }}
                                    </p>

                                    <div class="startup-metrics">
                                        <div class="metric-item">
                                            <div class="metric-label">Investors</div>
                                            <div class="metric-value">{{ $item['investor_count'] ?? 13 }}</div>
                                        </div>
                                        <div class="metric-item">
                                            <div class="metric-label">Valuation</div>
                                            <div class="metric-value"> {{ UtillsHelper::rupee() }}{{
                                                UtillsHelper::number_shorten($item['valuation'] ?? 0) }}</div>
                                        </div>
                                        <div class="metric-item">
                                            <div class="metric-label">Round Size</div>
                                            <div class="metric-value"> {{ isset($item['round_size']) ?
                                                UtillsHelper::rupee() .
                                                UtillsHelper::number_shorten($item['round_size']) : 'N/A' }}</div>
                                        </div>
                                    </div>

                                    <div class="startup-details">
                                        <div class="startup-location">
                                            <span>📍</span>
                                            <span>{{ $item['city']['name'] ?? 'Ahmedabad' }}</span>
                                        </div>
                                        <div class="startup-sector">
                                            {{ $item['sector']['name'] ?? 'Logistics' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
            @endif
        </div>

        <!-- Completed Campaigns Section -->
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">Completed Campaigns</h2>
                <p class="section-subtitle">Successfully funded startups</p>
            </div>

            @if(!empty($data['completedCampaigns']))
            <div class="swiper completed-campaigns-swiper">
                <div class="swiper-wrapper">
                    @foreach($data['completedCampaigns'] as $item)
                    <div class="swiper-slide completed-slide">
                        <div class="completed-card">
                            <div class="completed-banner-container">
                                @if(!empty($item['banner_url']))
                                <img src="{{ $item['banner_url'] }}" alt="Banner" class="completed-banner"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="completed-banner-placeholder" style="display: none;">
                                    {{ substr($item['brand_name'] ?? $item['company_name'] ?? 'S', 0, 1) }}
                                </div>
                                @else
                                <div class="completed-banner-placeholder">
                                    {{ substr($item['brand_name'] ?? $item['company_name'] ?? 'S', 0, 1) }}
                                </div>
                                @endif
                            </div>

                            <div class="completed-content">
                                <h4 class="completed-name">{{ $item['brand_name'] ?? $item['company_name'] ?? 'Unnamed
                                    Startup' }}</h4>

                                <p class="completed-description">
                                    {{ $item['brief_information'] ?? 'Successfully completed funding campaign with
                                    strong investor backing and reached target goals.' }}
                                </p>

                                <div class="completed-date">
                                    Completed {{ $item['completion_date'] ?? 'Dec 2024' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        // Loader management
        function hideLoader() {
            const loader = document.getElementById('loader');
            const mainContent = document.getElementById('mainContent');
            
            loader.classList.add('hidden');
            mainContent.classList.add('loaded');
        }

        // Wait for everything to load
        function initializeAfterLoad() {
            // Initialize Swipers
            const raisingNowSwiper = new Swiper('.raising-now-swiper', {
                slidesPerView: 1,
                spaceBetween: 20,
                centeredSlides: true,
                loop: true,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true
                },
                pagination: {
                    el: '.raising-now-swiper .swiper-pagination',
                    clickable: true,
                    dynamicBullets: true,
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        centeredSlides: false,
                    },
                    1024: {
                        slidesPerView: 3,
                        centeredSlides: false,
                    },
                    1400: {
                        slidesPerView: 4,
                        centeredSlides: false,
                    }
                },
                effect: 'slide',
                speed: 800,
            });

            const completedSwiper = new Swiper('.completed-campaigns-swiper', {
                slidesPerView: 2,
                spaceBetween: 15,
                centeredSlides: false,
                loop: false,
                navigation: {
                    nextEl: '.completed-campaigns-swiper .swiper-button-next',
                    prevEl: '.completed-campaigns-swiper .swiper-button-prev',
                },
                breakpoints: {
                    480: {
                        slidesPerView: 2,
                    },
                    768: {
                        slidesPerView: 3,
                    },
                    1024: {
                        slidesPerView: 4,
                    },
                    1400: {
                        slidesPerView: 6,
                    }
                },
                effect: 'slide',
                speed: 600,
            });

            // Hide loader after everything is initialized
            setTimeout(() => {
                hideLoader();
            }, 500); // Small delay to ensure smooth transition
        }

        // Wait for DOM and all resources to load
        window.addEventListener('load', function() {
            // Wait for images to load
            const images = document.querySelectorAll('img');
            let loadedImages = 0;
            const totalImages = images.length;

            if (totalImages === 0) {
                // No images to load
                initializeAfterLoad();
                return;
            }

            function imageLoaded() {
                loadedImages++;
                if (loadedImages === totalImages) {
                    initializeAfterLoad();
                }
            }

            images.forEach(img => {
                if (img.complete) {
                    imageLoaded();
                } else {
                    img.addEventListener('load', imageLoaded);
                    img.addEventListener('error', imageLoaded); // Count failed loads too
                }
            });

            // Fallback: hide loader after max 3 seconds regardless
            setTimeout(() => {
                if (!document.getElementById('loader').classList.contains('hidden')) {
                    initializeAfterLoad();
                }
            }, 3000);
        });

        // Fallback for when DOM is ready but resources might still be loading
        document.addEventListener('DOMContentLoaded', function() {
            // Set minimum loading time of 800ms for better UX
            setTimeout(() => {
                if (document.readyState === 'complete') {
                    initializeAfterLoad();
                }
            }, 800);
        });
    </script>
</body>

</html>