@extends('marketing.layouts.app')

@push('head')
<script type="application/ld+json">
{
      "@@context": "https://schema.org",
      "@@graph": [
        {
          "@@type": "Organization",
          "@@id": "https://privatedeals.in/#organization",
          "name": "Private Deals",
          "legalName": "Shuru Advisory Private Limited",
          "url": "https://privatedeals.in",
          "logo": "https://privatedeals.in/marketing/images/favicons/web-app-manifest-512x512.png",
          "description": "Private markets built for wealth partners. Discover, invest, monitor and find liquidity across Private Equity, LP Secondary and Unlisted Shares."
        },
        {
          "@@type": "WebSite",
          "@@id": "https://privatedeals.in/#website",
          "name": "Private Deals",
          "url": "https://privatedeals.in",
          "description": "Private markets built for wealth partners. Discover, invest, monitor and find liquidity across Private Equity, LP Secondary and Unlisted Shares.",
          "publisher": { "@@id": "https://privatedeals.in/#organization" },
          "inLanguage": "en-IN"
        }
      ]
    }
</script>
@endpush

@section('content')
<main>

<section class="hero-section pt-[230px] lg:pb-[200px] pb-[100px] bg-no-repeat bg-top-right">
  <div class="main-container">
    <div class="grid grid-cols-1 md:grid-cols-2 max-sm:space-y-18 2xl:gap-x-[100px]">
      <div>
        <div class="space-y-14">
          <div class="space-y-5 text-center md:text-left">
            <span data-ns-animate data-delay="0.1" class="badge badge-cyan">For Wealth Partners</span>
            <div class="space-y-4">
              <h1 data-ns-animate data-delay="0.2">Private Markets. Built for Wealth Partners.</h1>
              <div class="max-w-[550px] space-y-3">
                <p data-ns-animate data-delay="0.3">
                  Private Deals enables wealth partners to discover, evaluate and offer curated private-market opportunities to their clients. The platform brings together Private Equity, LP Secondary and Unlisted Share opportunities, along with the information and tools needed to evaluate them.
                </p>
                <p data-ns-animate data-delay="0.35">
                  From discovery and investment to portfolio monitoring and available liquidity, Private Deals supports the complete private-market journey in one platform.
                </p>
              </div>
            </div>
          </div>
          <div data-ns-animate data-delay="0.4" class="flex flex-wrap items-center justify-center gap-3 md:justify-start">
            <a href="{{ url('/opportunities') }}" class="btn hover:btn-secondary dark:hover:btn-accent btn-primary btn-lg"><span>Explore Private Markets</span></a>
            <a href="{{ url('/contact') }}#contact-form" class="btn btn-lg btn-white dark:btn-transparent hover:btn-secondary dark:hover:btn-accent"><span>Become a Partner</span></a>
          </div>
        </div>
        <div class="my-8"><div class="divider h-[1px] bg-stroke-1 dark:bg-stroke-5 w-0"></div></div>
        <div class="space-y-2 text-center md:text-left">
          <p data-ns-animate data-delay="0.5" class="max-w-[480px]">From <span class="text-ns-yellow font-medium">₹25,000 to ₹50 lakh+</span> ticket sizes. A private-market opportunity for every client profile.</p>
        </div>
      </div>
      <div>
        <div class="relative h-[650px] w-full max-w-[724px] ml-auto z-0 overflow-hidden md:overflow-visible">
          <figure data-ns-animate data-delay="0.1" data-offset="100" data-spring="true" data-duration="2" data-direction="up" class="absolute w-[200px] lg:w-[273px] max-sm:top-[10px] left-[40px] md:top-5 lg:top-0 sm:left-0 z-1 rotate-[8deg]">
            <x-optimized-image path="marketing/images/pd-hero-deal-card.png" alt="Wealth partner reviewing private market opportunity materials" class="rounded-[20px] w-full" />
          </figure>
          <figure data-ns-animate data-delay="0.2" data-offset="100" data-spring="true" data-duration="2" class="absolute max-w-full w-[350px] lg:w-[370px] xl:w-[408px] left-0 md:left-[10px] lg:left-[100px] xl:left-[135px] top-[150px] -z-1">
            <x-optimized-image path="marketing/images/pd-hero-platform.png" alt="Private Deals platform on desktop" class="rounded-[20px] w-full" loading="eager" fetchpriority="high" />
          </figure>
          <figure data-ns-animate data-delay="0.3" data-offset="100" data-spring="true" data-duration="2" data-direction="right" class="absolute max-w-full w-[150px] md:w-[250px] xl:w-[280px] right-0 xl:right-[25px] lp:right-[-20px] top-[250px] z-1 rotate-[-15deg] shadow-2 rounded-[20px] overflow-hidden">
            <x-optimized-image path="marketing/images/pd-hero-mobile.png" alt="Mobile access to private market deals" class="w-full" />
          </figure>
          <figure data-ns-animate data-delay="0.4" data-offset="100" data-spring="true" data-duration="2" data-direction="left" class="absolute max-w-full w-[600px] md:w-[357px] left-[2px] sm:-left-[45px] bottom-[-20px] sm:-bottom-[60px] z-1">
            <x-optimized-image path="marketing/images/pd-hero-tracking.png" alt="Investment documents and portfolio tracking" class="rounded-[20px] w-full" />
          </figure>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="pt-14 md:pt-16 lg:pt-[88px] xl:pt-[100px] pb-14 md:pb-16 lg:pb-[88px] xl:pb-[100px] bg-background-2 dark:bg-background-5">
  <div class="main-container">
    <div class="mx-auto max-w-[720px] space-y-5 text-center">
      <span data-ns-animate data-delay="0.1" class="badge badge-cyan">Growth engine</span>
      <div class="space-y-5">
        <h2 data-ns-animate data-delay="0.2">Turn Private Markets into a Growth Engine for Your Wealth Business</h2>
        <div class="space-y-4">
          <p data-ns-animate data-delay="0.3">Private markets are becoming an increasingly important part of sophisticated client portfolios. But distributing them shouldn't mean managing scattered deal documents, multiple counterparties, manual processes and uncertain liquidity.</p>
          <p data-ns-animate data-delay="0.35">Private Deals brings the opportunity, information, transaction workflow and post-investment experience together in one platform.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="relative pt-14 md:pt-16 lg:pt-[88px] xl:pt-[100px] pb-14 md:pb-16 lg:pb-[88px] xl:pb-[100px] overflow-hidden">
  <div class="main-container">
    <div class="mx-auto mb-14 max-w-[720px] space-y-5 text-center">
      <span data-ns-animate data-delay="0.1" class="badge badge-cyan">Investment Opportunities</span>
      <div>
        <h2 data-ns-animate data-delay="0.2" class="mb-3">One Platform. Three Private-Market Opportunities.</h2>
        <p data-ns-animate data-delay="0.3" class="max-w-[640px] mx-auto">Give your clients access to more. Their objectives, experience, portfolio size and appetite for private markets differ. Private Deals helps you have more relevant conversations with more of them.</p>
      </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <a href="{{ url('/primary') }}" class="pd-opp-card min-h-[270px] border border-stroke-4 dark:border-stroke-6 rounded-[20px] relative p-8 flex flex-col gap-y-6 z-0 overflow-hidden group justify-between">
        <div class="relative z-10 space-y-3">
          <p class="group-hover:text-ns-yellow text-lg transition-colors duration-500">For clients seeking growth</p>
          <p class="group-hover:text-accent/60 text-secondary/60 dark:text-accent/60">Explore startups, growth companies and pre-IPO opportunities.</p>
          <p class="group-hover:text-accent/60 text-secondary/60 dark:text-accent/60 text-tagline-1">Private Equity | ₹10 lakh+</p>
        </div>
        <p class="relative z-10 group-hover:text-white text-tagline-1">Explore Primary →</p>
      </a>
      <a href="{{ url('/secondary') }}" class="pd-opp-card min-h-[270px] border border-stroke-4 dark:border-stroke-6 rounded-[20px] relative p-8 flex flex-col gap-y-6 z-0 overflow-hidden group justify-between">
        <div class="relative z-10 space-y-3">
          <p class="group-hover:text-ns-yellow text-lg transition-colors duration-500">For clients seeking institutional opportunities</p>
          <p class="group-hover:text-accent/60 text-secondary/60 dark:text-accent/60">Explore selected secondary opportunities sourced from Limited Partners, family offices and funds.</p>
          <p class="group-hover:text-accent/60 text-secondary/60 dark:text-accent/60 text-tagline-1">Limited Partner Secondary | ₹50 lakh+</p>
        </div>
        <p class="relative z-10 group-hover:text-white text-tagline-1">Explore Secondary →</p>
      </a>
      <a href="{{ url('/unlisted') }}" class="pd-opp-card min-h-[270px] border border-stroke-4 dark:border-stroke-6 rounded-[20px] relative p-8 flex flex-col gap-y-6 z-0 overflow-hidden group justify-between">
        <div class="relative z-10 space-y-3">
          <p class="group-hover:text-ns-yellow text-lg transition-colors duration-500">For clients taking their first step into private markets</p>
          <p class="group-hover:text-accent/60 text-secondary/60 dark:text-accent/60">Explore 150+ unlisted companies with lower entry sizes.</p>
          <p class="group-hover:text-accent/60 text-secondary/60 dark:text-accent/60 text-tagline-1">Unlisted Shares | ₹25,000+</p>
        </div>
        <p class="relative z-10 group-hover:text-white text-tagline-1">Explore Unlisted →</p>
      </a>
      <a href="{{ url('/how-it-works') }}" class="pd-opp-card min-h-[270px] border border-stroke-4 dark:border-stroke-6 rounded-[20px] relative p-8 flex flex-col gap-y-6 z-0 overflow-hidden group justify-between">
        <div class="relative z-10 space-y-3">
          <p class="group-hover:text-ns-yellow text-lg transition-colors duration-500">For clients looking for liquidity</p>
          <p class="group-hover:text-accent/60 text-secondary/60 dark:text-accent/60">Explore opportunities to provide liquidity for eligible existing private-market and unlisted holdings.</p>
        </div>
        <p class="relative z-10 group-hover:text-white text-tagline-1">Explore the full journey →</p>
      </a>
    </div>
  </div>
