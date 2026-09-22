@extends('front.layouts.dashboard')

@section('child-content')
    <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="v-pills-home-tab">
            <div class="update_content">
                <div class="top_section">
                    <h3>{{ getPageTitle() }}</h3>
                </div>
                <div class="">
                    <div class="d_card">
                        <form class="" action="{{ route('front.raise.manageCaptable.savemanual') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d_field_group">
                                        <label>Name <span class="required">*</span></label>
                                        <input class="d_field" value="{{ old('name') }}" type="text" name="name"
                                            placeholder="Enter Name" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d_field_group ">
                                        <label>Mobile <span class="required">*</span></label>
                                        <input class="d_field input-number" value="{{ old('mobile_number') }}"
                                            type="text" name="mobile_number" placeholder="Enter Mobile" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d_field_group">
                                        <label>Email <span class="required">*</span></label>
                                        <input class="d_field" value="{{ old('email') }}" type="text" name="email"
                                            placeholder="Enter Email" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d_field_group">
                                        <label>No of Shares <span class="required">*</span></label>
                                        <input class="d_field input-number" value="{{ old('share') }}" type="text"
                                            name="share" placeholder="Enter Shares" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d_field_group">
                                        <label>Instrument <span class="required">*</span></label>
                                        <select class="d_field" name="instrument_type">
                                            <option value="">--Select Instrument Type--</option>
                                            @foreach (App\Enums\InstrumentTypeEnum::cases() as $instrument)
                                                <option value="{{ $instrument->value }}"
                                                    {{ old('instrument_type') == $instrument->value ? 'selected' : '' }}>
                                                    {{ $instrument->value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d_field_group">
                                        <label>Investor Type <span class="required">*</span></label>
                                        <select class="d_field" name="investor_type">
                                            <option value="">--Select Investor Type--</option>
                                            @foreach (App\Enums\InvestorTypeEnum::cases() as $investor)
                                                <option value="{{ $investor->value }}"
                                                    {{ old('investor_type') == $investor->value ? 'selected' : '' }}>
                                                    {{ $investor->value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d_field_group">
                                        <label>Is Promoter <span class="required">*</span></label>
                                        <select class="d_field" name="is_promoter">
                                            <option value="">-- Select --</option>
                                            <option value="yes" {{ old('is_promoter') == 'yes' ? 'selected' : '' }}>Yes
                                            </option>
                                            <option value="no" {{ old('is_promoter') == 'no' ? 'selected' : '' }}>No
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn_custom">
                                        Create
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
