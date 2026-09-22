<x-default-layout>
    @section('title')
    {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('coupon.list') }}
    @endsection

    @if ($errors->any())
    <div class="alert alert-danger mb-5">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="d-flex flex-column flex-lg-row">
        <div class="w-100 flex-lg-row-auto w-lg-1200px mb-7 me-7 me-lg-10">
            <form class="form" method="POST" action="{{ route('admin.coupon.update', ['uuid' => $coupon->uuid]) }}"
                id="couponForm">
                @csrf
                @method('PUT')
                <div class="card card-flush py-4 mb-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Edit Coupon</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Coupon Code</label>
                                <input name="code" class="form-control mb-2 input" placeholder="Enter Coupon Code"
                                    type="text" value="{{ old('code', $coupon->code) }}"
                                    style="text-transform: uppercase;">
                                @include('admin.partials.form.input-error-message', ['key' => 'code'])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Type</label>
                                <select class="form-select" name="type" id="coupon_type" required>
                                    <option value="">-- Select Type --</option>
                                    @foreach (App\Enums\CouponTypeEnum::cases() as $type)
                                    @if($type === \App\Enums\CouponTypeEnum::grabopportunity)
                                    <option value="{{ $type->value }}" {{ old('type', $coupon->type ?? null) ===
                                        $type->value ? 'selected' : '' }}>
                                        {{ $type->value }}
                                    </option>
                                    @endif
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', ['key' => 'type'])
                            </div>
                            <div class="fv-row w-100 flex-md-root" id="discount_value_row">
                                <label class="required form-label">Discount Value</label>
                                <input name="discount_value" class="form-control mb-2 input"
                                    placeholder="Enter Discount Value" type="number" step="0.01" min="0"
                                    value="{{ old('discount_value', $coupon->discount_value) }}" id="discount_value">
                                <small class="text-muted" id="discount_hint"></small>
                                @include('admin.partials.form.input-error-message', ['key' => 'discount_value'])
                            </div>
                            <div class="fv-row w-100 flex-md-root" id="max_discount_container" style="display: none;">
                                <label class="form-label">Max Discount Amount (₹)</label>
                                <input name="max_discount_amount" class="form-control mb-2 input"
                                    placeholder="Enter Max Discount Amount" type="number" step="0.01" min="0"
                                    value="{{ old('max_discount_amount', $coupon->max_discount_amount) }}">
                                @include('admin.partials.form.input-error-message', ['key' => 'max_discount_amount'])
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Applies On</label>
                                <select class="form-select" name="applies_on" required>
                                    <option value="">-- Select --</option>
                                    <option value="all" {{ old('applies_on', $coupon->applies_on) == 'all' ? 'selected'
                                        : '' }}>All Transactions</option>
                                    <option value="primary" {{ old('applies_on', $coupon->applies_on) == 'primary' ?
                                        'selected' : '' }}>Primary</option>
                                    <option value="secondary" {{ old('applies_on', $coupon->applies_on) == 'secondary' ?
                                        'selected' : '' }}>Secondary</option>
                                    <option value="pre_ipo" {{ old('applies_on', $coupon->applies_on) == 'pre_ipo' ?
                                        'selected' : '' }}>Pre-IPO</option>
                                </select>
                                @include('admin.partials.form.input-error-message', ['key' => 'applies_on'])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Company Scope</label>
                                <select class="form-select" name="company_scope" id="company_scope" required>
                                    @php
                                    $currentScope = \App\Enums\CouponCompanyScopeEnum::all->value; // 'All'
                                    if ($coupon->company_id) {
                                    $currentScope = \App\Enums\CouponCompanyScopeEnum::single->value; // 'Single'
                                    } elseif ($coupon->companies->count() > 0) {
                                    $currentScope = \App\Enums\CouponCompanyScopeEnum::multiple->value; // 'Multiple'
                                    }
                                    @endphp
                                    <option value="">-- Select Scope --</option>
                                    @foreach (App\Enums\CouponCompanyScopeEnum::cases() as $scope)
                                    @if($scope !== \App\Enums\CouponCompanyScopeEnum::single)
                                    <option value="{{ $scope->value }}" {{ old('company_scope',
                                        $currentScope)===$scope->value ? 'selected' : '' }}>
                                        {{ $scope->value }}
                                    </option>
                                    @endif
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', ['key' => 'company_scope'])
                            </div>
                            <div class="fv-row w-100 flex-md-root" id="single_company_container" style="display: none;">
                                <label class="form-label">Select Company</label>
                                <select class="form-select" name="company_id" id="company_id">
                                    <option value="">-- Select Company --</option>
                                    @foreach ($companies as $company)
                                    <option value="{{ $company->id }}" {{ old('company_id', $coupon->company_id) ==
                                        $company->id ? 'selected' : '' }}>
                                        {{ $company->brand_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', ['key' => 'company_id'])
                            </div>
                            <div class="fv-row w-100" id="multiple_company_container" style="display: none;">
                                <label class="form-label">Select Companies</label>
                                <div class="card mb-5 mb-xl-8">
                                    <div class="card-header border-0 pt-3 pb-3">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label fw-bold fs-6 mb-1">Companies</span>
                                        </h3>
                                        <div class="card-toolbar">
                                            <input type="text" id="company_search"
                                                class="form-control form-control-sm w-200px"
                                                placeholder="Search company...">
                                        </div>
                                    </div>
                                    <div class="card-body py-3" style="height: 300px; overflow-y: scroll;">
                                        <div class="table-responsive">
                                            <table
                                                class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-3"
                                                id="companies-table">
                                                <thead>
                                                    <tr class="fw-bold text-muted">
                                                        <th class="w-25px">
                                                            <div
                                                                class="form-check form-check-sm form-check-custom form-check-solid">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="checkAllCompanies">
                                                            </div>
                                                        </th>
                                                        <th class="min-w-200px">Company Name</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($companies as $company)
                                                    <tr>
                                                        <td>
                                                            <div
                                                                class="form-check form-check-sm form-check-custom form-check-solid">
                                                                <input class="form-check-input company-checkbox"
                                                                    type="checkbox" name="company_ids[]"
                                                                    value="{{ $company->id }}" {{ in_array($company->id,
                                                                old('company_ids', $selectedCompanyIds)) ? 'checked' :
                                                                '' }}
                                                                >
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="text-gray-900 fw-bold text-hover-primary fs-6">{{
                                                                $company->brand_name }}</span>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr id="companies-no-data" style="display: none;">
                                                        <td colspan="2" class="text-center text-muted fst-italic py-5">
                                                            No companies found
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @include('admin.partials.form.input-error-message', ['key' => 'company_ids'])
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3"
                                    placeholder="Enter coupon description">{{ old('description', $coupon->description) }}</textarea>
                                @include('admin.partials.form.input-error-message', ['key' => 'description'])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="form-label">Terms & Conditions</label>
                                <textarea name="terms_conditions" class="form-control mb-2 input kt_docs_tinymce_basic"
                                    placeholder="Enter terms and conditions">{{ old('terms_conditions', $coupon->terms_conditions) }}</textarea>
                                @include('admin.partials.form.input-error-message', ['key' => 'terms_conditions'])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="form-label">Minimum Investment Amount (₹)</label>
                                <input name="min_investment_amount" class="form-control mb-2 input"
                                    placeholder="Enter Minimum Investment Amount" type="number" step="0.01" min="0"
                                    value="{{ old('min_investment_amount', $coupon->min_investment_amount) }}">
                                @include('admin.partials.form.input-error-message', ['key' => 'min_investment_amount'])
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="form-label">Usage Limit Per User</label>
                                <input name="usage_limit_per_user" class="form-control mb-2 input"
                                    placeholder="Leave empty for unlimited" type="number" min="1"
                                    value="{{ old('usage_limit_per_user', $coupon->usage_limit_per_user) }}">
                                @include('admin.partials.form.input-error-message', ['key' => 'usage_limit_per_user'])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="form-label">Global Usage Limit</label>
                                <input name="usage_limit_global" class="form-control mb-2 input"
                                    placeholder="Leave empty for unlimited" type="number" min="1"
                                    value="{{ old('usage_limit_global', $coupon->usage_limit_global) }}">
                                @include('admin.partials.form.input-error-message', ['key' => 'usage_limit_global'])
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Valid From</label>
                                <input name="valid_from" class="form-control mb-2 input" type="datetime-local"
                                    value="{{ old('valid_from', $coupon->valid_from?->format('Y-m-d\TH:i')) }}"
                                    required>
                                @include('admin.partials.form.input-error-message', ['key' => 'valid_from'])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Valid To</label>
                                <input name="valid_to" class="form-control mb-2 input" type="datetime-local"
                                    value="{{ old('valid_to', $coupon->valid_to?->format('Y-m-d\TH:i')) }}" required>
                                @include('admin.partials.form.input-error-message', ['key' => 'valid_to'])
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-10 mb-5">
                            {{-- <div class="fv-row w-100 flex-md-root">
                                <label class="form-label">Created Via</label>
                                <select class="form-select" name="created_via">
                                    <option value="manual" {{ old('created_via', $coupon->created_via) == 'manual' ?
                                        'selected' : '' }}>Manual</option>
                                    <option value="campaign" {{ old('created_via', $coupon->created_via) == 'campaign' ?
                                        'selected' : '' }}>Campaign</option>
                                    <option value="referral" {{ old('created_via', $coupon->created_via) == 'referral' ?
                                        'selected' : '' }}>Referral</option>
                                </select>
                                @include('admin.partials.form.input-error-message', ['key' => 'created_via'])
                            </div>
                            @php
                            $isReferral = old('created_via', $coupon->created_via) === 'referral';
                            @endphp

                            <div class="fv-row w-100 flex-md-root" id="referral_config_container"
                                style="{{ $isReferral ? '' : 'display:none;' }}">

                                <label class="form-label fw-bold">Referral Coupon Assignment</label>

                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="assign_to_referrer" value="1"
                                        id="assign_to_referrer" {{ old('assign_to_referrer', $coupon->assign_to_referrer
                                    ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="assign_to_referrer">
                                        Assign coupon to Referrer
                                    </label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="assign_to_referred" value="1"
                                        id="assign_to_referred" {{ old('assign_to_referred', $coupon->assign_to_referred
                                    ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="assign_to_referred">
                                        Assign coupon to Referred User
                                    </label>
                                </div>
                                <div class="d-flex flex-wrap gap-10 mt-4">

                                    <div class="fv-row w-100 flex-md-root">
                                        <label class="form-label">Referrer Reward Amount (₹)</label>
                                        <input type="number" name="referrer_reward_value"
                                            class="form-control mb-2 input" step="0.01" min="0"
                                            value="{{ old('referrer_reward_value', $coupon->referrer_reward_value) }}"
                                            placeholder="Enter reward for referrer">
                                        @include('admin.partials.form.input-error-message', ['key' =>
                                        'referrer_reward_value'])
                                    </div>

                                    <div class="fv-row w-100 flex-md-root">
                                        <label class="form-label">Referred User Reward Amount (₹)</label>
                                        <input type="number" name="referred_reward_value"
                                            class="form-control mb-2 input" step="0.01" min="0"
                                            value="{{ old('referred_reward_value', $coupon->referred_reward_value) }}"
                                            placeholder="Enter reward for referred user">
                                        @include('admin.partials.form.input-error-message', ['key' =>
                                        'referred_reward_value'])
                                    </div>
                                </div>
                            </div> --}}
                            <div class="fv-row w-100 flex-md-root">
                                <div class="form-check form-switch mt-8">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                        id="is_active" {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Active
                                    </label>
                                </div>
                                <div class="form-check form-switch mt-8">
                                    <input class="form-check-input" type="checkbox" name="is_private" value="1"
                                        id="is_private" {{ old('is_private', $coupon->is_private) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_private">
                                        Private
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <div class="form-check form-switch">
                                    @php
                                    $meta = is_array($coupon->meta) ? $coupon->meta : [];
                                    $firstTransactionOnly = old('first_transaction_only') !== null ?
                                    old('first_transaction_only') : (isset($meta['first_transaction_only']) &&
                                    $meta['first_transaction_only']);
                                    @endphp
                                    <input class="form-check-input" type="checkbox" name="first_transaction_only"
                                        value="1" id="first_transaction_only" {{ $firstTransactionOnly ? 'checked' : ''
                                        }}>
                                    <label class="form-check-label" for="first_transaction_only">
                                        First Transaction Only
                                    </label>
                                </div>
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <div class="form-check form-switch">
                                    @php
                                    $newUserOnly = old('new_user_only') !== null ? old('new_user_only') :
                                    (isset($meta['new_user_only']) && $meta['new_user_only']);
                                    @endphp
                                    <input class="form-check-input" type="checkbox" name="new_user_only" value="1"
                                        id="new_user_only" {{ $newUserOnly ? 'checked' : '' }}>
                                    <label class="form-check-label" for="new_user_only">
                                        New Users Only
                                    </label>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.coupon.list') }}" class="btn btn-light me-3">Cancel</a>
                    <button type="submit" id="kt_ecommerce_edit_order_submit" class="btn btn-primary">
                        <span class="indicator-label">Update</span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
        $('#company_scope').on('change', function() {
            var scope = $(this).val();
            if (scope === '{{ App\Enums\CouponCompanyScopeEnum::single->value }}') {
                $('#single_company_container').show();
                $('#multiple_company_container').hide();
                $('#company_id').prop('required', true);
                $('#company_ids').prop('required', false);
            } else if (scope === '{{ App\Enums\CouponCompanyScopeEnum::multiple->value }}') {
                $('#single_company_container').hide();
                $('#multiple_company_container').show();
                $('#company_id').prop('required', false);
                $('#company_ids').prop('required', true);
            } else {
                $('#single_company_container').hide();
                $('#multiple_company_container').hide();
                $('#company_id').prop('required', false);
                $('#company_ids').prop('required', false);
            }
        });
        $('#company_scope').trigger('change');

        $('#coupon_type').on('change', function() {
            var type = $(this).val();
            var hint = '';

            if (type === '{{ \App\Enums\CouponTypeEnum::grabopportunity->value }}') {
                $('#discount_value_row').hide();
                $('#discount_value').val(0);
            } else {
                $('#discount_value_row').show();
            }
            if (type === '{{ \App\Enums\CouponTypeEnum::percentagediscount->value }}') {
                $('#max_discount_container').show();
                hint = 'Enter percentage (e.g., 10 for 10%)';
            } else {
                $('#max_discount_container').hide();
                if (type === '{{ \App\Enums\CouponTypeEnum::flatdiscount->value }}') {
                    hint = 'Enter flat discount amount in ₹';
                } else if (type === '{{ \App\Enums\CouponTypeEnum::persharediscount->value }}') {
                    hint = 'Enter discount per share in ₹';
                } else if (type === '{{ \App\Enums\CouponTypeEnum::cashback->value }}') {
                    hint = 'Enter cashback amount in ₹';
                } else if (type === '{{ \App\Enums\CouponTypeEnum::grabopportunity->value }}') {
                    hint = 'No explicit discount value needed for Grab Opportunity. Entering 0 is fine.';
                }
            }
            $('#discount_hint').text(hint);
        });
        $('#coupon_type').trigger('change');

        $('input[name="code"]').on('input', function() {
            $(this).val($(this).val().toUpperCase());
        });

        $('select[name="created_via"]').on('change', function() {
            if ($(this).val() === 'referral') {
                $('#referral_config_container').show();
            } else {
                $('#referral_config_container').hide();
                $('#assign_to_referrer').prop('checked', false);
                $('#assign_to_referred').prop('checked', false);
            }
        });
        $('select[name="created_via"]').trigger('change');

        $('#checkAllCompanies').on('change', function() {
            const isChecked = $(this).prop('checked');
            $('#companies-table tbody tr:visible .company-checkbox').prop('checked', isChecked);
        });

        $(document).on('change', '.company-checkbox', function() {
            updateCompanyCheckAllState();
        });

        $('#company_search').on('input', function() {
            const query = $(this).val().toLowerCase();
            let visibleCount = 0;

            $('#companies-table tbody tr').not('#companies-no-data').each(function() {
                const name = $(this).find('td:last').text().toLowerCase();
                if (name.includes(query)) {
                    $(this).show();
                    visibleCount++;
                } else {
                    $(this).hide();
                }
            });

            $('#companies-no-data').toggle(visibleCount === 0);
            updateCompanyCheckAllState();
        });

        function updateCompanyCheckAllState() {
            const visibleCheckboxes = $('#companies-table tbody tr:visible .company-checkbox');
            const totalVisible = visibleCheckboxes.length;
            const checkedVisible = visibleCheckboxes.filter(':checked').length;

            if (totalVisible === 0 || checkedVisible === 0) {
                $('#checkAllCompanies').prop('checked', false).prop('indeterminate', false);
            } else if (checkedVisible === totalVisible) {
                $('#checkAllCompanies').prop('checked', true).prop('indeterminate', false);
            } else {
                $('#checkAllCompanies').prop('checked', false).prop('indeterminate', true);
            }
        }
        });
    </script>
    @endpush
</x-default-layout>