</section>

<section class="dark:bg-background-6 pt-14 pb-14 md:pt-16 md:pb-16 lg:pt-[88px] lg:pb-[88px] xl:pt-[100px] xl:pb-[100px] bg-background-2">
  <div class="main-container">
    <div class="text-center space-y-5 max-w-[850px] mx-auto mb-14">
      <span data-ns-animate data-delay="0.1" class="badge badge-cyan">Partner advantage</span>
      <div>
        <h2 data-ns-animate data-delay="0.2" class="mb-3">Build More Than a Product. Build a Private-Markets Franchise.</h2>
        <p data-ns-animate data-delay="0.3" class="max-w-[640px] mx-auto">Private Deals isn't just another product for your shelf. It can become an additional growth engine for your wealth business.</p>
      </div>
    </div>
    <div class="grid grid-cols-12 max-md:space-y-8 md:gap-8">
      <div data-ns-animate data-delay="0.4" class="col-span-12 md:col-span-6 lg:col-span-4 px-8 py-8 xl:py-13 rounded-[20px] bg-white border border-stroke-4 dark:bg-background-5 dark:border-stroke-6 space-y-6">
        <div><span class="ns-shape-35 text-[52px] text-ns-yellow"></span></div>
        <div class="space-y-2">
          <h3 class="text-heading-6">Broaden Your Offering</h3>
          <p>Bring private-market opportunities into your client conversations without having to build the sourcing, research and transaction infrastructure yourself.</p>
        </div>
      </div>
      <div data-ns-animate data-delay="0.5" class="col-span-12 md:col-span-6 lg:col-span-4 px-8 py-8 xl:py-13 rounded-[20px] bg-white border border-stroke-4 dark:bg-background-5 dark:border-stroke-6 space-y-6">
        <div><span class="ns-shape-11 text-[52px] text-ns-yellow"></span></div>
        <div class="space-y-2">
          <h3 class="text-heading-6">Deepen Client Relationships</h3>
          <p>Give existing clients access to differentiated opportunities that complement their broader portfolios.</p>
        </div>
      </div>
      <div data-ns-animate data-delay="0.6" class="col-span-12 md:col-span-6 lg:col-span-4 px-8 py-8 xl:py-13 rounded-[20px] bg-white border border-stroke-4 dark:bg-background-5 dark:border-stroke-6 space-y-6">
        <div><span class="ns-shape-34 text-[52px] text-ns-yellow"></span></div>
        <div class="space-y-2">
          <h3 class="text-heading-6">Reach More Clients</h3>
          <p>With opportunities starting from ₹25,000, private markets don't have to be limited to only your largest relationships.</p>
        </div>
      </div>
      <div data-ns-animate data-delay="0.7" class="col-span-12 md:col-span-6 lg:col-span-4 px-8 py-8 xl:py-13 rounded-[20px] bg-white border border-stroke-4 dark:bg-background-5 dark:border-stroke-6 space-y-6">
        <div><span class="ns-shape-40 text-[52px] text-ns-yellow"></span></div>
        <div class="space-y-2">
          <h3 class="text-heading-6">Build Long-Term Relationships</h3>
          <p>Stay connected with clients beyond the initial investment through ongoing information, MIS and company updates.</p>
        </div>
      </div>
      <div data-ns-animate data-delay="0.8" class="col-span-12 md:col-span-6 lg:col-span-4 px-8 py-8 xl:py-13 rounded-[20px] bg-white border border-stroke-4 dark:bg-background-5 dark:border-stroke-6 space-y-6">
        <div><span class="ns-shape-44 text-[52px] text-ns-yellow"></span></div>
        <div class="space-y-2">
          <h3 class="text-heading-6">Help Clients Find Liquidity</h3>
          <p>When clients are ready to explore an exit, help them find potential liquidity for eligible existing investments.</p>
        </div>
      </div>
      <div data-ns-animate data-delay="0.9" class="col-span-12 md:col-span-6 lg:col-span-4 px-8 py-8 xl:py-13 rounded-[20px] bg-white border border-stroke-4 dark:bg-background-5 dark:border-stroke-6 space-y-6">
        <div><span class="ns-shape-8 text-[52px] text-ns-yellow"></span></div>
        <div class="space-y-2">
          <h3 class="text-heading-6">Stay Focused on Your Clients</h3>
          <p>Private Deals takes care of the technology and transaction infrastructure, allowing you to focus on what you do best: understanding your clients and helping them make better investment decisions.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="pt-14 md:pt-16 lg:pt-[88px] xl:pt-[100px] pb-14 md:pb-16 lg:pb-[88px] xl:pb-[100px]">
  <div class="main-container">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-y-12 xl:gap-x-28 items-center">
      <div class="space-y-5">
        <span data-ns-animate data-delay="0.1" class="badge badge-cyan">Liquidity</span>
        <h2 data-ns-animate data-delay="0.2">Investing Is Only One Part of the Journey.</h2>
        <p data-ns-animate data-delay="0.3">Private-market investments can have long holding periods. When your clients are ready to explore liquidity, finding the right pathway can be just as important as finding the right investment.</p>
        <p data-ns-animate data-delay="0.35">Private Deals helps wealth partners explore liquidity opportunities for eligible existing:</p>
        <ul class="mb-2 space-y-2 md:space-y-3.5">
          <li data-ns-animate data-delay="0.4" class="text-tagline-1 font-medium flex items-center gap-3 dark:text-accent">
            <span class="bg-ns-yellow rounded-full size-[18px] flex items-center justify-center shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="8" viewBox="0 0 10 8" fill="none" class="shrink-0"><path d="M4.31661 7.00605L9.74905 1.67144C10.0836 1.3459 10.0836 0.819702 9.74905 0.494158C9.41446 0.168614 8.87363 0.168614 8.53904 0.494158L3.7116 5.24012L1.46096 3.03807C1.12636 2.71253 0.585538 2.71253 0.250945 3.03807C-0.0836483 3.36362 -0.0836483 3.88982 0.250945 4.21536L3.1066 7.00605C3.27347 7.16841 3.49253 7.25 3.7116 7.25C3.93067 7.25 4.14974 7.16841 4.31661 7.00605Z" fill="white"/></svg></span>
            Private Equity investments
          </li>
          <li data-ns-animate data-delay="0.45" class="text-tagline-1 font-medium flex items-center gap-3 dark:text-accent">
            <span class="bg-ns-yellow rounded-full size-[18px] flex items-center justify-center shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="8" viewBox="0 0 10 8" fill="none" class="shrink-0"><path d="M4.31661 7.00605L9.74905 1.67144C10.0836 1.3459 10.0836 0.819702 9.74905 0.494158C9.41446 0.168614 8.87363 0.168614 8.53904 0.494158L3.7116 5.24012L1.46096 3.03807C1.12636 2.71253 0.585538 2.71253 0.250945 3.03807C-0.0836483 3.36362 -0.0836483 3.88982 0.250945 4.21536L3.1066 7.00605C3.27347 7.16841 3.49253 7.25 3.7116 7.25C3.93067 7.25 4.14974 7.16841 4.31661 7.00605Z" fill="white"/></svg></span>
            LP / secondary investments
          </li>
          <li data-ns-animate data-delay="0.5" class="text-tagline-1 font-medium flex items-center gap-3 dark:text-accent">
            <span class="bg-ns-yellow rounded-full size-[18px] flex items-center justify-center shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="8" viewBox="0 0 10 8" fill="none" class="shrink-0"><path d="M4.31661 7.00605L9.74905 1.67144C10.0836 1.3459 10.0836 0.819702 9.74905 0.494158C9.41446 0.168614 8.87363 0.168614 8.53904 0.494158L3.7116 5.24012L1.46096 3.03807C1.12636 2.71253 0.585538 2.71253 0.250945 3.03807C-0.0836483 3.36362 -0.0836483 3.88982 0.250945 4.21536L3.1066 7.00605C3.27347 7.16841 3.49253 7.25 3.7116 7.25C3.93067 7.25 4.14974 7.16841 4.31661 7.00605Z" fill="white"/></svg></span>
            Unlisted shares
          </li>
        </ul>
        <p data-ns-animate data-delay="0.55">Because good advice should continue after the investment is made.</p>
      </div>
      <div data-ns-animate data-delay="0.4" class="space-y-6 rounded-[20px] bg-secondary dark:bg-background-7 border border-stroke-1 dark:border-stroke-6 p-8 md:p-10">
        <h3 class="text-heading-5 text-white">From First Investment to Happy Ending.</h3>
        <p class="text-accent/60">Private-market investing shouldn't be a one-way journey.</p>
        <ul class="space-y-4">
          <li class="flex items-center gap-3"><span class="text-tagline-2 text-ns-yellow font-medium">01</span><span class="text-tagline-1 text-white">Discover</span></li>
          <li class="flex items-center gap-3"><span class="text-tagline-2 text-ns-yellow font-medium">02</span><span class="text-tagline-1 text-white">Evaluate</span></li>
          <li class="flex items-center gap-3"><span class="text-tagline-2 text-ns-yellow font-medium">03</span><span class="text-tagline-1 text-white">Invest</span></li>
          <li class="flex items-center gap-3"><span class="text-tagline-2 text-ns-yellow font-medium">04</span><span class="text-tagline-1 text-white">Monitor</span></li>
          <li class="flex items-center gap-3"><span class="text-tagline-2 text-ns-yellow font-medium">05</span><span class="text-tagline-1 text-white">Exit</span></li>
        </ul>
        <p class="text-accent/60">Private Deals helps wealth partners support their clients across the investment lifecycle, including opportunities to find liquidity for investments purchased earlier.</p>
        <p class="text-accent/60">Because a great investment experience doesn't end at the transaction. It ends when the client gets the outcome they were looking for.</p>
      </div>
    </div>
  </div>
