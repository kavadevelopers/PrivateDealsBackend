@extends('marketing.layouts.app')

@section('content')
<main>

<section class="xl:pt-[180px] md:pt-42 sm:pt-36 pt-32 pb-16">
  <div class="main-container">
    <div class="grid grid-cols-12 items-center xl:gap-[100px] lg:gap-20 gap-y-10">
      <div class="col-span-12 lg:col-span-6 space-y-6">
        <span class="badge badge-green">Unlisted Shares</span>
        <h1>Access Private Companies Before They List</h1>
        <p class="max-w-[520px]">Explore shares of selected unlisted and pre-IPO companies, with company information, financials, valuation data and market updates to help you make informed decisions for your clients.</p>
        <p class="text-tagline-1 text-secondary/60">Minimum Investment: From ₹15,000 onwards</p>
        <a href="{{ url('/contact') }}#contact-form" class="btn btn-primary btn-md"><span>Request Access</span></a>
      </div>
      <div class="col-span-12 lg:col-span-6">
        <div class="flex items-start -space-x-20">
          <figure class="max-w-[408px] w-full rounded-[20px] overflow-hidden">
            <x-optimized-image path="marketing/images/pd-unlisted-holding.png" alt="Unlisted share holding overview" class="w-full h-full object-cover" />
          </figure>
          <figure class="max-w-[225px] w-full rounded-2xl overflow-hidden mt-4">
            <x-optimized-image path="marketing/images/pd-unlisted-transfer.png" alt="Share transfer and exit status" class="w-full h-full object-cover" />
          </figure>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="pb-16 md:pb-24 bg-background-2 pt-14 md:pt-16 lg:pt-[88px]">
  <div class="main-container">
    <div class="max-w-[680px] mb-12 space-y-3">
      <span class="badge badge-green">Company research</span>
      <h2>Understand the Company Before You Invest</h2>
      <p>Get a clear view of the company, its financial performance and its current market position.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <div class="rounded-[20px] bg-white p-8 space-y-3 border border-stroke-4 pd-gold-rail"><h3 class="text-heading-6">Company Profile</h3><p>Understand the business, products, revenue model and industry.</p></div>
      <div class="rounded-[20px] bg-white p-8 space-y-3 border border-stroke-4 pd-gold-rail"><h3 class="text-heading-6">Financial Performance</h3><p>Review available financial statements, revenue, profitability and other key numbers.</p></div>
      <div class="rounded-[20px] bg-white p-8 space-y-3 border border-stroke-4 pd-gold-rail"><h3 class="text-heading-6">Valuation</h3><p>Understand the company's current valuation, previous transaction prices and relevant market comparisons.</p></div>
      <div class="rounded-[20px] bg-white p-8 space-y-3 border border-stroke-4 pd-gold-rail"><h3 class="text-heading-6">Market Updates</h3><p>Stay updated with important company news, funding activity and corporate developments.</p></div>
      <div class="rounded-[20px] bg-white p-8 space-y-3 border border-stroke-4 pd-gold-rail md:col-span-2 lg:col-span-1"><h3 class="text-heading-6">Research &amp; Analysis</h3><p>Access relevant research and sector information to support your investment view.</p></div>
    </div>
  </div>
</section>

<section class="pd-decide pt-14 md:pt-16 lg:pt-[88px] pb-14 md:pb-16 lg:pb-[88px]">
  <div class="main-container">
    <div class="pd-decide__inner">
      <span class="badge badge-green">Decision support</span>
      <h2>Make Better Investment Decisions</h2>
      <p>Bring the key information together before investing. This helps you assess whether the opportunity fits your client's investment objective and risk appetite.</p>
      <ul class="pd-decide__tags">
        <li>Business Fundamentals</li>
        <li>Financial Performance</li>
        <li>Valuation</li>
        <li>Market Updates</li>
      </ul>
    </div>
  </div>
</section>

