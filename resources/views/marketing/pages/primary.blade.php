@extends('marketing.layouts.app')

@section('content')
<main>

<section class="xl:pt-[180px] md:pt-42 sm:pt-36 pt-32 pb-16">
  <div class="main-container">
    <div class="grid grid-cols-12 items-center xl:gap-[100px] lg:gap-20 gap-y-10">
      <div class="col-span-12 lg:col-span-6 space-y-6">
        <span class="badge badge-green">Primary Investments</span>
        <h1>Invest in Companies Raising Capital</h1>
        <p class="max-w-[520px]">Access carefully selected primary investment opportunities in startups and high-growth companies, with the information, research and support you need to evaluate an opportunity for your clients.</p>
        <p class="text-tagline-1 text-secondary/60">Private Equity | ₹10 lakh+</p>
        <a href="{{ url('/contact') }}#contact-form" class="btn btn-primary btn-md"><span>Request Access</span></a>
      </div>
      <div class="col-span-12 lg:col-span-6">
        <div class="flex items-center gap-8">
          <figure class="max-w-[233px] w-full rounded-2xl overflow-hidden"><x-optimized-image path="marketing/images/pd-primary-timeline.png" alt="Primary investment timeline" class="w-full" /></figure>
          <figure class="max-w-[350px] w-full rounded-[20px] overflow-hidden"><x-optimized-image path="marketing/images/pd-primary-materials.png" alt="Company materials for a primary opportunity" class="w-full" /></figure>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="pb-16 md:pb-24 bg-background-2 dark:bg-background-5 pt-14 md:pt-16 lg:pt-[88px]">
  <div class="main-container">
    <div class="max-w-[680px] mb-12 space-y-3">
      <span class="badge badge-green">Company research</span>
      <h2>Know the Company Before You Invest</h2>
      <p>Get everything you need to understand the business and make an informed investment decision.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <div class="rounded-[20px] bg-white p-8 space-y-3 border border-stroke-4 pd-gold-rail"><h3 class="text-heading-6">Company Overview</h3><p>Understand what the company does, how it makes money, its market and its growth plans.</p></div>
      <div class="rounded-[20px] bg-white p-8 space-y-3 border border-stroke-4 pd-gold-rail"><h3 class="text-heading-6">Pitch Deck &amp; Product</h3><p>Access the company's pitch deck, product information, videos and other presentation material.</p></div>
      <div class="rounded-[20px] bg-white p-8 space-y-3 border border-stroke-4 pd-gold-rail"><h3 class="text-heading-6">Financials</h3><p>Review financial statements, revenue, profitability, capital structure and past performance.</p></div>
      <div class="rounded-[20px] bg-white p-8 space-y-3 border border-stroke-4 pd-gold-rail"><h3 class="text-heading-6">Future Growth</h3><p>Understand the company's business projections, expected growth and key assumptions.</p></div>
      <div class="rounded-[20px] bg-white p-8 space-y-3 border border-stroke-4 pd-gold-rail"><h3 class="text-heading-6">Valuation</h3><p>Review the company's valuation, previous funding rounds and relevant market comparisons.</p></div>
      <div class="rounded-[20px] bg-white p-8 space-y-3 border border-stroke-4 pd-gold-rail"><h3 class="text-heading-6">Due Diligence</h3><p>Access available financial, legal, technical and other due diligence reports.</p></div>
    </div>
  </div>
</section>

<section class="pt-14 md:pt-16 lg:pt-[88px] pb-14 md:pb-16 lg:pb-[88px]">
  <div class="main-container">
    <div class="mx-auto mb-12 max-w-[820px] space-y-3 text-center md:mb-14">
      <span class="badge badge-green">Client readiness</span>
      <h2 class="text-balance">Give Your Clients the Complete Picture</h2>
      <p class="mx-auto max-w-[640px]">Before presenting an opportunity to your clients, bring all the important information together in one place.</p>
    </div>
    <div class="pd-picture-grid">
      <article class="pd-picture-card">
        <h3 class="pd-picture-card__title">Business &amp; Financials</h3>
        <p class="pd-picture-card__text">Share the company's business and financial information clearly.</p>
      </article>
      <article class="pd-picture-card">
        <h3 class="pd-picture-card__title">Valuation &amp; Terms</h3>
        <p class="pd-picture-card__text">Review valuation, funding round details and investment terms.</p>
      </article>
      <article class="pd-picture-card">
        <h3 class="pd-picture-card__title">Documents Together</h3>
        <p class="pd-picture-card__text">Keep pitch decks, reports, financials and other documents together.</p>
      </article>
      <article class="pd-picture-card">
        <h3 class="pd-picture-card__title">Client Clarity</h3>
        <p class="pd-picture-card__text">Give your clients the information they need to understand the opportunity.</p>
      </article>
    </div>
  </div>
