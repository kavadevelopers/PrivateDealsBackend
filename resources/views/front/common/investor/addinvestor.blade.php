@extends('front.layouts.dashboard')

@section('child-content')

    <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="v-pills-home-tab">
            <div class="ui_content">
                <h3>{{ getPageTitle() }}</h3>
                <div class="d_card">
                    <form
                        action="{{ request()->routeis('front.business.*') ? route('front.business.investor.save') : route('front.investor.family.save') }}"
                        method="post" id="detailForm" enctype="multipart/form-data">
                        @csrf
                        {{-- <div class="all_field"> --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="d_field_group">
                                    <label>Types Of Investor <span class="required">*</span></label>
                                    <select class="select d_field" name="investor_type" aria-label="Select Investor Type">
                                        <option value="">-- Select Investor Type --</option>
                                        @foreach (App\Enums\InvestorTypeEnum::cases() as $type)
                                            <option value="{{ $type->value }}"
                                                {{ old('investor_type') === $type->value ? 'selected' : '' }}>
                                                {{ ucfirst($type->value) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @include('front.common.input-error-message', [
                                        'key' => 'investor_type',
                                    ])
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d_field_group">
                                    <label>Name <span class="required">*</span></label>
                                    <input class="d_field" type="text" name="name" value="{{ old('name') }}"
                                        placeholder="Enter Full Name">
                                    @include('front.common.input-error-message', [
                                        'key' => 'name',
                                    ])
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d_field_group">
                                    <label>Mobile Number <span class="required">*</span></label>
                                    <input class="d_field" type="tel" name="mobile_number"
                                        value="{{ old('mobile_number') }}" placeholder="Enter Mobile Number">
                                    @include('front.common.input-error-message', [
                                        'key' => 'mobile_number',
                                    ])
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="d_field_group">
                                    <label>Password <span class="required">*</span></label>
                                    <input class="d_field" type="password" name="password" value="{{ old('password') }}"
                                        placeholder="Enter Password">
                                    @include('front.common.input-error-message', [
                                        'key' => 'password',
                                    ])
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d_field_group">
                                    <label>Email <span class="required">*</span></label>
                                    <input class="d_field" type="email" name="email" value="{{ old('email') }}"
                                        placeholder="Enter Email">
                                    @include('front.common.input-error-message', [
                                        'key' => 'email',
                                    ])
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d_field_group">
                                    <label>Gender <span class="required">*</span></label>
                                    <select class="select d_field" name="gender">
                                        <option value="">-- Select Gender --</option>
                                        @foreach (App\Enums\GenderEnum::cases() as $gender)
                                            <option value="{{ $gender->value }}"
                                                {{ old('gender') == $gender->value ? 'selected' : '' }}>
                                                {{ ucfirst($gender->value) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @include('front.common.input-error-message', [
                                        'key' => 'gender',
                                    ])
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="d_field_group">
                                    <label>City <span class="required">*</span></label>
                                    <select class="select d_field" name="city_id" aria-label="Select City">
                                        <option value="">-- Select City --</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}"
                                                {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @include('front.common.input-error-message', [
                                        'key' => 'city_id',
                                    ])
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d_field_group">
                                    <label>Pincode <span class="required">*</span></label>
                                    <input class="d_field" type="text" name="pincode" value="{{ old('pincode') }}"
                                        maxlength="6" minlength="6" placeholder="Enter Pincode">
                                    @include('front.common.input-error-message', [
                                        'key' => 'pincode',
                                    ])
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d_field_group">
                                    <label>Street Address <span class="required">*</span></label>
                                    <input class="d_field" type="text" name="address" value="{{ old('address') }}"
                                        placeholder="Enter Address">
                                    @include('front.common.input-error-message', [
                                        'key' => 'address',
                                    ])
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @if (!request()->routeis('front.business.*'))
                                <div class="col-md-4">
                                    <div class="d_field_group">
                                        <label>Relation with you <span class="required">*</span></label>
                                        <select class="select d_field" name="relation_id">
                                            <option value="">-- Select Relation --</option>
                                            @foreach (App\Models\MasterFamilyRelationsModel::where('is_deleted', '')->get() as $Rkey => $Rvalue)
                                                <option value="{{ $Rvalue->id }}"
                                                    {{ old('relation_id') == $Rvalue->id ? 'selected' : '' }}>
                                                    {{ $Rvalue->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @include('front.common.input-error-message', [
                                            'key' => 'relation_id',
                                        ])
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-4">
                                <div class="field_group">
                                    <label for="profile_photo">Profile Photo (Optional)</label>
                                    <input id="profile_photo" class="file" type="file" name="profile_photo" />
                                    <i class="fa-solid fa-image input_icon"></i>
                                    @include('front.common.input-error-message', [
                                        'key' => 'profile_photo',
                                    ])
                                </div>
                            </div>
                        </div>

                        {{-- </div> --}}
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <button type="submit" class="btn_custom reg_otp">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
