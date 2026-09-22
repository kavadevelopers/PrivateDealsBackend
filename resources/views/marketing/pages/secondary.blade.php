@extends('marketing.layouts.app')

@section('content')
<main>

<section class="xl:pt-[180px] md:pt-42 sm:pt-36 pt-32 pb-16">
  <div class="main-container">
    <div class="grid grid-cols-12 items-center xl:gap-[100px] lg:gap-20 gap-y-10">
      <div class="col-span-12 lg:col-span-6 space-y-6">
        <span class="badge badge-green">Secondary Opportunities</span>
        <h1>Access Existing Shares in Private Companies</h1>
        <p class="max-w-[520px]">Explore opportunities to buy existing shares from investors such as founders, employees, family offices, funds and other shareholders.</p>
        <p class="text-tagline-1 text-secondary/60">Minimum Investment: From ₹1 Crore onwards</p>
        <a href="{{ url('/contact') }}#contact-form" class="btn btn-primary btn-md"><span>Request Access</span></a>
      </div>
      <div class="col-span-12 lg:col-span-6">
        <div class="flex items-center gap-8">
          <figure class="max-w-[326px] max-h-[317px] h-full w-full rounded-[20px] overflow-hidden">
            <x-optimized-image path="marketing/images/pd-secondary-overview.png" alt="Secondary interest overview" class="w-full h-full object-cover" />
          </figure>
          <figure class="max-w-[255px] max-h-[178px] h-full w-full rounded-2xl overflow-hidden">
            <x-optimized-image path="marketing/images/pd-secondary-terms.png" alt="Transaction terms for a secondary" class="w-full h-full object-cover" />
          </figure>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="pb-16 md:pb-24 bg-background-2 pt-14 md:pt-16 lg:pt-[88px]">
  <div class="main-container">
    <div class="max-w-[680px] mb-12 space-y-3">
      <span class="badge badge-green">Company &amp; share research</span>
      <h2>Know What You Are Buying</h2>
      <p>With secondary investments, you are not investing in a new funding round. You are buying existing shares from an existing shareholder. Our platform helps you understand both the company and the specific shares being offered.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <div class="rounded-[20px] bg-white p-8 space-y-3 border border-stroke-4 pd-gold-rail"><h3 class="text-heading-6">Company Information</h3><p>Understand the business, revenue model, market and growth.</p></div>
      <div class="rounded-[20px] bg-white p-8 space-y-3 border border-stroke-4 pd-gold-rail"><h3 class="text-heading-6">Financials</h3><p>Review financial performance, cash flows and key business numbers.</p></div>
      <div class="rounded-[20px] bg-white p-8 space-y-3 border border-stroke-4 pd-gold-rail"><h3 class="text-heading-6">Company Updates</h3><p>Access available investor presentations, business updates and relevant information.</p></div>
      <div class="rounded-[20px] bg-white p-8 space-y-3 border border-stroke-4 pd-gold-rail"><h3 class="text-heading-6">Valuation &amp; Pricing</h3><p>Understand the company's current valuation and the price at which the shares are being offered.</p></div>
      <div class="rounded-[20px] bg-white p-8 space-y-3 border border-stroke-4 pd-gold-rail"><h3 class="text-heading-6">Share Details</h3><p>Know the type, quantity, ownership and rights attached to the shares.</p></div>
      <div class="rounded-[20px] bg-white p-8 space-y-3 border border-stroke-4 pd-gold-rail"><h3 class="text-heading-6">Legal Documents</h3><p>Review available share transfer documents and other relevant legal information.</p></div>
    </div>
  </div>
</section>

<section class="pt-14 md:pt-16 lg:pt-[88px] pb-14 md:pb-16 lg:pb-[88px]">
  <div class="main-container">
    <div class="mx-auto mb-12 max-w-[820px] space-y-3 text-center md:mb-14">
      <span class="badge badge-green">Clear evaluation</span>
      <h2 class="text-balance">Evaluate the Opportunity Clearly</h2>
      <p class="mx-auto max-w-[640px]">Before investing, understand the three things that matter:</p>
    </div>
    <div class="pd-picture-grid pd-picture-grid--3">
      <article class="pd-picture-card">
        <h3 class="pd-picture-card__title">The Company</h3>
        <p class="pd-picture-card__text">Is the underlying business strong and relevant for your client?</p>
      </article>
      <article class="pd-picture-card">
        <h3 class="pd-picture-card__title">The Shares</h3>
        <p class="pd-picture-card__text">What exactly are you buying: quantity, share class, ownership and rights?</p>
      </article>
      <article class="pd-picture-card">
        <h3 class="pd-picture-card__title">The Deal</h3>
        <p class="pd-picture-card__text">What is the price, transaction structure, fees and expected settlement timeline?</p>
      </article>
    </div>
  </div>
