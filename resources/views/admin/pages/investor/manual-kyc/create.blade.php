<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('investor.create') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row">
        <div class="w-100 flex-lg-row-auto w-lg-1200px mb-7 me-7 me-lg-10">
            <form class="form" method="POST" action="{{ route('admin.investor.manual-kyc.save') }}"
                enctype="multipart/form-data">
                <input type="hidden" name="uuid" value="{{ $item->uuid }}">
                @csrf
                <div class="card card-flush py-4 mb-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Documents</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Aadhar Front Image</label>
                                <input name="aadhar_front" class="form-control mb-2 input" tabindex="0" type="file"
                                    onchange="fileExAllowedWithSize(this,'.png,.jpg,.jpeg,.PNG,.JPG,.JPEG','{{ CommonHelper::appSettings('file_image_max_size') }}')">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'aadhar_front',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Aadhar Back Image</label>
                                <input name="aadhar_back" class="form-control mb-2 input" tabindex="0" type="file"
                                    onchange="fileExAllowedWithSize(this,'.png,.jpg,.jpeg,.PNG,.JPG,.JPEG','{{ CommonHelper::appSettings('file_image_max_size') }}')">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'aadhar_back',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Pancard Image</label>
                                <input name="pan_card" class="form-control mb-2 input" tabindex="0" type="file"
                                    onchange="fileExAllowedWithSize(this,'.png,.jpg,.jpeg,.PNG,.JPG,.JPEG','{{ CommonHelper::appSettings('file_image_max_size') }}')">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'pan_card',
                                ])
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Cheque Image</label>
                                <input name="cheque" class="form-control mb-2 input" tabindex="0" type="file"
                                    onchange="fileExAllowedWithSize(this,'.png,.jpg,.jpeg,.PNG,.JPG,.JPEG','{{ CommonHelper::appSettings('file_image_max_size') }}')">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'cheque',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">CML/CMR Image</label>
                                <input name="cml" class="form-control mb-2 input" tabindex="0" type="file"
                                    onchange="fileExAllowedWithSize(this,'.png,.jpg,.jpeg,.PNG,.JPG,.JPEG','{{ CommonHelper::appSettings('file_image_max_size') }}')">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'cml',
                                ])
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-flush py-4 mb-5">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>KYC Details</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Aadhar Number</label>
                                <input name="aadhar_number" class="form-control mb-2 input input-number"
                                    placeholder="Enter Aadhar Number" tabindex="0" type="text"
                                    value="{{ old('aadhar_number') }}">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'aadhar_number',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Name as Aadhar</label>
                                <input name="name_as_aadhar" class="form-control mb-2 input"
                                    placeholder="Enter Name as Aadhar" tabindex="0" type="text"
                                    value="{{ old('name_as_aadhar') }}">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'name_as_aadhar',
                                ])
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">PAN Number</label>
                                <input name="pan_number" class="form-control mb-2 input" placeholder="Enter PAN Number"
                                    tabindex="0" type="text" value="{{ old('pan_number') }}">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'pan_number',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Name PAN</label>
                                <input name="name_as_pan" class="form-control mb-2 input" placeholder="Enter Name PAN"
                                    tabindex="0" type="text" value="{{ old('name_as_pan') }}">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'name_as_pan',
                                ])
                            </div>
                        </div>
                        @livewire('country-city-dropdown', [
                            'selectedCountry' => old('country_id'),
                            'selectedState' => old('state_id'),
                            'selectedCity' => old('city_id'),
                        ])
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Pincode</label>
                                <input name="pincode" class="form-control mb-2 input" placeholder="Enter Pincode"
                                    tabindex="0" type="text" value="{{ old('pincode') }}">
                                @include('admin.partials.form.input-error-message', ['key' => 'pincode'])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Street Address</label>
                                <textarea name="address" class="form-control mb-2 input " placeholder="Enter Address" tabindex="0" type="text">{{ old('address') }}</textarea>
                                @include('admin.partials.form.input-error-message', ['key' => 'address'])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Date of Birth</label>
                                <input name="date_of_birth" class="form-control mb-2 input flat-datepicker"
                                    placeholder="Enter Date of Birth" tabindex="0" type="text"
                                    value="{{ old('date_of_birth') }}">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'date_of_birth',
                                ])
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">DP ID</label>
                                <input name="dp_id" class="form-control mb-2 input" placeholder="Enter DP ID"
                                    tabindex="0" type="text" value="{{ old('dp_id') }}">
                                @include('admin.partials.form.input-error-message', ['key' => 'dp_id'])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Client ID</label>
                                <input name="client_id" class="form-control mb-2 input" placeholder="Enter Client ID"
                                    tabindex="0" type="text" value="{{ old('client_id') }}">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'client_id',
                                ])
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Demat Account</label>
                                <input name="demat_account" class="form-control mb-2 input"
                                    placeholder="Enter Demat Account" tabindex="0" type="text"
                                    value="{{ old('demat_account') }}">
                                @include('admin.partials.form.input-error-message', [
                                    'key' => 'demat_account',
                                ])
                            </div>
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
