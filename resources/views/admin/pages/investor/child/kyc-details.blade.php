{{-- <div class="card mb-5 mb-xl-10" id="kt_profile_details_view" id="pills-home">
    <div class="card-header cursor-pointer">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">KYC Details</h3>
        </div>
        <a href="{{ route('admin.investor.editKYCDetails', ['uuid' => $investor->uuid]) }}"
            class="btn btn-sm btn-primary align-self-center editKYCDetails">Edit
            KYC Details</a>
    </div>
    <div class="card-body p-9">

        @include('admin.pages.investor.child.kyc-data', [
            'investor' => $investor,
        ])
    </div>
</div>

<div class="modal fade" id="EditKYCModal" tabindex="-1" aria-labelledby="EditKYCModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <form id="kycForm" action="{{ route('admin.investor.updateKYCDetails') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="uuid" value="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditKYCModalLabel">Edit Investor KYC Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                                    <input name="aadhaar_front_image" class="form-control mb-2 input" tabindex="0"
                                        type="file"
                                        onchange="fileExAllowedWithSize(this,'.png,.jpg,.jpeg,.PNG,.JPG,.JPEG','{{ CommonHelper::appSettings('file_image_max_size') }}')">
                                    <div class="symbol symbol-50px me-5 mt-5">
                                        <img id="aadhaarFrontPreview" class="shimmer lazy"
                                            src="{{ asset('core/placeholders/square.png') }}" />
                                    </div>
                                    @include('admin.partials.form.input-error-message', [
                                        'key' => 'aadhaar_front_image',
                                    ])
                                </div>
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="required form-label">Aadhar Back Image</label>
                                    <input name="aadhaar_back_image" class="form-control mb-2 input" tabindex="0"
                                        type="file"
                                        onchange="fileExAllowedWithSize(this,'.png,.jpg,.jpeg,.PNG,.JPG,.JPEG','{{ CommonHelper::appSettings('file_image_max_size') }}')">
                                    <div class="symbol symbol-50px me-5 mt-5">
                                        <img id="aadhaarBackPreview" class="shimmer lazy"
                                            src="{{ asset('core/placeholders/square.png') }}" />
                                    </div>
                                    @include('admin.partials.form.input-error-message', [
                                        'key' => 'aadhaar_back_image',
                                    ])
                                </div>
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="required form-label">Pancard Image</label>
                                    <input name="pan_image" class="form-control mb-2 input" tabindex="0"
                                        type="file"
                                        onchange="fileExAllowedWithSize(this,'.png,.jpg,.jpeg,.PNG,.JPG,.JPEG','{{ CommonHelper::appSettings('file_image_max_size') }}')">
                                    <div class="symbol symbol-50px me-5 mt-5">
                                        <img id="panCardPreview" class="shimmer lazy"
                                            src="{{ asset('core/placeholders/square.png') }}" />
                                    </div>
                                    @include('admin.partials.form.input-error-message', [
                                        'key' => 'pan_image',
                                    ])
                                </div>
                            </div>
                            <div class="d-flex flex-wrap gap-10 mb-5">
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="required form-label">Cheque Image</label>
                                    <input name="cheque_image" class="form-control mb-2 input" tabindex="0"
                                        type="file"
                                        onchange="fileExAllowedWithSize(this,'.png,.jpg,.jpeg,.PNG,.JPG,.JPEG','{{ CommonHelper::appSettings('file_image_max_size') }}')">
                                    <div class="symbol symbol-50px me-5 mt-5">
                                        <img id="chequePreview" class="shimmer lazy"
                                            src="{{ asset('core/placeholders/square.png') }}" />
                                    </div>
                                    @include('admin.partials.form.input-error-message', [
                                        'key' => 'cheque_image',
                                    ])
                                </div>
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="required form-label">CML/CMR Image</label>
                                    <input name="cml_image" class="form-control mb-2 input" tabindex="0"
                                        type="file"
                                        onchange="fileExAllowedWithSize(this,'.png,.jpg,.jpeg,.PNG,.JPG,.JPEG','{{ CommonHelper::appSettings('file_image_max_size') }}')">
                                    <div class="symbol symbol-50px me-5 mt-5">
                                        <img id="cmlPreview" class="shimmer lazy"
                                            src="{{ asset('core/placeholders/square.png') }}" />
                                    </div>
                                    @include('admin.partials.form.input-error-message', [
                                        'key' => 'cml_image',
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
                                    <input name="aadhar_no" class="form-control mb-2 input input-number"
                                        placeholder="Enter Aadhar Number" tabindex="0" type="text"
                                        value="{{ old('aadhar_no', $investor->kyc->aadhar_no) }}">
                                    @include('admin.partials.form.input-error-message', [
                                        'key' => 'aadhar_no',
                                    ])
                                </div>
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="required form-label">Name as Aadhar</label>
                                    <input name="name_as_aadhar" class="form-control mb-2 input"
                                        placeholder="Enter Name as Aadhar" tabindex="0" type="text"
                                        value="{{ old('name_as_aadhar', $investor->kyc->name_as_aadhar) }}">
                                    @include('admin.partials.form.input-error-message', [
                                        'key' => 'name_as_aadhar',
                                    ])
                                </div>
                            </div>
                            <div class="d-flex flex-wrap gap-10 mb-5">
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="required form-label">PAN Number</label>
                                    <input name="pan_no" class="form-control mb-2 input"
                                        placeholder="Enter PAN Number" tabindex="0" type="text"
                                        value="{{ old('pan_no', $investor->kyc->pan_no) }}">
                                    @include('admin.partials.form.input-error-message', [
                                        'key' => 'pan_no',
                                    ])
                                </div>
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="required form-label">Name PAN</label>
                                    <input name="name_as_pan" class="form-control mb-2 input"
                                        placeholder="Enter Name PAN" tabindex="0" type="text"
                                        value="{{ old('name_as_pan', $investor->kyc->name_as_pan) }}">
                                    @include('admin.partials.form.input-error-message', [
                                        'key' => 'name_as_pan',
                                    ])
                                </div>
                            </div>
                            @livewire('country-city-dropdown', [
                                'selectedCountry' => old('country_id', $investor->country_id),
                                'selectedState' => old('state_id', $investor->state_id),
                                'selectedCity' => old('city_id', $investor->city_id),
                            ])
                            <div class="d-flex flex-wrap gap-10 mb-5">
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="required form-label">Pincode</label>
                                    <input name="pincode" class="form-control mb-2 input" placeholder="Enter Pincode"
                                        tabindex="0" type="text"
                                        value="{{ old('pincode', $investor->pincode) }}">
                                    @include('admin.partials.form.input-error-message', [
                                        'key' => 'pincode',
                                    ])
                                </div>
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="required form-label">Street Address</label>
                                    <textarea name="address_as_aadhar" class="form-control mb-2 input " placeholder="Enter Address" tabindex="0"
                                        type="text">{{ old('address_as_aadhar', $investor->kyc->address_as_aadhar) }}</textarea>
                                    @include('admin.partials.form.input-error-message', [
                                        'key' => 'address_as_aadhar',
                                    ])
                                </div>
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="required form-label">Date of Birth</label>
                                    <input name="dob_as_aadhar" class="form-control mb-2 input flat-datepicker"
                                        placeholder="Enter Date of Birth" tabindex="0" type="text"
                                        value="{{ old('dob_as_aadhar', $investor->kyc->dob_as_aadhar) }}">
                                    @include('admin.partials.form.input-error-message', [
                                        'key' => 'dob_as_aadhar',
                                    ])
                                </div>
                            </div>
                            <div class="d-flex flex-wrap gap-10 mb-5">
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="required form-label">DP ID</label>
                                    <input name="dp_id" class="form-control mb-2 input" placeholder="Enter DP ID"
                                        tabindex="0" type="text"
                                        value="{{ old('dp_id', $investor->dematAccount->dp_id) }}">
                                    @include('admin.partials.form.input-error-message', [
                                        'key' => 'dp_id',
                                    ])
                                </div>
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="required form-label">Client ID</label>
                                    <input name="client_id" class="form-control mb-2 input"
                                        placeholder="Enter Client ID" tabindex="0" type="text"
                                        value="{{ old('client_id', $investor->dematAccount->client_id) }}">
                                    @include('admin.partials.form.input-error-message', [
                                        'key' => 'client_id',
                                    ])
                                </div>
                                <div class="fv-row w-100 flex-md-root">
                                    <label class="required form-label">Demat Account</label>
                                    <input name="demat_account" class="form-control mb-2 input"
                                        placeholder="Enter Demat Account" tabindex="0" type="text"
                                        value="{{ old('demat_account', $investor->dematAccount->demat_account) }}">
                                    @include('admin.partials.form.input-error-message', [
                                        'key' => 'demat_account',
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" name="submitform" class="btn btn-primary" value="Submit">
                    </div>
                </div>
            </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).on('click', '.editKYCDetails', function(event) {
            event.preventDefault();
            var url = $(this).attr('href');
            $.ajax({
                type: "GET",
                url: url,
                success: function(response) {
                    if (response.investor) {
                        $('#kycForm input[name="uuid"]').val(response.investor.uuid);
                        if (response.investor.kyc) {
                            $('#aadhaarFrontPreview').attr('src', response.kyc.aadhaar_front_image ||
                                '');
                            $('#aadhaarBackPreview').attr('src', response.kyc.aadhaar_back_image || '');
                            $('#panCardPreview').attr('src', response.kyc.pan_image || '');
                            $('#chequePreview').attr('src', response.kyc.cheque_image || '');
                            $('#cmlPreview').attr('src', response.kyc.cml_image || '');
                        }
                        $('#EditKYCModal').modal('show');
                    }
                },
                error: function(xhr) {
                    alert("Failed to fetch details. Please try again.");
                }
            });
        });

        $('#kycForm').on('submit', function(event) {
            event.preventDefault(); // Prevent form's default submission behavior
            showSpinningLoader(true);

            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: "{{ route('admin.investor.updateKYCDetails') }}", // Ensure this matches the Laravel route
                data: formData,
                contentType: false, // Required for FormData
                processData: false, // Required for FormData
                success: function(response) {
                    showSpinningLoader(false);
                    $('#EditKYCModal').modal('hide'); // Close the modal
                    $('.card-body.p-9').html(response.table);
                    showErrorMessage(response.message, "success");
                    // Optionally refresh or update the table
                },
                error: function(xhr) {
                    showSpinningLoader(false);
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        var firstError = Object.values(errors)[0][0];
                        showErrorMessage(firstError, "error");
                    } else {
                        showErrorMessage("An unexpected error occurred. Please try again.", "error");
                    }
                }
            });
        });
    </script>
@endpush --}}


{{-- <div class="card mb-5 mb-xl-10" id="kt_profile_details_view" id="pills-home">
    <div class="card-header cursor-pointer">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Bank Account Details</h3>
        </div>
        @if ($bankDetails->status == \App\Enums\Utills\StatusEnum::approved->value)
            <span class="badge badge-success fw-bold">Approved</span>
        @elseif ($bankDetails->status == \App\Enums\Utills\StatusEnum::rejected->value)
            <span class="badge badge-danger fw-bold">Rejected</span>
        @elseif ($bankDetails->status == \App\Enums\Utills\StatusEnum::pending->value)
            <form method="POST" action="{{ route('admin.manualkyc.updateBankStatus', $bankDetails->id) }}" style="display:inline-block;">
                @csrf
                <button type="submit" name="action" value="{{ \App\Enums\Utills\StatusEnum::approved->value }}" class="btn btn-sm btn-primary m-2">Approve</button>
                <button type="submit" name="action" value="{{ \App\Enums\Utills\StatusEnum::rejected->value }}" class="btn btn-sm btn-danger m-2">Reject</button>
            </form>
        @endif
        
    </div>
    <div class="card-body p-9">

        @include('admin.pages.investor.child.kyc-data', [
            'investor' => $investor,
            'bankDetails' => $bankDetails,
            'dematDetails' => $dematDetails
        ])
    </div>
</div> --}}


<div class="card mb-5 mb-xl-10" id="kt_profile_details_view" id="pills-home">
    <div class="card-header cursor-pointer">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Bank Account Details</h3>
        </div>
        @if ($bankDetails->status == \App\Enums\Utills\StatusEnum::approved->value)
            <span class="badge badge-success fw-bold">Approved</span>
        @elseif ($bankDetails->status == \App\Enums\Utills\StatusEnum::rejected->value)
            <span class="badge badge-danger fw-bold">Rejected</span>
        @elseif ($bankDetails->status == \App\Enums\Utills\StatusEnum::pending->value)
            <span class="badge badge-warning fw-bold">Pending</span>
        @endif
    </div>
    <div class="card-body p-9">
        {{-- @include('admin.pages.investor.child.kyc-data', [
            'investor' => $investor,
            'bankDetails' => $bankDetails,
            'dematDetails' => $dematDetails
        ]) --}}

        <form method="POST" action="{{ route('admin.manualkyc.updateBankStatus', $bankDetails->id) }}" id="bankDetailsForm">
            @csrf
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Bank Name</label>
                <div class="col-lg-8">
                    <input type="text" name="bank_name" class="form-control"
                           value="{{ old('bank_name', $bankDetails->bank->name ?? '') }}"
                           {{ $bankDetails->status != \App\Enums\Utills\StatusEnum::pending->value ? 'disabled' : '' }}>
                    @include('admin.partials.form.input-error-message', ['key' => 'bank_name'])
                </div>
            </div>
        
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Account Holder Name</label>
                <div class="col-lg-8">
                    <input type="text" name="account_holder_name" class="form-control"
                           value="{{ old('account_holder_name', $bankDetails->account_holder_name ?? '') }}"
                           {{ $bankDetails->status != \App\Enums\Utills\StatusEnum::pending->value ? 'disabled' : '' }}>
                    @include('admin.partials.form.input-error-message', ['key' => 'account_holder_name'])
                </div>
            </div>
        
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Account Number</label>
                <div class="col-lg-8">
                    <input type="text" name="account_number" class="form-control"
                           value="{{ old('account_number', $bankDetails->account_number ?? '') }}"
                           {{ $bankDetails->status != \App\Enums\Utills\StatusEnum::pending->value ? 'disabled' : '' }}>
                    @include('admin.partials.form.input-error-message', ['key' => 'account_number'])
                </div>
            </div>
        
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">IFSC Code</label>
                <div class="col-lg-8">
                    <input type="text" name="ifsc_code" class="form-control"
                           value="{{ old('ifsc_code', $bankDetails->ifsc_code ?? '') }}"
                           {{ $bankDetails->status != \App\Enums\Utills\StatusEnum::pending->value ? 'disabled' : '' }}>
                    @include('admin.partials.form.input-error-message', ['key' => 'ifsc_code'])
                </div>
            </div>
        
            @if ($bankDetails->status == \App\Enums\Utills\StatusEnum::pending->value)
                <div class="row mt-4">
                    <div class="col-lg-8 offset-lg-4">
                        <button type="submit" name="action" value="{{ \App\Enums\Utills\StatusEnum::approved->value }}" class="btn btn-sm btn-primary me-2">Approve</button>
                        <button type="submit" name="action" value="{{ \App\Enums\Utills\StatusEnum::rejected->value }}" class="btn btn-sm btn-danger">Reject</button>
                    </div>
                </div>
            @endif
        </form>
    </div>
</div>

<div class="card mb-5 mb-xl-10" id="kt_profile_details_view" id="pills-home">
    <div class="card-header cursor-pointer">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Demat Account Details</h3>
        </div>
        @if ($dematDetails->status == \App\Enums\Utills\StatusEnum::approved->value)
            <span class="badge badge-success fw-bold">Approved</span>
        @elseif ($dematDetails->status == \App\Enums\Utills\StatusEnum::rejected->value)
            <span class="badge badge-danger fw-bold">Rejected</span>
        @elseif ($dematDetails->status == \App\Enums\Utills\StatusEnum::pending->value)
            <span class="badge badge-warning fw-bold">Pending</span>
        @endif
    </div>
    <div class="card-body p-9">
        <form method="POST" action="{{ route('admin.manualkyc.updateDematStatus', $dematDetails->id) }}" id="dematDetailsForm" enctype="multipart/form-data">
            @csrf
    
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">DP ID</label>
                <div class="col-lg-8">
                    <input type="text" name="dp_id" class="form-control"
                           value="{{ old('dp_id', $dematDetails->dp_id ?? '') }}"
                           {{ $dematDetails->status != \App\Enums\Utills\StatusEnum::pending->value ? 'disabled' : '' }}>
                    @include('admin.partials.form.input-error-message', ['key' => 'dp_id'])
                    <div class="form-text">DP ID must be exactly 8 characters</div>
                </div>
            </div>
    
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Client ID</label>
                <div class="col-lg-8">
                    <input type="text" name="client_id" class="form-control"
                           value="{{ old('client_id', $dematDetails->client_id ?? '') }}"
                           {{ $dematDetails->status != \App\Enums\Utills\StatusEnum::pending->value ? 'disabled' : '' }}>
                    @include('admin.partials.form.input-error-message', ['key' => 'client_id'])
                    <div class="form-text">Client ID must be exactly 8 characters</div>
                </div>
            </div>
    
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Demat Account</label>
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $dematDetails->demat_account ?? 'Will be generated automatically' }}</span>
                </div>
            </div>
    
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">CML Document</label>
                <div class="col-lg-8">
                    @if ($dematDetails->status == \App\Enums\Utills\StatusEnum::pending->value)
                        <div class="fv-row w-100 flex-md-root">
                            <label class="required form-label">CML/CMR Image</label>
                            <input name="cml" class="form-control mb-2 input" tabindex="0" type="file"
                                onchange="fileExAllowedWithSize(this,'.pdf','{{ CommonHelper::appSettings('file_image_max_size') }}')">
                            @include('admin.partials.form.input-error-message', ['key' => 'cml'])
            
                            <div class="form-text">Only PDF files, max size: {{ UtillsHelper::maxFileDocumentSizeInKB() / 1024 }}MB</div>
                        </div>
                    @endif
            
                    @if (!empty($investorKyc->cml_image))
                        <a href="{{ route('download.web', ['path' => $investorKyc->cml_image, 'name' => 'CML_Document']) }}" class="btn btn-sm btn-light-primary mt-2">
                            {!! getIcon('cloud-download', 'fs-4') !!} Download CML
                        </a>
                    @endif
                </div>
            </div>
    
            @if ($dematDetails->status == \App\Enums\Utills\StatusEnum::pending->value)
                <div class="row mt-4">
                    <div class="col-lg-8 offset-lg-4">
                        <button type="submit" name="action" value="{{ \App\Enums\Utills\StatusEnum::approved->value }}" class="btn btn-sm btn-primary me-2">Approve</button>
                        <button type="submit" name="action" value="{{ \App\Enums\Utills\StatusEnum::rejected->value }}" class="btn btn-sm btn-danger">Reject</button>
                    </div>
                </div>
            @endif
        </form>
    </div>
