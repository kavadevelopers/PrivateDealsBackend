@php
    use App\Support\Nav;
@endphp
<header>
  <div class="header-one lp:!max-w-[1290px] shadow-2 dark:bg-background-5 fixed top-5 left-1/2 z-50 mx-auto flex w-full max-w-[350px] -translate-x-1/2 items-center justify-between rounded-full bg-white px-2.5 py-2.5 opacity-0 min-[425px]:max-w-[375px] min-[500px]:max-w-[450px] sm:max-w-[540px] md:max-w-[720px] lg:max-w-[960px] xl:max-w-[1140px] xl:py-0" data-ns-animate data-direction="up" data-offset="100">
    <div>
      <a href="{{ url('/') }}">
        <span class="sr-only">Home</span>
        <figure class="hidden lg:block lg:max-w-[198px]">
          <img src="{{ asset('marketing/images/shared/main-logo.svg') }}" alt="Private Deals" class="dark:invert" />
        </figure>
        <figure class="block max-w-[44px] lg:hidden">
          <img src="{{ asset('marketing/images/shared/logo.svg') }}" alt="Private Deals" class="block w-full dark:hidden" />
          <img src="{{ asset('marketing/images/shared/logo-dark.svg') }}" alt="Private Deals" class="hidden w-full dark:block" />
        </figure>
      </a>
    </div>
    <nav class="hidden items-center xl:flex" aria-label="Primary">
      <ul class="flex items-center">
        @foreach (config('pages.nav.primary') as $item)
          @php $active = Nav::isActive($item['path']); @endphp
          @if (! empty($item['children']))
            <li class="nav-item relative cursor-pointer py-2.5" data-menu="opportunities-dropdown-menu">
              <a href="{{ url($item['path']) }}" class="{{ Nav::navLinkClass($active) }}">
                <span>{{ $item['label'] }}</span>
                <span class="nav-arrow block origin-center translate-y-px transition-all duration-300">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
                </span>
              </a>
              <div>
                <div class="dropdown-menu-bridge absolute left-1/2 -translate-x-1/2 top-full h-3 z-40 w-full min-w-[280px] pointer-events-none bg-transparent opacity-0"></div>
                <ul id="opportunities-dropdown-menu" class="dropdown-menu absolute top-full left-1/2 z-50 mt-2 w-[280px] -translate-x-1/2 rounded-[20px] border border-stroke-1 bg-white p-2 opacity-0 pointer-events-none shadow-14 transition-all duration-300 dark:border-background-7 dark:bg-background-6">
                  @foreach ($item['children'] as $child)
                    <li>
                      <a href="{{ url($child['path']) }}" class="text-tagline-1 text-secondary dark:text-accent relative z-10 block rounded-2xl px-4 py-3 transition-colors duration-200 hover:bg-background-3 dark:hover:bg-background-7">{{ $child['label'] }}</a>
                    </li>
                  @endforeach
                </ul>
              </div>
            </li>
          @else
            <li class="nav-item relative cursor-pointer py-2.5">
              <a href="{{ url($item['path']) }}" class="{{ Nav::navLinkClass($active) }}">
                <span>{{ $item['label'] }}</span>
              </a>
            </li>
          @endif
        @endforeach
      </ul>
    </nav>
    <div class="hidden items-center justify-center xl:flex">
      <a href="{{ config('pages.partner_login_url') }}" class="btn btn-md btn-white dark:btn-transparent hover:btn-primary"><span>Login</span></a>
    </div>
    <div class="block xl:hidden">
      <button type="button" class="nav-hamburger bg-background-4 dark:bg-background-6 flex size-12 cursor-pointer flex-col items-center justify-center gap-[5px] rounded-full">
        <span class="sr-only">Menu</span>
        <span class="bg-stroke-9 dark:bg-stroke-1 block h-0.5 w-6"></span>
        <span class="bg-stroke-9 dark:bg-stroke-1 block h-0.5 w-6"></span>
        <span class="bg-stroke-9 dark:bg-stroke-1 block h-0.5 w-6"></span>
      </button>
    </div>
  </div>
  <aside class="sidebar dark:bg-background-8 scroll-bar fixed top-0 right-0 z-[9999] h-screen w-full translate-x-full rounded-l-3xl bg-white transition-all duration-300 sm:w-1/2 xl:hidden">
    <div class="space-y-4 p-5 sm:p-8 lg:p-9">
      <div class="flex items-center justify-between">
        <a href="{{ url('/') }}">
          <span class="sr-only">Home</span>
          <figure class="max-w-[44px]">
            <img src="{{ asset('marketing/images/shared/logo.svg') }}" alt="Private Deals" class="block w-full dark:hidden" />
            <img src="{{ asset('marketing/images/shared/logo-dark.svg') }}" alt="Private Deals" class="hidden w-full dark:block" />
          </figure>
        </a>
        <button type="button" class="nav-hamburger-close bg-background-4 dark:bg-background-9 relative flex size-10 cursor-pointer flex-col items-center justify-center gap-1.5 rounded-full">
          <span class="sr-only">Close Menu</span>
          <span class="bg-stroke-9/60 dark:bg-stroke-1 absolute block h-0.5 w-4 rotate-45"></span>
          <span class="bg-stroke-9/60 dark:bg-stroke-1 absolute block h-0.5 w-4 -rotate-45"></span>
        </button>
      </div>
      <div class="scroll-bar mt-6 h-[85vh] w-full overflow-x-hidden overflow-y-auto pb-10">
        <p class="text-secondary dark:text-accent text-tagline-1 relative mb-2 block font-normal">Menu</p>
        <ul class="space-y-2">
          @foreach (config('pages.nav.primary') as $item)
            @php $active = Nav::isActive($item['path']); @endphp
            @if (! empty($item['children']))
              <li class="space-y-2">
                <button type="button" class="mobile-menu-toggle flex w-full cursor-pointer items-center justify-between py-2.5" data-menu="opportunities">
                  <span class="text-secondary/60 dark:text-accent/60 text-tagline-1 relative block font-normal">{{ $item['label'] }}</span>
                  <span class="menu-arrow transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M10 12L14 8L10 4" class="stroke-secondary/60 dark:stroke-accent/60" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                  </span>
                </button>
                <ul class="mobile-submenu hidden" data-submenu="opportunities">
                  @foreach ($item['children'] as $child)
                    <li><a href="{{ url($child['path']) }}" class="text-tagline-1 text-secondary dark:text-accent ml-4 block py-2.5 text-left font-normal transition-all duration-200">{{ $child['label'] }}</a></li>
                  @endforeach
                </ul>
              </li>
            @else
              <li>
                <a href="{{ url($item['path']) }}" class="{{ Nav::mobileNavLinkClass($active) }}">{{ $item['label'] }}</a>
              </li>
            @endif
          @endforeach
          <li><a href="{{ config('pages.partner_login_url') }}" class="text-tagline-1 text-secondary/60 dark:text-accent/60 block py-2.5 font-normal">Login</a></li>
        </ul>
      </div>
    </div>
  </aside>
</header>
