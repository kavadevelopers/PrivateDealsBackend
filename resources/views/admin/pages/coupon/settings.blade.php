<x-default-layout>
    @section('title') {{ getPageTitle() }} @endsection

    @section('breadcrumbs')
    {{-- {{ Breadcrumbs::render('coupon.settings') }} --}}
    @endsection

    <div class="d-flex flex-column">
        <form class="form" method="POST" action="{{ route('admin.coupon.settings.save') }}">
            @csrf
            <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                <div class="d-flex flex-column gap-7 gap-lg-10">

                    <div class="card card-flush py-4">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Coupon Settings</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0">

                            @if(session('success'))
                            <div class="alert alert-success mb-5">{{ session('success') }}</div>
                            @endif

                            <p class="text-muted mb-7">
                                Configure which coupon is automatically assigned for each event.
                                Leave blank / select <strong>"No Discount"</strong> to disable coupon for that event.
                            </p>

                            {{-- 1. Referrer --}}
                            <div class="d-flex flex-wrap gap-5 mb-7">
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="form-label fw-bold">
                                        Referrer Coupon
                                        <span class="text-muted fw-normal ms-2 fs-7">
                                            — Given to the investor who referred a new user
                                        </span>
                                    </label>
                                    <select class="form-select" name="coupon_referrer_coupon_id">
                                        <option value="">No Discount</option>
                                        @foreach($coupons as $coupon)
                                        <option value="{{ $coupon->id }}" {{ $setting['referrer_coupon_id']==$coupon->id
                                            ? 'selected' : '' }}>
                                            {{ $coupon->code }}
                                            — {{ $coupon->type }}
                                            ({{ $coupon->discount_value }})
                                        </option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('coupon_referrer_coupon_id'))
                                    <div class="text-danger mt-1">{{ $errors->first('coupon_referrer_coupon_id') }}
                                    </div>
                                    @endif
                                </div>
                            </div>

                            {{-- 2. Referred --}}
                            <div class="d-flex flex-wrap gap-5 mb-7">
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="form-label fw-bold">
                                        Referred (New User) Coupon
                                        <span class="text-muted fw-normal ms-2 fs-7">
                                            — Given to the newly registered user who used a referral code
                                        </span>
                                    </label>
                                    <select class="form-select" name="coupon_referred_coupon_id">
                                        <option value="">No Discount</option>
                                        @foreach($coupons as $coupon)
                                        <option value="{{ $coupon->id }}" {{ $setting['referred_coupon_id']==$coupon->id
                                            ? 'selected' : '' }}>
                                            {{ $coupon->code }}
                                            — {{ $coupon->type }}
                                            ({{ $coupon->discount_value }})
                                        </option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('coupon_referred_coupon_id'))
                                    <div class="text-danger mt-1">{{ $errors->first('coupon_referred_coupon_id') }}
                                    </div>
                                    @endif
                                </div>
                            </div>

                            {{-- 3. KYC --}}
                            <div class="d-flex flex-wrap gap-5 mb-7">
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="form-label fw-bold">
                                        KYC Completion Coupon
                                        <span class="text-muted fw-normal ms-2 fs-7">
                                            — Given when a new investor completes KYC within 48 hours of registration
                                        </span>
                                    </label>
                                    <select class="form-select" name="coupon_kyc_coupon_id">
                                        <option value="">No Discount</option>
                                        @foreach($coupons as $coupon)
                                        <option value="{{ $coupon->id }}" {{ $setting['kyc_coupon_id']==$coupon->id ?
                                            'selected' : '' }}>
                                            {{ $coupon->code }}
                                            — {{ $coupon->type }}
                                            ({{ $coupon->discount_value }})
                                        </option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('coupon_kyc_coupon_id'))
                                    <div class="text-danger mt-1">{{ $errors->first('coupon_kyc_coupon_id') }}</div>
                                    @endif
                                </div>
                            </div>

                            {{-- 4. New User --}}
                            <div class="d-flex flex-wrap gap-5 mb-7">
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="form-label fw-bold">
                                        New User Registration Coupon
                                        <span class="text-muted fw-normal ms-2 fs-7">
                                            — Given to every new investor upon registration (no referral required)
                                        </span>
                                    </label>
                                    <select class="form-select" name="coupon_new_user_coupon_id">
                                        <option value="">No Discount</option>
                                        @foreach($coupons as $coupon)
                                        <option value="{{ $coupon->id }}" {{ $setting['new_user_coupon_id']==$coupon->id
                                            ? 'selected' : '' }}>
                                            {{ $coupon->code }}
                                            — {{ $coupon->type }}
                                            ({{ $coupon->discount_value }})
                                        </option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('coupon_new_user_coupon_id'))
                                    <div class="text-danger mt-1">{{ $errors->first('coupon_new_user_coupon_id') }}
                                    </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.coupon.list') }}" class="btn btn-light me-5">Cancel</a>
                    <button type="submit" class="btn btn-success">
                        <span class="indicator-label">Save Changes</span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-default-layout>