</section>

<section class="pd-closer pt-14 pb-14 md:pt-16 md:pb-16 lg:pt-[88px] lg:pb-[88px] bg-background-2">
  <div class="main-container">
    <div class="pd-closer__grid">
      <figure class="pd-closer__media">
        <x-optimized-image path="marketing/images/pd-primary-meeting.png" alt="Advisor discussing a private equity opportunity" />
      </figure>
      <div class="pd-closer__copy">
        <span class="badge badge-green">Get Closer to the Company</span>
        <h2>Connect with Founders and Management</h2>
        <p>Where available, connect with founders and management through structured meetings and sessions. Use these interactions to understand the business, ask questions and get a better view of the company's future plans.</p>
        <ul class="pd-closer__tags">
          <li>Founder Meetings</li>
          <li>Product Demonstrations</li>
          <li>Management Interactions</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<section class="pd-invest-flow pt-14 md:pt-16 lg:pt-[88px] pb-14 md:pb-16 lg:pb-[88px]">
  <div class="main-container">
    <div class="pd-invest-flow__intro">
      <span class="badge badge-green">Invest Digitally</span>
      <h2>Invest Without the Usual Paperwork Hassle</h2>
      <p>Once you decide to invest, manage the transaction through a simple digital process. From documentation and digital signing to capital transfer and allotment, the process is managed through the platform.</p>
    </div>
    <ol class="pd-invest-flow__steps">
      <li>
        <em>01</em>
        <strong>Review Terms</strong>
        <span>Understand the investment terms before you proceed.</span>
      </li>
      <li>
        <em>02</em>
        <strong>Sign Agreements</strong>
        <span>Complete required documentation with digital signing.</span>
      </li>
      <li>
        <em>03</em>
        <strong>Complete Payment</strong>
        <span>Transfer capital through the secure payment process.</span>
      </li>
      <li>
        <em>04</em>
        <strong>Share Allotment</strong>
        <span>Track allotment and receive confirmation on platform.</span>
      </li>
    </ol>
  </div>
</section>

<section class="pd-after pt-14 pb-14 md:pt-16 md:pb-16 lg:pt-[88px] lg:pb-[88px]">
  <div class="main-container">
    <div class="pd-after__panel">
      <div class="pd-after__intro">
        <span class="badge badge-green">After investment</span>
        <h2>Continue Monitoring After Investment</h2>
        <p>Your role doesn't end once the shares are allotted.</p>
      </div>
      <ul class="pd-after__list">
        <li>
          <strong>Company Updates</strong>
          <span>Stay updated on business performance and important developments.</span>
        </li>
        <li>
          <strong>MIS &amp; Reports</strong>
          <span>Access periodic company reports and management information.</span>
        </li>
        <li>
          <strong>Corporate Updates</strong>
          <span>Track important announcements, AGM information and other company updates.</span>
        </li>
        <li>
          <strong>Documents</strong>
          <span>Keep allotment details, agreements, tax-related documents and other records in one place.</span>
        </li>
      </ul>
    </div>
  </div>
</section>

<section class="pt-14 md:pt-16 pb-14 md:pb-16">
  <div class="main-container">
    <div class="max-w-[760px] mx-auto text-center space-y-4">
      <span class="badge badge-green">Full journey</span>
      <h2>From Opportunity to Long-Term Monitoring</h2>
      <p>Discover the opportunity, understand the company, complete the investment and continue tracking it, all through one platform.</p>
    </div>
  </div>
</section>

<section class="relative">
  <div class="lg:main-container xl:max-w-[1440px] mx-auto w-full -mb-10 px-5 lg:px-0 xl:-mb-14 relative z-10">
    <div class="pd-cta-panel py-[76px] bg-secondary dark:bg-background-8 rounded-4xl relative z-10 overflow-hidden">
      <figure class="cta-bg-gradient -z-10 absolute -left-[30%] -top-[90%] md:-left-[30%] md:-top-[190%] lg:-left-[30%] xl:-left-[15%] lg:-top-[190%] size-[550px] md:size-[1050px] pointer-events-none select-none"><x-optimized-image path="marketing/images/ns-img-520.png" alt="" /></figure>
      <div class="text-center space-y-5">
        <h2 class="max-w-[830px] mx-auto text-white">View primary opportunities on the platform.</h2>
        <div class="flex flex-col sm:flex-row items-center gap-3 justify-center">
          <a href="{{ url('/contact') }}" class="btn btn-primary border-0 hover:btn-white btn-md"><span>View Primary Opportunities</span></a>
          <a href="{{ url('/opportunities') }}" class="btn btn-white hover:btn-primary btn-md dark:btn-transparent"><span>All Opportunities</span></a>
        </div>
      </div>
    </div>
  </div>
</section>

</main>
@endsection