</div>


<div class="card mb-5 mb-xl-10" id="kt_profile_details_view_pan">
    <div class="card-header cursor-pointer">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">PAN Details</h3>
        </div>
        @if ($panDetails->status == \App\Enums\Utills\StatusEnum::approved->value)
            <span class="badge badge-success fw-bold">Approved</span>
        @elseif ($panDetails->status == \App\Enums\Utills\StatusEnum::rejected->value)
            <span class="badge badge-danger fw-bold">Rejected</span>
        @elseif ($panDetails->status == \App\Enums\Utills\StatusEnum::pending->value)
            <span class="badge badge-warning fw-bold">Pending</span>
        @endif
    </div>

    <div class="card-body p-9">
        <form method="POST" action="{{ route('admin.manualkyc.updatePanStatus', $panDetails->id) }}" id="panDetailsForm" enctype="multipart/form-data">
            @csrf

            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Name as per PAN</label>
                <div class="col-lg-8">
                    <input type="text" name="name_as_pan" class="form-control"
                           value="{{ old('name_as_pan', $panDetails->name_as_pan ?? '') }}"
                           {{ $panDetails->status != \App\Enums\Utills\StatusEnum::pending->value ? 'disabled' : '' }}>
                    @include('admin.partials.form.input-error-message', ['key' => 'name_as_pan'])
                </div>
            </div>

            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">PAN Number</label>
                <div class="col-lg-8">
                    <input type="text" name="pan_no" class="form-control"
                           value="{{ old('pan_no', $panDetails->pan_no ?? '') }}"
                           {{ $panDetails->status != \App\Enums\Utills\StatusEnum::pending->value ? 'disabled' : '' }}>
                    @include('admin.partials.form.input-error-message', ['key' => 'pan_no'])
                </div>
            </div>

            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">PAN Document</label>
                <div class="col-lg-8">
                    @if ($panDetails->status == \App\Enums\Utills\StatusEnum::pending->value)
                        <div class="fv-row w-100 flex-md-root">
                            <label class="required form-label">Upload PAN Image</label>
                            <input name="pan_image" class="form-control mb-2 input" tabindex="0" type="file"
                                onchange="fileExAllowedWithSize(this, '.pdf,.jpg,.jpeg,.png', '{{ CommonHelper::appSettings('file_image_max_size') }}')">
                            @include('admin.partials.form.input-error-message', ['key' => 'pan_image'])

                            <div class="form-text">Only PDF/JPG/PNG files, max size: {{ UtillsHelper::maxFileDocumentSizeInKB() / 1024 }}MB</div>
                        </div>
                    @endif

                    @if (!empty($panDetails->pan_image))
                        <a href="{{ route('download.web', ['path' => $panDetails->pan_image, 'name' => 'PAN_Document']) }}" class="btn btn-sm btn-light-primary mt-2">
                            {!! getIcon('cloud-download', 'fs-4') !!} Download PAN
                        </a>
                    @endif
                </div>
            </div>

            @if ($panDetails->status == \App\Enums\Utills\StatusEnum::pending->value)
                <div class="row mt-4">
                    <div class="col-lg-8 offset-lg-4">
                        <button type="submit" name="action" value="{{ \App\Enums\Utills\StatusEnum::approved->value }}" class="btn btn-sm btn-primary me-2">Approve</button>
                        <button type="submit" name="action" value="{{ \App\Enums\Utills\StatusEnum::rejected->value }}" class="btn btn-sm btn-danger">Reject</button>
                    </div>
                </div>
            @endif
        </form>
    </div>
