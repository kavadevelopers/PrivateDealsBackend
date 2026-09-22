<footer class="footer footer-three dark:bg-background-8 border-stroke-1 relative overflow-hidden border-t bg-white dark:border-0">
  <div class="main-container">
    <div class="pd-footer-top">
      <div data-ns-animate data-delay="0.3" class="pd-footer-brand">
        <figure>
          <img src="{{ asset('marketing/images/shared/main-logo.svg') }}" class="dark:hidden" alt="Private Deals" />
          <img src="{{ asset('marketing/images/shared/dark-logo.svg') }}" class="hidden dark:block" alt="Private Deals" />
        </figure>
        <p class="text-secondary dark:text-accent text-tagline-2">
          A partner platform for private equity opportunities across Primary Investments, LP Secondaries, and Unlisted Shares. Operated by Shuru Advisory Private Limited.
        </p>
        <a href="{{ url('/contact') }}#contact-form" class="pd-store-btn pd-store-btn--sm pd-footer-demo" aria-label="Book a Demo">
          <span class="pd-store-btn__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><rect x="3.5" y="5" width="17" height="15" rx="2"/><path d="M8 3.5v3M16 3.5v3M3.5 10h17"/><path d="M9 14h2M13 14h2M9 17h6"/></svg>
          </span>
          <span class="pd-store-btn__label"><span class="pd-store-btn__sublabel">Talk to us</span><span class="pd-store-btn__name">Book a Demo</span></span>
        </a>
      </div>
      <div data-ns-animate data-delay="0.4" class="pd-footer-col">
        <p class="pd-footer-heading sm:text-heading-6 text-tagline-1 text-secondary dark:text-accent font-normal">Company</p>
        <ul>
          @foreach (config('pages.nav.footer_company') as $link)
            <li><a href="{{ url($link['path']) }}" class="footer-link-v2">{{ $link['label'] }}</a></li>
          @endforeach
        </ul>
      </div>
      <div data-ns-animate data-delay="0.5" class="pd-footer-col">
        <p class="pd-footer-heading sm:text-heading-6 text-tagline-1 text-secondary dark:text-accent font-normal">Legal</p>
        <ul>
          @foreach (config('pages.nav.footer_legal') as $link)
            <li><a href="{{ url($link['path']) }}" class="footer-link-v2">{{ $link['label'] }}</a></li>
          @endforeach
        </ul>
      </div>
      <div data-ns-animate data-delay="0.6" class="pd-footer-col pd-footer-col--apps">
        <p class="pd-footer-heading sm:text-heading-6 text-tagline-1 text-secondary dark:text-accent font-normal">Get the app</p>
        <div class="pd-footer-apps">
          <a href="#" class="pd-store-btn pd-store-btn--sm" aria-label="Get it on Google Play">
            <span class="pd-store-btn__icon" aria-hidden="true">
              <svg viewBox="0 0 512 512" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M325.3 234.3L104.6 13l280.8 161.2-60.1 60.1zM47 0C34 6.8 25.3 19.2 25.3 35.3v441.3c0 16.1 8.7 28.5 21.7 35.3l256.6-256L47 0zm425.2 225.6l-58.9-34.1-65.7 64.5 65.7 64.5 60.1-34.1c18-14.3 18-46.5-1.2-60.8zM104.6 499l280.8-161.2-60.1-60.1L104.6 499z"/></svg>
            </span>
            <span class="pd-store-btn__label"><span class="pd-store-btn__sublabel">Get it on</span><span class="pd-store-btn__name">Google Play</span></span>
          </a>
          <a href="#" class="pd-store-btn pd-store-btn--sm" aria-label="Download on the App Store">
            <span class="pd-store-btn__icon" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M16.3664 6.41528C14.4764 6.41528 13.6776 7.31716 12.3614 7.31716C11.0118 7.31716 9.98245 6.42185 8.34464 6.42185C6.74151 6.42185 5.03198 7.4006 3.94636 9.06794C2.42198 11.4192 2.68073 15.8475 5.14964 19.62C6.03276 20.9704 7.21214 22.485 8.75901 22.5014H8.78714C10.1315 22.5014 10.5309 21.6211 12.381 21.6108H12.4092C14.2317 21.6108 14.5973 22.4962 15.936 22.4962H15.9642C17.511 22.4798 18.7537 20.8017 19.6368 19.4564C20.2724 18.4889 20.5087 18.0033 20.9962 16.9087C17.4248 15.5531 16.851 10.4901 20.3831 8.54903C19.305 7.19903 17.7899 6.41716 16.3617 6.41716L16.3664 6.41528Z"/><path d="M15.9486 1.5C14.8236 1.57641 13.5111 2.29266 12.7423 3.22781C12.0448 4.07531 11.4711 5.3325 11.6961 6.55172H11.7861C12.9842 6.55172 14.2105 5.83031 14.9267 4.90594C15.6167 4.02609 16.1398 2.77922 15.9486 1.5Z"/></svg>
            </span>
            <span class="pd-store-btn__label"><span class="pd-store-btn__sublabel">Download on the</span><span class="pd-store-btn__name">App Store</span></span>
          </a>
        </div>
      </div>
    </div>
    <div class="relative overflow-hidden pd-footer-bottom">
      <div class="footer-divider bg-stroke-2 dark:bg-accent/5 absolute top-0 right-0 left-0 mx-auto h-px w-0 origin-center"></div>
      <p class="pd-footer-risk text-tagline-2 text-secondary/60 dark:text-accent/60 italic max-w-[720px] mx-auto">
        Private equity investments involve risk, including possible loss of capital. Read our <a href="{{ url('/risk-disclosure') }}" class="underline">Risk Disclosure</a> and <a href="{{ url('/disclaimer') }}" class="underline">Disclaimer</a>.
      </p>
      <p data-ns-animate data-delay="0.7" data-offset="10" data-start="top 105%" class="text-secondary dark:text-accent/60 text-tagline-2">
        Copyright &copy; Shuru Advisory Private Limited All rights reserved
      </p>
    </div>
  </div>
  <div>
    <button id="theme-toggle" aria-label="Theme toggle button" type="button" class="size-12 bg-background-8 !z-[9999] dark:bg-white rounded-l-2xl cursor-pointer flex items-center justify-center fixed right-0 bottom-5">
      <span id="dark-theme-icon">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 stroke-black">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
        </svg>
      </span>
      <span id="light-theme-icon">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
        </svg>
      </span>
    </button>
  </div>
  <script src="{{ asset('marketing/vendor/swiper.min.js') }}"></script>
  <script src="{{ asset('marketing/vendor/leaflet.min.js') }}"></script>
  <script src="{{ asset('marketing/vendor/vanilla-infinite-marquee.min.js') }}"></script>
  <script src="{{ asset('marketing/vendor/split-text.min.js') }}"></script>
  <script src="{{ asset('marketing/vendor/gsap.min.js') }}"></script>
  <script src="{{ asset('marketing/vendor/scroll-trigger.min.js') }}"></script>
  <script src="{{ asset('marketing/vendor/draw-svg.min.js') }}"></script>
  <script src="{{ asset('marketing/vendor/motionpathplugin.min.js') }}"></script>
  <script src="{{ asset('marketing/vendor/lenis.min.js') }}"></script>
  <script src="{{ asset('marketing/vendor/springer.min.js') }}"></script>
  <script src="{{ asset('marketing/vendor/number-counter.js') }}"></script>
  <script src="{{ asset('marketing/vendor/stack-card.min.js') }}"></script>
  <script src="{{ asset('marketing/assets/main.js') }}"></script>
</footer>