</section>

<section class="pd-invest-flow pt-14 md:pt-16 lg:pt-[88px] pb-14 md:pb-16 lg:pb-[88px] bg-background-2">
  <div class="main-container">
    <div class="pd-invest-flow__intro">
      <span class="badge badge-green">Simple Digital Transfer Process</span>
      <h2>Manage the Transaction Digitally</h2>
      <p>Once you decide to proceed, manage the transaction through a structured digital workflow. Track the transaction from the initial confirmation until the shares are transferred and settled.</p>
    </div>
    <ol class="pd-invest-flow__steps pd-invest-flow__steps--5">
      <li>
        <em>01</em>
        <strong>Confirm Deal</strong>
        <span>Lock in the opportunity and proceed with the transaction.</span>
      </li>
      <li>
        <em>02</em>
        <strong>Review Documentation</strong>
        <span>Check share transfer documents and related paperwork.</span>
      </li>
      <li>
        <em>03</em>
        <strong>Sign Agreements</strong>
        <span>Complete required agreements through digital signing.</span>
      </li>
      <li>
        <em>04</em>
        <strong>Transfer Shares</strong>
        <span>Move shares through the structured transfer process.</span>
      </li>
      <li>
        <em>05</em>
        <strong>Settlement</strong>
        <span>Complete settlement and confirm the final transfer.</span>
      </li>
    </ol>
  </div>
</section>

<section class="pd-after pt-14 pb-14 md:pt-16 md:pb-16 lg:pt-[88px] lg:pb-[88px]">
  <div class="main-container">
    <div class="pd-after__panel">
      <div class="pd-after__intro">
        <span class="badge badge-green">After the transfer</span>
        <h2>Keep Everything Organized After the Investment</h2>
        <p>Once the shares are transferred, continue monitoring them from your portfolio.</p>
      </div>
      <ul class="pd-after__list">
        <li>
          <strong>Portfolio Tracking</strong>
          <span>View secondary investments alongside your other private-market holdings.</span>
        </li>
        <li>
          <strong>Documents</strong>
          <span>Keep transfer documents, receipts and share-related records in one place.</span>
        </li>
        <li>
          <strong>Company Updates</strong>
          <span>Stay informed about important business and corporate developments.</span>
        </li>
        <li>
          <strong>Transaction History</strong>
          <span>Maintain a clear record of the investment and transfer.</span>
        </li>
      </ul>
    </div>
  </div>
</section>

<section class="pt-14 md:pt-16 pb-14 md:pb-16">
  <div class="main-container">
    <div class="max-w-[760px] mx-auto text-center space-y-4">
      <span class="badge badge-green">Secondary journey</span>
      <h2>A Simpler Way to Access Secondary Opportunities</h2>
      <p>From evaluating the company and the shares to completing the transfer and monitoring the investment, manage the complete secondary investment journey through one platform.</p>
    </div>
  </div>
</section>

<section class="relative">
  <div class="lg:main-container xl:max-w-[1440px] mx-auto w-full -mb-10 px-5 lg:px-0 xl:-mb-14 relative z-10">
    <div class="pd-cta-panel py-[76px] bg-secondary dark:bg-background-8 rounded-4xl relative z-10 overflow-hidden">
      <figure class="cta-bg-gradient -z-10 absolute -left-[30%] -top-[90%] md:-left-[30%] md:-top-[190%] lg:-left-[30%] xl:-left-[15%] lg:-top-[190%] size-[550px] md:size-[1050px] pointer-events-none select-none"><x-optimized-image path="marketing/images/ns-img-520.png" alt="" /></figure>
      <div class="text-center space-y-5">
        <h2 class="max-w-[830px] mx-auto text-white">Evaluate secondary opportunities on the platform.</h2>
        <div class="flex flex-col sm:flex-row items-center gap-3 justify-center">
          <a href="{{ url('/contact') }}#contact-form" class="btn btn-primary border-0 hover:btn-white btn-md"><span>Request Access</span></a>
          <a href="{{ url('/opportunities') }}" class="btn btn-white hover:btn-primary btn-md dark:btn-transparent"><span>All Opportunities</span></a>
        </div>
      </div>
    </div>
  </div>
</section>

</main>
@endsection
