@extends('marketing.layouts.app')

@section('content')
<main>

<section class="lg:pt-[180px] pt-[120px] lg:pb-[100px] pb-[70px]" aria-label="Login">
  <div class="main-container">
    <div class="mx-auto mb-8 max-w-[400px] space-y-3 text-center">
      <span class="badge badge-cyan">Partner access</span>
      <h1 class="text-heading-5">Sign in to Private Deals</h1>
      <p>Access is limited to registered wealth partners.</p>
    </div>
    <div data-ns-animate data-delay="0.1" class="pd-login-card max-w-[400px] mx-auto bg-background-1 dark:bg-background-6 rounded-[20px] py-14 px-8">
      <form id="pd-login-form" class="mb-6" novalidate>
        <p id="pd-login-status" class="pd-login-status" role="alert" hidden></p>
        <fieldset class="space-y-2 mb-4">
          <label for="mobile" class="block text-tagline-2 font-medium text-secondary dark:text-accent select-none">Mobile number</label>
          <input type="tel" id="mobile" name="mobile" class="auth-form-input" placeholder="Mobile number" autocomplete="tel" inputmode="numeric" required />
        </fieldset>
        <fieldset class="space-y-2 mb-3">
          <label for="password" class="block text-tagline-2 font-medium text-secondary dark:text-accent select-none">Password</label>
          <input type="password" id="password" name="password" class="auth-form-input" placeholder="At least 8 characters" autocomplete="current-password" required />
        </fieldset>
        <div class="flex items-center justify-between">
          <label class="inline-flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="remember" class="peer sr-only" />
            <span class="size-5 rounded-full border border-stroke-3 dark:border-stroke-7 relative after:absolute after:size-3 after:bg-primary-500 after:rounded-full after:top-1/2 after:left-1/2 after:-translate-x-1/2 after:-translate-y-1/2 after:opacity-0 peer-checked:after:opacity-100 peer-checked:border-primary-500 cursor-pointer"></span>
            <span class="text-tagline-2 text-secondary font-medium select-none dark:text-accent">Remember me</span>
          </label>
          <a href="{{ url('/contact') }}#contact-form" class="text-tagline-2 text-secondary font-medium underline dark:text-accent">Forgot password?</a>
        </div>
        <div class="mt-8">
          <button type="submit" id="pd-login-submit" class="btn btn-md btn-primary hover:btn-secondary dark:hover:btn-accent w-full before:content-none first-letter:uppercase">
            <span>Log In</span>
          </button>
        </div>
      </form>
      <div>
        <p class="text-center text-tagline-2 text-secondary font-normal flex flex-wrap items-center justify-center gap-1 dark:text-accent">
          Not registered yet?
          <a href="{{ url('/contact') }}#contact-form" class="text-tagline-1 font-medium footer-link-v2">Join us</a>
        </p>
        <p class="mt-8 text-center text-tagline-3 text-secondary/60 dark:text-accent/60">
          Want partner access?
          <a href="{{ url('/contact') }}#contact-form" class="text-primary-500 underline">Become a Partner</a>
        </p>
      </div>
    </div>
  </div>
</section>

</main>
@endsection

@push('scripts')
<script src="{{ asset('marketing/assets/login-form.js') }}"></script>
@endpush
