@if (Route::is('admin.myprofile.view'))
    <div class="card mb-5 mb-xl-10" id="kt_profile_details_view" id="pills-home">

        <div class="card-header cursor-pointer">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Profile Details</h3>
            </div>
            <!--end::Card title-->
            <a href="{{ route('admin.myprofile.edit') }}" class="btn btn-sm btn-primary align-self-center">Edit
                Profile</a>
        </div>


        <div class="card-body p-9">

            <div class="row mb-7">

                <label class="col-lg-4 fw-semibold text-muted">Full Name</label>


                <!--begin::Col-->
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $user->name }}</span>
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->


            <div class="row mb-7">

                <label class="col-lg-4 fw-semibold text-muted">Email</label>


                <!--begin::Col-->
                <div class="col-lg-8 fv-row">
                    <span class="fw-semibold text-gray-800 fs-6">{{ $user->email }}</span>
                    {{-- @if ($investor->is_verified_email)
                    <span class="badge badge-success">Verified</span>
                @else
                    <span class="badge badge-danger">Not Verified</span>
                @endif --}}
                </div>
                <!--end::Col-->
            </div>



            <div class="row mb-7">

                <label class="col-lg-4 fw-semibold text-muted">
                    Mobile Number

                    <span class="ms-1" data-bs-toggle="tooltip" aria-label="Phone number must be active"
                        data-bs-original-title="Phone number must be active" data-kt-initialized="1">
                        <i class="ki-duotone ki-information fs-7"><span class="path1"></span><span
                                class="path2"></span><span class="path3"></span></i> </span>
                </label>


                <!--begin::Col-->
                <div class="col-lg-8 d-flex align-items-center">
                    <span class="fw-bold fs-6 text-gray-800 me-2">+91-{{ $user->mobile_no }}</span>
                    {{-- @if ($investor->is_verified_mobile)
                    <span class="badge badge-success">Verified</span>
                @else
                    <span class="badge badge-danger">Not Verified</span>
                @endif --}}
                </div>
                <!--end::Col-->
            </div>



            {{-- <div class="row mb-7">

            <label class="col-lg-4 fw-semibold text-muted">Address</label>


            <!--begin::Col-->
            <div class="col-lg-8">
                <a href="#" class="fw-semibold fs-6 text-gray-800 text-hover-primary">{{ $investor->address }}</a>
            </div>
            <!--end::Col-->
        </div> --}}



            {{-- <div class="row mb-7">

            <label class="col-lg-4 fw-semibold text-muted">
                Country

                <span class="ms-1" data-bs-toggle="tooltip" aria-label="Country of origination"
                    data-bs-original-title="Country of origination" data-kt-initialized="1">
                    <i class="ki-duotone ki-information fs-7"><span class="path1"></span><span
                            class="path2"></span><span class="path3"></span></i> </span>
            </label>


            <!--begin::Col-->
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">{{ $investor->country->name }}</span>
            </div>
            <!--end::Col-->
        </div>



        <div class="row mb-7">

            <label class="col-lg-4 fw-semibold text-muted">State</label>


            <!--begin::Col-->
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">{{ $investor->state->name }}</span>
            </div>
            <!--end::Col-->
        </div>



        <div class="row mb-10">

            <label class="col-lg-4 fw-semibold text-muted">City</label>



            <div class="col-lg-8">
                <span class="fw-semibold fs-6 text-gray-800">{{ $investor->city->name }}</span>
            </div>

        </div> --}}

        </div>

    </div>