</section>

<section class="pt-14 md:pt-16 lg:pt-[88px] xl:pt-[100px] pb-14 md:pb-16 lg:pb-[88px] xl:pb-[100px] bg-background-2 dark:bg-background-5">
  <div class="main-container">
    <div class="pd-digital-panel relative z-10 overflow-hidden rounded-[32px] border border-stroke-1 dark:border-stroke-6 bg-secondary dark:bg-background-7">
      <figure class="pd-digital-glow absolute pointer-events-none select-none" aria-hidden="true">
        <x-optimized-image path="marketing/images/ns-img-513.png" alt="" width="512" height="512" />
      </figure>
      <div class="pd-digital-copy relative z-10">
        <span data-ns-animate data-delay="0.1" class="badge badge-blur text-ns-yellow">Digital experience</span>
        <h2 data-ns-animate data-delay="0.2" class="text-white">Your Private Market Workflow, At Your Fingertips.</h2>
        <p data-ns-animate data-delay="0.3" class="text-accent/60">Discover, evaluate and invest from one place. Keep documents and portfolio monitoring in the same digital experience.</p>
        <div data-ns-animate data-delay="0.35" class="pd-store-badges">
          <a href="#" class="pd-store-btn" aria-label="Get it on Google Play">
            <span class="pd-store-btn__icon" aria-hidden="true">
              <svg viewBox="0 0 512 512" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M325.3 234.3L104.6 13l280.8 161.2-60.1 60.1zM47 0C34 6.8 25.3 19.2 25.3 35.3v441.3c0 16.1 8.7 28.5 21.7 35.3l256.6-256L47 0zm425.2 225.6l-58.9-34.1-65.7 64.5 65.7 64.5 60.1-34.1c18-14.3 18-46.5-1.2-60.8zM104.6 499l280.8-161.2-60.1-60.1L104.6 499z"/></svg>
            </span>
            <span class="pd-store-btn__label"><span class="pd-store-btn__sublabel">Get it on</span><span class="pd-store-btn__name">Google Play</span></span>
          </a>
          <a href="#" class="pd-store-btn" aria-label="Download on the App Store">
            <span class="pd-store-btn__icon" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M16.3664 6.41528C14.4764 6.41528 13.6776 7.31716 12.3614 7.31716C11.0118 7.31716 9.98245 6.42185 8.34464 6.42185C6.74151 6.42185 5.03198 7.4006 3.94636 9.06794C2.42198 11.4192 2.68073 15.8475 5.14964 19.62C6.03276 20.9704 7.21214 22.485 8.75901 22.5014H8.78714C10.1315 22.5014 10.5309 21.6211 12.381 21.6108H12.4092C14.2317 21.6108 14.5973 22.4962 15.936 22.4962H15.9642C17.511 22.4798 18.7537 20.8017 19.6368 19.4564C20.2724 18.4889 20.5087 18.0033 20.9962 16.9087C17.4248 15.5531 16.851 10.4901 20.3831 8.54903C19.305 7.19903 17.7899 6.41716 16.3617 6.41716L16.3664 6.41528Z"/><path d="M15.9486 1.5C14.8236 1.57641 13.5111 2.29266 12.7423 3.22781C12.0448 4.07531 11.4711 5.3325 11.6961 6.55172H11.7861C12.9842 6.55172 14.2105 5.83031 14.9267 4.90594C15.6167 4.02609 16.1398 2.77922 15.9486 1.5Z"/></svg>
            </span>
            <span class="pd-store-btn__label"><span class="pd-store-btn__sublabel">Download on the</span><span class="pd-store-btn__name">App Store</span></span>
          </a>
        </div>
      </div>
      <ol data-ns-animate data-delay="0.4" class="pd-digital-steps relative z-10">
        <li>
          <span class="pd-digital-steps__num">01</span>
          <div>
            <p class="pd-digital-steps__title">Discover</p>
            <p class="pd-digital-steps__text">Find private-market opportunities across Primary, Secondary and Unlisted Shares.</p>
          </div>
        </li>
        <li>
          <span class="pd-digital-steps__num">02</span>
          <div>
            <p class="pd-digital-steps__title">Evaluate</p>
            <p class="pd-digital-steps__text">Review company information, financials, valuation and available diligence.</p>
          </div>
        </li>
        <li>
          <span class="pd-digital-steps__num">03</span>
          <div>
            <p class="pd-digital-steps__title">Invest</p>
            <p class="pd-digital-steps__text">Complete documentation and transactions through a digital workflow.</p>
          </div>
        </li>
        <li>
          <span class="pd-digital-steps__num">04</span>
          <div>
            <p class="pd-digital-steps__title">Monitor</p>
            <p class="pd-digital-steps__text">Stay connected to portfolios, documents and company updates.</p>
          </div>
        </li>
        <li>
          <span class="pd-digital-steps__num">05</span>
          <div>
            <p class="pd-digital-steps__title">Find Liquidity</p>
            <p class="pd-digital-steps__text">Explore exit pathways for eligible existing holdings.</p>
          </div>
        </li>
      </ol>
    </div>
  </div>
