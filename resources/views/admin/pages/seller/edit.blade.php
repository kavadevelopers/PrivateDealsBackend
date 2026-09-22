<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('preiposeller.create') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row">
        @if (isset($item))
            <div class="w-100 flex-lg-row-auto w-lg-1200px mb-7 me-7 me-lg-10">
                <form class="form" method="POST"
                    action="{{ route('admin.preiposeller.update', ['uuid' => $item->uuid]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card card-flush py-4 mb-5">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Seller</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="d-flex flex-wrap gap-10 mb-5">
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="form-label">Logo</label>
                                    <input name="logo" class="form-control mb-2 input" tabindex="0" type="file"
                                        onchange="fileExAllowedWithSize(this,'{{ CommonHelper::appSettings('file_image_extensions_allowed') }}','{{ CommonHelper::appSettings('file_image_max_size') }}')">
                                    @include('admin.partials.form.input-error-message', [
                                        'key' => 'logo',
                                    ])
                                    @if ($item->logo && $item->logo != null && $item->logo != '')
                                        <p><a
                                                href="{{ route('download.web', ['path' => $item->logo, 'name' => 'Logo of ' . $item->company_name]) }}">Download</a>
                                        </p>
                                    @endif
                                </div>
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="required form-label">CIN</label>
                                    <input placeholder="Enter CIN" name="cin" value="{{ old('cin', $item->cin) }}"
                                        class="form-control mb-2 input" tabindex="0" type="text">
                                    @include('admin.partials.form.input-error-message', [
                                        'key' => 'cin',
                                    ])
                                </div>
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="required form-label">PAN</label>
                                    <input placeholder="Enter PAN" name="pan" value="{{ old('pan', $item->pan) }}"
                                        class="form-control mb-2 input" tabindex="0" type="text">
                                    @include('admin.partials.form.input-error-message', [
                                        'key' => 'pan',
                                    ])
                                </div>
                            </div>
                            <div class="d-flex flex-wrap gap-10 mb-5">
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="required form-label">Company Name</label>
                                    <input placeholder="Enter Company" name="company_name"
                                        value="{{ old('company_name', $item->company_name) }}"
                                        class="form-control mb-2 input" tabindex="0" type="text">
                                    @include('admin.partials.form.input-error-message', [
                                        'key' => 'company_name',
                                    ])
                                </div>
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="required form-label">Address</label>
                                    <textarea placeholder="Enter Address" name="address" value="" class="form-control mb-2 input" tabindex="0"
                                        type="text">{{ old('address', $item->address) }}</textarea>
                                    @include('admin.partials.form.input-error-message', [
                                        'key' => 'address',
                                    ])
                                </div>
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="required form-label">DP ID</label>
                                    <textarea placeholder="Enter DP ID" name="dp_id" value="" class="form-control mb-2 input" tabindex="0"
                                        type="text">{{ old('dp_id', $item->dp_id) }}</textarea>
                                    @include('admin.partials.form.input-error-message', [
                                        'key' => 'dp_id',
                                    ])
                                </div>
                            </div>
                            <div class="d-flex flex-wrap gap-10 mb-5">
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="required form-label">Client ID</label>
                                    <textarea placeholder="Enter Client ID" name="client_id" value="" class="form-control mb-2 input" tabindex="0"
                                        type="text">{{ old('client_id', $item->client_id) }}</textarea>
                                    @include('admin.partials.form.input-error-message', [
                                        'key' => 'client_id',
                                    ])
                                </div>
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="required form-label">Bank Name</label>
                                    <textarea placeholder="Enter Bank Name" name="bank_name" value="" class="form-control mb-2 input" tabindex="0"
                                        type="text">{{ old('bank_name', $item->bank_name) }}</textarea>
                                    @include('admin.partials.form.input-error-message', [
                                        'key' => 'bank_name',
                                    ])
                                </div>
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="required form-label">Account Number</label>
                                    <textarea placeholder="Enter Account Number" name="account_number" value="" class="form-control mb-2 input"
                                        tabindex="0" type="text">{{ old('account_number', $item->account_number) }}</textarea>
                                    @include('admin.partials.form.input-error-message', [
                                        'key' => 'account_number',
                                    ])
                                </div>
                            </div>
                            <div class="d-flex flex-wrap gap-10 mb-5">
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="required form-label">IFSC</label>
                                    <textarea placeholder="Enter IFSC" name="ifsc" value="" class="form-control mb-2 input" tabindex="0"
                                        type="text">{{ old('ifsc', $item->ifsc) }}</textarea>
                                    @include('admin.partials.form.input-error-message', [
                                        'key' => 'ifsc',
                                    ])
                                </div>
                                <div class="fv-row fv-plugins-icon-container w-100 flex-md-root">
                                    <label class="required form-label">Branch</label>
                                    <textarea placeholder="Enter Branch" name="branch" value="" class="form-control mb-2 input" tabindex="0"
                                        type="text">{{ old('branch', $item->branch) }}</textarea>
                                    @include('admin.partials.form.input-error-message', [
                                        'key' => 'branch',
                                    ])
                                </div>
                            </div>
                            <div class="separator separator-dashed my-5"></div>
                            <h3 class="mb-5">Login credentials (API)</h3>
                            <div class="d-flex flex-wrap gap-10 mb-5">
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="form-label">Mobile country code</label>
                                    <input placeholder="91" name="mobile_country_code"
                                        value="{{ old('mobile_country_code', $item->mobile_country_code ?: '91') }}"
                                        class="form-control mb-2 input" tabindex="0" type="text">
                                    @include('admin.partials.form.input-error-message', [
                                        'key' => 'mobile_country_code',
                                    ])
                                </div>
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="form-label">Mobile number</label>
                                    <input placeholder="10-digit mobile" name="mobile_number"
                                        value="{{ old('mobile_number', $item->mobile_number) }}"
                                        class="form-control mb-2 input" tabindex="0" type="text">
                                    @include('admin.partials.form.input-error-message', [
                                        'key' => 'mobile_number',
                                    ])
                                </div>
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="form-label">Email</label>
                                    <input placeholder="Enter Email" name="email"
                                        value="{{ old('email', $item->email) }}" class="form-control mb-2 input"
                                        tabindex="0" type="email">
                                    @include('admin.partials.form.input-error-message', [
                                        'key' => 'email',
                                    ])
                                </div>
                            </div>
                            <div class="d-flex flex-wrap gap-10 mb-5">
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="form-label">Password</label>
                                    <input placeholder="Leave blank to keep current" name="password" value=""
                                        class="form-control mb-2 input" tabindex="0" type="password"
                                        autocomplete="new-password">
                                    @include('admin.partials.form.input-error-message', [
                                        'key' => 'password',
                                    ])
                                </div>
                                <div class="fv-row w-100 flex-md-root d-flex align-items-end">
                                    <div class="form-check form-switch form-check-custom form-check-solid mb-2">
                                        <input class="form-check-input" type="checkbox" name="is_blocked" value="1"
                                            id="is_blocked"
                                            {{ old('is_blocked', $item->is_blocked) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_blocked">Blocked</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-flush py-4 mb-5">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Permissions</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="d-flex flex-wrap column-gap-10">
                                <label class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1"
                                        name="is_primary_access"
                                        {{ old('is_primary_access', $item->is_primary_access) ? 'checked' : '' }} />
                                    <span class="form-check-label">Primary Startup</span>
                                </label>
                                <label class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1"
                                        name="is_secondary_access"
                                        {{ old('is_secondary_access', $item->is_secondary_access) ? 'checked' : '' }} />
                                    <span class="form-check-label">Secondary Startup</span>
                                </label>
                                <label class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1"
                                        name="is_preipo_access"
                                        {{ old('is_preipo_access', $item->is_preipo_access) ? 'checked' : '' }} />
                                    <span class="form-check-label">Pre-IPO Companies</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('admin.company.list') }}" class="btn btn-light me-3">Cancel</a>
                        <button type="submit" id="kt_ecommerce_edit_order_submit" class="btn btn-primary">
                            <span class="indicator-label">Save</span>
                            <span class="indicator-progress">
                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>

</x-default-layout>
