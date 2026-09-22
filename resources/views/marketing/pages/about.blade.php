@extends('marketing.layouts.app')

@section('content')
<main>

<section class="pt-32 pb-14 sm:pt-36 md:pt-42 md:pb-16 lg:pb-[88px] xl:pt-[180px] xl:pb-[100px]">
  <div class="main-container space-y-12 md:space-y-16 lg:space-y-[100px]">
    <div class="pd-about-intro mx-auto flex w-full max-w-[820px] flex-col items-center text-center">
      <span data-ns-animate data-delay="0.2" class="badge badge-cyan">About Private Deals</span>
      <h1 data-ns-animate data-delay="0.3" class="pd-about-intro__title font-medium text-balance">
        Making Private Markets Easier to Access, Understand and Manage
      </h1>
      <div data-ns-animate data-delay="0.4" class="pd-about-intro__copy w-full">
        <p>
          Private Deals is a digital platform designed to help wealth partners bring private-market investment opportunities to their clients.
        </p>
        <p>
          We bring together opportunities, company information, research, transaction workflows and post-investment management in one place.
        </p>
        <p>
          Built for wealth partners and advisors, it helps you manage private markets without scattered information, multiple counterparties or complex manual processes.
        </p>
      </div>
    </div>
    <article class="pd-about-intro__media mx-auto flex w-full max-w-[1280px] flex-col gap-6 md:flex-row md:gap-8">
      <figure data-ns-animate data-delay="0.5" data-instant class="min-w-0 flex-1 overflow-hidden rounded-[20px]">
        <x-optimized-image path="marketing/images/pd-about-collab.png" alt="Team collaborating on private equity coverage for partners" class="aspect-[4/3] h-full w-full object-cover" />
      </figure>
      <figure data-ns-animate data-delay="0.6" data-instant class="min-w-0 flex-1 overflow-hidden rounded-[20px]">
        <x-optimized-image path="marketing/images/pd-about-review.png" alt="Structured review of opportunity materials" class="aspect-[4/3] h-full w-full object-cover" />
      </figure>
    </article>
  </div>
</section>

<section class="pd-about-split pt-14 md:pt-16 lg:pt-[88px] xl:pt-[100px] pb-14 md:pb-16 lg:pb-[88px] xl:pb-[100px] overflow-hidden">
  <div class="main-container">
    <div class="pd-about-split__grid">
      <div class="pd-about-split__copy">
        <span data-ns-animate data-delay="0.2" class="badge badge-cyan">Why Private Deals</span>
        <h2 data-ns-animate data-delay="0.3" class="pd-about-split__title text-balance">
          Private Market Investing Requires More Than Just Finding an Opportunity
        </h2>
        <div data-ns-animate data-delay="0.4" class="pd-about-split__body">
          <p>
            Finding the right investment is only the first step. Before recommending an opportunity, you need to understand the company, review the available information and evaluate whether it is suitable for your client.
          </p>
          <p>
            Once the decision is made, the transaction needs to be completed, documents need to be managed and the investment needs to be monitored over time.
          </p>
          <p>
            Private Deals brings the entire journey together in one place. From discovering an opportunity to evaluating, investing and managing it afterwards.
          </p>
        </div>
        <p data-ns-animate data-delay="0.55" class="pd-about-split__journey">
          Discover → Evaluate → Invest → Manage → Explore Liquidity
        </p>
      </div>
      <div class="pd-about-split__media">
        <figure data-ns-animate data-delay="0.4">
          <x-optimized-image path="marketing/images/pd-about-workspace.png" alt="Private Deals workspace for opportunity tracking" />
        </figure>
      </div>
    </div>
  </div>
</section>

