@extends('front.layouts.dashboard')

@section('child-content')
    <script type="text/javascript" src="https://app.digio.in/sdk/v9/digio.js"></script>
    <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="portfolio" role="tabpanel" aria-labelledby="v-pills-home-tab">
            <div class="top_section">
                <h3>{{ getPageTitle() }}</h3>
            </div>
            @if (!$investor->kyc_status)
                @if (!$investor->kyc || ($investor->kyc && $investor->kyc->status == App\Enums\Utills\StatusEnum::rejected->value))
                    @if ($investor->kyc && $investor->kyc->status == App\Enums\Utills\StatusEnum::rejected->value)
                        <p class="text-left">KYC rejected (Please try again to complete KYC process)</p>
                    @endif
                    <div class="d_card">
                        <div class="all_field">
                            <div class="field_group">
                                <label>Select Verification Type <span class="required">*</span></label>
                                <select class="select" name="type" onchange="checkWhichSelected(this.value)" required>
                                    <option value="">Select</option>
                                    <option value="ekyc">eKyc</option>
                                    <option value="manual">Manual</option>
                                </select>
                                <i class="fa-solid fa-briefcase input_icon"></i>
                            </div>
                        </div>
                        <div class="eKycContainer" style="display:none;">
                            <h4 style="margin-top: 10px; margin-bottom: 10px;">Verify Aadhar using eKyc</h4>
                            <button class="btn_custom verify btnVerifyAadhar"
                                data-action="{{ route('front.investor.kyc.ekyc.token.get') }}"
                                data-getaction="{{ route('front.investor.kyc.ekyc.data.get') }}">Click to Verify
                                Aadhar</button>
                        </div>
                        <div class="manual_kyc" style="margin-top:20px;">
                            <div class="manualKycContainer" style="display: none;">
                                <form action="{{ route('front.investor.kyc.manual.save') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="field_group">
                                                <label>Select Aadhaar card front image <span
                                                        class="required">*</span></label>
                                                <input class="file" type="file" name="aadhar_front"
                                                    onchange="fileExAllowedWithSize(this,'{{ CommonHelper::appSettings('file_image_extensions_allowed') }}','{{ CommonHelper::appSettings('file_image_max_size') }}')"
                                                    required>
                                                <i class="fa-solid fa-image input_icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="field_group">
                                                <label>Select Aadhaar card back image <span
                                                        class="required">*</span></label>
                                                <input class="file" type="file" name="aadhar_back"
                                                    onchange="fileExAllowedWithSize(this,'{{ CommonHelper::appSettings('file_image_extensions_allowed') }}','{{ CommonHelper::appSettings('file_image_max_size') }}')"
                                                    required>
                                                <i class="fa-solid fa-image input_icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="field_group">
                                                <label>Select PAN Image <span class="required">*</span></label>
                                                <input class="file" type="file" name="pan_card"
                                                    onchange="fileExAllowedWithSize(this,'{{ CommonHelper::appSettings('file_image_extensions_allowed') }}','{{ CommonHelper::appSettings('file_image_max_size') }}')"
                                                    required>
                                                <i class="fa-solid fa-image input_icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-4">
                                            <button class="btn_custom" type="submit">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="d_card">
                            <button class="btn_custom verify"><i class="fa fa-circle-notch fa-spin"></i> Pending
                                verification</button>
                        </div>
                @endif
            @else
                <div class="all-p-cards">
                    <div class="card-p-custom">
                        <div class="user_info">
                            <div class="logo"><img class="lazy shimmer"
                                    data-src="{{ FileUpDownHelper::get_investor_profile_photo_url(Auth::guard('investor')->user()) }}">
                            </div>
                            <div class="name_type">
                                <h3>{{ $investor->kyc->name_as_aadhar }}</h3>
                                <p>DOB : <span
                                        class="bold">{{ DateTimeHelper::formatDateTime($investor->kyc->dob_as_aadhar, 'd F Y') }}</span>
                                </p>
                                <span class="badge badge-green"><i class="fa fa-check-circle"></i> Aadhar Verified</span>
                            </div>
                        </div>
                        <div>
                            <p>Name as PAN : <span class="bold">{{ $investor->kyc->name_as_pan }}</span></p>
                            <p>Aadhar No. : <span class="bold">{{ $investor->kyc->aadhar_no }}</span></p>
                            <p>PAN No. : <span class="bold">{{ $investor->kyc->pan_no }}</span></p>
                        </div>
                        <div>
                            <p>Address : <span class="bold">{{ $investor->kyc->address_as_aadhar }}</span></p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

@stop