<section class="pt-14 pb-14 md:pt-16 md:pb-16 lg:pt-[88px] lg:pb-[88px] bg-background-2">
  <div class="main-container">
    <div class="mx-auto mb-12 max-w-[820px] space-y-3 text-center md:mb-14">
      <span class="badge badge-green">Client readiness</span>
      <h2 class="text-balance">Give Your Clients the Information They Need</h2>
      <p class="mx-auto max-w-[640px]">Once you decide to consider an opportunity, easily access and share the information required to explain the investment to your clients.</p>
    </div>
    <div class="pd-picture-grid pd-picture-grid--4">
      <article class="pd-picture-card">
        <h3 class="pd-picture-card__title">Business Overview</h3>
        <p class="pd-picture-card__text">Clearly explain what the company does and how it operates.</p>
      </article>
      <article class="pd-picture-card">
        <h3 class="pd-picture-card__title">Financial Information</h3>
        <p class="pd-picture-card__text">Share important financial and performance numbers.</p>
      </article>
      <article class="pd-picture-card">
        <h3 class="pd-picture-card__title">Investment Rationale</h3>
        <p class="pd-picture-card__text">Present the key factors supporting the opportunity.</p>
      </article>
      <article class="pd-picture-card">
        <h3 class="pd-picture-card__title">Research &amp; Documents</h3>
        <p class="pd-picture-card__text">Keep company information, research and other documents together.</p>
      </article>
    </div>
  </div>
</section>

<section class="pd-invest-flow pt-14 md:pt-16 lg:pt-[88px] pb-14 md:pb-16 lg:pb-[88px]">
  <div class="main-container">
    <div class="pd-invest-flow__intro">
      <span class="badge badge-green">Invest Digitally</span>
      <h2>Complete the Investment Digitally</h2>
      <p>Complete the investment process through a simple digital workflow. Reduce paperwork and keep the transaction process clear from start to finish.</p>
    </div>
    <ol class="pd-invest-flow__steps pd-invest-flow__steps--5">
      <li>
        <em>01</em>
        <strong>Verify Opportunity</strong>
        <span>Confirm the company, pricing and available share details.</span>
      </li>
      <li>
        <em>02</em>
        <strong>Confirm Deal</strong>
        <span>Proceed with the selected unlisted opportunity.</span>
      </li>
      <li>
        <em>03</em>
        <strong>Sign Documentation</strong>
        <span>Complete required documents through digital signing.</span>
      </li>
      <li>
        <em>04</em>
        <strong>Complete Payment</strong>
        <span>Transfer capital through the secure payment process.</span>
      </li>
      <li>
        <em>05</em>
        <strong>Receive Shares</strong>
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
        <h2>Keep Monitoring After Investment</h2>
        <p>Continue tracking your client's unlisted investments after the transaction.</p>
      </div>
      <ul class="pd-after__list">
        <li>
          <strong>Portfolio Dashboard</strong>
          <span>View unlisted holdings alongside other private-market investments.</span>
        </li>
        <li>
          <strong>Company Updates</strong>
          <span>Stay informed about financial performance, announcements and key developments.</span>
        </li>
        <li>
          <strong>Market Tracking</strong>
          <span>Follow changes in transaction prices and available market information.</span>
        </li>
        <li>
          <strong>Document Vault</strong>
          <span>Keep contracts, transaction records, share documents and other information organized.</span>
        </li>
      </ul>
    </div>
  </div>
</section>

<section class="pt-14 md:pt-16 pb-14 md:pb-16">
  <div class="main-container">
    <div class="max-w-[760px] mx-auto text-center space-y-4">
      <span class="badge badge-green">Unlisted journey</span>
      <h2>From Discovery to Monitoring</h2>
      <p>Find the opportunity, understand the company, invest digitally and continue tracking the investment, all from one platform.</p>
    </div>
  </div>
</section>

<section class="relative">
  <div class="lg:main-container xl:max-w-[1440px] mx-auto w-full -mb-10 px-5 lg:px-0 xl:-mb-14 relative z-10">
    <div class="pd-cta-panel py-[76px] bg-secondary dark:bg-background-8 rounded-4xl relative z-10 overflow-hidden">
      <figure class="cta-bg-gradient -z-10 absolute -left-[30%] -top-[90%] md:-left-[30%] md:-top-[190%] lg:-left-[30%] xl:-left-[15%] lg:-top-[190%] size-[550px] md:size-[1050px] pointer-events-none select-none"><x-optimized-image path="marketing/images/ns-img-520.png" alt="" /></figure>
      <div class="text-center space-y-5">
        <h2 class="max-w-[830px] mx-auto text-white">Explore unlisted opportunities on the platform.</h2>
        <div class="flex flex-col sm:flex-row items-center gap-3 justify-center">
          <a href="{{ url('/contact') }}" class="btn btn-primary border-0 hover:btn-white btn-md"><span>Explore Unlisted Opportunities</span></a>
          <a href="{{ url('/opportunities') }}" class="btn btn-white hover:btn-primary btn-md dark:btn-transparent"><span>All Opportunities</span></a>
        </div>
      </div>
    </div>
  </div>
</section>

</main>
@endsection
