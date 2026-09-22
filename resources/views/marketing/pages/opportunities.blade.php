@extends('marketing.layouts.app')

@section('content')
<main>

<section class="xl:pt-[180px] md:pt-42 sm:pt-36 pt-32 pb-14 md:pb-16">
  <div class="main-container">
    <div class="pd-opp-intro mx-auto mb-12 md:mb-14 text-center">
      <span data-ns-animate data-delay="0.2" class="badge badge-green">Investment Opportunities</span>
      <h1 data-ns-animate data-delay="0.3" class="text-balance">One Platform. Three Private-Market Opportunities.</h1>
      <p data-ns-animate data-delay="0.4">
        Give your clients access to more. Explore Private Equity, Limited Partner Secondary and Unlisted Shares so you can have more relevant conversations with more of your clients.
      </p>
    </div>
    <div class="pd-opp-page-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-7">
      <article class="pd-opp-page-card">
        <div class="pd-opp-page-card__body">
          <p class="pd-opp-page-card__label">Primary</p>
          <h2 class="pd-opp-page-card__title">Invest in Companies Raising Capital</h2>
          <p class="pd-opp-page-card__text">Explore startups, growth companies and pre-IPO opportunities.</p>
          <p class="pd-opp-page-card__meta">Private Equity | ₹10 lakh+</p>
        </div>
        <a href="{{ url('/primary') }}" class="btn hover:btn-primary btn-white dark:btn-transparent btn-md"><span>Explore Primary</span></a>
      </article>
      <article class="pd-opp-page-card">
        <div class="pd-opp-page-card__body">
          <p class="pd-opp-page-card__label">Secondary</p>
          <h2 class="pd-opp-page-card__title">Access Existing Shares in Private Companies</h2>
          <p class="pd-opp-page-card__text">Explore selected secondary opportunities sourced from Limited Partners, family offices and funds.</p>
          <p class="pd-opp-page-card__meta">Limited Partner Secondary | ₹50 lakh+</p>
        </div>
        <a href="{{ url('/secondary') }}" class="btn hover:btn-primary btn-white dark:btn-transparent btn-md"><span>Explore Secondary</span></a>
      </article>
      <article class="pd-opp-page-card">
        <div class="pd-opp-page-card__body">
          <p class="pd-opp-page-card__label">Unlisted Shares</p>
          <h2 class="pd-opp-page-card__title">Access Private Companies Before They List</h2>
          <p class="pd-opp-page-card__text">Explore 150+ unlisted companies with lower entry sizes.</p>
          <p class="pd-opp-page-card__meta">Unlisted Shares | ₹25,000+</p>
        </div>
        <a href="{{ url('/unlisted') }}" class="btn hover:btn-primary btn-white dark:btn-transparent btn-md"><span>Explore Unlisted</span></a>
      </article>
    </div>
  </div>
</section>

<section class="pt-14 md:pt-16 pb-14 md:pb-16">
  <div class="main-container">
    <div class="max-w-[720px] mx-auto text-center space-y-4">
      <h2>Diverse Private Market Access Across Investment Sizes</h2>
      <p class="text-heading-5 text-ns-yellow">From ₹25,000 to ₹50 lakh+</p>
      <p>Indicative ticket sizes across curated opportunities, starting from ₹25,000 for Unlisted Shares, ₹10 lakh for Primary Investments, and ₹50 lakh+ for Limited Partner Secondaries, subject to asset availability and investor eligibility criteria.</p>
    </div>
  </div>
</section>

<section class="relative">
  <div class="lg:main-container xl:max-w-[1440px] mx-auto w-full -mb-10 px-5 lg:px-0 xl:-mb-14 relative z-10">
    <div class="pd-cta-panel py-[76px] bg-secondary dark:bg-background-8 rounded-4xl relative z-10 overflow-hidden">
      <figure class="cta-bg-gradient -z-10 absolute -left-[30%] -top-[90%] md:-left-[30%] md:-top-[190%] lg:-left-[30%] xl:-left-[15%] lg:-top-[190%] size-[550px] md:size-[1050px] pointer-events-none select-none"><x-optimized-image path="marketing/images/ns-img-520.png" alt="" /></figure>
      <div class="text-center space-y-5">
        <h2 class="max-w-[830px] mx-auto text-white">Centralize Your Clients' Private Market Investments Today.</h2>
        <p class="text-accent/60">Request partner access to evaluate current opportunities on the platform.</p>
        <div class="flex flex-col sm:flex-row items-center gap-3 justify-center">
          <a href="{{ url('/contact') }}#contact-form" class="btn btn-primary border-0 hover:btn-white btn-md"><span>Request Access</span></a>
          <a href="{{ url('/contact') }}" class="btn btn-white hover:btn-primary btn-md dark:btn-transparent"><span>Contact Us</span></a>
        </div>
      </div>
    </div>
  </div>
</section>

</main>
@endsection