<section class="pd-about-split pd-about-split--reverse pt-14 md:pt-16 lg:pt-[88px] xl:pt-[100px] pb-16 md:pb-24 lg:pb-32 overflow-hidden">
  <div class="main-container">
    <div class="pd-about-split__grid">
      <div class="pd-about-split__media pd-about-split__media--decor">
        <x-optimized-image path="marketing/images/pd-about-partner.png" alt="Partner reviewing ticket sizes and allocations" class="pd-about-split__hero-img" data-ns-animate data-delay="0.2" />
        <div data-ns-animate data-delay="0.3" data-direction="right" data-offset="90" class="pd-about-split__chip">
          From ₹25,000 to ₹50 lakh+
        </div>
        <figure data-ns-animate data-delay="0.5" data-direction="right" data-offset="100" class="pd-about-split__inset">
          <x-optimized-image path="marketing/images/pd-about-docs.png" alt="Document review on Private Deals" />
        </figure>
      </div>
      <div class="pd-about-split__copy">
        <span data-ns-animate data-delay="0.15" class="badge badge-cyan">Built to Support How You Work</span>
        <h2 data-ns-animate data-delay="0.2" class="pd-about-split__title text-balance">
          Supporting Your Role in Every Client Relationship
        </h2>
        <div data-ns-animate data-delay="0.3" class="pd-about-split__body">
          <p>
            Private Deals is designed to fit into the way wealth partners already work with their clients.
          </p>
          <p>
            You remain the primary advisor and continue to lead the investment relationship. We do not replace that. We support it with the infrastructure and tools needed to access and manage private-market investments more efficiently.
          </p>
        </div>
        <p data-ns-animate data-delay="0.35" class="pd-about-split__list-label">Through Private Deals, you can access:</p>
        <ul class="pd-about-split__list">
          <li data-ns-animate data-delay="0.4">
            <span class="pd-about-split__check" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="8" viewBox="0 0 10 8" fill="none"><path d="M4.31661 7.00605L9.74905 1.67144C10.0836 1.3459 10.0836 0.819702 9.74905 0.494158C9.41446 0.168614 8.87363 0.168614 8.53904 0.494158L3.7116 5.24012L1.46096 3.03807C1.12636 2.71253 0.585538 2.71253 0.250945 3.03807C-0.0836483 3.36362 -0.0836483 3.88982 0.250945 4.21536L3.1066 7.00605C3.27347 7.16841 3.49253 7.25 3.7116 7.25C3.93067 7.25 4.14974 7.16841 4.31661 7.00605Z" fill="white"/></svg></span>
            <span><strong>Private-Market Opportunities</strong>: Explore opportunities across Primary Investments, LP Secondary and Unlisted Shares.</span>
          </li>
          <li data-ns-animate data-delay="0.45">
            <span class="pd-about-split__check" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="8" viewBox="0 0 10 8" fill="none"><path d="M4.31661 7.00605L9.74905 1.67144C10.0836 1.3459 10.0836 0.819702 9.74905 0.494158C9.41446 0.168614 8.87363 0.168614 8.53904 0.494158L3.7116 5.24012L1.46096 3.03807C1.12636 2.71253 0.585538 2.71253 0.250945 3.03807C-0.0836483 3.36362 -0.0836483 3.88982 0.250945 4.21536L3.1066 7.00605C3.27347 7.16841 3.49253 7.25 3.7116 7.25C3.93067 7.25 4.14974 7.16841 4.31661 7.00605Z" fill="white"/></svg></span>
            <span><strong>Investment Information</strong>: Access company profiles, financials, valuation details, research and available due diligence.</span>
          </li>
          <li data-ns-animate data-delay="0.5">
            <span class="pd-about-split__check" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="8" viewBox="0 0 10 8" fill="none"><path d="M4.31661 7.00605L9.74905 1.67144C10.0836 1.3459 10.0836 0.819702 9.74905 0.494158C9.41446 0.168614 8.87363 0.168614 8.53904 0.494158L3.7116 5.24012L1.46096 3.03807C1.12636 2.71253 0.585538 2.71253 0.250945 3.03807C-0.0836483 3.36362 -0.0836483 3.88982 0.250945 4.21536L3.1066 7.00605C3.27347 7.16841 3.49253 7.25 3.7116 7.25C3.93067 7.25 4.14974 7.16841 4.31661 7.00605Z" fill="white"/></svg></span>
            <span><strong>Transaction Support</strong>: Manage investment documentation and transaction processes through a structured digital workflow.</span>
          </li>
          <li data-ns-animate data-delay="0.55">
            <span class="pd-about-split__check" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="8" viewBox="0 0 10 8" fill="none"><path d="M4.31661 7.00605L9.74905 1.67144C10.0836 1.3459 10.0836 0.819702 9.74905 0.494158C9.41446 0.168614 8.87363 0.168614 8.53904 0.494158L3.7116 5.24012L1.46096 3.03807C1.12636 2.71253 0.585538 2.71253 0.250945 3.03807C-0.0836483 3.36362 -0.0836483 3.88982 0.250945 4.21536L3.1066 7.00605C3.27347 7.16841 3.49253 7.25 3.7116 7.25C3.93067 7.25 4.14974 7.16841 4.31661 7.00605Z" fill="white"/></svg></span>
            <span><strong>Portfolio Management</strong>: Keep documents, company updates and portfolio information organized in one place.</span>
          </li>
          <li data-ns-animate data-delay="0.6">
            <span class="pd-about-split__check" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="8" viewBox="0 0 10 8" fill="none"><path d="M4.31661 7.00605L9.74905 1.67144C10.0836 1.3459 10.0836 0.819702 9.74905 0.494158C9.41446 0.168614 8.87363 0.168614 8.53904 0.494158L3.7116 5.24012L1.46096 3.03807C1.12636 2.71253 0.585538 2.71253 0.250945 3.03807C-0.0836483 3.36362 -0.0836483 3.88982 0.250945 4.21536L3.1066 7.00605C3.27347 7.16841 3.49253 7.25 3.7116 7.25C3.93067 7.25 4.14974 7.16841 4.31661 7.00605Z" fill="white"/></svg></span>
            <span><strong>Liquidity Opportunities</strong>: Explore available exit opportunities for eligible investments when they arise.</span>
          </li>
        </ul>
        <div data-ns-animate data-delay="0.7" class="pd-about-split__closing">
          <h3>Designed to Support, Not Replace, Your Client Relationships</h3>
          <p>
            Private Deals reduces operational complexity so you can focus more on advising clients and less on managing fragmented processes. The platform supports your work behind the scenes, while you stay in control of the relationship.
          </p>
        </div>
        <a data-ns-animate data-delay="0.8" href="{{ url('/contact') }}#contact-form" class="btn btn-md btn-secondary hover:btn-primary dark:btn-accent"><span>Become a Partner</span></a>
      </div>
    </div>
  </div>