</section>

<section class="relative">
  <div class="lg:main-container xl:max-w-[1440px] mx-auto w-full -mb-10 md:-mb-8 lg:-mb-6 px-5 lg:px-0 xl:-mb-14 relative z-10">
    <div class="pd-cta-panel py-[76px] bg-secondary dark:bg-background-8 rounded-4xl relative z-10 overflow-hidden">
      <figure data-ns-animate data-delay="0.3" data-direction="left" data-offset="100" class="cta-bg-gradient -z-10 absolute -left-[30%] -top-[90%] md:-left-[30%] md:-top-[190%] lg:-left-[30%] xl:-left-[15%] lg:-top-[190%] size-[550px] md:size-[1050px] pointer-events-none select-none">
        <x-optimized-image path="marketing/images/ns-img-520.png" alt="" />
      </figure>
      <div class="text-center space-y-5">
        <span data-ns-animate data-delay="0.1" class="badge badge-blur text-ns-yellow">Get started</span>
        <div class="space-y-6">
          <div class="space-y-3">
            <h2 data-ns-animate data-delay="0.2" class="max-w-[830px] mx-auto text-white">Centralize Your Clients' Private Market Investments Today.</h2>
            <p data-ns-animate data-delay="0.3" class="text-accent/60 px-4 sm:px-0">Access institutional opportunities, analyze core metrics, streamline execution workflows, and stay connected with post-investment client portfolios, all through one platform.</p>
          </div>
          <ul class="flex flex-col sm:flex-row items-center gap-y-5 sm:gap-x-3 justify-center">
            <li data-ns-animate data-delay="0.4" data-direction="left" data-offset="50" class="w-full sm:w-auto"><a href="{{ url('/contact') }}#contact-form" class="btn btn-primary border-0 hover:btn-white btn-md w-[90%] sm:w-auto"><span>Request Access</span></a></li>
            <li data-ns-animate data-delay="0.4" data-direction="right" data-offset="50" class="w-full sm:w-auto"><a href="{{ url('/contact') }}" class="btn btn-white hover:btn-primary btn-md dark:btn-transparent w-[90%] sm:w-auto"><span>Contact Us</span></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

</main>
@endsection
