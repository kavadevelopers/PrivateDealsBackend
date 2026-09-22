<x-auth-layout>

    <!--begin::Form-->
    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form"
        data-kt-redirect-url="{{ route('admin.dashboard') }}" action="{{ route('admin.login') }}">
        @csrf
        <!--begin::Heading-->
        <div class="text-center mb-11">
            <!--begin::Title-->
            <h1 class="text-gray-900 fw-bolder mb-3">
                Sign In
            </h1>
            <!--end::Title-->

            <!--begin::Subtitle-->
            {{-- <div class="text-gray-500 fw-semibold fs-6">
                Your Social Campaigns
            </div> --}}
            <!--end::Subtitle--->
        </div>
        <!--begin::Heading-->


        <!--begin::Separator-->
        <div class="separator separator-content my-14">
            <span class="w-125px text-gray-500 fw-semibold fs-7">Enter Username and Password</span>
        </div>
        <!--end::Separator-->

        <!--begin::Input group--->
        <div class="fv-row mb-8">
            <!--begin::Email-->
            <input type="text" placeholder="Username" name="username" autocomplete="off"
                class="form-control bg-transparent" value="" />
            <!--end::Email-->
        </div>

        <!--end::Input group--->
        <div class="fv-row mb-3">
            <!--begin::Password-->
            <input type="password" placeholder="Password" name="password" autocomplete="off"
                class="form-control bg-transparent" value="" />
            <!--end::Password-->
        </div>
        <!--end::Input group--->

        <!--begin::Wrapper-->
        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
            <div></div>

            <!--begin::Link-->
            {{-- <a href="{{ route('admin.password.request') }}" class="link-primary">
                Forgot Password ?
            </a> --}}
            <!--end::Link-->
        </div>
        <!--end::Wrapper-->

        <!--begin::Submit button-->
        <div class="d-grid mb-10">
            <input type="hidden" name="firebase_token" />
            <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                @include('admin/partials/general/_button-indicator', ['label' => 'Sign In'])
            </button>
        </div>
        <!--end::Submit button-->

        <!--begin::Sign up-->
        {{-- <div class="text-gray-500 text-center fw-semibold fs-6">
            Not a Member yet?
            <a href="{{ route('admin.register') }}" class="link-primary">
                Sign up
            </a>
        </div> --}}
        <!--end::Sign up-->
    </form>
    <!--end::Form-->

</x-auth-layout>
