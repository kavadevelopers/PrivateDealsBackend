<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('startup.manage') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row">
        <div class="w-100 flex-lg-row-auto w-lg-1200px mb-7 me-7 me-lg-10">
            <form class="form" method="POST" action="{{ route('admin.startup.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card card-flush py-4 mb-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Basic Details</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Brand Name</label>
                                <input name="brand_name" class="form-control mb-2 input" placeholder="Enter Brand Name"
                                    tabindex="0" type="text" value="{{ old('brand_name') }}">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'brand_name',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Mobile Number</label>
                                <input name="mobile_number" class="form-control mb-2 input input-number"
                                    placeholder="Enter Mobile Number" tabindex="0" type="text"
                                    value="{{ old('mobile_number') }}">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'mobile_number',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Email</label>
                                <input name="email" class="form-control mb-2 input" placeholder="Enter Email"
                                    tabindex="0" type="text" value="{{ old('email') }}">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'email',
                                ])
                            </div>
                        </div>
                        @livewire('industry-sector-dropdown', [
                            'selectedIndustry' => old('industry_id'),
                            'selectedSector' => old('sector_id'),
                        ])
                        @livewire('country-city-dropdown', [
                            'selectedCountry' => old('country_id'),
                            'selectedState' => old('state_id'),
                            'selectedCity' => old('city_id'),
                        ])
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Registered Address</label>
                                <textarea name="address" class="form-control mb-2" placeholder="Enter Registered Address" tabindex="0" type="text"
                                    value="">{{ old('address') }}</textarea>
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'address',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Pincode</label>
                                <input name="pincode" class="form-control mb-2 input" placeholder="Enter Pincode"
                                    tabindex="0" type="text" value="{{ old('pincode') }}">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'pincode',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Indicative Valuation</label>
                                <input name="indicative_valuation"
                                    class="form-control mb-2 input  input-decimal-number input-number-words"
                                    placeholder="Enter Indicative Valuation" tabindex="0" type="text"
                                    value="{{ old('indicative_valuation') }}">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'indicative_valuation',
                                ])
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row fv-plugins-icon-container col-12 col-md-6 col-lg-4">
                                <label class="form-label">Background Color Code</label>
                                <input name="bg_color_code"
                                    class="form-control mb-2 input"
                                    placeholder="Enter Background Color Code" tabindex="0" type="text"
                                    value="{{ old('bg_color_code') }}">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'bg_color_code',
                                ])
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-flush py-4 mb-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Legal Details</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Company Name (Legal name)</label>
                                <input name="company_name" class="form-control mb-2 input"
                                    placeholder="Enter Company Name (Legal name)" tabindex="0" type="text"
                                    value="{{ old('company_name') }}">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'company_name',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">CIN Number</label>
                                <input name="cin_number" class="form-control mb-2 input" placeholder="Enter CIN Number"
                                    tabindex="0" type="text" value="{{ old('cin_number') }}">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'cin_number',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">PAN Number</label>
                                <input name="pan_number" class="form-control mb-2 input" placeholder="Enter PAN Number"
                                    tabindex="0" type="text" value="{{ old('pan_number') }}">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'pan_number',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Incorporation Date</label>
                                <input name="incorporation_date" class="form-control mb-2 input flat-datepicker"
                                    placeholder="Enter Incorporation Date" tabindex="0" type="text"
                                    value="{{ old('incorporation_date') }}">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'incorporation_date',
                                ])
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-flush py-4 mb-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>CMS Content</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">One Liner</label>
                                <input name="one_liner" class="form-control mb-2 input" placeholder="Enter One Liner"
                                    tabindex="0" type="text" value="{{ old('one_liner') }}">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'one_liner',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Website</label>
                                <input name="website" class="form-control mb-2 input" placeholder="Enter Website"
                                    tabindex="0" type="text" value="{{ old('website') }}">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'website',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Highlights</label>
                                <textarea name="highlights" class="form-control mb-2 input" placeholder="Enter Highlights" tabindex="0"
                                    type="text" value="">{{ old('highlights') }}</textarea>
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'highlights',
                                ])
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-flush py-4 mb-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Idea</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="fv-row w-100 flex-md-root">
                            <textarea id="idea" name="idea" class="form-control mb-2 input kt_docs_tinymce_basic"
                                placeholder="Enter Idea" tabindex="0">{{ old('idea') }}</textarea>
                            @include('admin.partials.form.input-error-message', [
                                'key' => 'idea',
                            ])
                        </div>
                    </div>
                </div>

                <div class="card card-flush py-4 mb-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Key Information</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="fv-row w-100 flex-md-root">
                            <textarea id="key_information" name="key_information" class="form-control mb-2 input kt_docs_tinymce_basic"
                                placeholder="Enter Key Information" tabindex="0">{{ old('key_information') }}</textarea>
                            @include('admin.partials.form.input-error-message', [
                                'key' => 'key_information',
                            ])
                        </div>
                    </div>
                </div>

                <div class="card card-flush py-4 mb-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Social Media</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        @foreach (\App\Models\MasterSocialmediaLinkModel::where('is_deleted',0)->get() as $soKey => $soItem)
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            
                            <div class="fv-row w-100 flex-md-root">
                                <input type="hidden" name="social_media_id[]" value="{{ $soItem->id }}" class="form-control mb-2 input"/>
                                <label class="form-label">{{ $soItem->name }} Link</label>
                                <input name="social_media_link[{{ $soItem->id }}]" class="form-control mb-2 input"
                                    placeholder="Enter {{ $soItem->name }} Link"
                                    tabindex="0" type="text" value="{{ old('social_media_link.' . $soItem->id) }}">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'social_media_link.' . $soItem->id,
                                ])
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.startup.list') }}" class="btn btn-light me-3">Cancel</a>
                    <button type="submit" id="kt_ecommerce_edit_order_submit" class="btn btn-primary">
                        <span class="indicator-label">Save</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-default-layout>
