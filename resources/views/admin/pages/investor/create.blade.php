<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('investor.create') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row">
        <div class="w-100 flex-lg-row-auto w-lg-1200px mb-7 me-7 me-lg-10">
            <form class="form" method="POST" action="{{ route('admin.investor.store') }}" enctype="multipart/form-data">
                @csrf
                @if(isset($from_markasread) && $from_markasread)
                    <input type="hidden" name="from_markasread" value="1">
                @endif
                <div class="card card-flush py-4 mb-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Basic Details</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Types Of Investor</label>
                                <select class="form-select" name="investor_type" aria-label="Select Investor Type">
                                    <option value="">-- Select Investor Type --</option>
                                    @foreach (App\Enums\InvestorTypeEnum::cases() as $type)
                                        <option value="{{ $type->value }}"
                                            {{ old('investor_type') === $type->value ? 'selected' : '' }}>
                                            {{ ucfirst($type->value) }}
                                        </option>
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'investor_type',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Name</label>
                                <input name="name" class="form-control mb-2 input" placeholder="Enter Full Name"
                                    tabindex="0" type="text" value="{{ request('name', old('name')) }}">
                                @include('admin.partials.form.input-error-message', ['key' => 'name'])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Mobile Country Code</label>
                                <select class="form-select" data-control="select2" data-placeholder="Select Country Code"
                                    name="mobile_country_code" aria-label="Select example">
                                    <option value="">-- Select Country Code --</option>
                                    @foreach ($supposted_countries as $supposted_country)
                                        <option value="{{ $supposted_country->code}}"
                                            {{ request('mobile_country_code', old('mobile_country_code')) == $supposted_country->code ? 'selected' : '' }}>
                                            +{{ $supposted_country->code }} - {{ $supposted_country->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'mobile_country_code',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Mobile Number</label>
                                <input name="mobile_number" class="form-control mb-2 input"
                                    placeholder="Enter Mobile Number" tabindex="0" type="text"
                                    value="{{ request('mobile_number', old('mobile_number')) }}">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'mobile_number',
                                ])
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Password</label>
                                <input name="password" class="form-control mb-2" placeholder="Enter Password"
                                    tabindex="0" type="text" value="{{ old('password') }}">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'password',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Email</label>
                                <input name="email" class="form-control mb-2 input" placeholder="Enter Email"
                                    tabindex="0" type="text" value="{{ request('email', old('email')) }}">
                                @include('admin.partials.form.input-error-message', ['key' => 'email'])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="form-label">Gender</label>
                                <select class="form-select" name="gender" aria-label="Select example">
                                    <option value="">Select Gender</option>
                                    @foreach (App\Enums\GenderEnum::cases() as $gender)
                                        <option value="{{ $gender->value }}"
                                            {{ old('gender') == $gender->value ? 'selected' : '' }}>
                                            {{ $gender->value }}
                                        </option>
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', ['key' => 'gender'])
                            </div>
                        </div>
                        @livewire('country-city-dropdown', [
                            'selectedCountry' => old('country_id'),
                            'selectedState' => old('state_id'),
                            'selectedCity' => old('city_id'),
                            'isOptional' => true,
                        ])
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class=" form-label">Pincode</label>
                                <input name="pincode" class="form-control mb-2 input" placeholder="Enter Pincode"
                                    tabindex="0" type="text" value="{{ old('pincode') }}">
                                @include('admin.partials.form.input-error-message', ['key' => 'pincode'])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class=" form-label">Street Address</label>
                                <textarea name="address" class="form-control mb-2 input " placeholder="Enter Address" tabindex="0" type="text">{{ old('address') }}</textarea>
                                @include('admin.partials.form.input-error-message', ['key' => 'address'])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="form-label">Profile Photo (Optional)</label>
                                <input name="profile_photo" class="form-control mb-2 input" tabindex="0"
                                    type="file">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'profile_photo',
                                ])
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="form-label">Partner</label>
                                <select class="form-select" data-control="select2" data-placeholder="Select Partner" data-allow-clear="true"
                                     name="partner_id" aria-label="Select example">
                                     <option value=""></option>
                                     <option value="" {{ empty(old('partner_id')) ? 'selected' : '' }}>-- Select Partner --</option>
                                     @foreach ($partners as $partner)
                                         <option value="{{ $partner->id }}"
                                             {{ old('partner_id') == $partner->id ? 'selected' : '' }}>
                                             {{ $partner->name }}
                                         </option>
                                     @endforeach
                                 </select>
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'partner_id',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="form-label">Parent Investor</label>
                                <select class="form-select" data-control="select2"
                                    data-placeholder="Select Parent Investor" name="parent_investor_id"
                                    aria-label="Select example">
                                    <option value="">-- Select Investor --</option>
                                    @foreach ($investors as $investor)
                                        <option value="{{ $investor->id }}"
                                            {{ old('parent_investor_id') == $investor->id ? 'selected' : '' }}>
                                            {{ $investor->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'parent_investor_id',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="form-label">Parent Type</label>
                                <select class="form-select" data-control="select2"
                                    data-placeholder="Select Parent Type" name="parent_investor_type"
                                    aria-label="Select example">
                                    <option value="">-- Select Investor --</option>
                                    @foreach ($relations as $relation)
                                        <option value="{{ $relation->id }}"
                                            {{ old('parent_investor_type') == $relation->id ? 'selected' : '' }}>
                                            {{ $relation->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'parent_investor_type',
                                ])
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Permissions</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="d-flex flex-wrap column-gap-10">
                            <label class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1"
                                    name="is_primary_access" {{ old('is_primary_access') ? 'checked' : '' }} />
                                <span class="form-check-label">
                                    Primary Startup
                                </span>
                            </label>
                            <label class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1"
                                    name="is_secondary_access" {{ old('is_secondary_access') ? 'checked' : '' }} />
                                <span class="form-check-label">
                                    Secondary Startup
                                </span>
                            </label>
                            <label class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1"
                                    name="is_preipo_access" {{ old('is_preipo_access') ? 'checked' : '' }} />
                                <span class="form-check-label">
                                    Pre-IPO Companies
                                </span>
                            </label>
                            @include('admin.partials.form.input-error-message', ['key' => 'permission'])
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ url()->previous() }}" class="btn btn-light me-3">Cancel</a>
                    <button type="submit" id="kt_ecommerce_edit_order_submit" class="btn btn-primary">
                        <span class="indicator-label">Save</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-default-layout>