</section>

<section class="relative">
  <div class="lg:main-container xl:max-w-[1440px] mx-auto w-full -mb-10 px-5 lg:px-0 xl:-mb-14 relative z-10">
    <div class="pd-cta-panel py-[76px] bg-secondary dark:bg-background-8 rounded-4xl relative z-10 overflow-hidden">
      <figure class="cta-bg-gradient -z-10 absolute -left-[30%] -top-[90%] md:-left-[30%] md:-top-[190%] lg:-left-[30%] xl:-left-[15%] lg:-top-[190%] size-[550px] md:size-[1050px] pointer-events-none select-none"><x-optimized-image path="marketing/images/ns-img-520.png" alt="" /></figure>
      <div class="text-center space-y-5">
        <span class="badge badge-blur text-ns-yellow">Talk to us</span>
        <h2 class="max-w-[830px] mx-auto text-white">Ready to work private markets with clearer infrastructure?</h2>
        <p class="text-accent/60">Become a partner or log in to get started.</p>
        <div class="flex flex-col sm:flex-row items-center gap-3 justify-center">
          <a href="{{ url('/contact') }}" class="btn btn-primary border-0 hover:btn-white btn-md"><span>Contact Us</span></a>
          <a href="{{ config('pages.partner_login_url') }}" class="btn btn-white hover:btn-primary btn-md dark:btn-transparent"><span>Login</span></a>
        </div>
      </div>
    </div>
  </div>
</section>

</main>
@endsection
