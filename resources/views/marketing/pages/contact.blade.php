@extends('marketing.layouts.app')

@section('content')
<main>

<section class="pt-32 pb-14 sm:pt-36 md:pt-42 md:pb-16 lg:pb-20 xl:pt-[180px] xl:pb-[100px]" aria-label="Contact">
  <div class="main-container">
    <div class="space-y-[70px]">
      <div class="mx-auto max-w-[980px] space-y-4 text-center">
        <span data-ns-animate data-delay="0.1" class="badge badge-cyan">Contact Us</span>
        <h1 data-ns-animate data-delay="0.2" class="mx-auto max-w-[920px] text-balance">Partner access, walkthroughs, and working questions.</h1>
        <p data-ns-animate data-delay="0.3" class="mx-auto max-w-[820px]">
          If you advise investors, run a firm, or operate a platform that needs private equity coverage, start here. Tell us how you work. We will follow up about Private Deals, operated by Shuru Advisory Private Limited.
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-[1000px] mx-auto">
        <div class="bg-background-1 dark:bg-background-6 rounded-[20px] p-8 space-y-3 border border-stroke-1 dark:border-stroke-7 pd-gold-rail">
          <h2 class="text-heading-6">Who should write</h2>
          <p>Partners seeking access or a walkthrough, not a retail helpdesk for end investors shopping a single ticket.</p>
        </div>
        <div class="bg-background-1 dark:bg-background-6 rounded-[20px] p-8 space-y-3 border border-stroke-1 dark:border-stroke-7 pd-gold-rail">
          <h2 class="text-heading-6">What we can cover</h2>
          <p>Onboarding, the three opportunity types, slot booking on primaries, and how web, iOS, and Android fit your process.</p>
        </div>
        <div class="bg-background-1 dark:bg-background-6 rounded-[20px] p-8 space-y-3 border border-stroke-1 dark:border-stroke-7 pd-gold-rail">
          <h2 class="text-heading-6">What happens next</h2>
          <p>We respond and, when it is a fit, point you to Login or Download App so you continue inside the product.</p>
        </div>
      </div>

      <div class="flex flex-col items-center justify-center gap-10 lg:flex-row lg:items-start lg:gap-8 xl:gap-[70px]">
        <div data-ns-animate data-delay="0.4" class="flex flex-col gap-8 md:flex-row lg:flex-col">
          <div class="bg-secondary dark:bg-background-6 relative w-full space-y-6 overflow-hidden rounded-[20px] p-11 text-center md:max-w-[371px]">
            <figure class="pointer-events-none absolute top-[-187px] left-[174px] size-[350px] -rotate-[78deg] overflow-hidden select-none">
              <x-optimized-image path="marketing/images/ns-img-510.png" alt="" class="size-full object-cover" />
            </figure>
            <figure class="mx-auto size-10 overflow-hidden">
              <img src="{{ asset('marketing/images/icons/home.svg') }}" alt="" class="size-full object-cover" />
            </figure>
            <div class="space-y-2.5 relative z-10">
              <p class="text-heading-6 text-accent">Company</p>
              <p class="text-accent/60">Shuru Advisory Private Limited</p>
            </div>
          </div>
          <div class="card-item bg-secondary dark:bg-background-6 relative w-full overflow-hidden rounded-[20px] p-11 text-center md:max-w-[371px]">
            <figure class="pointer-events-none absolute top-[-206px] left-[-36px] size-[350px] rotate-[62deg] overflow-hidden select-none">
              <x-optimized-image path="marketing/images/ns-img-509.png" alt="" class="size-full object-cover" />
            </figure>
            <div class="space-y-6 relative z-10">
              <figure class="mx-auto size-10 overflow-hidden">
                <img src="{{ asset('marketing/images/icons/mail-open.svg') }}" alt="" class="size-full object-cover" />
              </figure>
              <div class="space-y-2.5">
                <p class="text-heading-6 text-accent">Email</p>
                <p class="text-accent/60"><a href="mailto:privatedeals.in@gmail.com">privatedeals.in@gmail.com</a></p>
              </div>
            </div>
          </div>
        </div>

        <div id="contact-form" data-ns-animate data-delay="0.3" class="pd-form-card dark:bg-background-6 mx-auto w-full max-w-[847px] rounded-4xl bg-white p-6 md:p-8 lg:p-11">
          <form id="pd-contact-form" action="https://www.shuruup.com/api/privatedeals/submit-data" method="POST" class="space-y-8">
            <input type="text" name="_honey" tabindex="-1" autocomplete="off" class="pd-form-honeypot" aria-hidden="true" />
            <p id="pd-contact-status" class="pd-form-status" role="status" hidden></p>
            <div class="flex flex-col items-center justify-between gap-6 md:gap-8 md:flex-row">
              <div class="w-full space-y-2">
                <label for="fullname" class="text-tagline-2 text-secondary dark:text-accent block font-medium">Your name</label>
                <input type="text" id="fullname" name="fullname" placeholder="Enter your name" required autocomplete="name" class="dark:focus-visible:border-stroke-4/20 dark:border-stroke-7 dark:bg-background-6 border-stroke-3 bg-background-1 text-tagline-2 placeholder:text-secondary/60 focus:border-secondary dark:placeholder:text-accent/60 dark:text-accent h-[48px] w-full rounded-full border px-[18px] py-3 font-normal focus:outline-none" />
              </div>
              <div class="w-full space-y-2">
                <label for="firm" class="text-tagline-2 text-secondary dark:text-accent block font-medium">Firm or platform</label>
                <input type="text" id="firm" name="firm" placeholder="Organisation name" required class="dark:focus-visible:border-stroke-4/20 dark:border-stroke-7 dark:bg-background-6 border-stroke-3 bg-background-1 text-tagline-2 placeholder:text-secondary/60 focus:border-secondary dark:placeholder:text-accent/60 dark:text-accent h-[48px] w-full rounded-full border px-[18px] py-3 font-normal focus:outline-none" />
              </div>
            </div>
            <div class="flex flex-col items-center justify-between gap-6 md:gap-8 md:flex-row">
              <div class="w-full space-y-2">
                <label for="email" class="text-tagline-2 text-secondary dark:text-accent block font-medium">Email address</label>
                <input type="email" id="email" name="email" placeholder="Work email" required autocomplete="email" class="dark:focus-visible:border-stroke-4/20 dark:border-stroke-7 dark:bg-background-6 border-stroke-3 bg-background-1 text-tagline-2 placeholder:text-secondary/60 focus:border-secondary dark:placeholder:text-accent/60 dark:text-accent h-[48px] w-full rounded-full border px-[18px] py-3 font-normal focus:outline-none" />
              </div>
              <div class="w-full space-y-2">
                <label for="number" class="text-tagline-2 text-secondary dark:text-accent block font-medium">Phone</label>
                <input type="text" id="number" name="number" placeholder="Enter your number" required autocomplete="tel" class="dark:focus-visible:border-stroke-4/20 dark:border-stroke-7 dark:bg-background-6 border-stroke-3 bg-background-1 text-tagline-2 placeholder:text-secondary/60 focus:border-secondary dark:placeholder:text-accent/60 dark:text-accent h-[48px] w-full rounded-full border px-[18px] py-3 font-normal focus:outline-none" />
              </div>
            </div>
            <div class="space-y-2">
              <label for="subject" class="text-tagline-2 text-secondary dark:text-accent block font-medium">Subject</label>
              <input type="text" id="subject" name="subject" placeholder="Partner access, walkthrough, or a working question" required class="dark:focus-visible:border-stroke-4/20 dark:border-stroke-7 dark:bg-background-6 border-stroke-3 bg-background-1 text-tagline-2 placeholder:text-secondary/60 focus:border-secondary dark:placeholder:text-accent/60 dark:text-accent h-[48px] w-full rounded-full border px-[18px] py-3 font-normal focus:outline-none" />
            </div>
            <div class="space-y-2">
              <label for="message" class="text-tagline-2 text-secondary dark:text-accent block font-medium">Message</label>
              <textarea id="message" name="message" rows="7" placeholder="How you work with investors, and what you need from Private Deals" required class="dark:bg-background-6 dark:border-stroke-7 border-stroke-3 bg-background-1 text-tagline-2 placeholder:text-secondary/60 focus:border-secondary dark:placeholder:text-accent/60 dark:text-accent w-full rounded-xl border px-[18px] py-3 font-normal focus:outline-none"></textarea>
            </div>
            <fieldset class="mb-4 flex items-center gap-2">
              <label for="terms" class="flex items-center gap-x-3">
                <input id="terms" name="terms" type="checkbox" value="Agreed" class="peer sr-only" required />
                <span class="border-stroke-3 dark:border-stroke-7 after:bg-primary-500 peer-checked:border-primary-500 relative size-4 cursor-pointer rounded-full border after:absolute after:top-1/2 after:left-1/2 after:size-2.5 after:-translate-x-1/2 after:-translate-y-1/2 after:rounded-full after:opacity-0 peer-checked:after:opacity-100"></span>
              </label>
              <label for="terms" class="text-tagline-3 text-secondary/60 dark:text-accent/60 cursor-pointer">
                I agree with the <a href="{{ url('/terms-conditions') }}" class="text-primary-500 text-tagline-3 underline">terms and conditions</a>
              </label>
            </fieldset>
            <button type="submit" id="pd-contact-submit" class="btn btn-md btn-secondary hover:btn-primary dark:btn-accent w-full"><span>Send message</span></button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

</main>
@endsection

@push('scripts')
<script src="{{ asset('marketing/assets/contact-form.js') }}"></script>
@endpush