@else
    <div class="card mb-5 mb-xl-10">
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
            data-bs-target="#kt_account_profile_details" aria-expanded="true"
            aria-controls="kt_account_profile_details">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Profile Details</h3>
            </div>
        </div>
        <div id="kt_account_settings_profile_details" class="collapse show">
            <form id="kt_account_profile_details_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                novalidate="novalidate" method="POST" action="{{ route('admin.myprofile.update') }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body border-top p-9">
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Profile Photo</label>
                        <div class="col-lg-8">
                            <div class="dp-change-container image-input image-input-outline" style="">
                                <div class="dp image-input-wrapper w-125px h-125px {{ Auth::guard('admin')->user()->profile_photo == null ? 'd-none' : '' }}"
                                    style="background-image: {{ Auth::guard('admin')->user()->profile_photo != null ? 'url(' . FileUpDownHelper::subadmin_profile_photo_url(Auth::guard('admin')->user()->profile_photo) . ')' : 'none' }}">
                                </div>
                                <div
                                    class="placeholder image-input-wrapper w-125px h-125px {{ Auth::guard('admin')->user()->profile_photo != null ? 'd-none' : '' }}">
                                    <div class="symbol symbol-125px symbol-fixed position-relative">
                                        <div
                                            class="symbol-label fs-1 {{ app(\App\Actions\GetThemeType::class)->handle('bg-light-? text-?', Auth::guard('admin')->user()->name) }}">
                                            {{ substr(Auth::guard('admin')->user()->name, 0, 1) }}
                                        </div>
                                    </div>
                                </div>
                                <label
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                    aria-label="Change avatar" data-bs-original-title="Change avatar"
                                    data-kt-initialized="1">
                                    <i class="ki-duotone ki-pencil fs-7"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    <!--begin::Inputs-->
                                    <input type="file" name="profile_photo"
                                        accept="{{ implode(',', array_map(fn($ext) => '.' . ltrim($ext), explode(',', CommonHelper::appSettings('file_image_extensions_allowed')))) }}"
                                        onchange="">
                                    <input type="hidden" name="avatar_remove">
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Label-->

                                <!--begin::Cancel-->
                                <span
                                    class="d-none btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                    aria-label="Cancel avatar" data-bs-original-title="Cancel avatar"
                                    data-kt-initialized="1">
                                    <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span
                                            class="path2"></span></i> </span>
                                <!--end::Cancel-->

                                <!--begin::Remove-->
                                <span
                                    class="{{ Auth::guard('admin')->user()->profile_photo == null ? 'd-none' : '' }} btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                    aria-label="Remove avatar" data-bs-original-title="Remove avatar"
                                    data-kt-initialized="1">
                                    <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span
                                            class="path2"></span></i> </span>
                                <!--end::Remove-->
                            </div>
                            <!--end::Image input-->

                            <!--begin::Hint-->
                            <div class="form-text">Allowed file types :
                                {{ CommonHelper::appSettings('file_image_extensions_allowed') }}</div>
                            <!--end::Hint-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Full Name</label>

                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                            <input type="text" name="name" class="form-control form-control-lg form-control-solid"
                                placeholder="Enter Full Name" value="{{ old('name', $user->name) }}">
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                        <!--end::Col-->
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Username</label>

                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                            <input type="text" name="username"
                                class="form-control form-control-lg form-control-solid" placeholder="Enter Username"
                                value="{{ old('username', $user->username) }}">
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                        <!--end::Col-->
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Mobile Number</label>

                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                            <input type="text" name="mobile_no"
                                class="form-control form-control-lg form-control-solid"
                                placeholder="Enter Mobile Number" value="{{ old('mobile_no', $user->mobile_no) }}">
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                        <!--end::Col-->
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Email</label>

                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                            <input type="text" name="email"
                                class="form-control form-control-lg form-control-solid"
                                placeholder="Enter Mobile Number" value="{{ old('email', $user->email) }}">
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                        <!--end::Col-->
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Change Password</label>

                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                            <input type="text" name="password"
                                class="form-control form-control-lg form-control-solid" placeholder="Enter Password"
                                value="{{ old('password') }}">
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--begin::Actions-->
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <a href="{{ route('admin.myprofile.view') }}" type="reset"
                            class="btn btn-light btn-active-light-primary me-2">Discard</a>
                        <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save
                            Changes</button>
                    </div>
                    <!--end::Actions-->
                    <input type="hidden">
            </form>
            <!--end::Form-->
        </div>
        <!--end::Content-->
    </div>

    @push('scripts')
        <script>
            $(function() {
                oldImage = '';
                @if (Auth::guard('admin')->user()->profile_photo != null)
                    oldImage =
                        "{{ FileUpDownHelper::subadmin_profile_photo_url(Auth::guard('admin')->user()->profile_photo) }}";
                @endif
                $('.dp-change-container input[name=profile_photo]').change(function() {
                    var allowedExtensions = '{{ CommonHelper::appSettings('file_image_extensions_allowed') }}';
                    var maxSize = '{{ CommonHelper::appSettings('file_image_max_size') }}';

                    if (!fileExAllowedWithSize(this, allowedExtensions, maxSize)) {
                        return false;
                    }
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('.dp-change-container .dp').css('background-image', 'url(' + e.target.result +
                            ')');
                    };
                    reader.readAsDataURL(this.files[0]);
                    $('.dp-change-container .dp').removeClass('d-none');
                    $('.dp-change-container .placeholder').addClass('d-none');
                    $('[data-kt-image-input-action="cancel"]').removeClass('d-none');
                    $('[data-kt-image-input-action="cancel"]').show();
                    $('[data-kt-image-input-action="remove"]').addClass('d-none');
                    $('.dp-change-container input[name="avatar_remove"]').val('');
                });

                $('[data-kt-image-input-action="cancel"]').on('click', function() {
                    $('.dp-change-container input[name="profile_photo"]').val('');
                    $('.dp-change-container input[name="avatar_remove"]').val('');
                    if (oldImage != '') {
                        $('.dp-change-container .dp').css('background-image', 'url(' + oldImage +
                            ')');
                        $('[data-kt-image-input-action="remove"]').removeClass('d-none');
                        $('[data-kt-image-input-action="cancel"]').addClass('d-none');
                    } else {
                        $('.dp-change-container .dp').addClass('d-none');
                        $('.dp-change-container .placeholder').removeClass('d-none');
                    }
                });

                $('[data-kt-image-input-action="remove"]').on('click', function() {
                    $('.dp-change-container input[name="profile_photo"]').val('');
                    $('.dp-change-container .dp').addClass('d-none');
                    $('.dp-change-container .placeholder').removeClass('d-none');
                    $('.dp-change-container input[name="avatar_remove"]').val('1');
                    $('[data-kt-image-input-action="remove"]').addClass('d-none');
                    $('.dp-change-container .dp').css('background-image', 'none');
                });
            })
        </script>
    @endpush
    <style>
        .dp-change-container .dp {
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
@endif
