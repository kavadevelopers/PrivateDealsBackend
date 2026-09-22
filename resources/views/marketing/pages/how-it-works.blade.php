@extends('marketing.layouts.app')

@section('content')
<main>

<section class="pt-32 pb-[80px] sm:pt-36 md:pt-42 xl:pt-[180px]">
  <div class="main-container">
    <div class="mb-[70px] mx-auto max-w-[980px] space-y-4 text-center">
      <span data-ns-animate data-delay="0.2" class="badge badge-cyan">How It Works</span>
      <h1 data-ns-animate data-delay="0.3" class="mx-auto max-w-[920px] text-balance">From Finding an Opportunity to Managing Your Client's Investment</h1>
      <p data-ns-animate data-delay="0.4" class="mx-auto max-w-[820px]">Private Deals brings the complete private-market investment journey onto one platform, helping wealth partners discover opportunities, understand them, invest digitally, manage investments and support clients after the investment.</p>
    </div>
    <div class="pd-process-grid">
      <div class="pd-process-grid__item">
        <div data-ns-animate data-delay="0.3" class="pd-process-card">
          <div class="pd-process-card__head">
            <p class="pd-process-card__step">01 · Discover</p>
            <span class="ns-shape-36 text-ns-yellow text-[44px] sm:text-[48px]" aria-hidden="true"></span>
          </div>
          <div class="pd-process-card__body">
            <h3 class="pd-process-card__title">Find the Right Opportunities for Your Clients</h3>
            <p class="pd-process-card__lead">Browse private-market opportunities across Primary, Secondary and Unlisted Shares from one platform.</p>
            <ul class="pd-process-list">
              <li><strong>Browse Opportunities</strong><span>Explore available private-market deals in one place.</span></li>
              <li><strong>Find What Fits</strong><span>Filter and identify opportunities that match your clients' needs.</span></li>
              <li><strong>Explore the Deal</strong><span>Open any opportunity to review its profile and key details.</span></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="pd-process-grid__item">
        <div data-ns-animate data-delay="0.4" class="pd-process-card">
          <div class="pd-process-card__head">
            <p class="pd-process-card__step">02 · Evaluate</p>
            <span class="ns-shape-8 text-ns-yellow text-[44px] sm:text-[48px]" aria-hidden="true"></span>
          </div>
          <div class="pd-process-card__body">
            <h3 class="pd-process-card__title">Understand the Opportunity Before You Invest</h3>
            <ul class="pd-process-list">
              <li><strong>Company Information</strong><span>Review the business, team and opportunity overview.</span></li>
              <li><strong>Financials</strong><span>Access key financial information to assess the company.</span></li>
              <li><strong>Valuation</strong><span>Understand pricing context and valuation details.</span></li>
              <li><strong>Research &amp; Due Diligence</strong><span>Review research materials and supporting diligence.</span></li>
              <li><strong>Company Updates</strong><span>Stay informed with relevant company updates.</span></li>
            </ul>
            <p class="pd-process-card__note">Everything you need to make an informed investment decision, in one place.</p>
          </div>
        </div>
      </div>
      <div class="pd-process-grid__item">
        <div data-ns-animate data-delay="0.5" class="pd-process-card">
          <div class="pd-process-card__head">
            <p class="pd-process-card__step">03 · Connect &amp; Clarify</p>
            <span class="ns-shape-2 text-ns-yellow text-[44px] sm:text-[48px]" aria-hidden="true"></span>
          </div>
          <div class="pd-process-card__body">
            <h3 class="pd-process-card__title">Get Your Questions Answered</h3>
            <p class="pd-process-card__lead">Sometimes documents are not enough. Get the opportunity-specific information you need before making a decision.</p>
            <ul class="pd-process-list">
              <li><strong>Founder &amp; Management Interactions</strong><span>Where available, connect with founders or management teams for primary opportunities.</span></li>
              <li><strong>Quick Support</strong><span>Connect with our team through WhatsApp for deal-related questions and assistance.</span></li>
              <li><strong>Deal Updates</strong><span>Stay updated on availability, timelines and important transaction changes.</span></li>
            </ul>
            <p class="pd-process-card__note">Understand the opportunity. Ask questions. Move forward with confidence.</p>
          </div>
        </div>
      </div>
      <div class="pd-process-grid__item">
        <div data-ns-animate data-delay="0.6" class="pd-process-card">
          <div class="pd-process-card__head">
            <p class="pd-process-card__step">04 · Invest</p>
            <span class="ns-shape-34 text-ns-yellow text-[44px] sm:text-[48px]" aria-hidden="true"></span>
          </div>
          <div class="pd-process-card__body">
            <h3 class="pd-process-card__title">Complete Your Investment Digitally</h3>
            <p class="pd-process-card__flow">Review Terms → Sign Documentation → Make Payment → Complete Settlement</p>
            <ul class="pd-process-list">
              <li><strong>Clear Terms</strong><span>Review investment terms before you proceed.</span></li>
              <li><strong>Digital Documentation</strong><span>Sign required documents online.</span></li>
              <li><strong>Secure Payment Process</strong><span>Complete payment through a secure process.</span></li>
              <li><strong>Track Your Investment</strong><span>Follow progress through to settlement.</span></li>
            </ul>
            <p class="pd-process-card__note">Less paperwork. More visibility.</p>
          </div>
        </div>
      </div>
      <div class="pd-process-grid__item">
        <div data-ns-animate data-delay="0.7" class="pd-process-card">
          <div class="pd-process-card__head">
            <p class="pd-process-card__step">05 · Manage</p>
            <span class="ns-shape-40 text-ns-yellow text-[44px] sm:text-[48px]" aria-hidden="true"></span>
          </div>
          <div class="pd-process-card__body">
            <h3 class="pd-process-card__title">Keep Track of Your Investments</h3>
            <ul class="pd-process-list">
              <li><strong>Portfolio Dashboard</strong><span>View your investments in one place.</span></li>
              <li><strong>Documents</strong><span>Access investment documents when you need them.</span></li>
              <li><strong>Company Updates</strong><span>Stay current with company news and updates.</span></li>
              <li><strong>Investment Tracking</strong><span>Monitor status and key milestones over time.</span></li>
            </ul>
            <p class="pd-process-card__note">Your work doesn't stop when the investment is completed.</p>
          </div>
        </div>
      </div>
      <div class="pd-process-grid__item">
        <div data-ns-animate data-delay="0.8" class="pd-process-card">
          <div class="pd-process-card__head">
            <p class="pd-process-card__step">06 · Serve Your Clients</p>
            <span class="ns-shape-11 text-ns-yellow text-[44px] sm:text-[48px]" aria-hidden="true"></span>
          </div>
          <div class="pd-process-card__body">
            <h3 class="pd-process-card__title">Give Your Clients a Better Investment Experience</h3>
            <ul class="pd-process-list">
              <li><strong>Share Information</strong><span>Share opportunity and investment information with clients.</span></li>
              <li><strong>Share Documents</strong><span>Provide clients with the documents they need.</span></li>
              <li><strong>Track Client Investments</strong><span>Keep oversight of client holdings.</span></li>
              <li><strong>Manage Multiple Opportunities</strong><span>Handle multiple deals from one workspace.</span></li>
            </ul>
            <p class="pd-process-card__note">You manage the relationship. We simplify the investment journey.</p>
          </div>
        </div>
      </div>
      <div class="pd-process-grid__item pd-process-grid__item--center">
        <div data-ns-animate data-delay="0.9" class="pd-process-card pd-process-card--exit">
          <div class="pd-process-card__exit-intro">
            <div class="pd-process-card__head">
              <p class="pd-process-card__step">07 · Exit</p>
              <span class="ns-shape-44 text-ns-yellow text-[44px] sm:text-[48px]" aria-hidden="true"></span>
            </div>
            <h3 class="pd-process-card__title">Stay Connected Until the Exit</h3>
            <p class="pd-process-card__note">Exit opportunities are subject to the specific investment, available liquidity, commercial terms and investor eligibility.</p>
          </div>
          <ul class="pd-process-list pd-process-list--exit">
            <li><strong>Liquidity Opportunities</strong><span>Explore available liquidity options where they arise.</span></li>
            <li><strong>Exit Support</strong><span>Get support through the exit process.</span></li>
            <li><strong>Transaction Tracking</strong><span>Track exit-related steps and status.</span></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="pd-journey-bridge">
  <div class="main-container">
    <div class="pd-journey-bridge__inner">
      <p class="pd-journey-bridge__eyebrow">The complete journey</p>
      <ol class="pd-journey-bridge__flow" aria-label="Private market journey stages">
        <li><em>01</em><span>Discover</span></li>
        <li><em>02</em><span>Evaluate</span></li>
        <li><em>03</em><span>Invest</span></li>
        <li><em>04</em><span>Manage</span></li>
        <li><em>05</em><span>Exit</span></li>
      </ol>
      <div class="pd-journey-bridge__copy">
        <h2>One Platform for the Complete Private-Market Journey</h2>
        <p>From discovering the right opportunity for your client to investing, monitoring and exploring liquidity, Private Deals brings the complete journey together in one platform.</p>
        <div class="pd-journey-bridge__actions">
          <a href="{{ url('/opportunities') }}" class="btn btn-primary border-0 hover:btn-secondary btn-md"><span>Explore Opportunities</span></a>
          <a href="{{ url('/contact') }}#contact-form" class="btn btn-white hover:btn-primary btn-md dark:btn-transparent"><span>Become a Partner</span></a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="pt-14 md:pt-16 lg:pt-[88px] pb-14 md:pb-16">
  <div class="main-container">
    <div class="grid grid-cols-1 max-md:space-y-10 md:grid-cols-2 items-center rounded-[32px] py-12 md:py-18 px-6 sm:px-8 md:px-[42px] bg-secondary dark:bg-background-7 overflow-hidden border border-stroke-1 dark:border-stroke-6 relative z-10">
      <figure class="pd-digital-glow absolute -top-[100%] -right-[40%] -rotate-[130deg] size-[1060px] pointer-events-none select-none" aria-hidden="true"><x-optimized-image path="marketing/images/ns-img-513.png" alt="" width="512" height="512" /></figure>
      <div class="relative z-10 space-y-8 max-w-[630px]">
        <span class="badge badge-blur text-ns-yellow">Same product, every surface</span>
        <h2 class="text-white">Your private market workflow, at your fingertips.</h2>
        <p class="text-accent/60">Download the app for iOS and Android, or continue on web.</p>
        <div class="pd-store-badges">
          <a href="#" class="pd-store-btn" aria-label="Get it on Google Play">
            <span class="pd-store-btn__icon" aria-hidden="true"><svg viewBox="0 0 512 512" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M325.3 234.3L104.6 13l280.8 161.2-60.1 60.1zM47 0C34 6.8 25.3 19.2 25.3 35.3v441.3c0 16.1 8.7 28.5 21.7 35.3l256.6-256L47 0zm425.2 225.6l-58.9-34.1-65.7 64.5 65.7 64.5 60.1-34.1c18-14.3 18-46.5-1.2-60.8zM104.6 499l280.8-161.2-60.1-60.1L104.6 499z"/></svg></span>
            <span class="pd-store-btn__label"><span class="pd-store-btn__sublabel">Get it on</span><span class="pd-store-btn__name">Google Play</span></span>
          </a>
          <a href="#" class="pd-store-btn" aria-label="Download on the App Store">
            <span class="pd-store-btn__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M16.3664 6.41528C14.4764 6.41528 13.6776 7.31716 12.3614 7.31716C11.0118 7.31716 9.98245 6.42185 8.34464 6.42185C6.74151 6.42185 5.03198 7.4006 3.94636 9.06794C2.42198 11.4192 2.68073 15.8475 5.14964 19.62C6.03276 20.9704 7.21214 22.485 8.75901 22.5014H8.78714C10.1315 22.5014 10.5309 21.6211 12.381 21.6108H12.4092C14.2317 21.6108 14.5973 22.4962 15.936 22.4962H15.9642C17.511 22.4798 18.7537 20.8017 19.6368 19.4564C20.2724 18.4889 20.5087 18.0033 20.9962 16.9087C17.4248 15.5531 16.851 10.4901 20.3831 8.54903C19.305 7.19903 17.7899 6.41716 16.3617 6.41716L16.3664 6.41528Z"/><path d="M15.9486 1.5C14.8236 1.57641 13.5111 2.29266 12.7423 3.22781C12.0448 4.07531 11.4711 5.3325 11.6961 6.55172H11.7861C12.9842 6.55172 14.2105 5.83031 14.9267 4.90594C15.6167 4.02609 16.1398 2.77922 15.9486 1.5Z"/></svg></span>
            <span class="pd-store-btn__label"><span class="pd-store-btn__sublabel">Download on the</span><span class="pd-store-btn__name">App Store</span></span>
          </a>
        </div>
      </div>
      <div class="relative z-10">
        <figure class="rounded-[20px] overflow-hidden max-w-[480px] ml-auto">
          <x-optimized-image path="marketing/images/pd-hero-mobile.png" alt="Private Deals on mobile during invest and manage steps" class="w-full" />
        </figure>
      </div>
    </div>
  </div>
</section>

</main>
@endsection
