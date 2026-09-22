<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>{{ getPageTitle() != '' ? getPageTitle() . ' | ' : '' }}{{ CommonHelper::appSettings('app_name') }}</title>
    <meta name="description"
        content="{{ $metaDescription ?? CommonHelper::appSettings('app_meta_description') ?? 'India\'s premier platform for startup investments, primary transactions, secondary market, and pre-IPO opportunities.' }}" />
    <meta name="keywords"
        content="{{ $metaKeywords ?? CommonHelper::appSettings('app_meta_keywords') ?? 'startup investment, pre-IPO, secondary market, primary market, equity investment' }}" />
    <meta name="author" content="{{ CommonHelper::appSettings('app_name') }}" />
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
    <meta name="theme-color" content="#ffffff" />

    <!-- Open Graph Meta Tags -->
    <meta property="og:title"
        content="{{ getPageTitle() != '' ? getPageTitle() . ' | ' : '' }}{{ CommonHelper::appSettings('app_name') }}" />
    <meta property="og:description"
        content="{{ $metaDescription ?? CommonHelper::appSettings('app_meta_description') ?? 'India\'s premier platform for startup investments, primary transactions, secondary market, and pre-IPO opportunities.' }}" />
    <meta property="og:url" content="{{ request()->url() }}" />
    <meta property="og:image" content="{{ $ogImage ?? asset('core/images/og-image.png') }}" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="{{ CommonHelper::appSettings('app_name') }}" />

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title"
        content="{{ getPageTitle() != '' ? getPageTitle() . ' | ' : '' }}{{ CommonHelper::appSettings('app_name') }}" />
    <meta name="twitter:description"
        content="{{ $metaDescription ?? CommonHelper::appSettings('app_meta_description') ?? 'India\'s premier platform for startup investments.' }}" />
    <meta name="twitter:image" content="{{ $ogImage ?? asset('core/images/og-image.png') }}" />

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ $canonicalUrl ?? request()->url() }}" />

    <!-- Sitemap -->
    <link rel="sitemap" type="application/xml" href="{{ route('sitemap.xml') }}" />

    <!-- Meta Logo -->
    <meta name="meta-logo" content="{{ asset('core/images/logo.png') }}">
    {!! includeFavicon() !!}
    <!-- Bootstarp Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />

    <!-- Font Awesome Icons Link -->
    {{--
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" /> --}}
    <script type="text/javascript">
        (function() {
            var css = document.createElement('link');
            css.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css';
            css.rel = 'stylesheet';
            css.type = 'text/css';
            document.getElementsByTagName('head')[0].appendChild(css);
        })();
    </script>
    <script type="text/javascript" src="https://app.digio.in/sdk/v9/digio.js"></script>

    <!-- CSS Link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('front-assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('front-assets/css/plugin/swiper.css') }}" />
    <link rel="stylesheet" href="{{ asset('front-assets/css/custom.css') }}" />
    @stack('custom-css')

    <!-- Schema.org Structured Data -->
    @if(isset($schemaMarkup))
    <script type="application/ld+json">
        {!! $schemaMarkup !!}
    </script>
    @else
    <script type="application/ld+json">
        {!! App\Helpers\SeoHelper::generateSchemaMarkup('Organization') !!}
    </script>
    @endif
    @stack('schema-markup')
    {{-- <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script> --}}
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
</head>

<body>

    @include('front.partials.header')
    @include('front.partials.common')

    @yield('content')

    @if (!request()->routeIs('front.business.*') && CommonHelper::appSettings('in_maintenance') == 'no')
    {{-- <footer>
        <div class="container_custom">
            <div class="content">
                <div class="group">
                    <a href="" class="logo"><img src="{{ asset('core/images/logo.png') }}" alt=""></a>
                    <div class="social">
                        <h3>Follow Us On</h3>
                        <div class="links">
                            @foreach (App\Models\MasterWebsiteSocialmediaModel::where('is_deleted',
                            0)->orderby('display_order', 'asc')->get() as $linkKey => $linkValue)
                            <a href="{{ $linkValue->link }}" target="_blank"><i
                                    class="fab {{ $linkValue->icon }}"></i></a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="group">
                    <h2>Legal Info</h2>
                    <div class="links">

                    </div>
                </div>
                <div class="group">
                    <h2>About {{ CommonHelper::appSettings('app_name') }}</h2>
                    <div class="links">

                    </div>
                </div>
                <div class="group contact">
                    <h2>Contact Us</h2>
                    <div class="contact_info">
                        <div class="info phone">
                            <div class="icon"><i class="fa-solid fa-phone"></i></div>
                            <p>{!! CommonHelper::appSettings('branding_content_contact_mobile') !!}</p>
                        </div>
                        <div class="info mail">
                            <div class="icon"><i class="fa-solid fa-paper-plane"></i></div>
                            <p>{{ CommonHelper::appSettings('branding_content_contact_email') }}</p>
                        </div>
                        <div class="info location">
                            <div class="icon"><i class="fa-solid fa-location-dot"></i></div>
                            <p>{!! nl2br(CommonHelper::appSettings('branding_content_contact_address')) !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer> --}}
    @endif

    <div class="bottom_copy">
        <div class="container_custom">
            <p>© {{ date('Y') }}, {{ CommonHelper::appSettings('app_name') }}. All Rights Reserved</p>
        </div>
    </div>
    <!-- Bootstarp -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <!-- jQuery Link -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.createjs.com/1.0.0/soundjs.min.js"></script>
    <script src="{{ asset('front-assets/js/plugin/swiper.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/lazy-master/jquery.lazy.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/lazy-master/jquery.lazy.plugins.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="{{ asset('front-assets/js/app.js') }}"></script>
    <script src="{{ asset('core/files/setup.js') }}"></script>

    @if (Auth::guard('investor')->check())
    <script src="{{ asset('front-assets/js/custom/auth/investor/common.js') }}"></script>
    @endif

    @foreach (getCustomJs() as $path)
    {!! sprintf('<script src="%s"></script>', asset($path)) !!}
    @endforeach



    @stack('custom-scripts')
    @include('front.partials.childs.firebase')
    @include('front.common.video-player')

    <script>
        $(function() {
            @if (Session::has('error'))
                showErrorMessage("{{ Session::get('error') }}", 'error');
            @endif
            @if (Session::has('success'))
                showErrorMessage("{{ Session::get('success') }}", 'success');
            @endif
        })
    </script>
</body>

</html>