</div>

<div class="card mb-5 mb-xl-10" id="kt_aadhaar_details_view" id="pills-aadhaar">
    <div class="card-header cursor-pointer">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Aadhaar Details</h3>
        </div>
        @if ($investorKyc->status == \App\Enums\Utills\StatusEnum::approved->value)
            <span class="badge badge-success fw-bold">Approved</span>
        @elseif ($investorKyc->status == \App\Enums\Utills\StatusEnum::rejected->value)
            <span class="badge badge-danger fw-bold">Rejected</span>
        @elseif ($investorKyc->status == \App\Enums\Utills\StatusEnum::pending->value)
            <span class="badge badge-warning fw-bold">Pending</span>
        @endif
    </div>
    <div class="card-body p-9">
        <form method="POST" action="{{ route('admin.manualkyc.updateAadharStatus', $investorKyc->id) }}" id="aadhaarDetailsForm" enctype="multipart/form-data">
            @csrf

            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Aadhaar Front Image</label>
                <div class="col-lg-8">
                    @if ($investorKyc->status == \App\Enums\Utills\StatusEnum::pending->value)
                        <div class="fv-row w-100 flex-md-root">
                            <label class="required form-label">Aadhaar Front Image</label>
                            <input name="aadhaar_front_image" class="form-control mb-2 input" type="file"
                                onchange="fileExAllowedWithSize(this,'.jpeg,.png,.jpg,.pdf','{{ CommonHelper::appSettings('file_image_max_size') }}')">
                            @include('admin.partials.form.input-error-message', ['key' => 'aadhaar_front_image'])
                            <div class="form-text">Allowed formats: JPEG, PNG, JPG, PDF. Max size: {{ UtillsHelper::maxFileDocumentSizeInKB() / 1024 }}MB</div>
                        </div>
                    @endif

                    @if (!empty($investorKyc->aadhaar_front_image))
                        <a href="{{ route('download.web', ['path' => $investorKyc->aadhaar_front_image, 'name' => 'Aadhaar_Front_Image']) }}" class="btn btn-sm btn-light-primary mt-2">
                            {!! getIcon('cloud-download', 'fs-4') !!} Download Aadhaar Front Image
                        </a>
                    @endif
                </div>
            </div>

            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Aadhaar Back Image</label>
                <div class="col-lg-8">
                    @if ($investorKyc->status == \App\Enums\Utills\StatusEnum::pending->value)
                        <div class="fv-row w-100 flex-md-root">
                            <label class="required form-label">Aadhaar Back Image</label>
                            <input name="aadhaar_back_image" class="form-control mb-2 input" type="file"
                                onchange="fileExAllowedWithSize(this,'.jpeg,.png,.jpg,.pdf','{{ CommonHelper::appSettings('file_image_max_size') }}')">
                            @include('admin.partials.form.input-error-message', ['key' => 'aadhaar_back_image'])
                            <div class="form-text">Allowed formats: JPEG, PNG, JPG, PDF. Max size: {{ UtillsHelper::maxFileDocumentSizeInKB() / 1024 }}MB</div>
                        </div>
                    @endif

                    @if (!empty($investorKyc->aadhaar_back_image))
                        <a href="{{ route('download.web', ['path' => $investorKyc->aadhaar_back_image, 'name' => 'Aadhaar_Back_Image']) }}" class="btn btn-sm btn-light-primary mt-2">
                            {!! getIcon('cloud-download', 'fs-4') !!} Download Aadhaar Back Image
                        </a>
                    @endif
                </div>
            </div>

            @if ($investorKyc->status == \App\Enums\Utills\StatusEnum::pending->value)
                <div class="row mt-4">
                    <div class="col-lg-8 offset-lg-4">
                        <button type="submit" name="action" value="{{ \App\Enums\Utills\StatusEnum::approved->value }}" class="btn btn-sm btn-primary me-2">Approve</button>
                        <button type="submit" name="action" value="{{ \App\Enums\Utills\StatusEnum::rejected->value }}" class="btn btn-sm btn-danger">Reject</button>
                    </div>
                </div>
            @endif
        </form>
    </div>
</div>
