{{-- <div class="row mb-7">
    <label class="col-lg-4 fw-semibold text-muted">Aadhar number</label>
    <div class="col-lg-8">
        <span class="fw-bold fs-6 text-gray-800">{{ $investor->kyc->aadhar_no ?? 'N/A' }}</span>
    </div>
</div>

<div class="row mb-7">
    <label class="col-lg-4 fw-semibold text-muted">PAN number</label>
    <div class="col-lg-8">
        <span class="fw-bold fs-6 text-gray-800">{{ $investor->kyc->pan_no ?? 'N/A' }}</span>
    </div>
</div>

<div class="row mb-7">
    <label class="col-lg-4 fw-semibold text-muted">Name as Aadhar</label>
    <div class="col-lg-8">
        <span class="fw-bold fs-6 text-gray-800">{{ $investor->kyc->name_as_aadhar ?? 'N/A' }}</span>
    </div>
</div>

<div class="row mb-7">
    <label class="col-lg-4 fw-semibold text-muted">Name as PAN</label>
    <div class="col-lg-8 fv-row">
        <span class="fw-semibold text-gray-800 fs-6">{{ $investor->kyc->name_as_pan ?? 'N/A' }}</span>
    </div>
</div>

<div class="row mb-7">
    <label class="col-lg-4 fw-semibold text-muted">DOB as Aadhar</label>
    <div class="col-lg-8 fv-row">
        <span
            class="fw-semibold text-gray-800 fs-6">{{ $investor->kyc && $investor->kyc->dob_as_aadhar ? DateTimeHelper::formatDateTime($investor->kyc->dob_as_aadhar, 'd F Y') : 'N/A' }}</span>
    </div>
</div>

<div class="row mb-7">
    <label class="col-lg-4 fw-semibold text-muted">Address as Aadhar</label>
    <div class="col-lg-8 fv-row">
        <span class="fw-semibold text-gray-800 fs-6">{!! nl2br($investor->kyc->address_as_aadhar ?? 'N/A') !!}</span>
    </div>
</div>

<div class="row mb-7">
    <label class="col-lg-4 fw-semibold text-muted">DP ID</label>
    <div class="col-lg-8 fv-row">
        <span class="fw-semibold text-gray-800 fs-6">{{ $investor->dematAccount->dp_id ?? 'N/A' }}</span>
    </div>
</div>

<div class="row mb-7">
    <label class="col-lg-4 fw-semibold text-muted">Client ID</label>
    <div class="col-lg-8 fv-row">
        <span class="fw-semibold text-gray-800 fs-6">{{ $investor->dematAccount->client_id ?? 'N/A' }}</span>
    </div>
</div>

<div class="row mb-7">
    <label class="col-lg-4 fw-semibold text-muted">Demat Account Number</label>
    <div class="col-lg-8 fv-row">
        <span class="fw-semibold text-gray-800 fs-6">{{ $investor->dematAccount->demat_account ?? 'N/A' }}</span>
    </div>
</div> --}}


{{-- <div class="row mb-7">
    <label class="col-lg-4 fw-semibold text-muted">Bank Name</label>
    <div class="col-lg-8">
        <span class="fw-bold fs-6 text-gray-800">{{ $bankDetails->bank->name ?? 'N/A' }}</span>
    </div>
</div>

<div class="row mb-7">
    <label class="col-lg-4 fw-semibold text-muted">Account Holder Name</label>
    <div class="col-lg-8">
        <span class="fw-bold fs-6 text-gray-800">{{ $bankDetails->account_holder_name ?? 'N/A' }}</span>
    </div>
</div>

<div class="row mb-7">
    <label class="col-lg-4 fw-semibold text-muted">Account Number</label>
    <div class="col-lg-8">
        <span class="fw-bold fs-6 text-gray-800">{{ $bankDetails->account_number ?? 'N/A' }}</span>
    </div>
</div>

<div class="row mb-7">
    <label class="col-lg-4 fw-semibold text-muted">IFSC Code</label>
    <div class="col-lg-8">
        <span class="fw-bold fs-6 text-gray-800">{{ $bankDetails->ifsc_code ?? 'N/A' }}</span>
    </div>
</div> --}}

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
