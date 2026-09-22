@extends('front.layouts.dashboard')

@section('child-content')
    <div class="profile_settings_page">
        <div id="main">
            <div class="container_custom">
                <div class="content">
                    <div class="bg_style ">
                        <h2 class="title">Profile settings</h2>
                        <div class="settings_tabs">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                    aria-labelledby="pills-home-tab">
                                    <form action="{{ route('front.investor.profile.profileviewsave') }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="user_image">
                                            <div class="image">
                                                <img id="profileImage"
                                                    src="{{ FileUpDownHelper::get_investor_profile_photo_url(Auth::guard('investor')->user()) }}"
                                                    alt="">
                                            </div>
                                            <div class="buttons_group">
                                                <button type="button"
                                                    class="change_image btn_custom_line btn-choose-image">Change
                                                    Image</button>
                                                <input type="file" name="" class="croppieImgPicker"
                                                    data-aspratio="1" data-type="profile" style="display:none;">

                                                <a href="{{ route('front.investor.profile.removeprofileimage') }}">
                                                    <button type="button" class="btn_custom">Remove Image</button>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="visibility">
                                            <h3 class="setting_title">Visibility</h3>
                                            <div class="visibility_radio">
                                                <div class="radio_group">
                                                    <input type="radio" id="vis-public" name="visibility" value="public"
                                                        {{ $list->profile_visibility == 'public' ? 'checked' : '' }}>
                                                    <label for="vis-public"><span class="radio_title">Public</span> <span
                                                            class="radio_desc">Your name, your last 5 investments and
                                                            any social
                                                            connections you add to your profile will be visible to other
                                                            registered
                                                            users when you invest.</span></label>
                                                </div>
                                                <div class="radio_group">
                                                    <input type="radio" id="vis-name-only" name="visibility"
                                                        value="Name Only"
                                                        {{ $list->profile_visibility == 'Name Only' ? 'checked' : '' }}>
                                                    <label for="vis-name-only"><span class="radio_title">Name Only</span>
                                                        <span class="radio_desc">Only your name and photo will be
                                                            visible to other
                                                            registered users when you invest.</span></label>
                                                </div>
                                                <div class="radio_group">
                                                    <input type="radio" id="vis-private" name="visibility" value="Private"
                                                        {{ $list->profile_visibility == 'Private' ? 'checked' : '' }}>
                                                    <label for="vis-private"><span class="radio_title">Private</span> <span
                                                            class="radio_desc">You will appear as 'Anonymous' in all
                                                            Investor
                                                            lists.</span></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="legal_name">
                                            <h3 class="setting_title">Legal name</h3>
                                            <div class="">
                                                <div class="d_field_group">
                                                    <label for="first-name">Full Name </label>
                                                    <input class="d_field" type="text" name="investorname"
                                                        value="{{ $list->name ?? '' }}" id="first-name" placeholder="N/A"
                                                        disabled>
                                                </div>

                                                <div class="d_field_group">
                                                    <label for="last-name">Name as on Aadhar</label>
                                                    <input class="d_field" type="text" name="nameasadhar"
                                                        value="{{ $kyc->name_as_aadhar ?? '' }}" id="last-name"
                                                        placeholder="N/A" disabled>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="display_name">
                                            <h3 class="setting_title">Display Name</h3>
                                            <div>
                                                <div class="radio_group">
                                                    <input type="radio" id="long-name" name="display-name" value="Public"
                                                        checked>
                                                    <label for="long-name">{{ $list->name ?? '' }}</label>
                                                </div>
                                            </div>
                                            <p class="notice">All comments will display your full legal name</p>
                                        </div>

                                        <div class="more">
                                            <h3 class="setting_title">More About You</h3>
                                            <div class="">
                                                <div class="d_field_group">
                                                    <label for="">Company Name</label>
                                                    <input class="d_field" type="text" name="company"
                                                        value="{{ $details->investor_company ?? '' }}"
                                                        placeholder="Company Name">
                                                </div>
                                                <div class="d_field_group">
                                                    <label for="company-position">Company Position</label>
                                                    <input class="d_field" type="text" name="position"
                                                        placeholder="Your Position"
                                                        value="{{ $details->investor_company_position ?? '' }}">
                                                </div>
                                                <div class="d_field_group">
                                                    <label for="bio">Short Bio</label>
                                                    <textarea class="d_field_ta" name="bio" placeholder="Short bio" spellcheck="false">{{ $details->investor_bio ?? '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="web-presence">
                                            <h3 class="setting_title">Web presence</h3>
                                            <div class="">
                                                <div class="d_field_group">
                                                    <label for="fb">Facebook</label>
                                                    <input class="d_field" type="text" name="fb"
                                                        placeholder="http://"
                                                        value="{{ $details->facebook_link ?? '' }}">
                                                </div>
                                                <div class="d_field_group">
                                                    <label for="tw">Twitter</label>
                                                    <input class="d_field" type="text" name="twitter"
                                                        placeholder="http://" value="{{ $details->twitter_link ?? '' }}">
                                                </div>
                                                <div class="d_field_group">
                                                    <label for="insta">Instagram</label>
                                                    <input class="d_field" type="text" name="insta"
                                                        placeholder="http://"
                                                        value="{{ $details->instagram_link ?? '' }}">
                                                </div>
                                                <div class="d_field_group">
                                                    <label for="in">Linkedin</label>
                                                    <input class="d_field" type="text" name="linkedin"
                                                        placeholder="http://"
                                                        value="{{ $details->linked_in_link ?? '' }}">
                                                </div>
                                                <div class="d_field_group">
                                                    <label for="web">Website</label>
                                                    <input class="d_field" type="text" name="web"
                                                        placeholder="http://" value="{{ $details->website_link ?? '' }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="contact-information">
                                            <h3 class="setting_title">Contact information</h3>
                                            <div class="">
                                                <div class="d_field_group">
                                                    <label for="email">Email <span class="required">*</span></label>
                                                    <input class="d_field" type="email" name="email"
                                                        placeholder="Enter Email" value="{{ $list->email ?? '' }}">
                                                </div>
                                                <div class="d_field_group">
                                                    <label for="number">Phone Number</label>
                                                    <input maxlength="10" minlength="10" class="d_field numbers"
                                                        type="text" placeholder="Mobile no." disabled
                                                        value="{{ $list->mobile_number ?? '' }}">
                                                </div>
                                                <div class="d_field_group">
                                                    <label for="date">Date of Birth</label>
                                                    <input class="d_field datepicker" type="text" name="dob"
                                                        value="{{ $details->date_of_birth ?? '' }}"
                                                        placeholder="Birth Date" disabled>
                                                </div>

                                                <div class="d_field_group">
                                                    <label for="add-l1">Address</label>
                                                    <input class="d_field" type="text" name="address"
                                                        placeholder="Address" value="{{ $list->address ?? '' }}">
                                                </div>
                                                {{-- <div class="d_field_group">
                                                <label for="add-l2">Address Line 2</label>
                                                <input class="d_field" type="text" name="address2" placeholder="Address Line 2" value="{{ Common::isValidRow($details,'address2') }}">
                                            </div> --}}
                                                <div class="d_field_group">
                                                    <label for="post-code">Pincode <span class="required">*</span></label>
                                                    <input class="d_field numbers" type="text" name="pin"
                                                        placeholder="Enter Pincode" value="{{ $list->pincode ?? '' }}"
                                                        required>
                                                </div>
                                                <div class="d_field_group">
                                                    <label for="country">Country</label>
                                                    <input class="d_field" type="text" name="" value="India"
                                                        placeholder="country" disabled>
                                                </div>
                                                <div class="d_field_group">
                                                    <label for="city">City <span class="required">*</span></label>
                                                    <input class="d_field" type="text" name=""
                                                        placeholder="Enter City" value="" disabled>
                                                </div>
                                                <div class="d_field_group">
                                                    <label for="state">State</label>
                                                    <input class="d_field" type="text" name=""
                                                        placeholder="Enter State" value="" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="policy_notice">For information about how we use your personal data
                                            please see our
                                            Privacy Notice.</p>
                                        <div class="submit_btn">
                                            <button type="submit" class="btn_custom">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                    aria-labelledby="pills-profile-tab">Change password</div>
                                <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                    aria-labelledby="pills-contact-tab">Notifications</div>
                                <div class="tab-pane fade" id="pills-security" role="tabpanel"
                                    aria-labelledby="pills-contact-tab">Notifications</div>
                                <div class="tab-pane fade" id="pills-pills-cookie" role="tabpanel"
                                    aria-labelledby="pills-contact-tab">Cookie & Marketing Preferences</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.change_image').on('click', function() {
                $('.croppieImgPicker').click();
            });

            $('.croppieImgPicker').on('change', function() {
                var formData = new FormData();
                formData.append('image', $('.croppieImgPicker')[0].files[0]);

                $.ajax({
                    url: '{{ route('front.investor.profile.saveprofile') }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.error) {
                            console.error('Error:', response.error.join('\n'));
                        } else {
                            console.log('Success:', response.success);

                            // Update the image source
                            $('#profileImage').attr('src', response.imageUrl);
                        }
                    },
                    error: function(response) {
                        console.error('Image upload failed.');
                    }
                });
            });
        });
    </script>
@endpush
